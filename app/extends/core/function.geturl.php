<?php
/**
 * @category   Smarty Plugin
 * @package    MAGIX CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {geturl} function plugin
 *
 * Type:     function
 * Name:     getUrl
 * Date:     August 21, 2009
 * Purpose:  Récupère l'url du nom de domaine ou défini le root du site automatiquement
 * Examples: {geturl}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_geturl($params, &$smarty){
	return magixcjquery_html_helpersHtml::getUrl();
}