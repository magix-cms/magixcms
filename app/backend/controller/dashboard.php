<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * dashboard
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
		} catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
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
		} catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
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
		} catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
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
			/*backend_config_smarty::getInstance()->cache_lifetime = 3600 * 4;
			backend_config_smarty::getInstance()->caching = 1;*/
			$version = '<strong>'.self::read_local_version().'</strong> ('.self::read_local_phase().')';
			//$version .= self::check_version();
			/*if(!backend_config_smarty::getInstance()->is_cached('dashboard/version.phtml')) {
		      // suppression du phtml du cache
		      backend_config_smarty::getInstance()->clear_cache('dashboard/version.phtml');
		      // ajout de la version au fichier
		      backend_config_smarty::getInstance()->assign('version', $version);
			}*/
			backend_config_smarty::getInstance()->assign('version', $version);
			backend_config_smarty::getInstance()->display('dashboard/version.phtml');
	}
	public function display(){
		//try {
		  //magixcjquery_debug_magixfire::magixFireDump('test',array('test'=>'test'));
		  /*magixcjquery_debug_magixfire::magixFireGroup('Test Group');
		  magixcjquery_debug_magixfire::magixFireLog('Hello World');
		  magixcjquery_debug_magixfire::magixFireGroupEnd();
		  magixcjquery_debug_magixfire::magixFireGroup('Mettre de la couleur dans un groupe',
                array('Collapsed' => false,
                      'Color' => '#FF00FF')
          );
          magixcjquery_debug_magixfire::magixFireLog('Hello le monde');
          magixcjquery_debug_magixfire::magixFireWarn('Personne ne répond');
          magixcjquery_debug_magixfire::magixFireError('La folie me gagne');
          magixcjquery_debug_magixfire::magixFireInfo('Je me soigne');
		  magixcjquery_debug_magixfire::magixFireGroupEnd();*/
		/*$test = '$(document).ready(function(){
              $("#accordion").accordion({
                           active:2,event:"mouseover",
                          icons:{header:"ui-icon-circle-arrow-e",headerSelected:"ui-icon-circle-arrow-s"}
              });';
		$comp = new magixcjquery_compjs_minify();
		$comp->_optionsPacker(
			array('encoding'=> 0,
			'fastDecode'=> true,
			'specialChars'=> false
			)
		);
	    print $comp->jscompressor('packer',$test);*/ 
		$licence = backend_model_setting::select_uniq_setting('licence');
		backend_config_smarty::getInstance()->assign('licence', $licence['setting_value']);
		backend_config_smarty::getInstance()->display('dashboard/index.phtml');
	}
}
?>