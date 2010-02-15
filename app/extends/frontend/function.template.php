<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {template} function plugin
 *
 * Type:     function
 * Name:    load template
 * Date:     january 26 2010
 * Purpose:  
 * Examples: {template}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_template($params, &$smarty){
		return frontend_model_template::frontendTheme()->themeSelected();
}
?>