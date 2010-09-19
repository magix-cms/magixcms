<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_simple_sidebar_catalog} function plugin
 *
 * Type:     function
 * Name:     widget_simple_sidebar_catalog
 * Date:     
 * Purpose:  
 * Examples: {widget_simple_sidebar_catalog title="Catalogue"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_simple_sidebar_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$ui = $params['ui'];
	$title = !empty($params['title'])? $params['title']:'';
	if(isset($_GET['catalog'])){
		if(isset($params['title'])){
			$wmenu = '<h2 class="t_catalog ui-widget-header ui-corner-all"><span class="ui-icon ui-icon-cart" style="float: left;"></span>'.$title.'</h2>';
		}else{
			$wmenu = null;
		}
		$wmenu .= '<div class="sidebar ui-widget-header ui-corner-all">
			<div id="catalog-menu" class="block">';
		if(!isset($_GET['idclc'])){
			if(!$lang){
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() as $cat){
					$wmenu .= '<ul class="personnal-side-list"><li><div><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div></li></ul>';
				}
			}else{
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) as $cat){
					$wmenu .= '<ul class="personnal-side-list"><li><div><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div></li></ul>';
				}
			}
		}else{
			$catId = 0;
			if(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_all_no_lang() != null){
				foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_all_no_lang() as $scat){
					if(isset($_GET['idclc'])){
						if($_GET['idclc'] === $scat['idclc']){
							$active = ' class="active-page"';
						}else{
							$active = '';
						} 
					}
					if($catId != $scat['idclc']) {
						$wmenu .= '<ul class="personnal-side-list"><li><div><a'.$active.' href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$scat['pathclibelle'],$scat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($scat['clibelle']).'</a></div></li></ul>';
						$catId = $scat['idclc'];
					}
					if($scat['idcls'] != null) {
						$wmenu .= '<ul class="current_subcat">';
						$wmenu .= '<li><a'.$active.' href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url($lang,$scat['pathclibelle'],$scat['idclc'],$scat['pathslibelle'],$scat['idcls'],true).'">'.magixcjquery_string_convert::ucFirst($scat['slibelle']).'</a></li>';				
						$wmenu .= '</ul>';
					}
				}
			}
		}
		$wmenu .= '</div><div style="clear:left;"></div></div>';
	}
	return $wmenu;
	
}