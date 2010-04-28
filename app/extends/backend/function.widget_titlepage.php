<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_titlepage} function plugin
 *
 * Type:     function
 * Name:     widget_titlepage
 * Date:   	 28 Avril 2010
 * Purpose:  
 * Examples: {widget_titlepage}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_widget_titlepage($params, &$smarty){
	$url = $_SERVER['REQUEST_URI'];
	$segment =  explode('&',parse_url($url,PHP_URL_QUERY));
	$root = magixcjquery_html_helpersHtml::getUrl().parse_url($url,PHP_URL_PATH).'?';
	$widget .= 'Magix CMS&trade;'.' - ';
	$widget .= empty($segment[1])? magixcjquery_string_convert::ucfirst($segment[0]): $segment[1];
	return $widget;
}
?>