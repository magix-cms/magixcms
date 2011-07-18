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
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name setting
 * Model setting
 */
class backend_model_setting extends backend_db_setting{
	/**
	 * Constructor
	 */
	function __construct(){}
	//SETTING
	/**
	 * @access public
	 * @static
	 * @param (string) $setting_id
	 * @param (string) $setting_value
	 */
	public static function update_setting_value($setting_id,$setting_value){
		if(isset($setting_id)){
			backend_db_setting::u_setting_value($setting_id,$setting_value);
		}
	}
	/**
	 * @access public
	 * @static
	 * @param (string) $setting_id
	 * @param (string) $setting_value
	 */
	public static function update_setting_label($setting_id,$setting_label){
		if(isset($setting_id)){
			backend_db_setting::u_setting_label($setting_id,$setting_label);
		}
	}
	/**
	 * @access public
	 * Retourne la valeur unique dans un tableau
	 * @param string $attr_name
	 */
	public static function tabs_load_config($attr_name){
		return parent::array_data_config($attr_name);
	}
	/**
	 * @access public
	 * @static
	 * Retourne la valeur de la configuration suivant l'identifiant
	 * @param (string) $setting_id
	 */
	public static function tabs_uniq_setting($setting_id){
		return parent::s_uniq_setting($setting_id);
	}
	//IMAGE
	/**
	 * @access private
	 * Assign les variables pour les paramètres des tailles images
	 */
	public function assign_img_size($attr_name){
		if(!is_null($attr_name)){
			foreach (parent::s_all_img_size_config($attr_name) as $conf){
				backend_controller_template::assign($conf['config_size_attr'],$conf['width'],$conf['height']);
			}
		}
	}
	public function data_img_size($attr_name,$config_size_attr){
		return parent::s_load_img_size($attr_name,$config_size_attr);
	}
	public function uniq_data_img_size($attr_name,$config_size_attr,$type){
		return parent::s_uniq_img_size($attr_name, $config_size_attr, $type);
	}
	public function fetch_img_size($attr_name){
		return parent::s_attribute_img_size_config($attr_name);
	}
	public function dataSizeImg(){}
}