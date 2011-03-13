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
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * update 11/02/2011
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name plugins
 *
 */
class frontend_controller_plugins{
	/**
	 * Constante PATHPLUGINS
	 * Défini le chemin vers le dossier des plugins
	 * @var string
	 */
	const PATHPLUGINS = 'plugins';
	/**
	 * Constante pour le dossier de traductions du plugin
	 */
	const I18N = 'i18n';
	/**
	 * 
	 * Define createInstance for Singleton
	 * @static
	 * @var $_createInstance
	 */
	private static $_createInstance = null;
	/**
	 * 
	 * @var string
	 */
	public $getplugin;
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'public_local_';
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour les emails
	 * @var string
	 */
	private static $MailConfigFile = 'public_mail_';
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_GET['magixmod'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['magixmod']);
		}
	}
	/**
     * instance singleton self (DataObjects)
     * @access public
     */
    public static function create(){
    	if (!isset(self::$_createInstance)){
    		if(is_null(self::$_createInstance)){
    			//$c = __CLASS__;
				self::$_createInstance = new frontend_controller_plugins();
			}
      	}
		return self::$_createInstance;
    }
	/**
	 * @access private
	 * return void
	 * Le chemin du dossier des plugins
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access public
	 * getplugin
	 */
	public function getplugin(){
		if(isset($_GET['magixmod'])){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['magixmod']);
		}
	}
	/**
	 * @access private
	 * Retourne le nom du plugin
	 * @param string $plugin
	 */
	private function controlGetPlugin($plugin=''){
		if(!$plugin == ''){
			$pluginName = $plugin;
		}else{
			$pluginName = $this->getplugin();
		}
		return $pluginName;
	}
	/**
	 * Retourne la langue courante
	 * @return string
	 * @access public 
	 * @static
	 */
	public function getLanguage(){
		if(isset($_GET['strLangue'])){
			if(!empty($_GET['strLangue'])){
				return magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			}
		}
	}
	/**
	 * @access private
	 * Retourne le chemin vers le dossier I18N du plugin
	 * @return string
	 */
	private function path_dir_i18n(){
		return $this->directory_plugins().self::controlGetPlugin().DIRECTORY_SEPARATOR.self::I18N.DIRECTORY_SEPARATOR;
	}
	/*public static function addTemplate($plugin){
		frontend_config_smarty::getInstance()->addTemplateDir($_SERVER['DOCUMENT_ROOT'].'/plugins/'.$plugin.'/');
	}*/
	/**
	 * Chargement du fichier de configuration suivant la langue en cours de session.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile,$filextension=false,$plugin=''){
		try {
			$filextends = $filextension ? $filextension : '.conf';
			if($this->getLanguage() == ''){
				$lang = '';
			}else{
				$lang = $this->getLanguage();
			}
			if(file_exists($this->path_dir_i18n())){
				$translate = !empty($lang) ? $lang : 'fr';
				return $this->path_dir_i18n().$configfile.$translate.$filextends;
			}else{
				return frontend_config_smarty::getInstance()->config_dir.'local'.$lang.$filextends;
			}
		} catch (Exception $e) {
			magixglobal_model_system::magixlog("Error path config", $e);
		}
	}
	/**
	 * @access public
	 * Affiche les pages du plugin
	 * @param void $page
	 * @param void $plugin
	 */
	public function append_display($page,$plugin='',$cache_id = null,$compile_id = null){
		return frontend_config_smarty::getInstance()->display(
			$this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$page,
			$cache_id,
			$compile_id
		);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 * @param void $plugin
	 */
	public function append_fetch($page,$plugin='',$cache_id = null,$compile_id = null){
		return frontend_config_smarty::getInstance()->fetch(
			$this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$page,
			$cache_id,
			$compile_id
		);
	}
	/**
	 * Affiche les pages du plugin
	 * @param void $page
	 * @param void $fetch
	 */
	public function append_assign($assign,$fetch){
		if($assign){
			return frontend_config_smarty::getInstance()->assign($assign,$fetch);
		}else{
			throw new Exception('Unable to assign a variable in template');
		}
	}
	/**
	 * Charge les variables du fichier de config dans le site
	 * @param string $varname
	 */
	public function getConfigVars($varname = null){
		return frontend_config_smarty::getInstance()->getConfigVars($varname);
	}
	/**
	 * Charge le fichier de configuration associer à la langue
	 * @param string $sections (optionnel) :la section à charger
	 */
	public function configLoad($sections = false){
		return frontend_config_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$ConfigFile), 
			$sections
		);
	}
	/**
	 * Charge le fichier de configuration pour les mails associer à la langue
	 * @param string $sections (optionnel) :la section à charger
	 */
	public function configLoadMail($sections = false){
		return frontend_config_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$MailConfigFile), 
			$sections
		);
	}
	/**
	 * Affiche les pages phtml supplémentaire
	 * @param void $page
	 */
	public function isCached($page){
		return frontend_config_smarty::getInstance()->isCached($page);
	}
	/**
	 * @access public
	 * Active le système de debug de smarty 3
	 */
	public function getDebugging(){
		return frontend_config_smarty::getInstance()->getDebugging();
	}
	/**
	 * @access public
	 * Active le test de l'installation de smarty 3
	 */
	public function testInstall(){
		return frontend_config_smarty::getInstance()->testInstall();
	}
	/**
	 * @access private
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function get_call_class($module){
		try{
			$class =  new $module;
			if($class instanceof $module){
				return $class;
			}else{
				throw new Exception('not instantiate the class: '.$module);
			}
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
	}
	/**
	 * Chargement d'un plugin dans la partie public
	 * @access private
	 */
	private function load_plugin(){
		try{
			plugins_Autoloader::register();
			if(file_exists($this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR.'public.php')){
				if(class_exists('plugins_'.$this->getplugin().'_public')){
					$load = $this->get_call_class('plugins_'.$this->getplugin().'_public');
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.$this->getplugin().' not define');
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
	public function display_plugins(){
		if($this->getplugin()){
			try{
				$this->load_plugin();
			}catch(Exception $e) {
				magixglobal_model_system::magixlog("Error plugins execute", $e);
			}
		}
	}
}