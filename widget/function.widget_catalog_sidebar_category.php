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
 * Smarty {widget_catalog_sidebar_category} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_sidebar_category
 * Date:     18 juillet 2011
 * Purpose:  
 * Examples: {widget_catalog_sidebar_category exclude=['fr'=>['1,3'],'en'=>['7']]}
 * Output:   
 * @link 	http://www.magix-dev.be
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_sidebar_category($params, $template){
	$ui = $params['ui'];
	$icons = $params['icons'];
	$exclude = $params['exclude'];
	//Si icons = true on retourne les icônes de jquery treeview
	if(isset($icons)){
		$folder = ' class="folder"';
		$file = ' class="file"';
	}else{
		$folder = '';
		$file = '';
	}
	//On retourne le titre
	$title = !empty($params['title'])? $params['title']:'';
	$wmenu .= '<div class="sidebar">';
	$wmenu .= '<div id="catalog-menu">';
	if(isset($params['title'])){
		$wmenu .= '<p class="title">'.$title.'</p>'."\n";
	}else{
		$wmenu .= null;
	}
	//Sur la page root du catalogue
	/*
	 * Si on est dans une catégorie on execute la suite
	 * 
	 */
	
	if(!isset($_GET['idclc'])){
			$display = " style='display:none;'";
	}else{
			$display= '';
	} 
	if (isset($exclude)) {
		/**
		 * Si la langue est définie
		 * On liste les catégories et les catégories respective de la catégorie sélectionné
		 */
		$exclude_array = $exclude[frontend_model_template::current_Language()];
		$exclude_sql = implode (',', $exclude_array);
		if(frontend_db_block_catalog::s_category_menu_with_exclude(frontend_model_template::current_Language(),$exclude_sql) != null){
				$wmenu .='<ul id="catalog-hierarchy" class="filetree">'."\n";
				foreach(frontend_db_block_catalog::s_category_menu_with_exclude(frontend_model_template::current_Language(),$exclude_sql) as $cat){
					if(isset($_GET['idclc'])){
						if($_GET['idclc'] === $cat['idclc']){
							$active = '';
							$active_link = ' class="active-page"';
							
						}else{
							$active = ' class="closed"';
							$active_link = '';
						} 
					}
					$wmenu .= '<li'.$active.'><a href="'.magixglobal_model_rewrite::filter_catalog_category_url(frontend_model_template::current_Language(),$cat['pathclibelle'],$cat['idclc'],true).'" ' . $active_link . '><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a>'."\n";
					if(frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$cat['idclc']) != null){
						$wmenu .= '<ul' . $display . '>';
						foreach(frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$cat['idclc']) as $scat){
							if(isset($_GET['idcls'])){
								if($_GET['idcls'] === $scat['idcls']){
									$currentpage = ' class="active-page"';
								}else{
									$currentpage = '';
								}  
							}
							$wmenu .= '<li><a'.$currentpage.' href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url(frontend_model_template::current_Language(),$scat['pathclibelle'],$scat['idclc'],$scat['pathslibelle'],$scat['idcls'],true).'"><span'.$file.'>'.magixcjquery_string_convert::ucFirst($scat['slibelle']).'</span></a></li>'."\n";	
						}
						$wmenu .= '</ul>';
					}
				$wmenu .= "</li>\n"; 
				}
				$wmenu .='</ul>'."\n";
			}
		$wmenu .= '</div><div style="clear:left;"></div></div>';
	}else{
		if(frontend_db_block_catalog::s_category_menu(frontend_model_template::current_Language()) != null){
				$wmenu .='<ul id="catalog-hierarchy" class="filetree">'."\n";
				foreach(frontend_db_block_catalog::s_category_menu(frontend_model_template::current_Language()) as $cat){
					if(isset($_GET['idclc'])){
						if($_GET['idclc'] === $cat['idclc']){
							$active = '';
							$active_link = ' class="active-page"';
							
						}else{
							$active = ' class="closed"';
							$active_link = '';
						} 
					}
					$wmenu .= '<li'.$active.'><a href="'.magixglobal_model_rewrite::filter_catalog_category_url(frontend_model_template::current_Language(),$cat['pathclibelle'],$cat['idclc'],true).'" ' . $active_link . '><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a>'."\n";
					if(frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$cat['idclc']) != null){
						$wmenu .= '<ul' . $display . '>';
						foreach(frontend_db_block_catalog::s_sub_category_menu(frontend_model_template::current_Language(),$cat['idclc']) as $scat){
							if(isset($_GET['idcls'])){
								if($_GET['idcls'] === $scat['idcls']){
									$currentpage = ' class="active-page"';
								}else{
									$currentpage = '';
								}  
							}
							$wmenu .= '<li><a'.$currentpage.' href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url(frontend_model_template::current_Language(),$scat['pathclibelle'],$scat['idclc'],$scat['pathslibelle'],$scat['idcls'],true).'"><span'.$file.'>'.magixcjquery_string_convert::ucFirst($scat['slibelle']).'</span></a></li>'."\n";	
						}
						$wmenu .= '</ul>';
					}
				$wmenu .= "</li>\n"; 
				}
				$wmenu .='</ul>'."\n";
			}
		$wmenu .= '</div><div style="clear:left;"></div></div>';
	}
	return $wmenu;
}