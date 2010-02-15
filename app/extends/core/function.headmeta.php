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
 * Smarty {headmeta meta=""} function plugin
 *
 * Type:     function
 * Name:     
 * Date:     
 * Purpose:  
 * Examples: {headmeta}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_headmeta($params, &$smarty){
	$meta = $params['meta'];
	if (!isset($meta)) {
	 	$smarty->trigger_error("meta: missing 'meta' parameter");
		return;
	}
	$ini = new magixcjquery_view_helper_headMeta();
	switch($meta){
		case 'contentType':
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$charset = !empty($params['charset'])?$params['charset']:'utf8';
			$head = $ini->contentType($content,$charset);
		break;
		case 'contentStyleType' : 
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->contentStyleType($content);
		break;
		case 'contentLanguage' :
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->contentLanguage($content);
		break;
		case 'revisitAfter' : 
			$int = !empty($params['int'])? $params['int'] : 3;
			$delay = !empty($params['delay']) ? $params['delay']: 'days';
			$head = $ini->revisitAfter($int,$delay);
		break;
		case 'keywords' :
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->keywords($content);
		break;
		case 'robots' :
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->robots($content);
		break;
		case 'googleSiteVerification' :
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->googleSiteVerification($content);
		break;
		case 'description' :
			$content = !isset($params['content'])?$smarty->trigger_error("content: missing 'content' parameter"):$params['content'];
			$head = $ini->description($content);
		break;
	}
	return $head;
}