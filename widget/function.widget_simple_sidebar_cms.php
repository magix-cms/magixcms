<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_simple_sidebar_cms} function plugin
 *
 * Type:     function
 * Name:     personnal_cms
 * Date:     September 29, 2009
 * Update:   May 23, 2010
 * Purpose:  
 * Examples: {widget_simple_sidebar_cms home=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_simple_sidebar_cms($params, $template){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$home = empty($params['home']) ? 'Home' : $params['home'];
	$menu = null;
	if(!isset($_GET['strLangue'])){
		if(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() != null){
			$nocat = null;
			foreach(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() as $block) $nocat .= $block['idcategory'];
			if($nocat == 0){
				$menu .= '<div id="page-menu-home" class="block">';
				$menu .= '<div><ul class="personnal-side-list">';
			}
			foreach(frontend_db_cms::publicDbCms()->s_root_page_cms_without_lang() as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['idcategory'].'-'.$block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				if(isset($_GET['getidpage'])){
					if($_GET['getidpage'] === $block['idpage']){
						$active = ' class="active-page"';
					}else{
						$active = ' class="non-active-page"';
					}  
				}
				$menu .='<li>'.'<div><a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['idpage'].'-'.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a></div>'.'</li>';
			}
			if($nocat == 0){
				$menu .= '</ul><div style="clear:left;"></div></div></div>';
			}
		}
	if(frontend_db_cms::publicDbCms()->s_category_cms_without_lang() != null){
			$menu .= '<div id="page-menu-nolang" class="block">';
			foreach(frontend_db_cms::publicDbCms()->s_category_cms_without_lang() as $block){
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['idcategory'].'-'.$block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				if(frontend_db_cms::publicDbCms()->s_page_cms_join_category_without_lang($block['idcategory'])!= null){
					$menu .= '<h3><a id="'.$block['pathcategory'].'" href="#">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3>';
					$menu .= '<div><ul class="personnal-side-list">';
					foreach(frontend_db_cms::publicDbCms()->s_page_cms_join_category_without_lang($block['idcategory']) as $url){
						if(isset($_GET['getidpage'])){
							if($_GET['getidpage'] === $url['idpage']){
								$active = ' class="active-page"';
							}else{
								$active= ' class="non-active-page"';
							}
						}
						$menu .='<li>'.'<a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$catpath.$url['idpage'].'-'.$url['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($url['subjectpage']).'</a>'.'</li>';
					}
					$menu .= '</ul><div style="clear:left;"></div></div>';
				}
			}
			$menu .= '</div>';
		}
	}else{
		if(frontend_db_cms::publicDbCms()->s_root_page_cms($lang) != null){
			$nocat = null;
			foreach(frontend_db_cms::publicDbCms()->s_root_page_cms($lang) as $block) $nocat .= $block['idcategory'];
			if($nocat == 0){
				$menu .= '<div id="page-menu-home" class="block">';
				$menu .= '<div><ul class="personnal-side-list">';
			}
			foreach(frontend_db_cms::publicDbCms()->s_root_page_cms($lang) as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['idcategory'].'-'.$block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				if(isset($_GET['getpurl'])){
					if($_GET['getpurl'] === $block['pathpage']){
						$active = ' class="active-page"';
					}else{
						$active = ' class="non-active-page"';
					}  
				}
				$menu .='<li>'.'<div><a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$block['idpage'].'-'.$block['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($block['subjectpage']).'</a></div>'.'</li>';
			}
			if($nocat == 0){
				$menu .= '</ul><div style="clear:left;"></div></div></div>';
			}
		}
		if(frontend_db_cms::publicDbCms()->s_category_cms($lang) != null){
			$menu .= '<div id="page-menu-lang">';
			foreach(frontend_db_cms::publicDbCms()->s_category_cms($lang) as $block){
				$islang = $block['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$block['codelang']: '';
				switch($block['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $block['idcategory'].'-'.$block['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				/*if(frontend_db_cms::publicDbCms()->s_page_cms_join_category($block['idcategory'],$lang) != null){
					$menu .= '<h3><a id="'.$block['pathcategory'].'" href="#">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3>';
					$menu .= '<div><ul class="personnal-side-list">';
					foreach(frontend_db_cms::publicDbCms()->s_page_cms_join_category($block['idcategory'],$lang) as $url){
						if(isset($_GET['getpurl'])){
							if($_GET['getpurl'] === $url['pathpage']){
								$active = ' class="active-page"';
							}else{
								$active = '';
							} 
						}
						$menu .='<li>'.'<a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$url['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($url['subjectpage']).'</a>'.'</li>';
					}
					$menu .= '</ul><div style="clear:left;"></div></div>';
				}
				*/
				if(frontend_db_cms::publicDbCms()->s_page_cms_join_category($block['idcategory'],$lang) != null){
					$menu .= '<h3><a id="'.$block['pathcategory'].'" href="#">'.magixcjquery_string_convert::ucFirst($block['category']).'</a></h3>';
					$menu .= '<div><ul class="personnal-side-list">';
					foreach(frontend_db_cms::publicDbCms()->s_page_cms_join_category($block['idcategory'],$lang) as $url){
						if(isset($_GET['getpurl'])){
							if($_GET['getpurl'] === $url['pathpage']){
								$active = ' class="active-page"';
							}else{
								$active= ' class="non-active-page"';
							}
						}
						$menu .='<li>'.'<a'.$active.' href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().$catpath.$url['idpage'].'-'.$url['pathpage'].'.html'.'">'.magixcjquery_string_convert::ucFirst($url['subjectpage']).'</a>'.'</li>';
					}
					$menu .= '</ul><div style="clear:left;"></div></div>';
				}
			}
			$menu .= '</div>';
		}
	}
	return $menu;
}