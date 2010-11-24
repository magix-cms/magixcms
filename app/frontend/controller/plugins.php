<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.3
 * update 24/11/2010
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name plugins
 *
 */
class frontend_controller_plugins{
/**
	 * Constante
	 * @var string
	 */
	const plugins = 'plugins/';
	/**
	 * 
	 * @var string
	 */
	public $getplugin;
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'local';
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour les emails
	 * @var string
	 */
	private static $MailConfigFile = 'mail';
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_GET['magixmod'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['magixmod']);
		}
	}
	/**
	 * @access private
	 * return void
	 * Le chemin du dossier des plugins
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path().self::plugins;
	}
	/**
	 * @access protected
	 * getplugin
	 */
	public static function getplugin(){
		if(isset($_GET['magixmod'])){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['magixmod']);
		}
	}
	/*public static function addTemplate($plugin){
		frontend_config_smarty::getInstance()->addTemplateDir($_SERVER['DOCUMENT_ROOT'].'/plugins/'.$plugin.'/');
	}*/
	private function controlGetPlugin($plugin=''){
		if(!$plugin == ''){
			$pluginName = $plugin;
		}else{
			$pluginName = self::getplugin();
		}
		return $pluginName;
	}
	/**
	 * Retourne la langue courante
	 * @return string
	 * @access public 
	 * @static
	 */
	public static function current_Language(){
		//return !empty($_SESSION['strLangue']) ? magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3) : '';
		return !empty($_GET['strLangue']) ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3) : '';
	}
	/**
	 * Chargement du fichier de configuration suivant la langue en cours de session.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile){
		try {
			return $configfile.self::current_Language().'.conf';
		} catch (Exception $e) {
			magixglobal_model_system::magixlog("Error path config", $e);
		}
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_display($page,$plugin=''){
		return frontend_config_smarty::getInstance()->display(self::directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$page);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_fetch($page,$plugin=''){
		return frontend_config_smarty::getInstance()->fetch(self::directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$page);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 */
	public static function append_assign($assign,$fetch){
		return frontend_config_smarty::getInstance()->assign($assign,$fetch);
	}
	/**
	 * Charge les variables du fichier de config dans le site
	 * @param string $varname
	 */
	public static function getConfigVars($varname){
		return frontend_config_smarty::getInstance()->getConfigVars($varname);
	}
	/**
	 * Charge le fichier de configuration associer à la langue
	 * @param string $sections (optionnel) :la section à charger
	 */
	public static function configLoad($sections = false){
		return frontend_config_smarty::getInstance()->configLoad(self::pathConfigLoad(self::$ConfigFile), $sections = false);
	}
	/**
	 * Affiche les pages phtml supplémentaire
	 * @param void $page
	 */
	public static function isCached($page){
		return frontend_config_smarty::getInstance()->isCached($page);
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function execute_plugins($className){
		try{
			$class =  new $className;
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
		return $class;
	}
	/**
	 * Chargement d'un plugin dans la partie public
	 * @access private
	 */
	private function load_plugin(){
		try{
			plugins_Autoloader::register();
			if(file_exists(magixglobal_model_system::base_path().'plugins/'.self::getplugin().'/public.php')){
				if(class_exists('plugins_'.self::getplugin().'_public')){
					$load = self::execute_plugins('plugins_'.self::getplugin().'_public');
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.self::getplugin().' not define');
				}
			}
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
	}
	/**
	 * @access public
	 * @static
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	public static function display_plugins(){
		if(self::getplugin()){
			try{
				self::load_plugin();
			}catch(Exception $e) {
				magixglobal_model_system::magixlog("Error plugins execute", $e);
			}
		}
	}
}