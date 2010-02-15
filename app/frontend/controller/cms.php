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
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	public $getcat;
	public $getpurl;
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
			$this->getcat = ($_GET['getcat']);
		}
		if(isset($_GET['getpurl'])){
			$this->getpurl = ($_GET['getpurl']);
		}
	}
	function load_cms_content_page(){
		$cms = frontend_db_cms::publicDbCms()->s_cms_page($this->getpurl);
		frontend_config_smarty::getInstance()->assign('subjectpage',magixcjquery_string_convert::ucFirst($cms['subjectpage']));
		frontend_config_smarty::getInstance()->assign('contentpage',$cms['contentpage']);
	}
	/**
	 * 
	 */
	function display(){
		self::load_cms_content_page();
		frontend_config_smarty::getInstance()->display('cms/index.phtml');
	}
}