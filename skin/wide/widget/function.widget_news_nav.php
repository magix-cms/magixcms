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
 * Smarty {widget_news_nav}
 * function plugin
 *
 * Type:     function
 * Name:     widget news nav
 * Date:     September 26, 2012
 * Update:   December  29, 2012
 * Purpose:  
 * Examples:

    {widget_news_nav}

    {widget_news_nav
        htmlAttribut=[
            'id_container' => 'secondary-nav',
            'class_container' => 'v-nav'
        ]
        title='<p class="title">Actualités par thèmes</p>'
    }

 * Output: string (<ul><li><a>tag_name<///)
 * @link
 * @author   Gerits Aurelien
 * @author   Samuel Lesre
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_nav($params, $template){

    $ModelNews          =   new frontend_model_news();
    $ModelSystem        =   new magixglobal_model_system();

    // *** Load SQL DATA
    $current    =   $ModelSystem->setCurrentId();
    $conf   =   array(
            'level' =>  'tag',
            'limit' =>  null
    );
    $data = $ModelNews->getData($conf,$current);
    $current    =   $current['news'];

    $output = null;
    if ($data != null) {
        // *** set default html attributs
        if ($params['htmlAttribut']) {
            $htmlAttr = $params['htmlAttribut'];
            $id_container       =       isset($htmlAttr['id_container'])       ? ' id="'.$htmlAttr['id_container'].'"'      : null;
            $class_container    =       isset($htmlAttr['class_container'])    ? ' class="'.$htmlAttr['class_container'].'"'   : null;
            $class_current      =       isset($htmlAttr['class_current'])      ? $htmlAttr['class_current']    : 'current';
        }

        // *** Set translation var
        $tr_show_news = frontend_model_template::getConfigVars('show_news');

        // *** format items loop (foreach item)
        $items = null;
        foreach($data as $row){
            $current_item = ($row['name_tag'] == $current['tag']['id']) ? $class_current : null;
            $uri_item = magixglobal_model_rewrite::filter_news_tag_url($row['iso'],urlencode($row['name_tag']),true);
            $name_item = $row['name_tag'];
            $class_item = ($current_item != null) ? ' class="'.$current_item.'"' : null;

            // *** item construct
            $item =  '<li'.$class_item.'>';
            $item .= '<a href="'.$uri_item.'" title="'.$tr_show_news .': '.$name_item.'">';
            $item .= $name_item;
            $item .= '</a>';
            $item .= '</li>';
            $items .= $item;

        }

        // *** container construct
        $output  = isset($params['title']) ? $params['title'] : '';
        $output .= '<ul'.$id_container.$class_container.'>';
            $output .= isset($params['prepend']) ? $params['prepend'] : null;
            $output .=  $items;
            $output .= isset($params['append']) ? $params['append'] : null;
        $output .= '</ul>';
    }
    return $output;
}