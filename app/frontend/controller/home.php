<?php
/**
 * @category   Controller 
 * @package    HomePage
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_controller_home{
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
	}
	/*
	 * Charge contenu de la page d'accueil courante
	 * @access public
	 */
	private function load_home_content(){
		$home = frontend_db_home::getHome()->s_home_page_construct($this->getlang);
		frontend_config_smarty::getInstance()->assign('subject',magixcjquery_string_convert::ucFirst($home['subject']));
		frontend_config_smarty::getInstance()->assign('content',$home['content']);
		frontend_config_smarty::getInstance()->assign('title',$home['metatitle']);
		frontend_config_smarty::getInstance()->assign('description',$home['metadescription']);
	}
	/**
	 * Retourne et affiche la page d'accueil courante
	 * @access public
	 */
	function display(){
		self::load_home_content();
		frontend_config_smarty::getInstance()->display('home/index.phtml');
	}
}
?>