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
 * Update:     March 20 2014
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
function smarty_function_widget_product_gallery($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelCatalog       =   new frontend_model_catalog();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   array('context' => 'product-gallery');
    $data       =   $ModelCatalog->getData($conf,$current);

    $html = null;
    if ($data != null) {
        $pattern['default']     =   patternMicroGallery();
        $pattern['custom']      =   null;
        if ($params['pattern']) {
            $pattern['custom']  =
                (is_array($params['pattern']))
                    ? $params['pattern']
                    : patternMicroGallery($params['pattern'])
            ;
        }
        $pattern['global'] = $ModelConstructor->mergeHtmlPattern($pattern['default'],$pattern['custom']);
        magixcjquery_debug_magixfire::magixFireTable('pattern',$pattern);
        magixcjquery_debug_magixfire::magixFireTable('pattern global',$pattern['global']);

        $i = 0;
        $items['html'] = null;
        foreach ($data as $row)
        {
            $i++;
            // *** Construit donées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
            $item['data']  = $ModelCatalog->setItemData($row,$current);

            // Configuration de la structure HTML de l'item
            $pattern['item'] = $ModelConstructor->setItemPattern($pattern['global'],$i);

            if ($pattern['item']['img']['classLink'] != '')
                $pattern['item']['img']['classLink'] = ' class="'.$pattern['item']['img']['classLink'].'"';

            // remise à zero du compteur si élément est le dernier de la ligne
            if ($pattern['item']['is_last'] == 1){
                $i = 0;
            }

            $items['html'] .= $pattern['item']['item']['before'];
            $items['html'] .= '<a href="'.$item['data']['imgSrc']['medium'].'" rel="productGallery" title="Agrandir"'.$pattern['item']['img']['classLink'].'>';
                $items['html'] .= '<img src="'.$item['data']['imgSrc']['small'].'" alt="Galery" />';
            $items['html'] .= '</a>';
            $items['html'] .= $pattern['item']['item']['after'];
        }
    }

    // *** ouput
    if ($items['html'] != null) {
        $html  = isset($params['title']) ? $params['title'] : '';
        $html .= $pattern['global']['container']['before'];
        $html .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
        $html .=  $items['html'];
        $html .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
        $html .= $pattern['global']['container']['after'];
    }

   return $html;
}
function patternMicroGallery ($name=null)
{
    switch ($name) {
        default:
            $pattern = array(
                'container'     =>  array(
                    'before'    =>  '<div class="thumbnails">',
                    // items injected here
                    'after'     =>  '</div>'
                ),
                'item'          =>  array(
                    'before'    => '<div class="thumbnail col-xs-6 col-md-6">',
                    // item's elements injected here (name, img, descr, ...)
                    'after'     => '</div>'
                ),
                'img'           =>  array(
                    'classLink'     =>  'img-gallery'
                ),
                'last'          =>  array(
                    'class'         => ' last',
                    'col'           => 1
                ),
                'allow'      =>  array(
                    '',
                    'img'

                ),
                'display'   =>  array(
                    1 =>    array('img')
                )
            );
    }
    return $pattern;
}
