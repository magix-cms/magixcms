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
	if(isset($ui)){
		switch($ui){
			case "true":
				$wcontent = ' ui-widget-content ui-corner-all';
				$wheader = ' ui-widget-header ui-corner-all';
				$carticon = '<span class="ui-icon ui-icon-cart" style="float: left;"></span>';
			break;
			case "false":
				$wcontent = '';
				$wheader = '';
				$carticon= '';
			break;
		}
	}else{
		$wcontent = '';
		$wheader = '';
		$carticon= '';
	}
	$title = !empty($params['title'])? $params['title']:'';
	if(isset($_GET['catalog'])){
		$wmenu .= '<div class="sidebar'.$wheader.'">';
		$wmenu .= '<div id="catalog-menu" class="block">';
		if(isset($params['title'])){
			$wmenu .= '<h3 class="t_catalog'.$wheader.'">'.$carticon.$title.'</h3>';
		}else{
			$wmenu .= null;
		}
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