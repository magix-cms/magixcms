<?php
/**
 * @category   Smarty Plugin
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cmsa.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-30
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {plugin_exist} function plugin
 *
 * Type:     function
 * Name:     
 * Date:     
 * Purpose:  
 * Examples: {plugin_exist}
 * Output:   true or false
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_plugin_exist($params, &$smarty){
	$class = $params['class'];
	if (!isset($class)) {
	 	$smarty->trigger_error("class: missing 'class' parameter");
		return;
	}
	if(class_exists('backend_plugins_'.$class)){
		return true;
	}
}