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
function smarty_function_widget_news_display($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelRewrite       =   new magixglobal_model_rewrite();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelNews          =   new frontend_model_news();
    $ModelPager         =   new magixglobal_model_pager();
    $Debug              =   new magixcjquery_debug_magixfire();

    $active             =   $ModelSystem->setActiveId();
    $data['conf']       =   (is_array($params['dataSelect'])) ? $params['dataSelect'] : array();
    $data['src']        =   $ModelNews->setDataSql($data['conf'],$active);

    // Set Pagination
    $pagination['html'] =   null;
    if ($data['src']['total'] AND $data['src']['limit']) {
        $pagination['src']  =
            $ModelPager->set_pagination_data(
                $data['src']['total'],
                $data['src']['limit'],
                '/'.$active['lang']['iso'].$ModelRewrite->mod_news_lang($active['lang']['iso']),
                $active['news']['pagination']['id'],
                '/'
            );
        $pagination['html']     =
            $ModelConstructor->formatPaginationHtml(
                $pagination['src'],
                $active['news']['pagination']['id']
            );
        unset($data['src']['total']);
        unset($data['src']['limit']);
    }

    $output['html'] = null;
    if ($data['src'] != null) {
        $htmlPattern['default']     =   newsPatternSelect();
        $htmlPattern['custom']      =   null;

        if ($params['htmlStructure']) {
            $htmlPattern['custom']  =
                (is_array($params['htmlStructure']))
                    ? $params['htmlStructure']
                    : newsPatternSelect($params['htmlStructure'])
            ;
        }
        $htmlPattern['global']  =   $ModelConstructor->mergeHtmlPattern($htmlPattern['default'],$htmlPattern['custom']);

        $i = 0;
        $items['html'] = null;
        foreach ($data['src'] as $row)
        {
            $i++;
            $item['data']   =   $ModelNews->setItemData($row,$active);

                // *** set item html structure & var
                $htmlPattern['global']['is_current']    =   ($item['data']['current'] == 'true') ? 1 : 0;
                $htmlPattern['global']['id']            =   (isset($item['data']['id'])) ? $item['data']['id'] : 0;
                $htmlPattern['global']['url']           =   (isset($item['data']['uri'])) ? $item['data']['uri'] : '#';
                $htmlPattern['item']                    =   $ModelConstructor->setItemPattern($htmlPattern['global'],$i);

                // *** Reset iteration if item is last of the line
                if ($htmlPattern['item']['is_last'] == 1){
                    $i = 0;
                }

                // *** in case diplay is null, we take default value
                if ($htmlPattern['item']['display'][1] == null)
                    $htmlPattern['item']['display'][1] = $htmlPattern['default']['display'][1];


                // *** format item loop (foreach element)
                $item['html'] = null;
                foreach ($htmlPattern['item']['display'][1] as $elem_type )
                {
                    $htmlPattern['elem'] = $htmlPattern['item'][$elem_type ];
                    if(array_search($elem_type,$htmlPattern['item']['display'][1])){
                        switch($elem_type){
                            case 'name':
                                $elem = $item['data']['name'];
                                break;
                            case 'img':
                                $elem = '<img src="'.$item['data']['img_src'].'" alt="'.$item['data']['name'].'"/>';
                                break;
                            case 'descr':
                                $elem =
                                    magixcjquery_form_helpersforms::inputCleanTruncate(
                                        magixcjquery_form_helpersforms::inputTagClean(
                                            $item['data']['descr']
                                        ),
                                        $htmlPattern['item']['descr']['lenght'],
                                        $htmlPattern['item']['descr']['delemiter']
                                    );
                                break;
                            case 'date':
                                $elem = $ModelConstructor->formatDateHtml($item['data']['date'],$htmlPattern['item']);
                                break;
                            case 'tag':
                                $elem = $item['data']['tag'];
                                break;
                            default:
                                $elem = null;
                        }

//                        if ($elem != null){
                            $item['html']   .= $htmlPattern['elem']['htmlBefore'];
                            $item['html']   .= $elem;
                            $item['html']   .= $htmlPattern['elem']['htmlAfter'];
//                        }
                    }

                }
                // *** item construct
                $items['html'] .= $htmlPattern['item']['item']['htmlBefore'];
                    $items['html'] .= $item['html'];
                $items['html'] .= $htmlPattern['item']['item']['htmlAfter'];
            }
        // *** container construct
        $output['html'] .= $htmlPattern['global']['container']['htmlBefore'];
        $output['html'] .= isset($params['htmlPrepend']) ? $params['htmlPrepend'] : null;
        $output['html'] .=  $items['html'];
        $output['html'] .= isset($params['htmlAppend']) ? $params['htmlAppend'] : null;
        $output['html'] .= $htmlPattern['global']['container']['htmlAfter'];
        $output['html'] .=  $pagination['html'];
    }
	return $output['html'];
}

