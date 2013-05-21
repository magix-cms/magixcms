<?php
/**
 * Smarty {iso} function plugin
 *
 * Type:     function
 * Name:     
 * Date:     
 * Update    
 * Purpose:  
 * Examples: 
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_iso($params, $template){
	return app_model_language::current_Language();
}