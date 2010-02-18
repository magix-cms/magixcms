<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {admin_ariane} function plugin
 *
 * Type:     function
 * Name:     admin_ariane
 * Date:     Octobre 31, 2009
 * Purpose:  
 * Examples: {admin_ariane}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_admin_ariane($params, &$smarty){
	$url = $_SERVER['REQUEST_URI'];
	$segment = explode('/', $url);
	$root = magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator();
	$fil = null;
	$fil .= empty($segment[2])? null: '<li><a href="'.$root.$segment[0].$segment[1].magixcjquery_html_helpersHtml::unixSeparator().$segment[2].'"><span style="float:left;" class="magix-icon magix-icon-home"></span></a></li>';
	$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[3]).'</li>';
	$fil .= empty($segment[4])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[4]).'</li>';
	$fil .= empty($segment[5])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[5]).'</li>';
	return $fil;
}
?>