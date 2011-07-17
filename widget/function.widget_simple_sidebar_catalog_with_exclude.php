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
 * Examples: {widget_simple_sidebar_catalog title="Catalogue" exclude=['nl'=>[ '1' => '10'], 'fr'=>['1' =>'20', '2'=> '30']]}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.2
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_simple_sidebar_catalog_with_exclude($params, $template){
	$ui = $params['ui'];
	$icons = $params['icons'];
	$exclude = $params['exclude'];
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
	$wmenu .= '<div id="catalog-menu">';
	if(isset($params['title'])){
		$wmenu .= '<p class="title'.$wheader.'">'.$carticon.$title.'</p>'."\n";
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
	/**
	 * Si la langue est définie
	 * On liste les catégories et les catégories respective de la catégorie sélectionné
	 */
	$exclude = $exclude[frontend_model_template::current_Language()];
	$exclude_sql = implode (',', $exclude);
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
return $wmenu;
	
}