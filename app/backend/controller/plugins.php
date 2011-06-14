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
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.6
 * update 13/03/2011
 * @author Gérits Aurélien <aurelien@magix-cms.com> 
 * @name plugins
 *
 */
class backend_controller_plugins{
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
	private static $ConfigFile = 'admin_local_';
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour les emails
	 * @var string
	 */
	private static $MailConfigFile = 'admin_mail_';
	/**
	 * Constructor
	 */
	public function __construct(){
		if(isset($_GET['name'])){
			$this->getplugin = (string) magixcjquery_filter_isVar::isPostAlpha($_GET['name']);
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
				self::$_createInstance = new backend_controller_plugins();
			}
      	}
		return self::$_createInstance;
    }
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access protected
	 * getplugin
	 */
	private function getplugin(){
		if(isset($this->getplugin) != null){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['name']);
		}
	}
	/**
	 * @access private
	 * Retourne le chemin vers le dossier I18N du plugin
	 */
	private function path_dir_i18n(){
		$dir_i18n = $this->directory_plugins().$this->getplugin().self::I18N.DIRECTORY_SEPARATOR;
		if(file_exists($dir_i18n)){
			return $dir_i18n;
		}
	}
	/**
	 * Retourne l'icon du plugin si elle existe
	 * @param $plugin (string)
	 * @return string
	 */
	private function icon_plugin($plugin){
		if(file_exists($this->directory_plugins().$plugin.DIRECTORY_SEPARATOR.'icon.png')){
			$icon = '<img src="/plugins/'.$plugin.'/icon.png" width="16" height="16" alt="icon '.$plugin.'" />';
		}else{
			$icon = '<span style="float:left;" class="magix-icon magix-icon-plugin-arrow"></span>';
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
		if(!is_readable($this->directory_plugins())){
			throw new exception('Plugin dir is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
		if($dir != null){
			plugins_Autoloader::register();
			$list = '<ul class="plugin-list">';
				foreach($dir as $d){
					if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
						$pluginPath = $this->directory_plugins().$d;
						if($makefiles->scanDir($pluginPath) != null){
							//Nom de la classe pour le test de la méthode
							$class = 'plugins_'.$d.'_admin';
							//Si la méthode run existe on ajoute le plugin dans le menu
							if(method_exists($class,'run')){
								$list .= '<li>'.$this->icon_plugin($d).
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
		return $this->listing_plugin();
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
			//Si le fichier admin.php existe dans le plugin
			if(file_exists($this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR.'admin.php')){
				//Si la classe exist on recherche la fonction run()
				if(class_exists('plugins_'.$this->getplugin().'_admin')){
					$load = $this->execute_plugins('plugins_'.$this->getplugin().'_admin');
					//Si la méthode existe on ajoute le plugin dans le register et execute la fonction run()
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.$this->getplugin().' is not found');
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
	public function pluginName(){
		return $this->getplugin();
	}
	/**
	 * Retourne l'url du plugin
	 * @access public
	 * @static
	 * pluginUrl
	 */
	public function pluginUrl(){
		return '/admin/plugins.php?name='.$this->pluginName();
	}
	/**
	 * Retourne le chemin du dossier du plugin courant
	 */
	public function pluginDir(){
		return $this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR;
	}
	/**
	 * Retourne le chemin du dossier du plugin courant
	 */
	public function pluginPath(){
		return self::PATHPLUGINS.'/'.$this->getplugin();
	}
	/**
	 * Retourne la langue courante
	 * @return string
	 * @access public 
	 * @static
	 */
	public function sessionLanguage(){
		if(isset($_SESSION['mc_adminlanguage'])){
			if(!empty($_SESSION['mc_adminlanguage'])){
				return magixcjquery_filter_join::getCleanAlpha($_SESSION['mc_adminlanguage'],3);
			}
		}
	}
	/**
	 * Chargement du fichier de configuration suivant la langue.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile){
		try {
			return $this->path_dir_i18n().$configfile.$this->sessionLanguage.'.conf';
		} catch (Exception $e) {
			magixglobal_model_system::magixlog("Error path config", $e);
		}
	}
	/**
	 * Affiche le template du plugin
	 * @param void $page
	 */
	public function append_display($page,$cache_id = null,$compile_id = null){
		backend_config_smarty::getInstance()->addTemplateDir($this->directory_plugins().$this->getplugin().'/skin/admin/');
		return backend_config_smarty::getInstance()->display($page,$cache_id,$compile_id);
	}
	/**
	 * Retourne le résultat du template plugin
	 * @param void $page
	 */
	public function append_fetch($page,$cache_id = null,$compile_id = null){
		backend_config_smarty::getInstance()->addTemplateDir($this->directory_plugins().$this->getplugin().'/skin/admin/');
		return backend_config_smarty::getInstance()->fetch($page,$cache_id,$compile_id);
	}
	/**
	 * Assign une variable pour smarty
	 * @param void $page
	 */
	public function append_assign($assign,$fetch){
		if($assign){
			return backend_config_smarty::getInstance()->assign($assign,$fetch);
		}else{
			throw new Exception('Unable to assign a variable in template');
		}
	}
	/**
	 * Charge le fichier de configuration associer à la langue
	 * @param string $sections (optionnel) :la section à charger
	 */
	public function configLoad($sections = false){
		return backend_config_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$ConfigFile), $sections
		);
	}
	/**
	 * Charge le fichier de configuration pour les mails associer à la langue
	 * @param string $sections (optionnel) :la section à charger
	 */
	public function configLoadMail($sections = false){
		return backend_config_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$MailConfigFile), $sections
		);
	}
	/**
	 * Affiche les pages phtml supplémentaire
	 * @param void $page
	 */
	public function isCached($page){
		return backend_config_smarty::getInstance()->isCached($page);
	}
	/**
	 * @access public
	 * Active le système de debug de smarty 3
	 */
	public function getDebugging(){
		return backend_config_smarty::getInstance()->getDebugging();
	}
	/**
	 * @access public
	 * Active le test de l'installation de smarty 3
	 */
	public function testInstall(){
		return backend_config_smarty::getInstance()->testInstall();
	}
	/**
	 * @access public
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	private function display_plugins(){
		if($this->getplugin()){
			try{
				backend_config_smarty::getInstance()->assign('pluginName',$this->pluginName());
				backend_config_smarty::getInstance()->assign('pluginUrl',$this->pluginUrl());
				backend_config_smarty::getInstance()->assign('pluginPath',$this->pluginPath());
				$this->load_plugin();
			}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
		}
	}
	public function run(){
		$this->display_plugins();
	}
//####### INSTALL TABLE ######
	/**
	 * @access private
	 * load sql file
	 */
	private function load_sql_file($filename){
		return backend_controller_plugins::pluginDir().'sql'.DIRECTORY_SEPARATOR.$filename;
	}
	/**
	 * @access public
	 * @static
	 * Installation des tables mysql du plugin
	 */
	public function db_install_table($filename,$fetchFile){
		try{
			if(file_exists($this->load_sql_file($filename))){
				if(magixglobal_model_db::create_new_sqltable($this->load_sql_file($filename))){
					$this->append_assign('refresh_plugins','<meta http-equiv="refresh" content="3";URL="'.$this->pluginUrl().'">');
					$fetch = $this->append_fetch($fetchFile);
					$this->append_assign('install_db',$fetch);
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('Error install table '.$this->pluginName().':',$e);
		}
	}
}