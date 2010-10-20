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
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name plugins
 *
 */
class frontend_controller_plugins{
/**
	 * Constante
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
		return $_SERVER['DOCUMENT_ROOT'].self::plugins;
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
	 * Chargement d'un plugin dans la partie public
	 * @access private
	 */
	private function load_plugin(){
		try{
			plugins_Autoloader::register();
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/plugins/'.self::getplugin().'/public.php')){
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
			$log = magixcjquery_error_log::getLog();
		    $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
		    $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
		    magixcjquery_debug_magixfire::magixFireError($e);
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
				$log = magixcjquery_error_log::getLog();
		        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
		        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
		        magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
}