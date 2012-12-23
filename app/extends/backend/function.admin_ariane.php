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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {admin_ariane} function plugin
 *
 * Type:     function
 * Name:     admin_ariane
 * Date:     Octobre 31, 2009
 * Update:   28 Avril 2010
 * Purpose:  
 * Examples: {admin_ariane}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_admin_ariane($params, $template){
	/*if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}*/
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	$url = $_SERVER['REQUEST_URI'];
	//print $_SERVER['QUERY_STRING'];
	//print_r(parse_url($url,PHP_URL_PATH));
	$segment =  explode('&',parse_url($url,PHP_URL_QUERY));
	//$segment = str_replace('=',' - ',$segment);
	//print_r($equal = explode('=', $segment[2]));
	$root = parse_url($url,PHP_URL_PATH);
	$fil .= '<li><a href="'.$root.'"><span style="float:left;" class="magix-icon magix-icon-home"></span></a></li>';
	if (isset($params['config_param'])) {
		$fil .= empty($segment[0])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;<a href="'.$root.'?'.$segment[0].'">'.magixcjquery_string_convert::ucfirst($tabs['level1']).'</a></li>';
		$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;<a href="'.$root.'?'.$segment[0].'&amp;'.$segment[1].'">'.magixcjquery_string_convert::ucfirst($tabs['level2']).'</a></li>';
		$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($tabs['level3']).'</li>';
		$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($tabs['level4']).'</li>';
	}
	return $fil;
}
?>