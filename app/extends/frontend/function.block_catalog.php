<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {block_catalog} function plugin
 *
 * Type:     function
 * Name:     block_catalog
 * Date:     
 * Purpose:  
 * Examples: {block_catalog title="Catalogue"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_block_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$title = $params['title'];
	$ui = $params['ui'];
	if(isset($ui)){
		switch($ui){
			case "true":
				$wcontent = ' ui-widget-content ui-corner-all';
				$wheader = ' ui-widget-header ui-corner-all';
			break;
			case "false":
				$wcontent = '';
				$wheader = '';
			break;
		}
	}else{
		$wcontent = '';
		$wheader = '';
	}
	$wmenu = '<div class="sidebar">
		<div id="catalog-menu" class="block">
		<div class="block"><span style="float:left;" class="ui-icon ui-icon-document"></span>'.magixcjquery_string_convert::ucFirst($title).'</div>';
	if(!isset($_GET['idclc'])){
		if(!$lang){
			$catId = 0;
			foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() as $cat){
				if($catId != $cat['idclc']) {
					$wmenu .= '<h3><a href="#" id="'.$cat['pathclibelle'].'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></h3>';
					$catId = $cat['idclc'];
				}
				$wmenu .= '<div><ul>';
				$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></li>';
				$wmenu .= '</ul></div>';
			}
		}else{
			$catId = 0;
		foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) as $cat){
				if($catId != $cat['idclc']) {
					$wmenu .= '<h3><a href="#" id="'.$cat['pathclibelle'].'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></h3>';
					$catId = $cat['idclc'];
				}
				$wmenu .= '<div><ul>';
				$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></li>';
				$wmenu .= '</ul></div>';
			}
		}
	}
	if(isset($_GET['idclc'])){
		if(!$lang){
			$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_category($_GET['idclc']);
			$wmenu .= '<h3><a href="#" id="'.$tcat['pathclibelle'].'">'.magixcjquery_string_convert::ucFirst($tcat['clibelle']).'</a></h3>';
			$wmenu .= '<div><ul>';
			if(frontend_db_catalog::publicDbCatalog()->s_product_menu_no_lang_no_cat() != null){
				foreach(frontend_db_catalog::publicDbCatalog()->s_product_menu_no_lang_no_cat() as $prod) $wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'">'.magixcjquery_string_convert::ucFirst($prod['titlecatalog']).'</a></li>';
			}
			foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat){
				$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],true).'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></li>';
			}
			$wmenu .= '</ul></div>';
		}else{
			$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_category($_GET['idclc']);
			$wmenu .= '<h3><a href="#" id="'.$tcat['pathclibelle'].'">'.magixcjquery_string_convert::ucFirst($tcat['clibelle']).'</a></h3>';
			$wmenu .= '<div><ul>';
			if(frontend_db_catalog::publicDbCatalog()->s_product_menu_with_lang_no_cat($lang) != null){
				foreach(frontend_db_catalog::publicDbCatalog()->s_product_menu_with_lang_no_cat($lang) as $prod) $wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'">'.magixcjquery_string_convert::ucFirst($prod['titlecatalog']).'</a></li>';
			}
			foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_with_lang($_GET['idclc'],$lang) as $cat){
				$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],true).'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></li>';
			}
			$wmenu .= '</ul></div>';
		}
	}
	if(isset($_GET['idcls'])){
		if(!$lang){
			$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_subcategory($_GET['idcls']);
			$wmenu .= '<h3><a href="#" id="'.$tcat['pathslibelle'].'">'.magixcjquery_string_convert::ucFirst($tcat['slibelle']).'</a></h3>';
			$wmenu .= '<div><ul>';
			foreach(frontend_db_catalog::publicDbCatalog()->s_product_menu_no_lang($_GET['idcls']) as $cat){
				$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['urlcatalog'],$cat['idproduct'],true).'">'.magixcjquery_string_convert::ucFirst($cat['titlecatalog']).'</a></li>';
			}
			$wmenu .= '</ul></div>';
		}
	}
	$wmenu .= '</div></div>';
	return $wmenu;
	
}