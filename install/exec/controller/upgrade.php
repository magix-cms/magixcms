<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   Controller 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name home
 *
 */
class exec_controller_upgrade extends db_upgrade{
	public $p_version;
	public function __construct(){
		if(magixcjquery_filter_request::isPost('p_version')){
			$this->p_version = magixcjquery_form_helpersforms::inputClean($_POST['p_version']);
		}
	}
	/**
	 * Charge le fichier version.xml courant
	 * @return string
	 */
	private function load_local_file(){
		$filename = magixglobal_model_system::base_path().'version.xml';
		if(file_exists($filename)){
			return $filename;
		}else{
			throw new Exception("File: version.xml is not exist");
		}
	}
	/**
	 * @access private
	 * Retourne le numéro de version courante
	 */
	private function xmlfile_current_version(){
		try {
			$xml = new SimpleXMLElement(self::load_local_file(),0, TRUE);
			$v = $xml->number;
			return $v;
		} catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * retourne la version courante dans la base de donnée
	 */
	private function load_current_version(){
		$set_version = parent::s_setting_version();
		if($set_version['setting_value'] != null){
			return $set_version['setting_value'];
		}
	}
	/**
	 * 
	 * Chemin du fichier SQL 
	 * @param string $version
	 */
	private function load_sql_file_version($version){
		return magixglobal_model_system::base_path().'install'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'upgrade.'.$version.'.sql';
	}
	private function sql_execute($version){
		try{
			if(file_exists($this->load_sql_file_version($version))){
				if(magixglobal_model_db::create_new_sqltable($this->load_sql_file_version($version))){
					
				}else{
					
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('Error update table :',$e);
		}
	}
	/**
	 * @access private
	 * Compare les versions XML et SQL
	 */
	public function compare_version(){
		/*$compare = strcmp(self::xmlfile_current_version(),self::load_current_version());
		return $compare;*/
		$config = '../app/config/config.php';
		if (file_exists($config)) {
			if (version_compare($this->load_current_version(),$this->xmlfile_current_version(),'<')){
				return false;
			}else{
				return true;
			}
		}else{
			return true;
		}
	}
	/*function http_fetch_url($url, $timeout = 10, $userpwd = ''){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if ($userpwd) {
			curl_setopt($ch, CURLOPT_USERPWD, $userpwd);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	function http_check_url($url, $timeout = 10){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_NOBODY, TRUE);
		if (strpos($url, 'https://') === 0) {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // On ne vérifie que l'existence de la page
		}
		if (!curl_exec($ch)) {
			return FALSE;
		}
		$ret = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
	return in_array($ret, array(200, 301, 302));
	}*/
	public function display_upgrade_page(){
		if(magixcjquery_filter_request::isGet('upgrade_version')){
			exec_config_smarty::getInstance()->display('update.phtml');
		}else{
			/*if(parent::s_t() != false){
				magixcjquery_debug_magixfire::magixFireLog('ok');
			}else{
				magixcjquery_debug_magixfire::magixFireLog('pas ok');
			}*/
			
			//$this->compare_version();
			exec_config_smarty::getInstance()->assign('current_version',$this->load_current_version());
			exec_config_smarty::getInstance()->assign('xmlcurrent_version',$this->xmlfile_current_version());
			exec_config_smarty::getInstance()->display('version_select.phtml');
		}
		
	}
}
class db_upgrade{
	protected function s_setting_version(){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = "magix_version"';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
	protected function s_show_database(){
		$database = M_DBNAME;
		return magixglobal_model_db::layerDB()->showDatabase($database,true);
	}
	protected function s_t(){
		return magixglobal_model_db::layerDB()->PDOConnexion();
	}
}