<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name googletools
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
	 * Charge les données de google webmaster tools
	 * @access private
	 */
	private function load_webmaster_gdata(){
		$gdata = backend_model_setting::select_uniq_setting('webmaster');
		backend_config_smarty::getInstance()->assign('webmaster',$gdata['setting_value']);
	}
	/**
	 * Charge les données de google analytics
	 * @access private
	 */
	private function load_analytics_gdata(){
		$gdata = backend_model_setting::select_uniq_setting('analytics');
		backend_config_smarty::getInstance()->assign('analytics',$gdata['setting_value']);
	}
	/**
	 * Insert le code webmaster tools dans la base de donnée.
	 * @access protected
	 */
	private function update_webmastertools(){
		if(isset($this->webmaster)){
			backend_model_setting::update_setting_value('webmaster',$this->webmaster);
			backend_config_smarty::getInstance()->assign('googletools','Webmaster Tools');
			backend_config_smarty::getInstance()->display('googletools/request/success.phtml');
		}
	}
	/**
	 * Insert le code analytics dans la base de donnée.
	 * @access protected
	 */
	private function update_analytics(){
		if(isset($this->analytics)){
			backend_model_setting::update_setting_value('analytics',$this->analytics);
			backend_config_smarty::getInstance()->assign('googletools','Analytics');
			backend_config_smarty::getInstance()->display('googletools/request/success.phtml');
		}
	}
	/**
	 * affiche la page du formulaire pour l'insertion.
	 */
	public function display_gdata(){
		$this->load_webmaster_gdata();
		$this->load_analytics_gdata();
		backend_config_smarty::getInstance()->display('googletools/index.phtml');
	}
	/**
	 * Envoi les données des outils Google
	 */
	public function post_gdata(){
		$this->update_webmastertools();
		$this->update_analytics();
	}
}