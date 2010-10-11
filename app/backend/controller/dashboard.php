<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name dashboard
 *
 */
class backend_controller_dashboard{
	/**
	 * @static 
	 * @var readInstance
	 */
	static protected $SimpleXMLElement;
	/**
	 * function construct
	 *
	 */
	function __construct(){}
	/**
	 * Charge le fichier version.xml courant
	 * @return string
	 */
	private function load_local_file(){
		return magixglobal_model_system::base_path().'version.xml';
	}
	/**
	 * Lit le fichier version.xml local et retourne le numéro de version
	 */
	private function read_local_version(){
		try {
			$xml = new SimpleXMLElement(self::load_local_file(),0, TRUE);
			$v = $xml->number;
		} catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		return $v;
	}
	/**
	 * Lit le fichier version.xml local et retourne la phase en court (alpha,beta,RC,Stable)
	 */
	private function read_local_phase(){
		try {
			$xml = new SimpleXMLElement(self::load_local_file(),0, TRUE);
			$v = $xml->phase;
		} catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		return $v;
	}
	/*
	 * Affiche la version du CMS ainsi que le message attaché
	 */
	public function version_cms(){
			$version = '<strong>'.self::read_local_version().'</strong> ('.self::read_local_phase().')';
			backend_config_smarty::getInstance()->assign('version', $version);
			backend_config_smarty::getInstance()->display('dashboard/version.phtml');
	}
	/**
	 * Retourne le dashboard
	 */
	private function display(){
		backend_config_smarty::getInstance()->display('dashboard/index.phtml');
	}
	/**
	 * Execute les scripts du dashboard
	 */
	public function run(){
		self::display();
	}
}
?>