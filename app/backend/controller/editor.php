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
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name editor
 *
 */
class backend_controller_editor{
	/**
	 * Sélectionne l'éditeur html
	 * @var string
	 */
	public $editor;
	/**
	 * 
	 * Configure l'éditeur HTML
	 * @var string
	 */
	public $manager_setting;
	/**
	 * 
	 * Constructeur
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('editor')){
			$this->editor = magixcjquery_form_helpersforms::inputClean($_POST['editor']);
		}
		if(magixcjquery_filter_request::isPost('manager_setting')){
			$this->manager_setting = magixcjquery_form_helpersforms::inputClean($_POST['manager_setting']);
		}
	}
	/**
	 * Charge les données concernant l'éditeur wysiwyg
	 */
	private function load_wysiwyg_editor(){
		$config = backend_model_setting::tabs_uniq_setting('editor');
		if($config['setting_value'] == "pdw_file_browser"){
			$checked_filebrowser = 'checked="checked"';
		}else{
			$checked_filebrowser = '';
		}
		$m_setting = <<<EOT
		<ul>
				<li><input type="radio" name="manager_setting" $checked_filebrowser value="pdw_file_browser" />pdw_file_browser(Intégrer)</li>
EOT;
		if(file_exists(magixglobal_model_system::base_path().'framework/js/tiny_mce/plugins/imagemanager/')){
			if($config['setting_value'] == "imagemanager"){
				$checked_imagemanager = 'checked="checked" ';
			}else{
				$checked_imagemanager = '';
			}
			$m_setting .= <<<EOT
			<li><input type="radio" name="manager_setting" $checked_imagemanager value="imagemanager" />Imagemanager(Payant)</li>
EOT;
		}
		$m_setting .= '</ul>';
		backend_controller_template::assign('list_manager_setting',$m_setting);
	}
	/**
	 * Update les données concernant l'éditeur wysiwyg
	 */
	private function send_wysiwyg_editor(){
		if($this->editor){
			backend_model_setting::update_setting_label('editor',$this->editor);
			backend_model_setting::update_setting_value('editor','pdw_file_browser');
			backend_controller_template::display('config/request/success.phtml');
		}
	}
	/**
	 * @access private
	 * POST les données de la configuration de l'éditeur
	 */
	private function send_manager_editor(){
		if($this->manager_setting){
			backend_model_setting::update_setting_value('editor',$this->manager_setting);
			backend_controller_template::display('config/request/success.phtml');
		}
	}
	/**
	 * @access public
	 * 
	 * Execution de la configuration
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'config'
            ),array('config_'),false
        );
		if(magixcjquery_filter_request::isGet('htmleditor')){
			self::send_wysiwyg_editor();
		}elseif(magixcjquery_filter_request::isGet('manager_editor_setting')){
			self::send_manager_editor();
		}else{
			$this->load_wysiwyg_editor();
			backend_controller_template::display('config/editor.phtml');
		}
	}
}