<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> 
 *
 */
/**
 * Smarty {getplugin} function plugin
 *
 * Type:     function
 * Name:     getplugin
 * Date:     13 octobre 2011 23:15
 * Purpose:  Retourne l'url du plugin courant ou défini en paramètre
 * Examples: {getplugin 
 				config_param=['magixmod'=>'','type'=>'root']
 			 }
 			 {getplugin 
 				config_param=['magixmod'=>'','type'=>'plugin_params']
 				rewrite_params=['mygetvar'=>'mytest','idnum'=>1]
 			 }
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_getplugin($params, $template){
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	$magixmod = $tabs['magixmod'];
	if (!isset($magixmod)) {
	 	trigger_error("magixmod: missing 'magixmod' parameter");
		return;
	}
	if (empty($magixmod)) {
		trigger_error("magixmod: 'magixmod' parameter is empty");
		return;
	}
	$lang = frontend_model_template::current_Language();
	if($tabs['type']!= null OR $tabs['type']!=''){
		$type = $tabs['type'];
	}elseif(!isset($tabs['type'])){
		$type = 'root';
	}else{
		$type = 'root';
	}
	switch($type){
		case 'root':
			return magixglobal_model_rewrite::filter_plugins_root_url($lang, $magixmod,true);
		break;
		case 'plugin_params':
			if (!isset($params['rewrite_params'])) {
		 		trigger_error("rewrite_params: missing 'rewrite_params' parameter");
				return;
			}
			if(is_array($params['rewrite_params'])){
				$pg_params = $params['rewrite_params'];
			}
			return magixglobal_model_rewrite::filter_plugins_params_url($lang, $magixmod, $pg_params, true);
		break;
		default:
			return magixglobal_model_rewrite::filter_plugins_root_url($lang, $magixmod,true);
		break;
	}
}