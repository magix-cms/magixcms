<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien@magix-cms.com>
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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * @link http://www.magix-cms.com,http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * Type:     function
 * Name:     admin_level_config
 * Date:     29/05/2011
 * Purpose:  
 * Examples: {admin_level_config config_param=['module'=>'cms','allow_level'=>'1']}
 * Output:   
 * @param $params
 * @param $template
 * @return void
 */
function smarty_function_admin_level_config($params, $template){
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	if(class_exists('backend_model_setting',true)){
		if(isset($tabs['module'])){
			$setting = new backend_model_setting();
			$attr_name = $setting->tabs_load_config($tabs['module']);
			if($tabs['allow_level'] != null OR $tabs['allow_level'] != ''){
				$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
				if($tabs['allow_level'] == '*' AND $attr_name['status'] == 1){
					return true;
				}else if($attr_name['status'] == 1 AND $perms['perms'] <= $tabs['allow_level']){
					return true;
				}else{
					return false;
				}
			}else{
				if($attr_name['status'] == 1){
					return true;
				}
			}
		}else{
			$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
			if($tabs['allow_level'] == '*'){
				return true;
			}else if($perms['perms'] <= $tabs['allow_level']){
				return true;
			}else{
				return false;
			}
		}
	}else{
		trigger_error("model_setting is not exist", E_USER_WARNING);
	}
}