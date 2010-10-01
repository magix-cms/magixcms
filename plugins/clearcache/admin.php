<?php
/**
 * MAGIX CMS
 * @category   clear 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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
	function __construct(){
		if(magixcjquery_filter_request::isGet('clear')){
			$this->clear = (string) magixcjquery_form_helpersforms::inputClean($_GET['clear']);
		}
	}
	/**
	 * @access protected
	 * @param nom du dossier de caches dossier $dir
	 */
	protected function path_var_dir($dir){
		return magixglobal_model_system::base_path().'var'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access private
	 * @param string $dir
	 * Suppression des caches
	 */
	private function clear_dir_caches($dir){
		$makefile = new magixcjquery_files_makefiles();
		$scandir = $makefile->scanDir(self::path_var_dir($dir),'.htaccess');
		$clean = '';
		if($scandir != null){
			foreach($scandir as $file){
				$clean .= $makefile->removeFile(self::path_var_dir($dir),$file);
			}
		}
		backend_controller_plugins::append_display('success.phtml');
	}
	/**
	 * Execute le suppression du/des caches
	 * @access private
	 */
	private function exec_clear(){
		switch($this->clear){
			case "caches":
				self::clear_dir_caches('caches');
			break;
			case "tpl":
				self::clear_dir_caches('templates_c');
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
			self::exec_clear();
		//Si on veut modifier un onglet catalogue
		}else{
			
			// Retourne la page index.phtml
			backend_controller_plugins::append_display('index.phtml');
		}
	}
}