function newsPatternSelect($name=null) {
    $ModelTemplate  =   new frontend_model_template();
    $tr =   array(
        'show_news' => $ModelTemplate->getConfigVars('show_news_page')
    );

    switch ($name) {
        case 'sidebar':
            $pattern    =   array(
                'container'     =>  array(
                    'htmlBefore'    =>  '<ul class="thumbnails">',
                    // items injected here
                    'htmlAfter'     =>  '</ul>'
                ),
                'item'          =>  array(
                    'htmlBefore'    => '<li class="span3"><a href="#url#" title="'.$tr['show_news'].'" class="thumbnail">',
                    // item's elements injected here (name, img, descr, ...)
                    'htmlAfter'     => '</a></li>'
                ),
                'img'           =>  array(
                    'htmlBefore'
                    => ' ',
                    'htmlAfter'
                    =>  ' '
                ),
                'date'          =>  array(
                    'htmlBefore'    => '<span class="date badge">',
                    'format'        =>  array(
                        'day'   => 'd/',
                        'month'   => 'm/',
                        'year'   => 'Y'
                    ),
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '</span><br />'
                ),
                'name'          =>  array(
                    'htmlBefore'
                    =>  ' ',
                    'htmlAfter'
                    =>  ' '
                ),
                'tag'           =>  array(
                    'htmlBefore'    => '<span class="tag">',
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '<span>'
                ),
                'display'       =>  array(
                    1           => array(
                        'date',
                        'img',
                        'name'
                    )
                )
            );
            break;
        default:
            $pattern    =   array(
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
                    'htmlBefore'
                    => ' ',
                    'htmlAfter'
                    =>  ' '
                ),
                'name'          =>  array(
                    'htmlBefore'
                    =>  '<div class="caption">
                            <h3>
                                <a href="#url#" title="'.$tr['show_news'].'">',
                    'htmlAfter'
                            =>  '</a>
                            </h3>'
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
                    'htmlBefore'    => '<span class="date badge badge-info pull-right">',
                    'format'        =>  array(
                        'day'   => 'd/',
                        'month'   => 'm/',
                        'year'   => 'Y'
                    ),
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '</span>'
                ),
                'tag'           =>  array(
                    'htmlBefore'    => '<span class="tag">',
                    // item's elements injected here (name, img, descr)
                    'htmlAfter'     => '<span>'
                ),
                'current'       =>  array(
                    'class'         =>  ' current'
                ),
                'last'          =>  array(
                    'class'         => ' last',
                    'col'           => 1
                ),
                'display'       =>  array(
                    1           => array(
                        'img',
                        'name',
                        'date',
                        'descr',
                        'tag'
                    )
                ),
                'allow' => array(
                    '' ,
                    'img' ,
                    'name' ,
                    'descr' ,
                    'date' ,
                    'tag'
                )
            );
    }
    return $pattern;
}