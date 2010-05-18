<?php
/**
 * @category   Smarty Plugin
 * @package    MAGIX CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {notify_header text=""} function plugin
 *
 * Type:     function
 * Name:     notify
 * Date:     May 17 2010
 * Purpose:  
 * Examples: {notify_header text=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_notify_header($params, &$smarty){ 
	/*$text = $params['text'];
	if (!isset($text)) {
	 	$smarty->trigger_error("type: missing 'text' parameter");
		return;
	}*/
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/install/')){
		$dom = '<div id="notify-install">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<p>Please delete the &laquo;install&raquo; folder after installation</p>
				</div>
		</div>';
	}elseif (!is_writable($_SERVER['DOCUMENT_ROOT'].'/upload')){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<p>You don\'t have permission to write in &laquo;upload&raquo; folder</p>
				</div>
		</div>';
	}elseif(!is_writable($_SERVER['DOCUMENT_ROOT'].'/var')){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<p>You don\'t have permission to write in &laquo;var&raquo; folder</p>
				</div>
		</div>';
	}elseif(!is_writable($_SERVER['DOCUMENT_ROOT'].'/media')){
		$dom = '<div id="notify-folder">
				<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
				<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
				<div id="message-notification">
					<p>You don\'t have permission to write in &laquo;media&raquo; folder</p>
				</div>
		</div>';
	}else{
		$dom = null;
	}
	return $dom;
}