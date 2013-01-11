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
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_product_gallery} function plugin
 *
 * Type:     function
 * Name:     microgalery
 * Date:     January 11 2013
 * Date:     January 11 2013
 * Purpose:  
 * Output:
 * @author   Gerits Aurelien
 * @author   Sire Sam (sire-sam.be)
 * @link http://www.magix-cms.com
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_widget_product_gallery($params, $template){

    // ***Catch $_GET var
    if(isset($_GET['idproduct']))
        $id_current['product'] = $_GET['idproduct'];
    else
        return null;

    // *** load SQL DATA
//    $data = frontend_db_block_catalog::s_identifier_catalog($id_current['product']);;
//      $data = frontend_db_block_catalog::s_microgalery_product($identifier['idcatalog']);
    $sort_config = array('level' => 'product-gallery');
    $data = frontend_model_catalog::set_sql_data($sort_config,$id_current);

    $output = null;
    if ($data != null) {
        // *** Default html Structure
        $strucHtml_default = array(
            'container'     =>  array(
                'htmlBefore'    =>  '<ul class="thumbnails">',
                // items injected here
                'htmlAfter'     =>  '</ul>'
            ),
            'item'          =>  array(
                'htmlBefore'    => '<li class="span2">',
                // item's elements injected here (name, img, descr, ...)
                'htmlAfter'     => '</li>'
            ),
            'img'           =>  array(
                'classLink'     =>  'thumbnail gallery-link'
            ),
            'last'          =>  array(
                'class'         => ' last',
                'col'           => 1
            )
        );

        // *** Default item setting
        $strucHtml_default['allow']     = array('','img');
        $strucHtml_default['display']   = array( 1 => array('','img'));

        // *** Update html struct & item setting with custom var (params['structureHTML'])
        $structHtml_custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
        $strucHtml = frontend_model_catalog::set_html_struct($strucHtml_default,$structHtml_custom);

        // *** Format setting
        $items = null;
        $i = 0;

        // *** loop for list format
        foreach ($data as $row) {
            $i++;

            // *** Construit donées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
            $item_dataVal  = frontend_model_catalog::set_data_item($row,$id_current);

            // Configuration de la structure HTML de l'item
            $strucHtml_item = frontend_model_news::set_html_struct_item($strucHtml,$i);

            if ($strucHtml_item['img']['classLink'] != '')
                $strucHtml_item['img']['classLink'] = ' class="'.$strucHtml['img']['classLink'].'"';

            // remise à zero du compteur si élément est le dernier de la ligne
            if ($strucHtml_item['is_last'] == 1){
                $i = 0;
            }

            $items .= $strucHtml_item['item']['htmlBefore'];
            $items .= '<a href="'.$item_dataVal['img_src']['maxi'].'" rel="product-gallery" title="Agrandir"'.$strucHtml_item['img']['classLink'].'>';
                $items .= '<img src="'.$item_dataVal['img_src']['mini'].'" alt="Gallerie" />';
            $items .= '</a>';
            $items .= $strucHtml_item['item']['htmlAfter'];
        }
    }

    // *** ouput
    $output .= $strucHtml['container']['htmlBefore'];
    $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
    $output .=  $items;
    $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
    $output .= $strucHtml['container']['htmlAfter'];

   return $output;
}