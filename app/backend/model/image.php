<?php
/**
 * @category   Model image
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_image {
	/**
	 * 
	 * @param $filename
	 * @return size
	 */
	public static function  image_valid($filename){
			$size = getimagesize($filename);
			switch ($size['mime']) {
			    case "image/gif":
			        break;
			    case "image/jpeg":
			        break;
			    case "image/png":
			        break;
			    case false:
			    	break;
			}
			return $size;
		}
		/**
		 * function fixe maxsize
		 * @param $maxh hauteur maximum
		 * @param $maxw largeur maximum
		 * @param string $source
		 * @return bool
		 */
	public static function imgSizeMax($source,$maxw,$maxh){  
		list($width, $height) = getimagesize($source);
		if($width>$maxw || $height>$maxh){
			return false;
		}else{	
			return true;
		}
	}
	/**
		 * function fixe minsize
		 * @param $maxh hauteur minimum
		 * @param $maxw largeur minimum
		 * @param string $source
		 * @return bool
		 */
	public static function imgSizeMin($source,$maxw,$maxh){  
		list($width, $height) = getimagesize($source);
		if($width<$maxw || $height<$maxh){
			return false;
		}else{	
			return true;
		}
	}
	/**
	 * Upload une image 
	 * @param files $img
	 * @param dir $path
	 */
	public static function upload_img($img,$path){
				$error = null;
				if (isset($_FILES[$img])) {
					if ($_FILES[$img]['error'] == UPLOAD_ERR_OK){
						if(self::image_valid($_FILES[$img]['tmp_name']) === false){
							$error .='<div class="error">Mauvais format d\'image (gif,png,jpeg uniquement)</div>';		    
						}else{		
							if(chmod($_FILES[$img]["tmp_name"],0777)){
								if(is_uploaded_file($_FILES[$img]["tmp_name"])){
									$source = $_FILES[$img]['tmp_name'];
									$cible = $_SERVER['DOCUMENT_ROOT'].magixcjquery_html_helpersHtml::unixSeparator().$path.magixcjquery_html_helpersHtml::unixSeparator().magixcjquery_url_clean::rplMagixString($_FILES[$img]["name"]);
										if (self::imgSizeMax($source,2000,2000) == false) {
											$error .= '<div class="error">La taille maximum excéde</div>';
										}else{
											if (!move_uploaded_file($source, $cible)) {
												$error .= '<div class="error">Erreur de fichier temporaire</div>';
											}
										}	
								}else{
									$error .= 'Erreur d\'écriture du disque</div>';
								}
							}
						}
					}
				}elseif (UPLOAD_ERR_NO_FILE == true){
					$error .= '<div class="error">Aucun fichier</div>';
				}elseif (UPLOAD_ERR_INI_SIZE == true){
					$error .=  '<div class="error">Le fichier est trop grand</div>';
				}elseif (UPLOAD_ERR_CANT_WRITE == true){
					$error .= '<div class="error">Erreur d\'écriture du disque</div>';	
				}elseif (UPLOAD_ERR_FORM_SIZE == true){
					$error .= '<div class="error">Le fichier est trop grand <br /> Taille maximum 800x600</div>';
				}else{
					$error .= '<div class="error">Erreur d\'écriture du disque</div>';
				}
			return $error;
		}
}
?>