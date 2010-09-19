<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {block_sub_category_catalog} function plugin
 *
 * Type:     function
 * Name:     block_sub_category_catalog
 * Date:     
 * Purpose:  
 * Examples: {block_sub_category_catalog title=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_block_sub_category_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$title = $params['title']?$params['title']:'';
	$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_category($_GET['idclc']);
	foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat) $vcat .= $cat['idcls'];
	if($vcat!= null){
		$block = '<p>'.$title.'</p>';
		$block .= '<ul>';
		foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat){
				if($cat['idcls'] != null){
					$block .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],true).'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></li>';
				}
			}
		$block .= '</ul>';
	}
	return $block;
}