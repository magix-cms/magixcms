<?php
/**
 * @category   Smarty Plugin
 * @package    plugins core
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {getLang} function plugin
 *
 * Type:     function
 * Name:     getUrl
 * Date:     September 11, 2009
 * Purpose:  Récupère la langue de en court.
 * Examples: {getlang}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_getlang($params, &$smarty){
	return !empty($_GET['strLangue']) ? magixcjquery_html_helpersHtml::unixSeparator().magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3) : '';
}