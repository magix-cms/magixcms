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
 * @license  Dual licensed under the MIT or GPL Version 3 licenses.
 * @version  plugin version
 * @author   <samuel@magix-cms.com>, <aurelien@magix-cms.com>
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_prelude_lang} function plugin
 *
 * Type:     function
 * Name:     widget_prelude_lang
 * Date:     25/11/2010
 * Examples: {widget_prelude_lang display=true icons=true separator="|"}
 * Output:   
 * @link 
 * @version  1.1
 * @param $params
 * @param $template
 * @return string
 */

function smarty_function_widget_prelude_lang($params, $template){
	$display = !empty($params['display'])? "true" : "false";
	$icons = !empty($params['icons'])? "true" : "false";
	$default = !empty($params['default'])? $params['default'] : "fr";
	$separator = !empty($params['separator'])? $params['separator'] : "";
	if($display == "true"){
		$menu = '<div id="prelude">';
		switch($icons){
			case "true":
				$menu .= '<a href="/" hreflang="'.$default.'">';
				$menu .= '<img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/lang/'.$default.'.png" alt="'.$default.'" />';
				$menu .= '</a>';
				foreach (fetch_all_lang() as $l){
					$menu .= $separator.'<a href="/'.$l['codelang'].'/" hreflang="'.$l['codelang'].'">';
					$menu .= '<img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/lang/'.$l['codelang'].'.png" alt="'.$l['desclang'].'" />';
					$menu .= '</a>';
				}
			break;
			case "false":
				$menu .= '<a href="/">'.$default.'</a>';
				foreach (fetch_all_lang() as $l){
					$menu .= $separator.'<a href="/'.$l['codelang'].'/">'.$l['codelang'].'</a>';
				}
			break;
		}
		$menu .= "</div>";
	}
	return $menu;
}
function fetch_all_lang(){
    $sql = 'SELECT l.idlang, l.codelang, l.desclang
           FROM mc_lang AS l
           ORDER BY l.idlang';
    return magixglobal_model_db::layerDB()->select($sql);
}

?>