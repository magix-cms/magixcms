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
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
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
			$this->M_DBDRIVER = !empty($_POST['M_DBDRIVER']) ? $_POST['M_DBDRIVER'] : 'mysql';
		}
		if(magixcjquery_filter_request::isPost('M_DBHOST')){
			$this->M_DBHOST = !empty($_POST['M_DBHOST']) ? $_POST['M_DBHOST'] : '';
		}
		if(magixcjquery_filter_request::isPost('M_DBUSER')){
			$this->M_DBUSER = !empty($_POST['M_DBUSER']) ? $_POST['M_DBUSER'] : '';
		}
		if(magixcjquery_filter_request::isPost('M_DBPASSWORD')){
			$this->M_DBPASSWORD = !empty($_POST['M_DBPASSWORD']) ? $_POST['M_DBPASSWORD'] : '';
		}
		if(magixcjquery_filter_request::isPost('M_DBNAME')){
			$this->M_DBNAME = !empty($_POST['M_DBNAME']) ? $_POST['M_DBNAME'] : '';
		}
	}
	private function test_database_connexion(){
		if(isset($this->M_DBNAME)){
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
	}
	/**
	 * Execution 
	 */
	public function run(){
		if(isset($this->M_DBNAME)){
			
		}else{
			
		}
	}
}
class database_connex{
	protected function s_show_database(){
		$database = 'cms';
		return magixglobal_model_db::layerDB()->showDatabase($database,true);
	}
}