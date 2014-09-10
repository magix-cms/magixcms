<?php
/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of MAGIX CMS.
# MAGIX CMS, The content management system optimized for users
# Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * @author Sire Sam <samuel.lesire@gmail.com>
 * Copyright: MAGIX CMS
 * Date: 29/12/12
 * Time: 15:04
 * License: Dual licensed under the MIT or GPL Version
 */
class frontend_model_news extends frontend_db_news {
    /**
     * Formate les valeurs principales d'un élément suivant la ligne passées en paramètre
     * @param $row
     * @param $current
     * @param bool $newrow
     * @return array|null
     */
    public function setItemData($row,$current,$newrow = false)
    {
        $ModelImagepath     =   new magixglobal_model_imagepath();
        $ModelDateformat    =   new magixglobal_model_dateformat();
        $ModelTemplate      =   new frontend_model_template();
        $ModelRewrite       =   new magixglobal_model_rewrite();

        $data   =   null;
        if (isset($row['idnews'])) {
            $data['tag']    =   null;
            $tag['data']    =   parent::s_tagByNews($row['idnews']);

            if (is_array($tag['data'])) {
                $data['tagData'] = array();
                foreach ($tag['data'] as $t){
                    $t['uri'] =
                        $ModelRewrite->filter_news_tag_url(
                            $row['iso'],
                            $t['name_tag'],
                            true
                        );
                    $data['tag']    .=  '<a href="'.$t['uri'].'" title="'.$t['name_tag'].'">';
                    $data['tag']    .=  $t['name_tag'];
                    $data['tag']    .=  '</a> ';
                    $data['tagData'][]  =  array(
                        'id' =>  $t['name_tag'],
                        'name'=> $t['name_tag'],
                        'iso' => $row['iso'],
                        'url'   =>  $t['uri']
                    );

                }
            }

            if (isset($row['n_image'])){
                $data['imgSrc']   =   array(
                    'small' =>
                        $ModelImagepath->filterPathImg(
                            array (
                                'filtermod'=>'news',
                                'img'=> 's_'.$row['n_image']
                            )
                        ),
                    'medium' =>
                    $ModelImagepath->filterPathImg(
                        array (
                            'filtermod'=>'news',
                            'img'=> $row['n_image']
                        )
                    )
                );
            }
            $data['imgSrc']['default']   = $ModelImagepath->filterPathImg(
                array(
                    'img'=>
                    'skin/'.
                        $ModelTemplate->frontendTheme()->themeSelected().
                        '/img/news/news-default.png')
            );

            $data['id']        = $row['idnews'];
            $data['name']      = $row['n_title'];
            $data['uri']       =
                $ModelRewrite->filter_news_url(
                    $row['iso'],
                    $ModelDateformat->date_europeen_format(
                        $row['date_register']
                    ),
                    $row['n_uri'],
                    $row['keynews'],
                    true
                );
            $data['current']    =   false;
            if (isset($current['record']['id'])) {
                $data['active']   = ($row['keynews'] == $current['record']['id']) ? true : false;
            }
            $data['date']['register']      = $ModelDateformat->SQLDate($row['date_register']);
            $data['date']['publish']       = $ModelDateformat->SQLDate($row['date_publish']);
            $data['content']     = $row['n_content'];
            // Plugin
            if($newrow != false){
                if(is_array($newrow)){
                    foreach($newrow as $key => $value){
                        $data[$key] = $row[$value];
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param array $custom
     * @param array $current
     * @param bool $class
     * @return array|null
     */
    public function getData($custom,$current,$class = false)
    {
        if (!(is_array($custom)))
            return null;

        if (!(array_key_exists('news',$current)))
            return null;

        $ModelPager      =   new magixglobal_model_pager();

        // set default values for query
        $data['conf']   =   array(
            'id'       =>  $current['news']['tag']['id'],
            'type'      =>  null,
            'limit'     =>  10,
            'offset'    =>  $ModelPager->setPaginationOffset(10,$current['news']['pagination']['id']),
            'lang'      =>  $current['lang']['iso'],
            'level'     =>  'all'
        );
        $current = $current['news'];

        // set data selection conf
        if (isset($custom['select'])) {
            if( $custom['select'] == 'current') {
                if ($current['tag']['id'] != null) {
                    $data['conf']['id']     =   $current['tag']['id'];
                    $data['conf']['type']   =   'collection';

                }
            } elseif (is_array($custom['select'])) {
                if (array_key_exists($data['conf']['lang'],$custom['select'])) {
                    $data['conf']['id']     =   $custom['select'][$data['conf']['lang']];
                    $data['conf']['type']   =   'collection';

                }
            }
        } elseif(isset($custom['exclude'])) {
            if (is_array($custom['exclude'])) {
                if (array_key_exists($data['conf']['lang'],$custom['exclude'])) {
                    $data['conf']['id']     =   $custom['exclude'][$data['conf']['lang']];
                    $data['conf']['type']   =   'exclude';
                }
            }
        }
        // set number of line to return (with pagination)
        if (isset($custom['limit'])) {
            $data['conf']['limit']          =   $custom['limit'];
            $data['conf']['offset']          =   $ModelPager->setPaginationOffset(
                $data['conf']['limit'],
                $current['pagination']['id']
            );
        }
        // set kind of data
        if (isset($custom['level'])) {
            switch ($custom['level']) {
                case 'last-news':
                    $data['conf']['level']  = 'last-news';
                    break;
                case 'tag':
                    $data['conf']['level']  = 'tag';
                    break;
            }
        }
        // Plugin
        if (isset($custom['plugins'])) {
            $data['plugins']  =   $custom['plugins'];
        }
        // *** Run - load data
        if ($data['conf']['level'] == 'last-news') {
            if (isset($data['conf']['type'])) {
                if($class && class_exists($class)){
                    $data['src'] = $class::s_news_in_tag(
                        $data['conf']['lang'],
                        $data['conf']['id'],
                        $data['conf']['type'],
                        $data['conf']['limit']
                    );
                }else{
                    $data['src'] = parent::s_news_in_tag(
                        $data['conf']['lang'],
                        $data['conf']['id'],
                        $data['conf']['type'],
                        $data['conf']['limit']
                    );
                }

            } else {
                if($class && class_exists($class)){
                    $data['src'] = $class::s_news(
                        $data['conf']['lang'],
                        $data['conf']['limit'],
                        0,
                        null
                    );
                }else{
                    $data['src'] = parent::s_news(
                        $data['conf']['lang'],
                        $data['conf']['limit'],
                        0,
                        null
                    );
                }
            }
        } elseif ($data['conf']['level'] == 'tag') {
            if($class && class_exists($class)){
                $data['src'] = $class::s_tag_all(
                    $data['conf']['lang']
                );
            }else{
                $data['src'] = parent::s_tag_all(
                    $data['conf']['lang']
                );
            }
        } elseif (isset($data['conf']['id'])) {
            if($class && class_exists($class)){
                $data['src'] = $class::s_news_in_tag(
                    $data['conf']['lang'],
                    $data['conf']['id'],
                    $data['conf']['type'],
                    $data['conf']['limit']
                );
            }else{
                $data['src'] = parent::s_news_in_tag(
                    $data['conf']['lang'],
                    $data['conf']['id'],
                    $data['conf']['type'],
                    $data['conf']['limit']
                );
            }
        }else {
            if($class && class_exists($class)){
                $data['src'] = $class::s_news(
                    $data['conf']['lang'],
                    $data['conf']['limit'],
                    $data['conf']['offset']
                );
                $data['src']['total'] = array_shift($class::s_news_lang_total($data['conf']['lang']));
            }else{
                $data['src'] = parent::s_news(
                    $data['conf']['lang'],
                    $data['conf']['limit'],
                    $data['conf']['offset']
                );
                $data['src']['total'] = array_shift(parent::s_news_lang_total($data['conf']['lang']));
            }

            $data['src']['limit'] = $data['conf']['limit'];

        }
        return $data['src'];
    }
}
?>