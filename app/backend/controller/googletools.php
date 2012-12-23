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
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name googletools
 *
 */
class backend_controller_googletools{
	/**
	 * @access public
	 * string
	 * @var webmaster
	 */
	public $webmaster;
	/**
	 * @access public
	 * string
	 * @var analytics
	 */
	public $analytics;
	/**
	 * Function construct
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('webmaster')){
			$this->webmaster = magixcjquery_form_helpersforms::inputClean($_POST['webmaster']);
		}
		if(magixcjquery_filter_request::isPost('analytics')){
			$this->analytics = magixcjquery_form_helpersforms::inputClean($_POST['analytics']);
		}
	}
	/**
	 * Charge les données de google webmaster tools
	 * @access private
	 */
	private function load_webmaster_gdata(){
		$gdata = backend_model_setting::tabs_uniq_setting('webmaster');
		backend_config_smarty::getInstance()->assign('webmaster',$gdata['setting_value']);
	}
	/**
	 * Charge les données de google analytics
	 * @access private
	 */
	private function load_analytics_gdata(){
		$gdata = backend_model_setting::tabs_uniq_setting('analytics');
		backend_config_smarty::getInstance()->assign('analytics',$gdata['setting_value']);
	}
	/**
	 * Insert le code webmaster tools dans la base de donnée.
	 * @access protected
	 */
	private function update_webmastertools(){
		if(isset($this->webmaster)){
			backend_model_setting::update_setting_value('webmaster',$this->webmaster);
			backend_config_smarty::getInstance()->assign('googletools','Webmaster Tools');
			backend_config_smarty::getInstance()->display('googletools/request/success.phtml');
		}
	}
	/**
	 * Insert le code analytics dans la base de donnée.
	 * @access protected
	 */
	private function update_analytics(){
		if(isset($this->analytics)){
			backend_model_setting::update_setting_value('analytics',$this->analytics);
			backend_config_smarty::getInstance()->assign('googletools','Analytics');
			backend_config_smarty::getInstance()->display('googletools/request/success.phtml');
		}
	}
	/**
	 * affiche la page du formulaire pour l'insertion.
	 */
	private function display_gdata(){
		$this->load_webmaster_gdata();
		$this->load_analytics_gdata();
		backend_config_smarty::getInstance()->display('googletools/index.phtml');
	}
	/**
	 * Envoi les données des outils Google
	 */
	private function post_gdata(){
		$this->update_webmastertools();
		$this->update_analytics();
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('pgdata')){
			self::post_gdata();
		}else{
			self::display_gdata();
		}
	}
}