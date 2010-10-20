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
 * Smarty {block_sub_category_catalog} function plugin
 *
 * Type:     function
 * Name:     block_sub_category_catalog
 * Date:     
 * Purpose:  
 * Examples: {block_sub_category_catalog title=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_block_sub_category_catalog($params, &$smarty){
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	$title = $params['title']?$params['title']:'';
	$tcat = frontend_db_catalog::publicDbCatalog()->s_current_name_category($_GET['idclc']);
	foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat) $vcat .= $cat['idcls'];
	if($vcat!= null){
		$block = '<p>'.$title.'</p>';
		$block .= '<ul>';
		foreach(frontend_db_catalog::publicDbCatalog()->s_sub_category_menu_no_lang($_GET['idclc']) as $cat){
				if($cat['idcls'] != null){
					$block .= '<li><a href="'.magixglobal_model_rewrite::filter_catalog_subcategory_url($lang,$cat['pathclibelle'],$cat['idclc'],$cat['pathslibelle'],$cat['idcls'],true).'">'.magixcjquery_string_convert::ucFirst($cat['slibelle']).'</a></li>';
				}
			}
		$block .= '</ul>';
	}
	return $block;
}