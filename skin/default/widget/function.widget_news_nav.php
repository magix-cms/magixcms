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
        //Récupération variables localisation
    $lang_iso           = frontend_model_template::current_Language();
    $current_tag_name   =   ($_GET['tag']) ? magixcjquery_form_helpersforms::inputClean($_GET['tag']) : null;
        //Récupération langue courante
    $data = s_tag_all($lang_iso);
    $output = null;

    if ($data != null){
            // ***HTML attributs var
        if ($params['htmlAttribut']){
            $htmlAttr = $params['htmlAttribut'];
            $id_container       =       isset($htmlAttr['id_container'])       ? ' id="'.$htmlAttr['id_container'].'"'      : null;
            $class_container    =       isset($htmlAttr['class_container'])    ? ' class="'.$htmlAttr['class_container'].'"'   : null;
            $class_current      =       isset($htmlAttr['class_current'])      ? $htmlAttr['class_current']    : 'current';
        }
            // ***HTML injection var
        $title = isset($params['title']) ? $params['title'] : null;

            // ***tanslation var
        $tr_show_news = frontend_model_template::getConfigVars('show_news');

        /*** FORMATTING ***/
        /**********************/
        $items = null;
        foreach($data as $row){
            /** DATA (parent pages)**/
            $current_item = ($row['name_tag'] == $current_tag_name) ? $class_current : null;
            $uri_item = magixglobal_model_rewrite::filter_news_tag_url($row['iso'],urlencode($row['name_tag']),true);
            $name_item = $row['name_tag'];
            $class_item = ($current_item != null) ? ' class="'.$current_item.'"' : null;

            $item =  '<li'.$class_item.'>';
            $item .= '<a href="'.$uri_item.'" title="'.$tr_show_news .': '.$name_item.'">';
            $item .= $name_item;
            $item .= '</a>';
            $item .= '</li>';
            $items .= $item;

        }

        $output  = isset($title) ? $title : null;
        $output .= '<ul'.$id_container.$class_container.'>';
            $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items;
            $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
        $output .= '</ul>';
    }
    return $output;
}
/**
 * Return all tag in language grouped by name and related to published news
 * @param string $lang_iso
 * @return array
 */
function s_tag_all($lang_iso){
    $sql = 'SELECT tag.name_tag, lang.iso
            FROM mc_news_tag AS tag
            LEFT JOIN mc_news AS news ON (news.idnews = tag.idnews)
            LEFT JOIN mc_lang AS lang ON (lang.idlang = news.idlang)
            WHERE lang.iso = :lang_iso AND news.published = 1
            GROUP BY tag.name_tag';
    return magixglobal_model_db::layerDB()->select($sql,array(
        ':lang_iso'=> $lang_iso
    ));
}
