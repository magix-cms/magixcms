<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   clear 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name clearcache
 * Le plugin clearcache nettoie les caches tpl et GZ de l'installation
 *
 */
class plugins_clearcache_admin{
	/**
	 * @access public
	 * @var GET clear
	 */
	public $clear;
	/**
	 * @access public
	 * Constructor
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('clear')){
			$this->clear = (string) magixcjquery_form_helpersforms::inputClean($_POST['clear']);
		}
	}
	/**
	 * @access protected
	 * @param nom du dossier de caches dossier $dir
	 */
	protected function path_var_dir($dir){
		$vardir = magixglobal_model_system::base_path().'var'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
		if(file_exists($vardir)){
			return $vardir;
		} else{
			$magixfire = new magixcjquery_debug_magixfire();
			$magixfire->magixFireError(new Exception('Error: var is not exist'));
		}
	}
	/**
	 * @access private
	 * @param string $dir
	 * Suppression des caches
	 */
	private function clear_dir_caches($dir){
		$makefile = new magixcjquery_files_makefiles();
		$scandir = $makefile->scanDir($this->path_var_dir($dir),'.htaccess');
		$clean = '';
		if($scandir != null){
			foreach($scandir as $file){
				$clean .= $makefile->removeFile($this->path_var_dir($dir),$file);
			}
		}
		backend_controller_plugins::create()->append_display('success.phtml');
	}
	/**
	 * Execute le suppression du/des caches
	 * @access private
	 */
	private function initStartClear(){
		switch($this->clear){
			case "caches":
				$this->clear_dir_caches('caches');
			break;
			case "tpl":
				$this->clear_dir_caches('templates_c');
			break;
			case "admin":
				$this->clear_dir_caches('tpl_admin');
			break;
		}
	}
	/**
	 * @access public
	 * Execute le plugin
	 */
	public function run(){
		//Si on veut supprimer les caches
		if(isset($this->clear)){
			$this->initStartClear();
		//Si on veut modifier un onglet catalogue
		}else{
			// Retourne la page index.phtml
			backend_controller_plugins::create()->append_display('index.phtml');
		}
	}
}