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
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_news_display}
 * function plugin
 *
 * Type:     function
 * Name:     widget_news_display
 * Update:   December  25, 2012
 * Update:   December  29, 2012
 * Purpose:  
 * Examples: {widget_news_display}
 * Output:   
 * @link
 * @author   Gerits Aurelien
 * @author   Sire Sam (sire-sam.be)
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @TODO formatage de la date suivant valeur passée en paramètre (valeur à définir)
 */
function smarty_function_widget_news_display($params, $template){

    // ***Catch $_GET var
    $id_current['tag']     = (isset($_GET['tag'])) ? $_GET['tag'] : null;
    $id_current['news']    = (isset($_GET['getnews'])) ? $_GET['getnews'] : null;

    // *** load SQL DATA
    $sort_config = (is_array($params['dataSelect'])) ? $params['dataSelect'] : array();
    $data = frontend_model_news::set_sql_data($sort_config,$id_current);

    // *** set pagination
    $pagination = null;
    if (isset($data['pagination'])){
        $pagination = $data['pagination'];
        unset($data['pagination']);
    }

    // FORMAT DATA
    // ***********
    $output = null;
    if ($data != null){
        // *** Default html Structure
        $strucHtml_default = array(
            'container'     =>  array(
                'htmlBefore'    =>  '<ul class="thumbnails">',
                    // items injected here
                'htmlAfter'     =>  '</ul>'
            ),
            'item'          =>  array(
                'htmlBefore'    => '<li class="span4"><div class="thumbnail">',
                   // item's elements injected here (name, img, descr, ...)
                'htmlAfter'     => '</div></div></li>'
            ),
            'img'           =>  array(
                'classLink'     =>  'img'
            ),
            'name'          =>  array(
                'htmlBefore'    =>  '<div class="caption"> <h3>',
                'classLink'     =>  'name',
                'htmlAfter'     =>  '</h3>'
            ),
            'descr'         =>  array(
                'htmlBefore'    =>  '<p>',
                'lenght'        =>  250,
                'delemiter'     =>  '...',
                'htmlAfter'     =>  '</p>'
            ),
            'pagination'    =>  array(
                'htmlBefore'    => '<div>',
                'class'         => 'pagination',
                'htmlAfter'     => '</div>'
            ),
            'date'          =>  array(
                'htmlBefore'    => '',
                    // item's elements injected here (name, img, descr)
                'htmlAfter'     => ''
            ),
            'tag'           =>  array(
                'htmlBefore'    => '',
                    // item's elements injected here (name, img, descr)
                'htmlAfter'     => ''
            ),
            'current'       =>  array(
                'class'         =>  ' current'
            ),
            'last'          =>  array(
                'class'         => ' last',
                'col'           => 1
            )
        );

        // *** Default item setting
        $strucHtml_default['allow']     = array('','img', 'name', 'descr', 'date', 'tag');
        $strucHtml_default['display']   = array( 1 => array('','name', 'img', 'descr', 'date', 'tag'));

        // *** Update html struct & item setting with custom var (params['structureHTML'])
        $structHtml_custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
        $strucHtml = frontend_model_news::set_html_struct($strucHtml_default,$structHtml_custom);

        // *** Format setting
        $items = null;
        $i = 0;

        // *** boucle / loop
            // *** list format START
            // ***************************
            foreach($data as $row){
                $i++;

                // Construit doonées de l'item en array avec clée nominative unifiée ('name' => 'monname,'descr' => '<p>ma descr</p>,...)
                $item_dataVal  = frontend_model_news::set_data_item($row,$id_current);

                // Configuration de la structure HTML de l'item
                $strucHtml['is_current'] = ($item_dataVal['current'] == 'true') ? 1 : 0;
                $strucHtml['id'] = (isset($item_dataVal['id'])) ? $item_dataVal['id'] : 0;
                $strucHtml['url'] = (isset($item_dataVal['uri'])) ? $item_dataVal['uri'] : '#';
                $strucHtml_item = frontend_model_news::set_html_struct_item($strucHtml,$i);

                // remise à zero du compteur si élément est le dernier de la ligne
                if ($strucHtml_item['is_last'] == 1){
                    $i = 0;
                }

                // Si affichage null, récupération affichage par default
                if ($strucHtml_item['display'][1] == null)
                    $strucHtml_item['display'][1] = $strucHtml_default['display'][1];

                $item = null;

                foreach ($strucHtml_item['display'][1] as $elem_type ){
                    // loop format elements in item
                    $strucHtml_elem = $strucHtml_item[$elem_type ];
                    if(array_search($elem_type,$strucHtml_item['display'][1])){
                        // Config class link
                        $item_classLink = null;
                        if(isset($strucHtml_elem['classLink'])){
                            $item_classLink = ' class="'.$strucHtml_elem['classLink'].'"';
                            $item_classLink = ($strucHtml_elem['classLink'] == 'none') ? 'none' : $item_classLink;
                        }
                        // Format element on switch
                        switch($elem_type){
                            case 'name':
                                $elem = '<a'.$item_classLink.' href="'.$item_dataVal['uri'].'" title="'. $item_dataVal['name'].'">';
                                $elem .= $item_dataVal['name'];
                                $elem .= '</a>';
                                break;
                            case 'img':
                                $elem = '<a'.$item_classLink.' href="'.$item_dataVal['uri'].'" title="'. $item_dataVal['name'].'">';
                                $elem .= '<img src="'.$item_dataVal['img_src'].'" alt="'.$item_dataVal['name'].'"/>';
                                $elem .= '</a>';
                                break;
                            case 'descr':
                                $elem = magixcjquery_form_helpersforms::inputCleanTruncate( magixcjquery_form_helpersforms::inputTagClean($item_dataVal['descr']), $strucHtml_item['descr']['lenght'] , $strucHtml_item['descr']['delemiter']);
                                break;
                            case 'date':
                                $elem = $item_dataVal['date'];
                                break;
                            case 'tag':
                                $elem = $item_dataVal['tag'];
                                break;
                            default:
                                $elem = null;
                        }
                        if ($elem != null){
                            $item .= $strucHtml_elem['htmlBefore'];
                            $item .= $elem;
                            $item .= $strucHtml_elem['htmlAfter'];
                        }
                    }

                }
                $items .= $strucHtml_item['item']['htmlBefore'];
                $items .= $item;
                $items .= $strucHtml_item['item']['htmlAfter'];
            }
        // *** list format END
        if($pagination != null) {
            // *** Format pagination
            $pagination_ouput  = $strucHtml['pagination']['htmlBefore'];
            $pagination_ouput .= $pagination;
            $pagination_ouput .= $strucHtml['pagination']['htmlAfter'];
        }

        // OUTPUT
        // ***********
        $output .= $strucHtml['container']['htmlBefore'];
        $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
        $output .=  $items;
        $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
        $output .= $strucHtml['container']['htmlAfter'];
        $output .=  $pagination_ouput;
    }
	return $output;
}