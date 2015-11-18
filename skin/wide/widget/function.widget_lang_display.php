<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
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
 * Smarty {widget_lang_display} function plugin
 *
 * Type:     function
 * Name:     widget_lang_display
 * Date:     03/01/2013
 * Date Update : 12/01/2013
 * Output:
 * @author   Sire Sam (http://www.sire-sam.be)
 * @author   Gerits Aurélien (http://www.magix-dev.be)
 * @link
 * @version  1.0
 * @param $params
 * @param $template
 * @return string
 */

function smarty_function_widget_lang_display($params, $template){

    $ModelConstructor   =   new magixglobal_model_constructor();

    // *** Catch location var
    $iso_current     =       magixcjquery_filter_request::isGet('strLangue');

    // *** Load SQL DATA
    $data = frontend_db_lang::s_fetch_lang();

    $output = null;
    if ($data != null){
        // *** set default html structure
        $strucHtml_default = array(
            'container'     =>  array(
                'before'    => '<ul class="nav">',
                // items injected here
                'after'     => '</ul>'
            ),
            'item'          =>  array(
                'before'    => '<li>',
                // item's elements injected here (name, img, descr)
                'after'     => '</li>'
            ),
            'icon'         =>  array(
                'before'    =>  ' ',
                'after'     =>  ' '
            ),
            'name'        =>  array(
                'before'    =>  ' ',
                'after'     =>  ' '
            ),
            'iso'       =>  array(
                'before'    => '(',
                'after'     => ')'
            ),
            'current'     =>  array(
                'class'         =>  ' current'
            ),
            'last'        =>  array(
                'class'         => ' last',
                'col'           =>  1
            )
        );

    // *** Set default elem to display
    $strucHtml_default['allow']     = array('', 'icon', 'name', 'iso');
    $strucHtml_default['display']   = array(
        1 =>    array('', 'icon', 'name', 'iso')
    );

    // *** Update html struct & item setting with custom var (params['structureHTML']) @TODO vérifier si le paramaètre htmlDispaly tj opérationnel
    $structHtml_custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
    $strucHtml = $ModelConstructor->mergeHtmlPattern($strucHtml_default,$structHtml_custom);

    // *** Set translation var
    $t_go_to_version = frontend_model_template::getConfigVars('go_to_version');

    // *** format items loop (foreach item)
    $items = null;
    $i = 0;
    foreach($data as $row){
        $i++;

        // *** set additional var in htmlStruct
        $strucHtml['is_current'] = ($iso_current == $row['iso']) ? 1 : 0;
        $strucHtml['is_last'] = 0;
        if ($i == $strucHtml['last']['col']){
            $strucHtml['is_last'] = 1;
            $i = 0;
        }

        // *** in case diplay is null, we take default value
        if ($strucHtml['display'][1] == null)
            $strucHtml['display'][1] = $strucHtml_default['display'][1];

        // *** set link class
        $item_classLink = null;
        if($strucHtml['is_last'] == 1 OR $strucHtml['is_current'] == 1){
            $item_class = ' class="';
            $item_class .= ($strucHtml['is_last'] == 1) ? $strucHtml['last']['class'] : '';
            $item_class .= ($strucHtml['is_current'] == 1) ? $strucHtml['current']['class'] : '';
            $item_class .= '"';
        }

        // *** format item loop (foreach element)
        $item = null;
        foreach ($strucHtml['display'][1] as $elem_type ){
            $strucHtml_elem = $strucHtml[$elem_type ];
            if(array_search($elem_type,$strucHtml['display'][1])) {
                switch($elem_type){
                    case 'name':
                        $elem = ucfirst($row['language']);
                        break;
                    case 'icon':
                        $elem = '<img src="/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/lang/'.$row['iso'].'.png" alt="'.$row['name'].'"/>';
                        break;
                    case 'iso':
                        $elem = $row['iso'];
                        break;
                    default:
                        $elem = null;
                }
                // *** elem construct
                if ($elem != null){
                    $item .= $strucHtml_elem['before'];
                    $item .= $elem;
                    $item .= $strucHtml_elem['after'];
                }
            }
        }
        // *** item construct
        $items .= $strucHtml['item']['before'];
            $items .= '<a href="/'.$row['iso'].'/" hreflang="'.$row['iso'].'" title="'.ucfirst($t_go_to_version).': '.$row['language'].'">';
                $items .= $item;
            $items .= '</a>';
        $items .= $strucHtml['item']['after'];
    }
    // *** container construct
    $output .= $strucHtml['container']['before'];
        $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
            $output .=  $items;
        $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
    $output .= $strucHtml['container']['after'];
    }
    return $output;
}
?>