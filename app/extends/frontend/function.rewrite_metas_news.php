<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {rewrite_metas_news} function plugin
 *
 * Type:     function
 * Name:     rewritemetanews
 * Date:     September 29, 2009
 * Purpose:  
 * Examples: {rewrite_metas_news}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_rewrite_metas_news($params, &$smarty){
	$type = $params['type'];
	$p = $params['param'];
	$level = $params['level'];
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	switch ($type){
		case 'title':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,1,$level);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,1,$level,$lang);
			}
			if($db != null){
				switch ($level){
				case 0 :
					$content = $db['strrewrite'];
				break;
				case 1 :
					//Tableau des variables à rechercher
					$search = array('[[record]]');
					//Tableau des variables à remplacer 
					$replace = array(magixcjquery_string_convert::ucFirst($p));
					//texte générique à remplacer
					$content = str_replace($search ,$replace,$db['strrewrite']);
				break;
				}
			}else{
				$content = $p;
			}
			break;
		case 'description':
			if($lang == null){
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta_emptylanguage(5,2,$level);
			}else{
				$db = frontend_db_config::frontendDCconfig()->s_plugin_rewrite_meta(5,2,$level,$lang);
			}
			if($db != null){
			switch ($level){
				case 0 :
					$content = $db['strrewrite'];
				break;
				case 1 :
					//Tableau des variables à rechercher
					$search = array('[[record]]');
					//Tableau des variables à remplacer 
					$replace = array(magixcjquery_string_convert::ucFirst($p));
					//texte générique à remplacer
					$content = str_replace($search ,$replace,$db['strrewrite']);
				break;
				}
			}else{
				$content = $p;
			}
			break;
	}
	return $content;
}