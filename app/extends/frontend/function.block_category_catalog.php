<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {block_category_catalog} function plugin
 *
 * Type:     function
 * Name:     block_catalog
 * Date:     
 * Purpose:  
 * Examples: {block_category_catalog title="Catalogue"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_block_category_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$title = !empty($params['title'])?$params['title']:'';
	$ui = $params['ui'];
	$size = $params['size']?$params['size']:'mini';
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	switch($size){
		case 'medium':
			$sizecapture = 'medium';
		break;
		case 'mini':
			$sizecapture = 'mini';
		break;
	}
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
	if(isset($ui)){
		$wcontent = ' ui-widget-content ui-corner-all';
		$wheader = ' ui-widget-header ui-corner-all';
	}
	$block = '<h1>'.$title.'</h1>';
	switch($lang){
		case null:
			if(frontend_db_catalog::publicDbCatalog()->s_category_withimg_nolang() != null){
				$block .= '<div id="catalog-list-category">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_withimg_nolang() as $cat){
					$block .= '<div class="list-img-category'.$wheader.'">';
					if($tposition == 'top'){
						$block .= '<div class="title-product"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					if($cat['imgcatalog'] != null){
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg'.magixcjquery_html_helpersHtml::unixSeparator().$sizecapture.magixcjquery_html_helpersHtml::unixSeparator().$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
						$block .= '</div>';
					}else{
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'public/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
						$block .= '</div>';
					}
					if($tposition == 'bottom'){
						$block .= '<div class="title-category"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					$block .= '</div>';
				}
				$block .= '</div><div style="clear:left;"></div>';
			}
		break;
		case !null:
			if(frontend_db_catalog::publicDbCatalog()->s_category_withimg_lang($lang) != null){
				$block .= '<div id="catalog-list-category'.$wcontent.'">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_withimg_lang($lang) as $cat){
					$block .= '<div class="list-img-category'.$wheader.'">';
					if($tposition == 'top'){
						$block .= '<div class="title-product"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					if($cat['imgcatalog'] != null){
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$lang.magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg'.magixcjquery_html_helpersHtml::unixSeparator().$sizecapture.magixcjquery_html_helpersHtml::unixSeparator().$cat['imgcatalog'].'" alt="'.$cat['titlecatalog'].'" /></a>';
						$block .= '</div>';
					}else{
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$lang.magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'public/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['titlecatalog'].'" /></a>';
						$block .= '</div>';
					}
					if($tposition == 'bottom'){
						$block .= '<div class="title-category"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$langsession.magixcjquery_html_helpersHtml::unixSeparator().'c'.magixcjquery_html_helpersHtml::unixSeparator().$cat['pathclibelle'].'-'.$cat['idclc'].'.html'.'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					$block .= '</div>';
				}
				$block .= '</div><div style="clear:left;"></div>';
			}
		break;
	}
	return $block;
}