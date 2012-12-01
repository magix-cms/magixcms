<?php
/**
 * Smarty {pathadmin} function plugin
 *
 * Type:     function
 * Name:     pathadmin
 * Date:     01/12/2012 19:07
 * Purpose:  Récupère L'URL de l'admin.
 * Examples: {pathadmin}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_pathadmin($params, $template){
	return PATHADMIN;
}