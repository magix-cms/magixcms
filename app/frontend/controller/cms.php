<?php
/**
 * @category   Controller 
 * @package    CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_controller_cms{
	/**
	 * Langue
	 * @var string
	 */
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	/**
	 * Identifiant de la catégorie
	 * @var $getidcategory (integer)
	 */
	public $getidcategory;
	/**
	 * URL de la catégorie
	 * @var $getcat
	 */
	public $getcat;
	/**
	 * Url de la page
	 * @var $getpurl (integer)
	 */
	public $getpurl;
	/**
	 * Identifiant de la page
	 * @var $getidpage (integer)
	 */
	public $getidpage;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['getcat'])){
			$this->getcat = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getcat']);
		}
		if(isset($_GET['getpurl'])){
			$this->getpurl = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getpurl']);
		}
		if(isset($_GET['getidcategory'])){
			$this->getidcategory = magixcjquery_filter_isVar::isPostNumeric($_GET['getidcategory']);
		}
		if(isset($_GET['getidpage'])){
			$this->getidpage = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage']);
		}
	}
	/**
	 * Charge le contenu de la page courante si existe
	 * @access public
	 */
	public function load_cms_content_page(){
		$cms = frontend_db_cms::publicDbCms()->s_cms_page($this->getidpage);
		frontend_config_smarty::getInstance()->assign('subjectpage',magixcjquery_string_convert::ucFirst($cms['subjectpage']));
		frontend_config_smarty::getInstance()->assign('contentpage',$cms['contentpage']);
	}
	/**
	 * Retourne et affiche la page CMS avec le contenu dynamique
	 * @access public
	 */
	public function display(){
		self::load_cms_content_page();
		frontend_config_smarty::getInstance()->display('cms/index.phtml');
	}
}