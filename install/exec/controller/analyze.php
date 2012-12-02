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
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name analyze
 *
 */
class exec_controller_analyze{
	/**
	 * post checking install
	 * @var check_exec
	 * @access public 
	 */
	public $check_exec;
	/**
	 * constructor
	 */
	function __construct(){
		if(isset($_POST['check_exec'])){
	        $this->check_exec = (string) magixcjquery_filter_var::escapeHTML($_POST['check_exec']);
	    }
	}
	/**
	 * analyse la version de php du système
	 * @access public
	 */
	public function testing_php_version(){
		if (version_compare(phpversion(),'5.0','<')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de mbstring
	 * @access public
	 */
	public function testing_mbstring(){
		if (!function_exists('mb_detect_encoding')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de iconv
	 * @access public
	 */
	public function testing_iconv(){
		if (!function_exists('iconv')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de obstart
	 * @access public
	 */
	public function testing_obstart(){
		if (!function_exists('ob_start')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de simplexml
	 * @access public
	 */
	public function testing_simplexml(){
		if (!function_exists('simplexml_load_string')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de import dom xml
	 * @access public
	 */
	public function testing_domxml(){
		if (!function_exists('dom_import_simplexml')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * analyse la présence de SPL
	 * @access public
	 */
	public function testing_spl(){
		if (!function_exists('spl_classes')) {
			$testing = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
		}else{
			$testing = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
		}
		print $testing;
	}
	/**
	 * Affiche la page de test
	 * @access public
	 */
	public function display_testing_page(){
		exec_config_smarty::getInstance()->display('check.phtml');
	}
}