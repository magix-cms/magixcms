<?php
/**
 * @category   Smarty Plugin
 * @package    MAGIX CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.1 2010-09-07
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
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