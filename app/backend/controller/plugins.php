<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.cms-site.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name PLUGINS
 * @version 1.3
 *
 */
class backend_controller_plugins{
	/**
	 * Cosntante
	 * @var string
	 */
	const plugins = '/plugins/';
	/**
	 * 
	 * @var string
	 */
	public $getplugin;
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_GET['plugin'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['plugin']);
		}
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return $_SERVER['DOCUMENT_ROOT'].self::plugins;
	}
	/**
	 * @access protected
	 * getplugin
	 */
	private function getplugin(){
		if(isset($_GET['plugin'])){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['plugin']);
		}
	}
	/**
	 * @access private
	 * listing plugin
	 */
	private function listing_plugin(){
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable(self::directory_plugins())){
			throw new exception('Plugin is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir(self::directory_plugins());
		/*$count = count($dir);
		if($count == 0){
			throw new exception('Plugin is not found');
		}*/
		/*if(!is_array($dir)){
			throw new exception('Plugin is not array');
		}*/
		if($dir != null){
			$list = '<ul>';
				foreach($dir as $d){
					if(file_exists(self::directory_plugins().$d.'/'.'admin.php')){
						$pluginPath = self::directory_plugins().$d;
						//if($pluginPath) continue;
						if($makefiles->scanDir($pluginPath) != null){
							$list .= '<li><span style="float:left;" class="ui-icon ui-icon-wrench"></span>
							<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'admin'.magixcjquery_html_helpersHtml::unixSeparator().'index.php?dashboard&amp;plugin='.$d.'">'
							.magixcjquery_string_convert::ucFirst($d).'</a></li>';
						}
					}
				}
			$list .= '</ul>';
		}
		return $list;
	}
	/**
	 * Construction de la navigation pour les plugins utilisateurs
	 * @access public
	 * @return void
	 */
	public function constructNavigation(){
		return self::listing_plugin();
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function execute_plugins($className){
		try{
			$class =  new $className;
		}catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
		}
		return $class;
	}
	/**
	 * Chargement d'un plugin pour l'administration
	 * @access private
	 */
	private function load_plugin(){
		try{
			plugins_Autoloader::register();
			$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/plugins/'.self::getplugin().'/admin.php')){
				if(class_exists('plugins_'.self::getplugin().'_admin')){
					$load = self::execute_plugins('plugins_'.self::getplugin().'_admin');
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.self::getplugin().' not found');
				}
			}
		}catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
		    $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
		    $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
		    magixcjquery_debug_magixfire::magixFireError($e);
		}
	}
	/**
	 * Retourne le nom du plugin
	 * @access public
	 * @static
	 * pluginName
	 */
	public static function pluginName(){
		//$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
		return self::getplugin();//$plugin['pname'];
	}
	/**
	 * Retourne l'url du plugin
	 * @access public
	 * @static
	 * pluginUrl
	 */
	public static function pluginUrl(){
		return magixcjquery_html_helpersHtml::getUrl().'/admin/index.php?dashboard&amp;plugin='.self::pluginName();
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_display($page){
		backend_config_smarty::getInstance()->addTemplateDir($_SERVER['DOCUMENT_ROOT'].'/plugins/'.self::getplugin().'/skin/admin/');
		backend_config_smarty::getInstance()->display($page);
	}
	/**
	 * Assign une variable pour smarty
	 * @param void $page
	 */
	public static function append_assign($assign,$fetch){
		return backend_config_smarty::getInstance()->assign($assign,$fetch);
	}
	/**
	 * @access public
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	public function display_plugins(){
		if(self::getplugin()){
			try{
			//$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
			backend_config_smarty::getInstance()->assign('pluginName',self::pluginName()/*$plugin['pname']*/);
			backend_config_smarty::getInstance()->assign('pluginUrl',self::pluginUrl());
			self::load_plugin();
			}catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
		        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
		        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
		        magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
}