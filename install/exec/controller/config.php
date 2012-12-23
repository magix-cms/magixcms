<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @package    CONFIG
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name install
 *
 */
class exec_controller_config{
	/**
	 * chemin vers le fichier de base config.in.php
	 * @var void
	 */
	public static $config_in;
	/**
	 * chemin vers le fichier de base config.php
	 * @var void
	 */
	public static $configfile;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBDRIVER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBHOST;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBUSER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBPASSWORD;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBNAME;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_LOG;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	//public static $M_TMP_DIR;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_FIREPHP;
	/**
	 * Constructor
	 */
	function __construct(){
		
		/**
		 * path for reading file config.php.in
		 */
		self::$config_in = self::dir_config_file().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php.in';
		/*
		 * path for create file config.php
		 */
		self::$configfile = self::dir_config_file().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
		self::$M_DBDRIVER = !empty($_POST['M_DBDRIVER']) ? $_POST['M_DBDRIVER'] : 'mysql';
		self::$M_DBHOST = !empty($_POST['M_DBHOST']) ? $_POST['M_DBHOST'] : '';
		self::$M_DBUSER = !empty($_POST['M_DBUSER']) ? $_POST['M_DBUSER'] : '';
		self::$M_DBPASSWORD = !empty($_POST['M_DBPASSWORD']) ? $_POST['M_DBPASSWORD'] : '';
		self::$M_DBNAME = !empty($_POST['M_DBNAME']) ? $_POST['M_DBNAME'] : '';
		self::$M_LOG = !empty($_POST['M_LOG']) ? $_POST['M_LOG'] : '';
		//self::$M_TMP_DIR = !empty($_POST['M_TMP_DIR']) ? $_POST['M_TMP_DIR'] : '';
		self::$M_FIREPHP = !empty($_POST['M_FIREPHP']) ? $_POST['M_FIREPHP'] : '';
	}
	private function dir_config_file(){
		return magixglobal_model_system::base_path();
	}
	/**
	 * Vérifie si le fichier config.php.in est présent
	 */
	private function config_in_exist(){
		if (!is_file(self::$config_in)) {
			throw new Exception(sprintf('File %s does not exist.',self::$config_in));
		}
		return true;
	}
	private function writeConfigFile(){
		if(isset($_POST['M_DBHOST']) && isset($_POST['M_DBUSER']) && isset($_POST['M_DBPASSWORD']) && isset($_POST['M_DBNAME'])){
			//echo dirname(self::$configfile);
			if (!is_writable(dirname(self::$configfile))) {
				throw new Exception(sprintf('Cannot write %s file.',self::$configfile));
			}
			self::config_in_exist();
			try{
				# Creates config.php file
				$full_conf = file_get_contents(self::$config_in);
				$writeconst = new magixcjquery_files_makefiles();
				/**
				 * create constante define in config file
				 */
				$writeconst->writeConstValue('M_DBDRIVER',self::$M_DBDRIVER,$full_conf);
				$writeconst->writeConstValue('M_DBHOST',self::$M_DBHOST,$full_conf);
				$writeconst->writeConstValue('M_DBUSER',self::$M_DBUSER,$full_conf);
				$writeconst->writeConstValue('M_DBPASSWORD',self::$M_DBPASSWORD,$full_conf);
				$writeconst->writeConstValue('M_DBNAME',self::$M_DBNAME,$full_conf);
				switch(self::$M_LOG){
					case 'debug':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf);
					break;
					case 'log':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf);
					break;
					case 'false':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf,false);
				}
				$writeconst->writeConstValue('M_TMP_DIR',self::dir_config_file().'var'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'errors.log',$full_conf);
				$writeconst->writeConstValue('M_FIREPHP',self::$M_FIREPHP,$full_conf,false);
				
				$fp = fopen(self::$configfile,'wb');
				if ($fp === false) {
					throw new Exception(sprintf('Cannot write %s file.',self::$configfile));
				}
				fwrite($fp,$full_conf);
				fclose($fp);
				//chmod(self::$configfile, 0666);
				exec_config_smarty::getInstance()->display('request/success-config.phtml');
			} catch(Exception $e) {
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	private function createConfig(){
		self::writeConfigFile();
	}
	private function display_config_page(){
		$dom = null;
		if(!is_writable(self::dir_config_file().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config')){
			$dom = '<div id="notify-folder">
					<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
					<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
					<div id="message-notification">
						<p>You don\'t have permission to write in &laquo;/app/config&raquo; folder</p>
					</div>
			</div>';
		}
		exec_config_smarty::getInstance()->assign('notify',$dom);
		exec_config_smarty::getInstance()->display('config.phtml');
	}
	public function run(){
		if(magixcjquery_filter_request::isGet('cfile')){
			self::createConfig();
		}else{
			self::display_config_page();
		}
	}
}