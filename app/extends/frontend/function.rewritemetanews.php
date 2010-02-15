<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {rewritemetanews} function plugin
 *
 * Type:     function
 * Name:     rewritemetanews
 * Date:     September 29, 2009
 * Purpose:  
 * Examples: {rewritemetanews}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_rewritemetanews($params, &$smarty){
	$type = $params['type'];
	$p = $params['param'];
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	switch ($type){
		case 'title':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,1,0);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,1,0,$lang);
			}
			if($db != null){
				$phrase2 = $db['phrase2'] ? ' '.$db['phrase2'] : '';
				$meta = $p.' '.$db['phrase1'].' '.$p.$phrase2;
			}else{
				$meta = $p;
			}
			break;
		case 'description':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,2,0);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,2,0,$lang);
			}
			if($db != null){
				$phrase2 = $db['phrase2'] ? ' '.$db['phrase2'] : '';
				$meta = $db['phrase1'].' '.$p.$phrase2;
			}else{
				$meta = $p;
			}
			break;
	}
	return $meta;
}