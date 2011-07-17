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
 * Smarty {widget_catalog_sidebar_product} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_sidebar_product
 * Date:     
 * Purpose:  
 * Examples: {widget_catalog_sidebar_product title="<h3>Catalogue</h3>"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien / Samuel Lesire
 * @version  1.2
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_sidebar_product($params, $template){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$ui = $params['ui'];
	$icons = $params['icons'];
	//Si jQuery UI on applique les style
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
		$wmenu .= '<div class="sidebar'.$wheader.'">';
		$wmenu .= '<div id="menu-catalog" class="block">';
		if(isset($params['title'])){
			$wmenu .= '<p class="title'.$wheader.'">'.$carticon.$title.'</p>'."\n";
		}else{
			$wmenu .= null;
		}
		//Sur la page root du catalogue
		
		/*if(!isset($_GET['idclc'])){
			$wmenu .= '<ul id="catalog-hierarchy" class="filetree">'."\n";
			if(!$lang){
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() as $cat){
					$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'"><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a></li>';
				}
			}else{
				foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) as $cat){
					$wmenu .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'"><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a></li>';
				}
			}
			$wmenu .= '</ul>'."\n";
		}else{/*
			/*
			 * Si on est dans une catégorie on execute la suite
			 * Si pas de langue
			 */
			

			if(!$lang){
				if(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() != null){
					$wmenu .='<ul id="catalog-hierarchy" class="filetree">'."\n";
					$i = 0;				
					foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_no_lang() as $cat){
														
						if(isset($_GET['idclc'])){
							if($_GET['idclc'] === $cat['idclc']){
								$active = '';
								$active_link = ' class="active-page"';
								$display = '';
								
							}else{
								$active = ' class="closed"';
								$active_link = '';
								$display = " style='display:none;'";
							} 
						} else {
							if ($i == 0) {
								$display = '';
								$i++;
							}else {
								$display = " style='display:none;'";
							}
						}
						
						$wmenu .= '<li'.$active.'><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'" ' . $active_link . ' ><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a>'."\n";
						if(frontend_db_catalog::publicDbCatalog()->s_product_in_category_no_language($cat['idclc']) != null){
							
							$wmenu .= '<ul' . $display . '>';
							foreach(frontend_db_catalog::publicDbCatalog()->s_product_in_category_no_language($cat['idclc']) as $pcat){
								if(isset($_GET['idproduct'])){
										
									if($_GET['idproduct'] === $pcat['idproduct']){
										$currentpage = ' class="active-page"';
									}else{
										$currentpage = '';
									}  
								}
								$wmenu .= '<li><a'.$currentpage.' href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$pcat['pathclibelle'],$pcat['idclc'],$pcat['urlcatalog'],$pcat['idproduct'],true).'"><span'.$file.'>'.magixcjquery_string_convert::ucFirst($pcat['titlecatalog']).'</span></a></li>'."\n";	
							}
							$wmenu .= '</ul>';
						}
					
					$wmenu .= "</li>\n"; 
					}
					$wmenu .='</ul>'."\n";
				}
			}else{
				/**
				 * Si la langue est définie
				 * On liste les catégories et les catégories respective de la catégorie sélectionné
				 */
			if(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) != null){
					$wmenu .='<ul id="catalog-hierarchy" class="filetree">'."\n";
					$i = 0;					
					foreach(frontend_db_catalog::publicDbCatalog()->s_category_menu_with_lang($lang) as $cat){
							
						if(isset($_GET['idclc'])){
							if($_GET['idclc'] === $cat['idclc']){
								$active = '';
								$active_link = ' class="active-page"';
								$display = '';
								
							}else{
								$active = ' class="closed"';
								$active_link = '';
								$display = " style='display:none;'";
							} 
						} else {
							if ($i == 0) {
								$display = '';
								$i++;
							}else {
								$display = " style='display:none;'";
							}
						}
						
						$wmenu .= '<li'.$active.'><a href="'.magixglobal_model_rewrite::filter_catalog_category_url($lang,$cat['pathclibelle'],$cat['idclc'],true).'" ' . $active_link . '><span'.$folder.'>'.magixcjquery_string_convert::ucFirst($cat['clibelle']).'</span></a>'."\n";
						
						if(frontend_db_catalog::publicDbCatalog()->s_product_in_category_with_language($idclc,$lang) != null){
															
							$wmenu .= '<ul' . $display . '>';
							foreach(frontend_db_catalog::publicDbCatalog()->s_product_in_category_with_language($idclc,$lang) as $pcat){

								if(isset($_GET['idproduct'])){
									if($_GET['idproduct'] === $pcat['idproduct']){
										$currentpage = ' class="active-page"';
									}else{
										$currentpage = '';
									}  
								}


								$wmenu .= '<li><a'.$currentpage.' href="'.magixglobal_model_rewrite::filter_catalog_product_url($lang,$pcat['pathclibelle'],$pcat['idclc'],$pcat['urlcatalog'],$pcat['idproduct'],true).'"><span'.$file.'>'.magixcjquery_string_convert::ucFirst($pcat['titlecatalog']).'</span></a></li>'."\n";	
							}
							$wmenu .= '</ul>';
						}
					
					$wmenu .= "</li>\n"; 
					}
					$wmenu .='</ul>'."\n";
				}
			}
		/*}*/
		$wmenu .= '</div><div style="clear:left;"></div></div>';
	return $wmenu;
	
}