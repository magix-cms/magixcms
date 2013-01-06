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
	public $lang;
	/**
	 * @access public
	 * @var string
	 */
	public $cms;
	/**
	 * @access public
	 * @var string
	 */
	public $news;
	/**
	 * @access public
	 * @var string
	 */
	public $catalog;
	/**
	 * @access public
	 * @var string
	 */
	public $metasrewrite,$plugins;
    public $action;
	/**
	 * function construct
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('lang')){
			$this->lang = magixcjquery_filter_isVar::isPostNumeric($_POST['lang']);
		}
		if(magixcjquery_filter_request::isPost('cms')){
			$this->cms = magixcjquery_filter_isVar::isPostNumeric($_POST['cms']);
		}
		if(magixcjquery_filter_request::isPost('news')){
			$this->news = magixcjquery_filter_isVar::isPostNumeric($_POST['news']);
		}
		if(magixcjquery_filter_request::isPost('catalog')){
			$this->catalog = magixcjquery_filter_isVar::isPostNumeric($_POST['catalog']);
		}
		if(magixcjquery_filter_request::isPost('metasrewrite')){
			$this->metasrewrite = magixcjquery_filter_isVar::isPostNumeric($_POST['metasrewrite']);
		}
		if(magixcjquery_filter_request::isPost('plugins')){
			$this->plugins = magixcjquery_filter_isVar::isPostNumeric($_POST['plugins']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
	}

    /**
     * @param $create
     * @return array
     */
    private function load_data_config($create){
        $data = parent::s_data_config();
        /*$assign_exclude = array(
            'lesson_level','lesson_days','lesson_category','lesson_teachers'
        );*/
        foreach($data as $key){
            $id[]=$key['attr_name'];
            $status[]=$key['status'];
        }
        return array_combine($id,$status);
    }

    /**
     * @return array
     */
    private function load_lang_config(){
        $data = backend_db_block_lang::s_data_lang();
        foreach($data as $key){
            //$create->assign($key['idlang'],$key['iso']);
            $id[]=$key['idlang'];
            $iso[]=$key['iso'];
        }
        return array_combine($id,$iso);
    }

    /**
     * @param $create
     */
    private function load_data_setting($create){
        $data = parent::s_data_setting();
        /*$assign_exclude = array(
            'lesson_level','lesson_days','lesson_category','lesson_teachers'
        );*/
        foreach($data as $key){
            /*$iso = $val;
            if( !(array_search($key,$assign_exclude) ) ){
                $create->append_assign($key,$val);
            }*/
            $create->assign($key['attr_name'],$key['status']);
        }
    }
	/**
	 * @access private
	 * function load limited_cms_number
	 * @intégrer
	 */
	/*private function load_limited_cms_number(){
		$config = backend_model_setting::tabs_load_config('cms');
		backend_controller_template::assign('idconfigcms',$config['idconfig']);
		backend_controller_template::assign('max_record',$config['max_record']);
	}*/
	/**
	 * Charge les données concernant l'éditeur wysiwyg
	 */
	/*private function load_wysiwyg_config_editor(){
		if(file_exists(magixglobal_model_system::base_path().'framework/js/tiny_mce/plugins/filemanager/')){
			$Init_Filemanager = 1;
		}else{
			$Init_Filemanager = 0;
		}
		$config = backend_model_setting::tabs_uniq_setting('editor');
		backend_controller_template::assign('editor',$config['setting_label']);
		backend_controller_template::assign('tinymce_filemanager',$Init_Filemanager);
		backend_controller_template::assign('manager_setting',$config['setting_value']);
	}*/
    /**
     * @access private
     */
    private function update(){
        if(isset($this->lang)){
            parent::u_config_states($this->lang,'lang');
        }
        if(isset($this->cms)){
            parent::u_config_states($this->cms,'cms');
        }
        if(isset($this->news)){
            parent::u_config_states($this->news,'news');
        }
        if(isset($this->catalog)){
            parent::u_config_states($this->catalog,'catalog');
        }
        if(isset($this->metasrewrite)){
            parent::u_config_states($this->metasrewrite,'metasrewrite');
        }
        if(isset($this->plugins)){
            parent::u_config_states($this->plugins,'plugins');
        }
    }
	/**
	 * @access public
	 * @static
	 * load global attribute configuration
	 */
	public static function load_attribute_config(){
        $create = new backend_controller_template();
        $config = parent::s_setting_id('editor');
        $create->assign('manager_setting',$config['setting_value']);
        $create->assign('array_lang',self::load_lang_config());
	}
	/**
	 * @access public
	 * 
	 * Execution de la configuration
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        if(isset($this->action)){
            if($this->action == 'edit'){
                $this->update();
                $create->display('config/request/success_update.phtml');
            }
        }else{
            $create->assign('array_radio_config',$this->load_data_config($create));
            $create->display('config/index.phtml');
        }
	}
}