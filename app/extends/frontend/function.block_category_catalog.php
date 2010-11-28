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
function smarty_function_block_category_catalog($params, $template){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$title = !empty($params['title'])?$params['title']:'';
	$ui = $params['ui'];
	//$size = $params['size']?$params['size']:'mini';
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	/*switch($size){
		case 'medium':
			$sizecapture = 'medium';
		break;
		case 'mini':
			$sizecapture = 'mini';
		break;
	}*/
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
	$block = $title;
	switch($lang){
		case null:
			if(frontend_db_catalog::publicDbCatalog()->s_category_withimg_nolang() != null){
				$block .= '<div id="catalog-list-category">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_withimg_nolang() as $cat){
					$block .= '<div class="list-img-category'.$wcontent.'">';
					if($tposition == 'top'){
						$block .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					if($cat['img_c'] != null){
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/category/'.$cat['img_c'].'" alt="'.$cat['clibelle'].'" /></a>';
						$block .= '</div>';
					}else{
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['clibelle'].'" /></a>';
						$block .= '</div>';
					}
					if($tposition == 'bottom'){
						$block .= '<div class="title-category'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					$block .= '</div>';
				}
				$block .= '</div><div style="clear:left;"></div>';
			}
		break;
		case !null:
			if(frontend_db_catalog::publicDbCatalog()->s_category_withimg_lang($lang) != null){
				$block .= '<div id="catalog-list-category">';
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_withimg_lang($lang) as $cat){
					$block .= '<div class="list-img-category'.$wcontent.'">';
					if($tposition == 'top'){
						$block .= '<div class="title-product'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					if($cat['img_c'] != null){
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg/category/'.$cat['img_c'].'" alt="'.$cat['clibelle'].'" /></a>';
						$block .= '</div>';
					}else{
						$block .= '<div class="img-product">';
						$block .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog'.magixcjquery_html_helpersHtml::unixSeparator().'no-picture.png'.'" alt="'.$cat['clibelle'].'" /></a>';
						$block .= '</div>';
					}
					if($tposition == 'bottom'){
						$block .= '<div class="title-category'.$wheader.'"><a href="'.magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></div>';
					}
					$block .= '</div>';
				}
				$block .= '</div><div style="clear:left;"></div>';
			}
		break;
	}
	return $block;
}