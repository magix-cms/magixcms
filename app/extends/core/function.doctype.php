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
 * Smarty {doctype type=""} function plugin
 *
 * Type:     function
 * Name:     doctype
 * Date:     January 4 2010
 * Purpose:  
 * Examples: {doctype type=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_doctype($params, &$smarty){
	$type = $params['type'];
	if (!isset($type)) {
	 	$smarty->trigger_error("type: missing 'type' parameter");
		return;
	}
	return magixcjquery_view_helper_doctype::doctype($type);
}