<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {block_cms} function plugin
 *
 * Type:     function
 * Name:     FileAriane
 * Date:     September 29, 2009
 * Purpose:  
 * Examples: {block_cms home=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_block_cms($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$home = empty($params['home']) ? 'Home' : $params['home'];
	$menu = null;
	if(!isset($_GET['strLangue'])){
		if(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() != null){
			$nocat = null;
			foreach(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() as $block) $nocat .= $block['idcategory'];
			if($nocat == 0){
				$menu .= '<div id="page-menu-home" class="block ui-widget-content ui-corner-all">';
				$menu .= '<div class="ui-widget-header ui-corner-all"><h3><span style="float:left;" class="ui-icon ui-icon-home"></span><a href="#" id="page-home">'.magixcjquery_string_convert::ucFirst($home).'</a></h3></div>';
				$menu .= '<div><ul>';
			}
				foreach(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() as $block){
					$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
					switch($block['idcategory']){
						case 0:
							$catpath = null;
						break;
						default: 
							$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
						break;
					}
					if(isset($_GET['getpurl'])){
						if($_GET['getpurl'] === $block['pathpage']){
							$active = ' class="active-page"';
						}else{
							$active = '';
						}  
					}
					$menu .='<li>'.'<div><a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a></div>'.'</li>';
				}
			if($nocat == 0){
				$menu .= '</ul></div></div>';
			}
		}
		if(frontend_db_cms::publicDbCms()->s_category_cms_without_lang() != null){
			$menu .= '<div id="page-menu-nolang" class="block ui-widget-content ui-corner-all">';
			foreach(frontend_db_cms::publicDbCms()->s_category_cms_without_lang() as $block){
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				if(isset($_GET['getpurl'])){
					if($_GET['getpurl'] === $block['pathpage']){
						$active = ' class="active-page"';
					}else{
						$active = '';
					} 
				}
				if(frontend_db_cms::publicDbCms()->s_page_cms_join_category_without_lang($block['idcategory'] != null)){
					$menu .= '<div class="ui-widget-header ui-corner-all"><h3><a id="'.$block['pathcategory'].'" href="#">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3></div>';
					$menu .= '<div><ul class="personnal-side-list">';
					foreach(frontend_db_cms::publicDbCms()->s_page_cms_join_category_without_lang($block['idcategory']) as $url){
						$menu .='<li>'.'<a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$catpath.$url['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($url['subjectpage']).'</a>'.'</li>';
					}
					$menu .= '</ul></div>';
				}
			}
			$menu .= '</div>';
		}
	}
	return $menu;
}