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
 * Name:     widget_simple_sidebar_cms
 * Date:     September 29, 2009
 * Update:   Jully 18, 2011
 * Purpose:  
 * Examples: {widget_simple_sidebar_cms home=""}
 * Output:   http://www.magix-dev.be
 * @link 
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_cms_sidebar_page($params, $template){
	$home = empty($params['home']) ? 'Home' : $params['home'];
	$menu = '';
		if(frontend_db_block_cms::s_parent_p(frontend_model_template::current_Language()) != null){
			$menu .= '<ul id="menu-cms"  class="li-list treeview">';
			$i = 0;
			foreach(frontend_db_block_cms::s_parent_p(frontend_model_template::current_Language()) as $p){
				if(isset($_GET['getidpage_p']) OR isset($_GET['getidpage'])){
					if($_GET['getidpage_p'] === $p['idpage'] OR $_GET['getidpage'] === $p['idpage']){
						$active = ' class="active-cat"';
					}else{
						$active = ' style="display:none;"';
					}  
				} else {
					if ($i == 0) {
						$active = ' class="active-cat"';
						$i++;
					}else{
						$active = ' style="display:none;"';
					}
				}
				$uri_parent = magixglobal_model_rewrite::filter_cms_url($p['iso'], NULL, NULL, $p['idpage'], $p['uri_page'],true);
				$menu .= '<li><a href="'.$uri_parent.'">'.magixcjquery_string_convert::ucFirst($p['title_page']).'</a>';
				if(frontend_db_block_cms::s_child_page($p['idpage']) != null){
					$menu .= '<ul'. $active .'>';
					foreach(frontend_db_block_cms::s_child_page($p['idpage']) as $row){
						if(isset($_GET['getidpage'])){
							if($_GET['getidpage'] === $row['idpage']){
								$active = ' class="active-page"';
							}else{
								$active= ' class="non-active-page" ';
							}
						}else{
							$active= ' class="non-active-page" ';
						}
						$uri_child = magixglobal_model_rewrite::filter_cms_url($row['iso'], $row['idcat_p'], $p['uri_page'], $row['idpage'], $row['uri_page'],true);
						$menu .='<li>'.'<a'.$active.' href="'.$uri_child.'">'.magixcjquery_string_convert::ucFirst($row['title_page']).'</a>'.'</li>';
					}
					$menu .= '</ul>';
				}
				$menu .= '</li>';
			}
			$menu .= '</ul>';
		}
	return $menu;
}