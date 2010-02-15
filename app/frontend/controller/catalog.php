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
	protected function session_language(){
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
	 * Charge L'image d'une fiche catalogue si elle existe sinon retourne une image fictive
	 */
	function load_imgcatalog_product_page(){
		$subcat = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idcatalog);
		switch($subcat['idcls']){
			case 0:
				$scategory = '';
			break;
			default:
				$scategory = magixcjquery_html_helpersHtml::unixSeparator().$subcat['pathslibelle'].'-'.$subcat['idcls'];
			break;
		}
		$page = '';
		if(isset($this->getlang)){
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_with_language($this->idclc,$this->idcatalog,$this->getlang);
			$page .= '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$page .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$page .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$this->getlang.magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$products['pathclibelle'].'-'.$products['idclc'].$scategory.magixcjquery_html_helpersHtml::unixSeparator().$products['urlcatalog'].'-'.$products['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'public/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';
			}
			$page .= '</div>';
		}else{
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idcatalog);
			$page .= '<div class="img-product">';
			if($products['imgcatalog'] != null){
				$page .= '<a class="imagebox" href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/product/'.$products['imgcatalog'].'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/medium/'.$products['imgcatalog'].'" alt="'.$products['titlecatalog'].'" /></a>';
			}else{
				$page .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().self::session_language().magixcjquery_html_helpersHtml::unixSeparator().$products['pathclibelle'].'-'.$products['idclc'].$scategory.magixcjquery_html_helpersHtml::unixSeparator().$products['urlcatalog'].'-'.$products['idcatalog'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'public/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$products['titlecatalog'].'" /></a>';

			}
			$page .= '</div>';
		}
		return $page;
	}
	/**
	 * Charge le titre d'une fiche catalogue
	 */
	function load_titlecatalog_product_page(){
		if(isset($this->getlang)){
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_with_language($this->idclc,$this->idcatalog,$this->getlang);
			$page = magixcjquery_string_convert::ucFirst($products['titlecatalog']);
		}else{
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idcatalog);
			$page = magixcjquery_string_convert::ucFirst($products['titlecatalog']);
		}
		return $page;
	}
	/**
	 * Charge le contenu d'une fiche catalogue
	 */
	function load_contentcatalog_product_page(){
		if(isset($this->getlang)){
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_with_language($this->idclc,$this->idcatalog,$this->getlang);
			$page = $products['desccatalog'];
		}else{
			$products = frontend_db_catalog::publicDbCatalog()->s_product_page_no_language($this->idclc,$this->idcatalog);
			$page = $products['desccatalog'];
		}
		return $page;
	}
	/**
	 * 
	 */
	function display_category(){
		$catname = frontend_db_catalog::publicDbCatalog()->s_current_name_category($this->idclc);
		frontend_config_smarty::getInstance()->assign('clibelle',magixcjquery_string_convert::ucFirst($catname['clibelle']));
		frontend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	function display_sub_category(){
		$catname = frontend_db_catalog::publicDbCatalog()->s_current_name_subcategory($this->idcls);
		frontend_config_smarty::getInstance()->assign('slibelle',magixcjquery_string_convert::ucFirst($catname['slibelle']));
		frontend_config_smarty::getInstance()->display('catalog/subcategory.phtml');
	}
	/**
	 * 
	 */
	function display_product(){
		frontend_config_smarty::getInstance()->assign('titlecatalog',self::load_titlecatalog_product_page());
		frontend_config_smarty::getInstance()->assign('imgcatalog',self::load_imgcatalog_product_page());
		frontend_config_smarty::getInstance()->assign('desccatalog',self::load_contentcatalog_product_page());
		frontend_config_smarty::getInstance()->display('catalog/product.phtml');
	}
	function display_catalog(){
		frontend_config_smarty::getInstance()->display('catalog/index.phtml');
	}
}