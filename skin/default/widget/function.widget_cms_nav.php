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
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_cms_nav} function plugin
 *
 * Type:     function
 * Name:     widget_cms_nav
 * Date:     22/09/2012
 * Update:   10/03/2012
 * Output:
 * @author   Sire Sam (http://www.sire-sam.be)
 * @author   Gerits Aurélien (http://www.magix-dev.be)
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_cms_nav($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelCms           =   new frontend_model_cms();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   (is_array($params['conf'])) ? $params['conf'] : array('level' => 'all');
    $data       =   $ModelCms->getData($conf,$current);
    $current    =   $current['cms'];

    $i = 1;
    $items = null;
    $output = null;
    if ($data != null) {
        // *** set default html attributs
        if ($params['htmlAttribut']) {
            $htmlAttr = $params['htmlAttribut'];
            $id_container       =       isset($htmlAttr['id_container'])       ? ' id="'.$htmlAttr['id_container'].'"'      : null;
            $class_container    =       isset($htmlAttr['class_container'])    ? ' class="'.$htmlAttr['class_container'].'"'   : null;
            $class_active      =       isset($htmlAttr['class_active'])      ? $htmlAttr['class_active'] : 'active';
        }

        // *** format items loop (foreach item)
        foreach($data as $row_1){
            $items_2 = null;
            if ( isset($row_1['subdata']) AND is_array($row_1['subdata'])){
                foreach($row_1['subdata'] as $row_2){
                    /** HTML FORMAT (LEVEL 2)**/
                    $data_item_2    = $ModelCms->setItemData($row_2,$current);
                    if ($data_item_2['active'] === true) {
                        $current_item = ' class="'.$class_active.'"';
                    }else {
                        $current_item = null;
                    }
                    $items_2 .= '<li'.$current_item.'>';
                    $items_2 .= '<a href="'.$data_item_2['url'].'" title="'. $data_item_2['name'].'">';
                    $items_2 .= $data_item_2['name'];
                    $items_2 .= '</a>';
                    $items_2 .= '</li>';
                }
            }
            /** HTML FORMAT (LEVEL 1)**/
            $data_item = $ModelCms->setItemData($row_1,$current);
            if ($data_item['active'] === true) {
                $current_item = ' class="'.$class_active.'"';
            }else {
                $current_item = null;
            }
            $items .= '<li'.$current_item.'>';
            $items .= '<a href="'.$data_item['url'].'" title="'. $data_item['name'].'">';
            $items .= $data_item['name'];
            $items .= '</a>';
            $items .=  ($items_2 != null) ? '<ul class="hidden-sm">'.$items_2.'</ul>' : '';
            $items .= '</li>';
        }

        if ($items != null) {
            $output  = isset($params['title']) ? $params['title'] : '';
            $output .= '<ul'.$id_container.$class_container.'>';
            $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items;
            $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
            $output .= '</ul>';
        }
    }
	return $output;
}