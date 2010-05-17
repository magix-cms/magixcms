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
 * Smarty {notify_install text=""} function plugin
 *
 * Type:     function
 * Name:     notify_install
 * Date:     May 17 2010
 * Purpose:  
 * Examples: {notify_install text=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_notify_install($params, &$smarty){ 
	$text = $params['text'];
	if (!isset($text)) {
	 	$smarty->trigger_error("type: missing 'text' parameter");
		return;
	}
	if(file_exists($_SERVER['DOCUMENT_ROOT'].'/install/')){
		$jquery = '<div id="notify-install">
					<a href="#" class="close-notify ui-state-default ui-corner-all"><span style="float:left;" class="ui-icon ui-icon-closethick"></span> Close</a>
					<a class="dont-notify ui-state-default ui-corner-all">Don\'t Show Again</a>	
					<div id="message-notification">
						<p>'.$text.'</p>
					</div>
			   </div>';
	}else{
		 $jquery = null;
	}
	return $jquery;
}