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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty {notify_dir_header} function plugin
 *
 * Type:     function
 * Name:     notify
 * Date:     May 17 2010
 * Update    September 09 2010
 * Purpose:  
 * Examples: {notify_dir_header}
 * Output:   HTML
 * @link 
 * @author   Gerits Aurelien
 * @version  1.1
 * @param params
 * @param Smarty
 * @return string
 */
function smarty_function_notify_dir_header($params, &$smarty){ 
	/*$text = $params['text'];
	if (!isset($text)) {
	 	$smarty->trigger_error("type: missing 'text' parameter");
		return;
	}*/
	$pathdir = dirname(realpath( __FILE__ ));
	$arraydir = array('app\extends\core', 'app/extends/core');
	//magixcjquery_debug_magixfire::magixFireLog(magixglobal_model_system::root_path($arraydir,array("install","install") , $pathdir),'path');
	if(file_exists(magixglobal_model_system::root_path($arraydir,array("install","install") , $pathdir))){
		$dom = '<div id="notify-install">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span>Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-delete" style="float:left;"></span><div style="padding-top:10px;">Please delete the &laquo;install&raquo; folder after installation</div>
					</div>
				</div>
		</div>';
	}elseif (!is_writable(magixglobal_model_system::root_path($arraydir,array("upload","upload") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span>Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-conflict" style="float:left;"></span><div style="padding-top:10px;">You don\'t have permission to write in &laquo;upload&raquo; folder</div>
					</div>
				</div>
		</div>';
	}elseif(!is_writable(magixglobal_model_system::root_path($arraydir,array("var","var") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span>Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-conflict" style="float:left;"></span><div style="padding-top:10px;">You don\'t have permission to write in &laquo;upload&raquo; folder</div>
					</div>
				</div>
		</div>';
	}elseif(!is_writable(magixglobal_model_system::root_path($arraydir,array("media","media") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span>Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-conflict" style="float:left;"></span><div style="padding-top:10px;">You don\'t have permission to write in &laquo;upload&raquo; folder</div>
					</div>
				</div>
		</div>';
	}else{
		$dom = '';
	}
	return $dom;
}