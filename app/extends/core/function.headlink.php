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
 * Smarty {headlink rel="" href="" optionnal(media="")} function plugin
 *
 * Type:     function
 * Name:     
 * Date:     
 * Purpose:  
 * Examples: {headlink}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_headlink($params, &$smarty){
	$rel = $params['rel'];
	if (!isset($rel)) {
	 	$smarty->trigger_error("rel: missing 'rel' parameter in link");
		return;
	}
	$href = $params['href'];
	if (!isset($href)) {
	 	$smarty->trigger_error("href: missing 'href' parameter in link");
		return;
	}
	$ini = new magixcjquery_view_helper_headLink();
	switch($rel){
		case 'stylesheet':
			$head = $ini->linkStyleSheet($href,$params['media']);
		break;
		case 'rss':
			$head = $ini->linkRss($href);
		break;
	}
	return $head;
}