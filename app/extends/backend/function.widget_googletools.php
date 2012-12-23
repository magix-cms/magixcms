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
 * Smarty {widget_googletools} function plugin
 *
 * Type:     function
 * Name:     widget_googletools
 * Date:     Décember 18, 2009
 * Update:   2 September, 2010  
 * Purpose:  
 * Examples: {widget_googletools}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_googletools($params, $template){
	$webmasterdata = backend_model_setting::tabs_uniq_setting('webmaster');
	$analyticsdata = backend_model_setting::tabs_uniq_setting('analytics');
	$plugin = '<table class="clear">
					<thead>
					<tr>
						<th><span style="float:left;" class="magix-icon magix-icon-webmaster"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-analytics"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
					</tr>
					</thead>
					<tbody>
					<tr>';
	if($webmasterdata['setting_value'] == null){
		$webtools = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
	}else{
		$webtools = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
	}
	if($analyticsdata['setting_value'] == null){
		$analytics = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
	}else{
		$analytics = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
	}
	$plugin .= '<td class="nowrap">'.$webtools.'</td>
				<td class="maximal">'.$analytics.'</td>
				<td class="nowrap"><a href="/admin/googletools.php"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
	$plugin .= '</tr></tbody></table>';
	return $plugin;
}