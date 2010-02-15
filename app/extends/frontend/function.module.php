<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {module} function plugin
 *
 * Type:     function
 * Name:     module
 * Date:     Janvier 17, 2009
 * Purpose:  
 * Examples: {module type=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_module($params, &$smarty){
	$type = $params['type'];
	$config = frontend_db_config::frontendDCconfig()->s_public_config_named($type);
	return $config['status'];
}