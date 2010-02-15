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
		if(frontend_db_cms::publicDbCms()->block_plugin_cms_nolang_nocat() != null){
			$nocat = null;
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms_nolang_nocat() as $block) $nocat .= $block['idcategory'];
			if($nocat == 0){
				$menu .= '<div id="page-menu-home" class="block ui-widget-content ui-corner-all">';
				$menu .= '<div class="ui-widget-header ui-corner-all"><h3><span style="float:left;" class="ui-icon ui-icon-home"></span><a href="#" id="page-home">'.magixcjquery_string_convert::ucFirst($home).'</a></h3></div>';
				$menu .= '<div><ul>';
			}
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms_nolang_nocat() as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}  
				$menu .='<li>'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a>'.'</li>';
			}
			if($nocat == 0){
				$menu .= '</ul></div></div>';
			}
		}
		$catIdnolang = 0;
		if(frontend_db_cms::publicDbCms()->block_plugin_cms_nolang() != null){
			$menu .= '<div id="page-menu-nolang" class="block ui-widget-content ui-corner-all">';
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms_nolang() as $block){
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				if($catIdnolang != $block['idcategory']){
					$menu .= '<div class="ui-widget-header ui-corner-all"><h3><span style="float:left;" class="ui-icon ui-icon-document"></span><a href="#" id="'.$block['pathcategory'].'">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3></div>';
					$catIdnolang = $block['idcategory'];
				}
				$menu .= '<div>';
				$menu .= '<ul>';
				$menu .='<li>'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a>'.'</li>';
				$menu .= '</ul>';
				$menu .= '</div>';
			}
			$menu .= '</div>';
		}
	}else{
		if(frontend_db_cms::publicDbCms()->block_plugin_cms_nocat($lang) != null){
			$nocat2 = '';
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms_nocat($lang) as $block) $nocat2 .= $block['idcategory'];
			if($nocat2 == 0){
				$menu .= '<div id="page-menu-home-lang" class="block ui-widget-content ui-corner-all">';
				$menu .= '<div class="ui-widget-header ui-corner-all"><h3><span style="float:left;" class="ui-icon ui-icon-home"></span><a href="#" id="page-home">'.magixcjquery_string_convert::ucFirst($home).'</a></h3></div>';
				$menu .= '<div><ul>';
			}
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms_nocat($lang) as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				$menu .='<li>'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a>'.'</li>';
			}
			if($nocat2 == 0){
				$menu .= '</ul></div></div>';
			}
		}
		if(frontend_db_cms::publicDbCms()->block_plugin_cms($lang) != null){
			$menu .= '<div id="page-cat-lang" class="block ui-widget-content ui-corner-all">';
			$catId = 0;
			foreach(frontend_db_cms::publicDbCms()->block_plugin_cms($lang) as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				$catpath = $block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
				if($catId != $block['idcategory']){
					$menu .= '<div class="ui-widget-header ui-corner-all"><h3><span style="float:left;" class="ui-icon ui-icon-home"></span><a href="#" id="page-'.$block['pathcategory'].'">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3></div>';
					$catId = $block['idcategory'];
				}
				$menu .= '<div><ul>';
				$menu .='<li>'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a>'.'</li>';
				$menu .= '</ul></div>';
			}
			$menu .= '</div>';
		}
	}
	return $menu;
}