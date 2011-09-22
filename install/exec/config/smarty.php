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
 * @category   config 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * Configuration / extends smarty with class
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name smarty
 *
 */
$inc = magixglobal_model_system::base_path().'lib'.DIRECTORY_SEPARATOR.'smarty3'.DIRECTORY_SEPARATOR.'Smarty.class.php';
if (file_exists($inc)) {
	require_once($inc);
}else{
	exit();
}
//if(!defined('REQUIRED_SMARTY_DIR')) define('REQUIRED_SMARTY_DIR','./');
/**
 * Extend class smarty
 *
 */
class exec_config_smarty extends Smarty{
	/**
    * Variable statique permettant de porter l'instance unique
    */
    static protected $instance;
	/**
	 * function construct class
	 *
	 */
	public function __construct(){
		/**
		 * include parent var smarty
		 */
		parent::__construct(); 
		self::setParams();
		/*
		 You can remove this comment, if you prefer this JSP tag style
		 instead of the default { and }
		 $this->left_delimiter =  '<%';
		 $this->right_delimiter = '%>';
		 */
	}
	private function setPath(){
		/*$pathdir = dirname(realpath( __FILE__ ));
		$arraydir = array('install\exec\config', 'install/exec/config');
		return $smartydir = magixglobal_model_system::root_path($arraydir,array('', '') , $pathdir);
		*/
		return magixglobal_model_system::base_path();
	}
	protected function setParams() {
		/**
		 * Path -> configs
		 */
		$this->config_dir = array(self::setPath()."/install/local/");
		/**
		 * Path -> templates
		 */
		$this->template_dir = array(self::setPath()."/install/skin/");
		/**
		 * path plugins
		 * @var void
		 */
		$this->plugins_dir = array(
			self::setPath().'/lib/smarty3/plugins/'
			,self::setPath().'/app/extends/core/'
		);
		/**
		 * Path -> compile
		 */
		$this->compile_dir = self::setPath()."/var/tpl_admin/";
		/**
		 * debugging (true/false)
		 */
		$this->debugging = false;
		/**
		 * compile (true/false)
		 */
		$this->compile_check = true;
		/**
		 * Force compile
		 * @var void
		 * (true/false)
		 */
		$this->force_compile = false;
		/**
		 * caching (true/false)
		 */
		$this->caching = false;
		/**
		 * Use sub dirs (true/false)
		 */
		$this->use_sub_dirs = false;
		/**
		 * cache_dir -> cache
		 */
		$this->cache_dir = self::setPath().'/var/tmp/';
		/**
		 * load pre filter
		 */
		//$this->load_filter('pre','magixmin');
		$this->autoload_filters = array('pre' => array('magixmin'));
		/**
		 * 
		 * @var error_reporting
		 */
		$this->error_reporting = error_reporting() &~E_NOTICE;
		/**
		 * Security
		 */
		//$this->enableSecurity();
	}
	public static function getInstance(){
        if (!isset(self::$instance))
      {
         self::$instance = new exec_config_smarty();
      }
    	return self::$instance;
    }
}
?>
