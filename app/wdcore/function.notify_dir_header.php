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
function smarty_function_notify_dir_header($params, $template){ 
	$pathdir = dirname(realpath( __FILE__ ));
	$arraydir = array('app\extends\core', 'app/extends/core');
	if(file_exists(magixglobal_model_system::root_path($arraydir,array("install","install") , $pathdir))){
		$dom = '<div id="notify-install">
				<a href="#" class="close-notify ui-state-default ui-corner-all">Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-delete" style="float:left;"></span><div style="padding-top:10px;">Please delete the &laquo;install&raquo; folder after installation</div>
					</div>
				</div>
		</div>';
	}elseif (!is_writable(magixglobal_model_system::root_path($arraydir,array("upload","upload") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all">Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-conflict" style="float:left;"></span><div style="padding-top:10px;">You don\'t have permission to write in &laquo;upload&raquo; folder</div>
					</div>
				</div>
		</div>';
	}elseif(!is_writable(magixglobal_model_system::root_path($arraydir,array("var","var") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all">Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<div class="mc-rep-request">
						<span class="notify-32-icon notify-32-icon-folder-conflict" style="float:left;"></span><div style="padding-top:10px;">You don\'t have permission to write in &laquo;upload&raquo; folder</div>
					</div>
				</div>
		</div>';
	}elseif(!is_writable(magixglobal_model_system::root_path($arraydir,array("media","media") , $pathdir))){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all">Close</a>
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