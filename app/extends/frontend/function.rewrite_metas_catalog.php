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
 * Examples for category page: {rewrite_metas_catalog type="title" static=false param="$clibelle" level="1"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_rewrite_metas_catalog($params, &$smarty){
	$type = $params['type'];
	$p = $params['param'];
	$level = $params['level'];
	if (!isset($type)) {
	 	$smarty->trigger_error("type: missing 'type' parameter");
		return;
	}
	if (!isset($level)) {
	 	$smarty->trigger_error("level: missing 'level' parameter");
		return;
	}
	$lang = $_GET['strLangue'] ? $_GET['strLangue']:'';
		switch ($type){
			case 'title':
				if($lang == null){
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(7,1,$level);
				}else{
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(7,1,$level,$lang);
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
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(7,2,$level);
				}else{
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(7,2,$level,$lang);
				}
				if($db != null){
					$phrase2 = $db['phrase2'] ? ' '.$db['phrase2'] : '';
					$meta = $p.' '.$db['phrase1'].' '.$p.$phrase2;
				}else{
					$meta = $p;
				}
				break;
		}
	return $meta;
}