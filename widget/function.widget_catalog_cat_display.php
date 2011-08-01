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
 * Smarty {widget_catalog_cat_display title="" tposition="bottom" col="2" size="medium"} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_cat_display
 * Date:     
 * Update:   01-08-2011 
 * Purpose:  
 * Examples: {widget_catalog_cat_display css_param=[
					'class_container'=>'list-div medium bg light w11-32',
					'class_elem'=>'list-div-elem',
					'class_img'=>'img'
				] title="" tposition="bottom" col="2" size="medium"}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.2
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_cat_display($params, $template){
	$title = !empty($params['title'])?$params['title']:'';
	//Position du nom de l'élément
	$tposition = $params['tposition']? $params['tposition'] : 'top';
	// Nombre de colonnes
	$last = $params['col']? $params['col'] : 0 ;
	//Paramètres des classes CSS
	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array('class_container'=>'list-div medium bg light w11-32',
				'class_elem'=>'list-div-elem',
				'class_img'=>'img'
			);
	}
	$i = 1;
	$block = $title;
	$imgPath = new magixglobal_model_imagepath('catalog');
	if(frontend_db_block_catalog::s_category_widget(frontend_model_template::current_Language()) != null){
		$block .= '<div class="'.$tabs['class_container'].'">'."\n";
		foreach(frontend_db_block_catalog::s_category_widget(frontend_model_template::current_Language()) as $cat){
			if ($i == $last ) {
				$last_elem = ' last';
				$i = 1;
			} else {
				$last_elem = null;
				$i++;
			}
			$block .= '<div class="'.$tabs['class_elem'].$last_elem.'">'."\n";
			if($tposition == 'top'){
				$block .= '<p class="name"><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></p>';
			}
			if($cat['img_c'] != null){
				$block .= '<a class="'.$tabs['class_img'].'" href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'"><img src="'.$imgPath->filter_path_img('category',$cat['img_c']).'" alt="'.$cat['clibelle'].'" /></a>';
			}else{
				$block .= '<a class="'.$tabs['class_img'].'" href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'"><img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png'.'" alt="'.$cat['clibelle'].'" /></a>';
			}
			if($tposition == 'bottom'){
				$block .= '<p class="name"><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($cat['iso'], $cat['pathclibelle'], $cat['idclc'],true).'">'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</a></p>';
			}
			$block .= '</div>'."\n";
		}
		$block .= '</div>'."\n";
	}
	return $block;
}