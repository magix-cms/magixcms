<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name image
 * Model image
 */
class backend_model_image {

    /**
     * Vérifie si le type est bien une image
     * @param $filename
     * @param bool $debug
     * @return size
     */
	public static function image_valid($filename,$debug=false){
		try{
			$firebug = new magixcjquery_debug_magixfire();
			if (!function_exists('exif_imagetype')){
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
				if($debug!=false){
					$firebug->magixFireLog('exif_imagetype not exist');
				}
			}else{
				$size = exif_imagetype($filename);
				switch ($size) {
					case IMAGETYPE_GIF:
						break;
					case IMAGETYPE_JPEG:
						break;
					case IMAGETYPE_PNG:
						break;
					case false:
						break;
				}
				if($debug!=false){
					$firebug->magixFireLog('exif_imagetype exist');
				}
			}
			return $size;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}

	/**
	 * Retourne l'extension du fichier image
	 * @param $filename
	 * @return size
	 */	
	public static function image_analyze($filename){
		try{
		$size = getimagesize($filename);
			switch ($size['mime']) {
			    case "image/gif":
			    	$imgtype = '.gif';
			        break;
			    case "image/jpeg":
			    	$imgtype = '.jpg';
			        break;
			    case "image/png":
			    	$imgtype = '.png';
			        break;
			    case false:
			    	break;
			}
			return $imgtype;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
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
     * @param bool $debug
     * @return null|string
     */
	public static function upload_img($img,$path,$debug=false){
			$error = null;
			$firebug = new magixcjquery_debug_magixfire();
			if (isset($_FILES[$img])) {
				if ($_FILES[$img]['error'] == UPLOAD_ERR_OK){
					if(self::image_valid($_FILES[$img]['tmp_name']) === false){
						$error .= 'Mauvais format d\'image (gif,png,jpeg uniquement)';		    
					}else{
						if(!is_readable($_FILES[$img]["tmp_name"])){
							$tmp_img = chmod($_FILES[$img]["tmp_name"],0777);
						}else{
							$tmp_img = $_FILES[$img]["tmp_name"];
						}
						//if(chmod($_FILES[$img]["tmp_name"],0777)){
							if(is_uploaded_file($_FILES[$img]["tmp_name"])){
								$source = $tmp_img;
								$cible = magixglobal_model_system::base_path().$path.magixcjquery_url_clean::rplMagixString($_FILES[$img]["name"]);
								if (self::imgSizeMax($source,2500,2500) == false) {
									$error .= 'La taille maximum excéde';
								}elseif (self::imgSizeMin($source,5,5) == false) {
									$error .= 'Le fichier est trop petit';
								}else{
									if (!move_uploaded_file($source, $cible)) {
										$error .= 'Erreur de fichier temporaire';
									}else{
										if($debug != false){
											$firebug->magixFireGroup('Upload image infos');
											$firebug->magixFireLog('Success','Status');
											$firebug->magixFireLog($source,'Source');
											$firebug->magixFireLog($cible,'Cible');
											$firebug->magixFireGroupEnd();
										}
									}
								}	
							}else{
								$error .= 'Erreur d\'écriture du disque';
							}
						//}
					}
				}elseif (UPLOAD_ERR_INI_SIZE == true){
					$error .=  'Le fichier est trop grand';
				}elseif (UPLOAD_ERR_CANT_WRITE == true){
					$error .= 'Erreur d\'écriture du disque';	
				}elseif (UPLOAD_ERR_FORM_SIZE == true){
					$error .= 'Le fichier est trop grand: Taille maximum 2000x2000';
				}
			}elseif (UPLOAD_ERR_NO_FILE == true){
				$error .= 'Aucun fichier';
			}else{
				$error .= 'Erreur d\'écriture du disque';
			}
		if($error != null){
			$n = $firebug->magixFireGroup('Upload image analyse');
			$n .= $firebug->magixFireLog($error);
			$n .= $firebug->magixFireGroupEnd();
		}else{
			$n = NULL;
		}
		return $n;
	}

    /**
     * Retourne un tableau associatif des valeurs pour les tailles images
     * @param $attr_name
     * @param $config_size_attr
     * @return array
     */
    public function arrayImgSize($attr_name,$config_size_attr){
        $dbconfig = new backend_db_config();
        return $dbconfig->s_img_size($attr_name,$config_size_attr);
    }

    /**
     * Retourne les valeurs suivant l'attribut sous forme d'un tableau pour les tailles images
     * @param $attr_name
     * @param $config_size_attr
     * @param $type
     * @return array
     */
    public function dataImgSize($attr_name,$config_size_attr,$type){
        $dbconfig = new backend_db_config();
        return $dbconfig->s_img_size_data($attr_name,$config_size_attr,$type);
    }
}
?>