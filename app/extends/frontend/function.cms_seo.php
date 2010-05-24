<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {cms_seo config=""} function plugin
 *
 * Type:     function
 * Name:     SEO CMS (pages)
 * Date:     December 7, 2009
 * Purpose:  
 * Examples: {cms_seo config="title"} or {cms_seo config="description"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_cms_seo($params, &$smarty){
	$config = $params['config'];
	$default = $params['default'];
	if (!isset($params['config'])) {
	 	$smarty->trigger_error("config: missing 'config' parameter");
		return;
	}
	$seo = frontend_db_cms::publicDbCms()->s_cms_seo($_GET['getidpage']);
	switch($config){
		case 'title':
			if($seo['metatitle'] != null){
				$seo = $seo['metatitle'];
			}else{
				$seo = $default;
			}
		break;
		case 'description':
			if($seo['metadescription'] != null){
				$seo = $seo['metadescription'];
			}else{
				$seo = $default;
			}
		break;
	}
	return $seo;
}