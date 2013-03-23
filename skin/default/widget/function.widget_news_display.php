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
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package     Smarty
 * @subpackage  plugins
 * Type:        function
 * Name:        widget_news_display
 * date:        25/12/2013
 * Update:      10/03/2013
 * Examples:    {widget_news_display}
 * @author      Sire Sam (sire-sam.be)
 * @link        htt://www.sire-sam.be, http://www.magix-dev.be
 * @author      Gerits Aurelien
 * @version     1.1
 * @param       array
 * @param       Smarty
 * @return      string
 */
function smarty_function_widget_news_display($params, $template)
{
    $ModelSystem        =   new magixglobal_model_system();
    $ModelRewrite       =   new magixglobal_model_rewrite();
    $ModelConstructor   =   new magixglobal_model_constructor();
    $ModelNews          =   new frontend_model_news();
    $ModelPager         =   new magixglobal_model_pager();
    $Debug              =   new magixcjquery_debug_magixfire();

    // Set and load data
    $current    =   $ModelSystem->setCurrentId();
    $conf       =   (is_array($params['conf'])) ? $params['conf'] : array();
    $data       =   $ModelNews->getData($conf,$current);

    // Set Pagination
    $pagination['html'] =   null;
    if (isset($data['total']) AND isset($data['limit'])) {
        $pagination['src']  =
            $ModelPager->setPaginationData(
                $data['total'],
                $data['limit'],
                '/'.$current['lang']['iso'].$ModelRewrite->mod_news_lang($current['lang']['iso']),
                $current['news']['pagination']['id'],
                '/'
            );
        $pagination['html']     =
            $ModelConstructor->formatPaginationHtml(
                $pagination['src'],
                $current['news']['pagination']['id']
            );
        unset($data['total']);
        unset($data['limit']);
    }

    // Format data
    $html = null;
    if ($data != null) {
        $pattern['default']     =   patternNews();
        $pattern['custom']      =   null;
        if ($params['pattern']) {
            $pattern['custom']  =
                (is_array($params['pattern']))
                    ? $params['pattern']
                    : patternNews($params['pattern'])
            ;
        }
        $pattern['global']  =   $ModelConstructor->mergeHtmlPattern($pattern['default'],$pattern['custom']);

        $i = 0;
        $items['html'] = null;
        foreach ($data as $row)
        {
            $i++;
            $item['data']   =   $ModelNews->setItemData($row,$current);

                // *** set item html structure & var
                $pattern['global']['is_current']    =   ($item['data']['current'] == 'true') ? 1 : 0;
                $pattern['global']['id']            =   (isset($item['data']['id'])) ? $item['data']['id'] : 0;
                $pattern['global']['url']           =   (isset($item['data']['uri'])) ? $item['data']['uri'] : '#';
                $pattern['item']                    =   $ModelConstructor->setItemPattern($pattern['global'],$i);

                // *** Reset iteration if item is last of the line
                if ($pattern['item']['is_last'] == 1){
                    $i = 0;
                }

                // *** in case diplay is null, we take default value
                if ($pattern['item']['display'][1] == null)
                    $pattern['item']['display'][1] = $pattern['default']['display'][1];


                // *** format item loop (foreach element)
                $item['html'] = null;
                foreach ($pattern['item']['display'][1] as $elem_type )
                {
                    $pattern['elem'] = $pattern['item'][$elem_type ];
                    if(array_search($elem_type,$pattern['item']['display'][1])){
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
                                        $pattern['item']['descr']['lenght'],
                                        $pattern['item']['descr']['delemiter']
                                    );
                                break;
                            case 'date':
                                $elem = $ModelConstructor->formatDateHtml($item['data']['date'],$pattern['item']);
                                break;
                            case 'tag':
                                $elem = $item['data']['tag'];
                                break;
                            default:
                                $elem = null;
                        }

                        if ($elem != null
                            OR isset($pattern['elem']['before'])
                            OR isset($pattern['elem']['after'])
                        ) {
                            $item['html']   .= $pattern['elem']['before'];
                            $item['html']   .= $elem;
                            $item['html']   .= $pattern['elem']['after'];
                        }
                    }

                }
                // *** item construct
                $items['html'] .= $pattern['item']['item']['before'];
                    $items['html'] .= $item['html'];
                $items['html'] .= $pattern['item']['item']['after'];
            }
        // *** container construct
        $html  = isset($params['title']) ? $params['title'] : '';
        $html .= $pattern['global']['container']['before'];
        $html .= isset($params['prepend']) ? $params['prepend'] : null;
        $html .=  $items['html'];
        $html .= isset($params['append']) ? $params['append'] : null;
        $html .= $pattern['global']['container']['after'];
        $html .=  $pagination['html'];
    }
	return $html;
}

function patternNews ($name=null)
{
    $ModelTemplate  =   new frontend_model_template();
    $tr =   array(
        'show_news' => $ModelTemplate->getConfigVars('show_news_page')
    );

    switch ($name) {
        case 'sidebar':
            $pattern    =   array(
                'container'     =>  array(
                    'before'    =>  '<ul class="thumbnails">',
                    // items injected here
                    'after'     =>  '</ul>'
                ),
                'item'          =>  array(
                    'before'    => '<li class="span3"><a href="#url#" title="'.$tr['show_news'].'" class="thumbnail">',
                    // item's elements injected here (name, img, descr, ...)
                    'after'     => '</a></li>'
                ),
                'img'           =>  array(
                    'before'
                    => ' ',
                    'after'
                    =>  ' '
                ),
                'date'          =>  array(
                    'before'    => '<span class="date badge">',
                    'format'        =>  array(
                        'day'   => 'd/',
                        'month'   => 'm/',
                        'year'   => 'Y'
                    ),
                    // item's elements injected here (name, img, descr)
                    'after'     => '</span><br />'
                ),
                'name'          =>  array(
                    'before'
                    =>  ' ',
                    'after'
                    =>  ' '
                ),
                'tag'           =>  array(
                    'before'    => '<span class="tag">',
                    // item's elements injected here (name, img, descr)
                    'after'     => '<span>'
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
                    'before'    =>  '<ul class="thumbnails">',
                    // items injected here
                    'after'     =>  '</ul>'
                ),
                'item'          =>  array(
                    'before'    => '<li class="span4"><div class="thumbnail">',
                    // item's elements injected here (name, img, descr, ...)
                    'after'     => '</div></div></li>'
                ),
                'img'           =>  array(
                    'before'
                    => ' ',
                    'after'
                    =>  ' '
                ),
                'name'          =>  array(
                    'before'
                    =>  '<div class="caption">
                            <h3>
                                <a href="#url#" title="'.$tr['show_news'].'">',
                    'after'
                            =>  '</a>
                            </h3>'
                ),
                'descr'         =>  array(
                    'before'    =>  '<p>',
                    'lenght'        =>  250,
                    'delemiter'     =>  '...',
                    'after'     =>  '</p>'
                ),
                'pagination'    =>  array(
                    'before'    => '<div>',
                    'class'         => 'pagination',
                    'after'     => '</div>'
                ),
                'date'          =>  array(
                    'before'    => '<span class="date badge badge-info pull-right">',
                    'format'        =>  array(
                        'day'   => 'd/',
                        'month'   => 'm/',
                        'year'   => 'Y'
                    ),
                    // item's elements injected here (name, img, descr)
                    'after'     => '</span>'
                ),
                'tag'           =>  array(
                    'before'    => '<span class="tag">',
                    // item's elements injected here (name, img, descr)
                    'after'     => '<span>'
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