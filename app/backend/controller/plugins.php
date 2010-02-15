<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name CMS
 * @version 4.0
 *
 */
class backend_controller_plugins{
	/**
	 * 
	 * @var string
	 */
	public $getplugin;
	/**
	 * 
	 */
	function __construct(){
		if(isset($_GET['plugin'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['plugin']);
		}
	}
	protected function getplugin(){
		if(isset($_GET['plugin'])){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['plugin']);
		}
	}
	/**
	 * Construction de la navigation pour les plugins utilisateurs
	 */
	function constructNavigation(){
		$sidebar = null;
		if(backend_db_plugins::s_plugins_navigation_construct() != null){
			$sidebar .= '<ul>';
			foreach(backend_db_plugins::s_plugins_navigation_construct() as $mconstruct){
				$sidebar .= '<li><span style="float:left;" class="ui-icon ui-icon-wrench"></span><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'admin'.magixcjquery_html_helpersHtml::unixSeparator().'dashboard'.magixcjquery_html_helpersHtml::unixSeparator().'plugin'.magixcjquery_html_helpersHtml::unixSeparator().$mconstruct['pname'].magixcjquery_html_helpersHtml::unixSeparator().'">'.magixcjquery_string_convert::ucFirst($mconstruct['pname']).'</a></li>';
			}
			$sidebar .= '</ul>';
		}
		return $sidebar;
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	protected function execute_plugins($className){
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
	public static function pluginName(){
		$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
		return $plugin['pname'];
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_display($page){
		$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
		backend_config_smarty::getInstance()->display($plugin['pname'].$page);
	}
	/**
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	function display_plugins(){
		if(isset($this->getplugin)){
			try{
			$plugin = backend_db_plugins::s_plugins_page_index($this->getplugin);
			backend_config_smarty::getInstance()->assign('pluginName',$plugin['pname']);
			//backend_config_smarty::getInstance()->display($plugin['pname'].'/index.phtml');
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/app/backend/plugins/'.$plugin['pname'].'.php')){
				if(class_exists('backend_plugins_'.$plugin['pname'])){
					$create = self::execute_plugins('backend_plugins_'.$plugin['pname']);
					$create->run();
				}
			}else{
				throw new exception('Ce plugin est inexistant'); 
			}
			}catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
		        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
		        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
		        magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
}