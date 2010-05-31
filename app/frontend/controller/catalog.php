<?php
/**
 * @category   Controller 
 * @package    CATALOG
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_controller_catalog{
	/**
	 * variable des langues
	 * @var string
	 */
	public $slang;
	public $idclc;
	public $idcls;
	public $idcatalog;
	public $getlang;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_SESSION['strLangue'])){
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['idclc'])){
			$this->idclc = magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
		}
		if(isset($_GET['idcls'])){
			$this->idcls = magixcjquery_filter_isVar::isPostNumeric($_GET['idcls']);
		}
		if(isset($_GET['idcatalog'])){
			$this->idcatalog = magixcjquery_filter_isVar::isPostNumeric($_GET['idcatalog']);
		}
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
	}
	/**
	 * @access protected function
	 * retourne une traduction pour la construction de l'url catalogue
	 * @return string
	 */
	private function session_language(){
		switch($this->getlang){
			case 'fr':
			$langsession = 'catalogue';
				break;
			case 'en':
			$langsession = 'catalog';
				break;	
			case 'de':
			$langsession = 'katalog';
				break;
			case 'nl':
			$langsession = 'catalog';
				break;	
			default:
			$langsession = 'catalogue';
		}
		return $langsession;
	}
	/**
	 * Charge le titre d'une fiche catalogue
	 */
	public function load_product_page(){
		if(isset($this->getlang)){
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_with_language($this->idclc,$this->idcatalog,$this->getlang);
			switch($products['idcls']){
				case 0:
					$scategory = '';
				break;
				default:
					$scategory = magixcjquery_html_helpersHtml::unixSeparator().$products['pathslibelle'].'-'.$products['idcls'];
				break;
			}
			/**
			 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
			 */
			$imgc = '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$imgc .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$imgc .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$products['pathclibelle'].'-'.$products['idclc'].$scategory.magixcjquery_html_helpersHtml::unixSeparator().$products['urlcatalog'].'-'.$products['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';
			}
			$imgc .= '</div>';
			$page = frontend_config_smarty::getInstance()->assign('titlecatalog',$products['titlecatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('category',$products['clibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('subcategory',$products['slibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('imgcatalog',$imgc);
			$page .= frontend_config_smarty::getInstance()->assign('desccatalog',$products['desccatalog']);
		}else{
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idcatalog);
			switch($products['idcls']){
				case 0:
					$scategory = '';
				break;
				default:
					$scategory = magixcjquery_html_helpersHtml::unixSeparator().$products['pathslibelle'].'-'.$products['idcls'];
				break;
			}
			/**
			 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
			 */
			$imgc = '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$imgc .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/medium/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$imgc .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$products['pathclibelle'].'-'.$products['idclc'].$scategory.magixcjquery_html_helpersHtml::unixSeparator().$products['urlcatalog'].'-'.$products['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';

			}
			$imgc .= '</div>';
			$page = frontend_config_smarty::getInstance()->assign('titlecatalog',$products['titlecatalog']);
			$page .= frontend_config_smarty::getInstance()->assign('category',$products['clibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('subcategory',$products['slibelle']);
			$page .= frontend_config_smarty::getInstance()->assign('imgcatalog',$imgc);
			$page .= frontend_config_smarty::getInstance()->assign('desccatalog',$products['desccatalog']);
		}
		return $page;
	}
	/**
	 * Affiche la page des categories du catalogue
	 * @access public
	 */
	public function display_category(){
		$catname = frontend_db_catalog::publicDbCatalog()->s_current_name_category($this->idclc);
		frontend_config_smarty::getInstance()->assign('clibelle',magixcjquery_string_convert::ucFirst($catname['clibelle']));
		frontend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	/**
	 * Affiche la page des sous categories du catalogue
	 * @access public
	 */
	public function display_sub_category(){
		$catname = frontend_db_catalog::publicDbCatalog()->s_current_name_subcategory($this->idcls);
		frontend_config_smarty::getInstance()->assign('slibelle',magixcjquery_string_convert::ucFirst($catname['slibelle']));
		frontend_config_smarty::getInstance()->display('catalog/subcategory.phtml');
	}
	/**
	 * Affiche la page du produit selectionner du catalogue
	 * @access public
	 */
	public function display_product(){
		self::load_product_page();
		frontend_config_smarty::getInstance()->display('catalog/product.phtml');
	}
	/**
	 * Affiche la page ROOT du catalogue
	 * @access public
	 */
	public function display_catalog(){
		frontend_config_smarty::getInstance()->display('catalog/index.phtml');
	}
}