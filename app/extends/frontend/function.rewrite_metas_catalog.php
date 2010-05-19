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
	$product = $params['product'];
	$category = $params['category'];
	$subcategory = $params['subcategory'];
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
					$meta = $db['strrewrite'];
					//Tableau des variables à rechercher
					$search = array('[[product]]','[[category]]','[[subcategory]]');
					//Tableau des variables à remplacer 
					$replace = array(magixcjquery_string_convert::ucFirst($product),$category,$subcategory);
					//texte générique à remplacer
					$content = str_replace($search ,$replace,$db['strrewrite']);
				}else{
					//$meta = $p;
				}
				break;
			case 'description':
				if($lang == null){
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(7,2,$level);
				}else{
					$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(7,2,$level,$lang);
				}
				if($db != null){
					$meta = $db['strrewrite'];
				}else{
					$meta = $p;
				}
				break;
		}
	return $content;
}