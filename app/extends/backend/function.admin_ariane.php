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
 * Update:   28 Avril 2010
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
	//print $_SERVER['QUERY_STRING'];
	//print_r(parse_url($url,PHP_URL_PATH));
	$segment =  explode('&',parse_url($url,PHP_URL_QUERY));
	$segment = str_replace('=',' - ',$segment);
	//print_r($equal = explode('=', $segment[2]));
	$root = magixcjquery_html_helpersHtml::getUrl().parse_url($url,PHP_URL_PATH);
	$fil = null;
	$fil .= '<li><a href="'.$root.'"><span style="float:left;" class="magix-icon magix-icon-home"></span></a></li>';
	$fil .= empty($segment[0])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[0]).'</li>';
	$fil .= empty($segment[1])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[1]).'</li>';
	$fil .= empty($segment[2])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[2]).'</li>';
	$fil .= empty($segment[3])? null: '<li><span style="float:left;" class="ui-icon ui-icon-arrow-1-e"></span>&nbsp;'.magixcjquery_string_convert::ucfirst($segment[3]).'</li>';
	return $fil;
}
?>