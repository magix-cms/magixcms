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
 * @category   Controller 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name testconnexion
 *
 */
class exec_controller_testconnexion extends database_connex{
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public $M_DBDRIVER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public $M_DBHOST;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public $M_DBUSER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public $M_DBPASSWORD;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public $M_DBNAME;
	/**
	 * Constructor
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('M_DBDRIVER')){
			$this->M_DBDRIVER = $_POST['M_DBDRIVER'];
		}
		if(magixcjquery_filter_request::isPost('M_DBHOST')){
			$this->M_DBHOST = $_POST['M_DBHOST'];
		}
		if(magixcjquery_filter_request::isPost('M_DBUSER')){
			$this->M_DBUSER = $_POST['M_DBUSER'];
		}
		if(magixcjquery_filter_request::isPost('M_DBPASSWORD')){
			$this->M_DBPASSWORD = $_POST['M_DBPASSWORD'];
		}
		if(magixcjquery_filter_request::isPost('M_DBNAME')){
			$this->M_DBNAME = $_POST['M_DBNAME'];
		}
	}
	private function test_database_connexion(){
		if(isset($this->M_DBUSER)){
			if(empty($this->M_DBDRIVER) OR empty($this->M_DBHOST) OR empty($this->M_DBUSER) OR empty($this->M_DBPASSWORD) OR empty($this->M_DBNAME)){
				exec_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
				$fileconfig = magixglobal_model_system::base_path().'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
				if(file_exists($fileconfig)){
					exec_config_smarty::getInstance()->display('request/file_exist.phtml');
				}else{
					if(!defined('M_DBDRIVER') OR !defined('M_DBHOST') OR !defined('M_DBUSER') OR !defined('M_DBPASSWORD') OR !defined('M_DBNAME')){
						define('M_DBDRIVER',$this->M_DBDRIVER);
						// Database hostname (usually "localhost")
						define('M_DBHOST',$this->M_DBHOST);
						// Database user
						define('M_DBUSER',$this->M_DBUSER);
						// Database password
						define('M_DBPASSWORD',$this->M_DBPASSWORD);
						// Database name
						define('M_DBNAME',$this->M_DBNAME);
					}
					if(parent::testconnex()){
						exec_config_smarty::getInstance()->display('request/result_testconnexion.phtml');
					}
				}
			}
		}
	}
	/**
	 * Execution 
	 */
	public function run(){
		$this->test_database_connexion();
	}
}
class database_connex{
	/**
	 * 
	 */
	protected function s_show_database(){
		$database = 'cms';
		return magixglobal_model_db::layerDB()->showDatabase($database,true);
	}
	/**
	 * Test connexion PDO
	 */
	protected function testconnex(){
		return magixglobal_model_db::layerDB()->PDOConnexion();
	}
}