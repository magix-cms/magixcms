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
 * Smarty {widget_session_identifier} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     October 31, 2009
 * Purpose:  
 * Examples: {widget_session_identifier}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_session_identifier($params, &$smarty){
	if(isset($_SESSION['useradmin'])){
		$const_url = backend_db_admin::adminDbMember()->s_t_profil_url($_SESSION['useradmin']);
		$plugin = $const_url['pseudo'];
	}
	return $plugin;
}
?>