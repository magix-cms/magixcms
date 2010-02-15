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
	switch($lang){
			case 'fr':
			$langsession = 'catalogue';
				break;
			case 'en':
			$langsession = 'catalog';
				break;	
			case 'de':
			$langsession = 'katalog';
				break;
			case 'nl':
			$langsession = 'catalog';
				break;	
			default:
			$langsession = 'catalogue';	
	}
	$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_category($_GET['idclc']);
	if(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) != null){
		$block = '<p>'.$title.'</p>';
		$block .= '<ul>';
		foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat){
				$block .= '<li><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathslibelle'].'-'.$cat['idcls'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></li>';
			}
		$block .= '</ul>';
	}
	return $block;
}