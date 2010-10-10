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
		return magixcjquery_html_helpersHtml::getUrl().'/version.xml';
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
	/**
	 * Compare la version local et la version distante
	 */
	private function compare_version(){
		try {
		$http_contexte = stream_context_create(
		    array(
		        'http' => array(
		            'method' => 'GET',
		    		'header '=> 'HEAD',
		            'timeout' => 5
		        )
		    )
		);
		/*
		 * Si le fichier n'est pas accessible une erreur est retourné.
		 */
		if(!$stream = @fopen('http://www.logiciel-referencement-professionnel.com/version.xml', 'r', false, $http_contexte)){
			$compare = '<div style="margin:3px 3px 1px 0px;padding:3px;" class="ui-state-error ui-corner-all">
					<span style="float:left;" class="ui-icon ui-icon-alert"></span>
			Serveur indisponible</div>';
			fclose($stream);
		}else{
			$xml = new SimpleXMLElement('http://www.logiciel-referencement-professionnel.com/version.xml',0, TRUE);
			$magixv = $xml->number;
			$localv = self::read_local_version();
				if(strcmp($localv , $magixv)){
					$compare = '<div style="margin:3px 3px 1px 0px;padding:3px;" class="ui-state-error ui-corner-all">
					<span style="float:left;" class="ui-icon ui-icon-alert"></span>
					Une nouvelle version est disponible :'.$magixv.'&nbsp;'.$xml->phase.'</div>';
				}else{
					$compare = '<div style="margin:3px 3px 1px 0px;padding:3px;" class="ui-state-highlight ui-corner-all">
					<span style="float:left;" class="ui-icon ui-icon-check"></span>
					Vous utilisez la dernière version</div>';
				}
			}
			fclose($stream);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		return $compare;
	}
	/**
	 * Retourne le résultat de la comparaison de version
	 */
	private function check_version(){
		return self::compare_version();
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
		$licence = backend_model_setting::select_uniq_setting('licence');
		backend_config_smarty::getInstance()->assign('licence', $licence['setting_value']);
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