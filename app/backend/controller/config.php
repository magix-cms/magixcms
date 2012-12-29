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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name config
 *
 */
class backend_controller_config extends backend_db_config{
	/**
	 * @access public
	 * @var string
	 */
	public $configlang;
	/**
	 * @access public
	 * @var string
	 */
	public $configcms;
	/**
	 * @access public
	 * @var string
	 */
	public $confignews;
	/**
	 * @access public
	 * @var string
	 */
	public $configcatalog;
	/**
	 * @access public
	 * @var string
	 */
	public $configforms;
	/**
	 * @access public
	 * @var string
	 */
	public $configmicrogalery;
	/**
	 * @access public
	 * @var string
	 */
	public $configrmetas;
	/**
	 * intéger number for limited configuration
	 * @var number
	 */
	public $max_record;
	/**
	 * 
	 * idconfig
	 * @var idconfig
	 */
	public $idconfig;
	/**
	 * function construct
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('configlang')){
			$this->configlang = magixcjquery_filter_isVar::isPostNumeric($_POST['configlang']);
		}
		if(magixcjquery_filter_request::isPost('configcms')){
			$this->configcms = magixcjquery_filter_isVar::isPostNumeric($_POST['configcms']);
		}
		if(magixcjquery_filter_request::isPost('confignews')){
			$this->confignews = magixcjquery_filter_isVar::isPostNumeric($_POST['confignews']);
		}
		if(magixcjquery_filter_request::isPost('configcatalog')){
			$this->configcatalog = magixcjquery_filter_isVar::isPostNumeric($_POST['configcatalog']);
		}
		if(magixcjquery_filter_request::isPost('configforms')){
			$this->configforms = magixcjquery_filter_isVar::isPostNumeric($_POST['configforms']);
		}
		if(magixcjquery_filter_request::isPost('configmicrogalery')){
			$this->configmicrogalery = magixcjquery_filter_isVar::isPostNumeric($_POST['configmicrogalery']);
		}
		if(magixcjquery_filter_request::isPost('configrmetas')){
			$this->configrmetas = magixcjquery_filter_isVar::isPostNumeric($_POST['configrmetas']);
		}
		if(magixcjquery_filter_request::isPost('max_record')){
			$this->max_record = magixcjquery_filter_isVar::isPostNumeric($_POST['max_record']);
		}
		if(magixcjquery_filter_request::isPost('idconfig')){
			$this->idconfig = magixcjquery_filter_isVar::isPostNumeric($_POST['idconfig']);
		}
	}
	/**
	 * @access private
	 * function load configuration lang
	 * @string
	 */
	private function load_config_lang(){
		$config = backend_model_setting::tabs_load_config('lang');
		//$config = backend_db_config::adminDbConfig()->s_config_named('lang');
		backend_controller_template::assign('configlang',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration cms
	 * @string
	 */
	private function load_config_cms(){
		$config = backend_model_setting::tabs_load_config('cms');
		backend_controller_template::assign('configcms',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration news
	 * @string
	 */
	private function load_config_news(){
		$config = backend_model_setting::tabs_load_config('news');
		backend_controller_template::assign('confignews',$config['status']);
	}
	/**
	 * @access private
	 * function load configuration catalog
	 * @string
	 */
	private function load_config_catalog(){
		$config = backend_model_setting::tabs_load_config('catalog');
		backend_controller_template::assign('configcatalog',$config['status']);
	}
	/**
	 * @access private
	 * function load rewrite metas
	 * @string
	 */
	private function load_config_metasrewrite(){
		$config = backend_model_setting::tabs_load_config('metasrewrite');
		backend_controller_template::assign('configmetasrewrite',$config['status']);
	}
	/**
	 * @access private
	 * function admin configuration
	 * @string
	 */
	private function admin_config(){
		$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		backend_controller_template::assign('perms',$perms['perms']);
	}
	/**
	 * @access private
	 * function load limited_cms_number
	 * @intégrer
	 */
	private function load_limited_cms_number(){
		$config = backend_model_setting::tabs_load_config('cms');
		backend_controller_template::assign('idconfigcms',$config['idconfig']);
		backend_controller_template::assign('max_record',$config['max_record']);
	}
	/**
	 * Charge les données concernant l'éditeur wysiwyg
	 */
	private function load_wysiwyg_config_editor(){
		if(file_exists(magixglobal_model_system::base_path().'framework/js/tiny_mce/plugins/filemanager/')){
			$Init_Filemanager = 1;
		}else{
			$Init_Filemanager = 0;
		}
		$config = backend_model_setting::tabs_uniq_setting('editor');
		backend_controller_template::assign('editor',$config['setting_label']);
		backend_controller_template::assign('tinymce_filemanager',$Init_Filemanager);
		backend_controller_template::assign('manager_setting',$config['setting_value']);
	}
	/**
	 * @access public
	 * @static
	 * load global attribute configuration
	 */
	public static function load_attribute_config(){
		/*self::load_config_lang();
		self::load_config_cms();
		self::load_config_news();
		self::load_config_catalog();
		self::load_config_metasrewrite();
		self::load_limited_cms_number();
		self::load_wysiwyg_config_editor();
		self::admin_config();*/
        self::load_wysiwyg_config_editor();
	}
	/**
	 * @access public
	 * 
	 * Execution de la configuration
	 */
	public function run(){
		$header= new magixglobal_model_header();
		/**
	 	* update states for configuration
	 	* @access private
	 	*/
		if(isset($this->configlang)){
			parent::u_config_states($this->configlang,'lang');
		}elseif(isset($this->configcms)){
			parent::u_config_states($this->configcms,'cms');
		}elseif(isset($this->confignews)){
			parent::u_config_states($this->confignews,'news');
		}elseif(isset($this->configcatalog)){
			parent::u_config_states($this->configcatalog,'catalog');
		}elseif(isset($this->configrmetas)){
			parent::u_config_states($this->configrmetas,'metasrewrite');
		}elseif(isset($this->max_record)){
			parent::u_limited_module($this->idconfig,$this->max_record);
		}else{
			backend_controller_template::display('config/params.phtml');	
		}
	}
}