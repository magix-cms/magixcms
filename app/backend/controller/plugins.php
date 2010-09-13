<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name plugins
 *
 */
class backend_controller_plugins{
	/**
	 * Cosntante
	 * @var string
	 */
	const plugins = 'plugins';
	/**
	 * 
	 * @var string
	 */
	public $getplugin;
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_GET['name'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['name']);
		}
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.self::plugins.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access protected
	 * getplugin
	 */
	private function getplugin(){
		if(isset($_GET['name']) != null){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['name']);
		}
	}
	/**
	 * Retourne l'icon du plugin si elle existe
	 * @param $plugin (string)
	 * @return string
	 */
	private function icon_plugin($plugin){
		if(file_exists(self::directory_plugins().$plugin.DIRECTORY_SEPARATOR.'icon.png')){
			$icon = '<img src="'.magixcjquery_html_helpersHtml::getUrl().'/plugins/'.$plugin.'/icon.png" width="16" height="16" alt="icon '.$plugin.'" />';
		}else{
			$icon = '<span style="float:left;" class="ui-icon ui-icon-wrench"></span>';
		}
		return $icon;
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
		if($dir != null){
			plugins_Autoloader::register();
			$list = '<ul class="plugin-list">';
				foreach($dir as $d){
					if(file_exists(self::directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
						$pluginPath = self::directory_plugins().$d;
						if($makefiles->scanDir($pluginPath) != null){
							//Nom de la classe pour le test de la méthode
							$class = 'plugins_'.$d.'_admin';
							//Si la méthode run existe on ajoute le plugin dans le menu
							if(method_exists($class,'run')){
								$list .= '<li>'.self::icon_plugin($d).
								'<a href="/admin/plugins.php?name='.$d.'">'
								.magixcjquery_string_convert::ucFirst($d).'</a></li>';
							}
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
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
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
			//$plugin = backend_db_plugins::s_plugins_page_index(self::getplugin());
			if(file_exists(self::directory_plugins().self::getplugin().DIRECTORY_SEPARATOR.'admin.php')){
				//Si la classe exist on recherche la fonction run()
				if(class_exists('plugins_'.self::getplugin().'_admin')){
					$load = self::execute_plugins('plugins_'.self::getplugin().'_admin');
					//Si la méthode existe on ajoute le plugin dans le register et execute la fonction run()
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.self::getplugin().' not found');
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Retourne le nom du plugin
	 * @access public
	 * @static
	 * pluginName
	 */
	public static function pluginName(){
		return self::getplugin();
	}
	/**
	 * Retourne l'url du plugin
	 * @access public
	 * @static
	 * pluginUrl
	 */
	public static function pluginUrl(){
		return magixcjquery_html_helpersHtml::getUrl().'/plugins.php?name='.self::pluginName();
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_display($page){
		backend_config_smarty::getInstance()->addTemplateDir(self::directory_plugins().self::getplugin().'/skin/admin/');
		return backend_config_smarty::getInstance()->display($page);
	}
	/**
	 * Retourne les pages du plugin
	 * @param void $page
	 */
	public static function append_fetch($page){
		backend_config_smarty::getInstance()->addTemplateDir(self::directory_plugins().self::getplugin().'/skin/admin/');
		return backend_config_smarty::getInstance()->fetch($page);
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
	private function display_plugins(){
		if(self::getplugin()){
			try{
				backend_config_smarty::getInstance()->assign('pluginName',self::pluginName()/*$plugin['pname']*/);
				backend_config_smarty::getInstance()->assign('pluginUrl',self::pluginUrl());
				self::load_plugin();
			}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		}
	}
	public function run(){
		self::display_plugins();
	}
}