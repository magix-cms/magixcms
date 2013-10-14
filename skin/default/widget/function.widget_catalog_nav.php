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
 * Smarty {widget_catalog_nav} function plugin
 *
 * Type:     function
 * Name:     widget_catalog_nav
 * Date:     27/09/2012
 * Update:   10/03/2013
 * Output:
 * @author   Sire Sam (http://www.sire-sam.be)
 * @author   Gerits Aurélien (http://www.magix-dev.be)
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog_nav($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelCatalog       =   new frontend_model_catalog();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   (is_array($params['conf'])) ? $params['conf'] : array('context' => 'all');
    $data       =   $ModelCatalog->getData($conf,$current);
    $current    =   $current['catalog'];

    $i = 1;
    $items = null;
    $output = null;
    if ($data != null){
        // *** set html attribut
       $htmlAttr = isset($params['htmlAttribut']) ? $params['htmlAttribut'] : null;
       $id_container       =       isset($htmlAttr['id_container'])       ? ' id="'.$htmlAttr['id_container'].'"'      : null;
       $class_container    =       isset($htmlAttr['class_container'])    ? ' class="'.$htmlAttr['class_container'].'"'   : null;
       $class_current      =       isset($htmlAttr['class_current'])      ? $htmlAttr['class_current'] : 'active';

        // *** format items loop (foreach item)
        foreach($data as $row_1){
            $items_2 = null;
            if ( isset($row_1['subdata']) AND is_array($row_1['subdata']) AND $row_1['subdata'] != null){
                $sub_items_3 = null;
                foreach($row_1['subdata'] as $row_2){
                    $items_3 = null;
                    if ( isset($row_2['subdata']) AND is_array($row_2['subdata']) AND $row_2['subdata'] != null){
                        foreach($row_2['subdata'] as $row_3){
                            /** HTML FORMAT (LEVEL 3)**/
                            $data_item_3    = $ModelCatalog->setItemData($row_3,$current);
                            if ( $data_item_3['active'] === true) {
                                $current_item = ' class="'.$class_current.'"';

                            }else {
                                $current_item = null;
                            }
                            $items_3 .= '<li'.$current_item.'>';
                            $items_3 .= '<a href="'.$data_item_3['url'].'" title="'. $data_item_3['name'].'">';
                            $items_3 .= $data_item_3['name'];
                            $items_3 .= '</a>';
                            $items_3 .= '</li>';
                        }
                    }
                    /** HTML FORMAT (LEVEL 2)**/
                    $data_item_2    = $ModelCatalog->setItemData($row_2,$current);
                    if ($data_item_2['active'] === true) {
                        $current_item = ' class="'.$class_current.'"';
                    }else {
                        $current_item = null;
                    }
                    $items_2 .= '<li'.$current_item.'>';
                    $items_2 .= '<a href="'.$data_item_2['url'].'" title="'. $data_item_2['name'].'">';
                    $items_2 .= $data_item_2['name'];
                    $items_2 .= '</a>';
                    $items_2 .=  ($items_3 != null) ? '<ul class="hidden-sm">'.$items_3.'</ul>' : '';
                    $items_2 .= '</li>';
                }
            }
            /** HTML FORMAT (LEVEL 1)**/
            $data_item = $ModelCatalog->setItemData($row_1,$current);
            if ($data_item['active'] === true) {
                $current_item = ' class="'.$class_current.'"';
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

        // *** container construct
        if ($items != null) {
            $output .= isset($params['title']) ? $params['title'] : null;
            $output .= '<ul'.$id_container.$class_container.'>';
            $output .= isset($params['prepend']) ? $params['prepend'] : null;
            $output .=  $items;
            $output .= isset($params['append']) ? $params['append'] : null;
            $output .= '</ul>';
        }
    }
    return $output;
}