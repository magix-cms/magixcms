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
 * Smarty {widget_catalog_cat_display title="" tposition="bottom" ui=false col="2" size="medium"} function plugin
 *
 * Type:     function
 * Name:     block_catalog
 * Date:     
 * Purpose:  
 * Examples: {widget_catalog_cat_display title="" tposition="bottom" ui=false col="2" size="medium"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_cat_display($params, $template){
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
	// Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
	$i = 1;
	
	
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
	if(frontend_db_block_catalog::s_category_withimg_lang($lang) != null){
		$block .= '<div class="list-div medium bg light w11-32">';
		foreach(frontend_db_block_catalog::s_category_withimg_lang($lang) as $cat){
			if ($i == $last ) {
				$last_elem = 'last ';
				$i = 1;
			} else {
				$last_elem = null;
				$i++;
			}
			$block .= '<div class="list-div-elem '.$last_elem.$wcontent.'">';
			if($tposition == 'top'){
				$block .= '<p class="name'.$wheader.'"><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></p>';
			}
			if($cat['img_c'] != null){
				$block .= '<a class="img" href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="/upload/catalogimg/category/'.$cat['img_c'].'" alt="'.$cat['clibelle'].'" /></a>';
			}else{
				$block .= '<a class="img" href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'"><img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['clibelle'].'" /></a>';
			}
			if($tposition == 'bottom'){
				$block .= '<p class="name'.$wheader.'"><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang, $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></p>';
			}
			$block .= '</div>';
		}
		$block .= '</div>';
	}
	return $block;
}