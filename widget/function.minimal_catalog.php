<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {minimal_catalog} function plugin
 *
 * Type:     function
 * Name:     minimal_catalog
 * Date:     
 * Purpose:  
 * Examples: {minimal_catalog title="Catalogue"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_minimal_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$ui = $params['ui'];
	$title = !empty($params['title'])?$params['title']:'';
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
	if(isset($_GET['catalog'])){
	$wmenu = '<h2 class="t_catalog ui-widget-header ui-corner-all"><span class="ui-icon ui-icon-cart" style="float: left;"></span>'.$title.'</h2>';
	$wmenu .= '<div class="sidebar ui-widget-header ui-corner-all">
		<div id="catalog-menu" class="block">';
	if(!isset($_GET['idclc'])){
		if(!$lang){
			foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() as $cat){
				$wmenu .= '<ul class="personnal-side-list"><li><div><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div></li></ul>';
			}
		}else{
		foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) as $cat){
				$wmenu .= '<ul class="personnal-side-list"><li><div><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$lang.magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</div></li></ul>';
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
						$wmenu .= '<ul class="personnal-side-list"><li><div><a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$scat['pathclibelle'].'-'.$scat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($scat['clibelle']).'</a></div></li></ul>';
						$catId = $scat['idclc'];
					}
					if($scat['idcls'] != null) {
					$wmenu .= '<ul class="current_subcat">';
					$wmenu .= '<li><a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().$scat['pathclibelle'].'-'.$scat['idclc'].magixcjquery_html_helpersHtml::unixSeparator().'s'.magixcjquery_html_helpersHtml::unixSeparator().$scat['pathslibelle'].'-'.$scat['idcls'].'.html'.'">'.magixcjquery_string_convert::ucFirst($scat['slibelle']).'</a></li>';				
					$wmenu .= '</ul>';
					}
			}
		}
	}
	$wmenu .= '</div><div style="clear:left;"></div></div>';
	}
	return $wmenu;
	
}