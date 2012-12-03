<?php
/**
 * Smarty {baseadmin} function plugin
 *
 * Type:     function
 * Name:     baseadmin
 * Date:     01/12/2012 19:07
 * Purpose:  Récupère L'URL de l'admin.
 * Examples: {baseadmin}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_baseadmin($params, $template){
	return PATHADMIN;
}