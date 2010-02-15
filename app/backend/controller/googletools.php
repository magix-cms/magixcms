<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com> * @name Google Tools
 * @version 1.0
 *
 */
class backend_controller_googletools{
	/**
	 * @access public
	 * string
	 * @var webmaster
	 */
	public $webmaster;
	/**
	 * @access public
	 * string
	 * @var analytics
	 */
	public $analytics;
	/**
	 * Function construct
	 */
	function __construct(){
		if(isset($_POST['webmaster'])){
			$this->webmaster = magixcjquery_form_helpersforms::inputClean($_POST['webmaster']);
		}
		if(isset($_POST['analytics'])){
			$this->analytics = magixcjquery_form_helpersforms::inputClean($_POST['analytics']);
		}
	}
	/**
	 * Charge les données dans le formulaire
	 * @access public
	 */
	public function load_gdata_field(){
		$gdata = backend_db_googletools::adminDbGtools()->s_google_tools_widget();
		backend_config_smarty::getInstance()->assign('webmaster',$gdata['webmaster']);
		backend_config_smarty::getInstance()->assign('analytics',$gdata['analytics']);
	}
	/**
	 * Insert le code webmaster tools et analytics dans la base de donnée.
	 * @access protected
	 */
	protected function u_gdata(){
		if(isset($this->webmaster) AND isset($this->analytics)){
			/*if(empty($this->webmaster) OR empty($this->analytics)){
				$fetch = backend_config_smarty::getInstance()->fetch('request/empty.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}else{*/
				backend_db_googletools::adminDbGtools()->u_google_tools(
						$this->webmaster,
						$this->analytics
					);
				$fetch = backend_config_smarty::getInstance()->fetch('request/success.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			//}
		}
	}
	/**
	 * affiche la page du formulaire pour l'insertion.
	 */
	public function display_gdata(){
		self::u_gdata();
		self::load_gdata_field();
		backend_config_smarty::getInstance()->display('googletools/index.phtml');
	}
}