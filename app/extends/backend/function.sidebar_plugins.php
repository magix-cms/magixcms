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
 * Smarty {sidebar_plugins} function plugin
 *
 * Type:     function
 * Name:     sidebar_plugins
 * Date:     
 * Purpose:  
 * Examples: {sidebar_plugins}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_sidebar_plugins($params, &$smarty){
	$plugins = new backend_controller_plugins();
	return $plugins->constructNavigation();
}