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
 * Update:   Novembre 28, 2010
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
function smarty_function_widget_cms_sidebar_page($params, $template){
	$home = empty($params['home']) ? 'Home' : $params['home'];
	$menu = '';
		if(frontend_db_block_cms::s_parent_p(frontend_model_template::current_Language()) != null){
			$menu .= '<ul id="menu-cms"  class="li-list treeview">';
			foreach(frontend_db_block_cms::s_parent_p(frontend_model_template::current_Language()) as $p){
				$i = 0;
				if(isset($_GET['getidpage_p'])){
					if($_GET['getidpage_p'] === $p['idcat_p']){
						$active = ' class="active-cat"';
					}else{
						$active = ' style="display:none;"';
					}  
				}/* elseif ($i == 0) {
					$active = ' class="active-cat"';
					$i++;
				}*/ else {
					$active = ' style="display:none;"';
				}
				switch($p['idcat_p']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $p['idcat_p'].'-'.$p['title_page'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				print_r(frontend_db_block_cms::s_parent_p(frontend_model_template::current_Language()));
				$menu .= '<li><span class="no-link">'.magixcjquery_string_convert::ucFirst($p['title_page']).'</span>';
				$menu .= '<ul'. $active .'>';
				if(frontend_db_block_cms::s_child_page($p) != null){
					if(frontend_db_block_cms::s_child_page($p) != '0'){
					foreach(frontend_db_block_cms::s_child_page($p['idcat_p']) as $row){
						if(isset($_GET['getidpage'])){
							if($_GET['getidpage'] === $row['idpage']){
								$active = ' class="active-page"';
							}else{
								$active= ' class="non-active-page" ';
							}
						}
						$menu .='<li>'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().magixcjquery_html_helpersHtml::unixSeparator().$catpath.$row['idpage'].'-'.$row['uri_page'].'.html'.'">'.magixcjquery_string_convert::ucFirst($row['title_page']).'</a>'.'</li>';
					}
					$menu .= '</ul></li>';
					}
				}
			}
			$menu .= '</ul>';
		}
	return $menu;
}