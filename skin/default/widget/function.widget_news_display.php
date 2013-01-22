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
 * Update:   January   17, 2013
 * Purpose:  
 * Examples: {widget_news_display}
 * Output:   
 * @link
 * @author   Gerits Aurelien
 * @author   Sire Sam (sire-sam.be)
 * @version  1.0.1
 * @param array
 * @param Smarty
 * @return string
 * @TODO formatage de la date suivant valeur passée en paramètre (valeurs à définir)
 */
function smarty_function_widget_news_display($params, $template){

    // *** Catch location var
    $id_current['tag']          = (isset($_GET['tag']))     ? $_GET['tag']          : null;
    $id_current['news']         = (isset($_GET['getnews'])) ? $_GET['getnews']      : null;
    $id_current['pagination']   = (isset($_GET['page']))   ? intval($_GET['page'])  : 1;
    $id_current['lang']         = frontend_model_template::current_Language();

    // *** Load SQL data
    $sort_config = (is_array($params['dataSelect'])) ? $params['dataSelect'] : array();
    $data = frontend_model_news::set_sql_data($sort_config,$id_current);

    // *** Set pagination
    $dataPager = null;
    if (isset($data['total']) AND isset($data['limit'])) {
        $lib_rewrite        = new magixglobal_model_rewrite();
        $basePath = '/'.$id_current['lang'].$lib_rewrite->mod_news_lang($id_current['lang']);
        $dataPager = frontend_model_news::set_pagination_data($data['total'],$data['limit'],$basePath,$id_current['pagination'],'/');
        $pagination = null;
        if ($dataPager != null) {
            $pagination = '<div class="pagination">';
                $pagination .= '<ul>';
                foreach ($dataPager as $row) {
                    switch ($row['name']){
                        case 'first':
                            $name = '<<';
                            break;
                        case 'previous':
                            $name = '<';
                            break;
                        case 'next':
                            $name = '>';
                            break;
                        case 'last':
                            $name = '>>';
                            break;
                        default:
                            $name = $row['name'];
                    }
                    $classItem = ($name == $id_current['pagination']) ? ' class="active"' : null;
                    $pagination .= '<li'.$classItem.'>';
                        $pagination .= '<a href="'.$row['url'].'" title="'.$name.'" >';
                            $pagination .= $name;
                        $pagination .= '</a>';
                    $pagination .= '</li>';
                }
                $pagination .= '</ul>';
            $pagination .= '</div>';
        }
        unset($data['total']);
        unset($data['limit']);
    }

    $output = null;
    if ($data != null){
        // *** set default html structure
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

        // *** Set default elem to display
        $strucHtml_default['allow']     = array('','img', 'name', 'descr', 'date', 'tag');
        $strucHtml_default['display']   = array( 1 => array('','name', 'img', 'descr', 'date', 'tag'));

        // *** Update html struct & item setting with custom var (params['structureHTML'])
        $structHtml_custom = ($params['htmlStructure']) ? $params['htmlStructure'] : null;
        $strucHtml = frontend_model_news::set_html_struct($strucHtml_default,$structHtml_custom);

        // *** format items loop (foreach item)
        // ** Loop management var
        $items = null;
        $i = 0;
            foreach($data as $row){
                $i++;

                // ** Set items data (with specific key)
                $item_dataVal  = frontend_model_news::set_data_item($row,$id_current);

                // *** set item html structure & var
                $strucHtml['is_current'] = ($item_dataVal['current'] == 'true') ? 1 : 0;
                $strucHtml['id'] = (isset($item_dataVal['id'])) ? $item_dataVal['id'] : 0;
                $strucHtml['url'] = (isset($item_dataVal['uri'])) ? $item_dataVal['uri'] : '#';
                $strucHtml_item = frontend_model_news::set_html_struct_item($strucHtml,$i);

                // *** Reset iteration if item is last on the line
                if ($strucHtml_item['is_last'] == 1){
                    $i = 0;
                }

                // *** in case diplay is null, we take default value
                if ($strucHtml_item['display'][1] == null)
                    $strucHtml_item['display'][1] = $strucHtml_default['display'][1];

                // *** format item loop (foreach element)
                $item = null;
                foreach ($strucHtml_item['display'][1] as $elem_type ){
                    $strucHtml_elem = $strucHtml_item[$elem_type ];
                    if(array_search($elem_type,$strucHtml_item['display'][1])){
                        // *** set link class
                        $item_classLink = null;
                        if(isset($strucHtml_elem['classLink'])){
                            $item_classLink = ' class="'.$strucHtml_elem['classLink'].'"';
                            $item_classLink = ($strucHtml_elem['classLink'] == 'none') ? 'none' : $item_classLink;
                        }
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
                        // *** elem construct
                        if ($elem != null){
                            $item .= $strucHtml_elem['htmlBefore'];
                            $item .= $elem;
                            $item .= $strucHtml_elem['htmlAfter'];
                        }
                    }

                }
                // *** item construct
                $items .= $strucHtml_item['item']['htmlBefore'];
                $items .= $item;
                $items .= $strucHtml_item['item']['htmlAfter'];
            }
        // *** container construct
        $output .= $strucHtml['container']['htmlBefore'];
                $output .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
                    $output .=  $items;
                $output .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
            $output .= $strucHtml['container']['htmlAfter'];
        $output .=  $pagination;
    }
	return $output;
}