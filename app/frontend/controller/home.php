<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name home
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