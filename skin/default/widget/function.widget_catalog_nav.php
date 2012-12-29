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
 * Date:     September 27, 2012
 * Update:   December  29, 2012
 * Purpose:
 * Output:
 * @link    htt://www.sire-sam.be, http://www.magix-dev.be
 * @author   Samuel Lesire
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string

 * Examples:
 *************
 *
 * basic :
 *-------
{widget_catalog_nav}

 *
 * HTML before :
 *-------------
{widget_catalog_onstructor
title='<p class="title">Fonctionalités Magix CMS</p>'
}

 *  Data config :
 *--------------
{widget_catalog_nav
hierarchy=[
'select' => 'all',
'level'   => 'all'
]
}

    - Allowed values & syntax
    'select' => 'all' (default),
                'current' (current page),
                ['fr'=>['1']] (only parent with idclc == 1 in FR version)
                ['fr'=>['1','6'],'en'=>['8']] (only parent with idclc == 1 AND 6 in FR version, 8 for EN Version)

    'exclude' => ['fr'=>['1']] (all excepted parent with idclc == 1 in FR version)
                ['fr'=>['1','6'],'en'=>['8']] (all excepted parent with idclc == 1 AND 6 in FR version, 8 for EN Version)

    'level'  => 'all'(default)
        'category'      (only first level category)
        'subcategory'   (only second level category)
        'product'       (only products)
        ['category] => 'subcategory'            ( first level categories with associated children)
        ['category] => ['subcategory' => 'product']             (first level categories with associated children ans their associated products )
        ['category'] => 'products']         ( first level categories with associated products)



 *
 */
function smarty_function_widget_catalog_nav($params, $template) {

    // ***Catch $_GET var
    $id_current['category']     =       magixcjquery_filter_isVar::isPostNumeric($_GET['idclc'])        ;
    $id_current['subcategory']  =       magixcjquery_filter_isVar::isPostNumeric($_GET['idcls'])        ;
    $id_current['product']      =       magixcjquery_filter_isVar::isPostNumeric($_GET['idproduct'])    ;

    // ***Current language iso
    $lang =  frontend_model_template::current_Language();
    $sort_config = array(
        'level' => 'all'
    );
    $sort_config = (is_array($params['dataSelect'])) ? $params['dataSelect'] : $sort_config;
    $data = frontend_model_catalog::set_sql_data($sort_config,$id_current);

    // FORMAT DATA
    // ***********
    $i = 1;
    $items = null;
    $output = null;
    if ($data != null){
         // ***HTML attributs var
       $htmlAttr = isset($params['htmlAttribut']) ? $params['htmlAttribut'] : null;
       $id_container       =       isset($htmlAttr['id_container'])       ? ' id="'.$htmlAttr['id_container'].'"'      : null;
       $class_container    =       isset($htmlAttr['class_container'])    ? ' class="'.$htmlAttr['class_container'].'"'   : null;
        $class_current      =       isset($htmlAttr['class_current'])      ? $htmlAttr['class_current'] : 'current';

        foreach($data as $row_1){
            $items_2 = null;
            if ( isset($row_1['subdata']) AND is_array($row_1['subdata']) AND $row_1['subdata'] != null){
                $sub_items_3 = null;
                foreach($row_1['subdata'] as $row_2){
                    $items_3 = null;
                    if ( isset($row_2['subdata']) AND is_array($row_2['subdata']) AND $row_2['subdata'] != null){
                        foreach($row_2['subdata'] as $row_3){
                            /** HTML FORMAT (LEVEL 3)**/
                            $data_item_3    = frontend_model_catalog::set_data_item($row_3,$id_current);
                            if ($data_item_3['current'] != 'false') {
                                $current_item = ' class="'.$class_current.'"';
                            }else {
                                $current_item = null;
                            }
                            $items_3 .= '<li'.$current_item.'>';
                            $items_3 .= '<a href="'.$data_item_3['uri'].'" title="'. $data_item_3['name'].'">';
                            $items_3 .= $data_item_3['name'];
                            $items_3 .= '</a>';
                            $items_3 .= '</li>';
                        }
                    }
                    /** HTML FORMAT (LEVEL 2)**/
                    $data_item_2    = frontend_model_catalog::set_data_item($row_2,$id_current);
                    if ($data_item_2['current'] != 'false') {
                        $current_item = ' class="'.$class_current.'"';
                    }else {
                        $current_item = null;
                    }
                    $items_2 .= '<li'.$current_item.'>';
                    $items_2 .= '<a href="'.$data_item_2['uri'].'" title="'. $data_item_2['name'].'">';
                    $items_2 .= $data_item_2['name'];
                    $items_2 .= '</a>';
                    $items_2 .=  ($items_3 != null) ? '<ul class="subnav-list">'.$items_3.'</ul>' : '';
                    $items_2 .= '</li>';
                }
            }
            /** HTML FORMAT (LEVEL 1)**/
            $data_item = frontend_model_catalog::set_data_item($row_1,$id_current);
            if ($data_item['current'] != 'false') {
                $current_item = ' class="'.$class_current.'"';
            }else {
                $current_item = null;
            }
            $items .= '<li'.$current_item.'>';
            $items .= '<a href="'.$data_item['uri'].'" title="'. $data_item['name'].'">';
            $items .= $data_item['name'];
            $items .= '</a>';
            $items .=  ($items_2 != null) ? '<ul class="subnav-list">'.$items_2.'</ul>' : '';
            $items .= '</li>';
        }

        // OUTPUT
        // ***********
        if ($items != null) {
            $output .= isset($params['title']) ? $params['title'] : null;
            $output .= '<ul'.$id_container.$class_container.'>';
            $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items;
            $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
            $output .= '</ul>';
        }
    }
    return $output;
}