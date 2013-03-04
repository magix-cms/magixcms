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
     * @param $id_current
     * @return array|null
     */
    public function setItemData($row,$id_current)
    {
        $ModelImagepath     =   new magixglobal_model_imagepath();
        $ModelDateformat    =   new magixglobal_model_dateformat();
        $ModelTemplate      =   new frontend_model_template();
        $ModelRewrite       =   new magixglobal_model_rewrite();

        $data   =   null;
        if (isset($row['idnews'])) {
            $data['tag']    =   null;
            $tag['data']    =   frontend_db_block_news::s_news_tag($row['idnews']);

            if (is_array($tag['data'])) {
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

                }
            }
            if (isset($row['n_image']) != null){
                $data['img_src']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'filtermod'=>'news',
                            'img'=>'s_'.$row['n_image']
                        )
                    );
            }else{
                $data['img_src']   = $ModelImagepath->filterPathImg(
                    array(
                        'img'=>
                            'skin/'.
                            $ModelTemplate->frontendTheme()->themeSelected().
                            '/img/news/news-default.png')
                );
            }

            $data['id']        = $row['idnews'];
            $data['name']      = $row['n_title'];
            $data['uri']       =
                $ModelRewrite->filter_news_url(
                    $row['iso'],
                    $ModelDateformat->date_europeen_format(
                        $row['date_publish']
                    ),
                    $row['n_uri'],
                    $row['keynews'],
                    true
                );
            $data['current']   = ($row['idnews'] == $id_current['news']) ? 'true' : 'false';
            $data['date']      = $ModelDateformat->SQLDate($row['date_publish']);
            $data['descr']     = $row['n_content'];
        }
        return $data;
    }
    /**
     * Construction du tableau contenant la structure html globale (tous niveaux)
     * @params array $default
     * @params array $custom
     */
    public function set_html_struct($default,$custom){
        // *** Merge default and custom structure
        if (is_array($custom)){
            $default['display'] = array();
            foreach($custom AS $k => $v){
                foreach($v AS $sk => $sv){
                    if ($sv != null){
                        $default[$k][$sk] = $sv;
                    }
                }
                if (array_search($k,$default['allow']))
                    $default['display'][1][] = $k;
            }
        }
        // *** push null value on case[0] (allow array search on format function)
        foreach($default['display'] AS $k => $v){
            array_unshift($default['display'],null);
        }
        return $default;
    }
    /**
     * Formatage des variables pour la structure html
     * @params array $htmlStruct
     * @params numeric $i
     */
    public function set_html_struct_item($htmlStruct,$i){
        $htmlItem = null;
        $class_position = null;

        // Gestion de l'élément last
        $htmlStruct['is_last'] = 0;
        if (is_numeric($htmlStruct['last']['col'])) {
            if (is_int($htmlStruct['last']['col']/ $i) AND ($i != 1 AND $htmlStruct['last']['col'] != 1)){
                $htmlStruct['is_last'] = 1;
            }
        }
        if (is_array($htmlStruct)){
            foreach($htmlStruct AS $k => $v){
                // $k == 'container', 'img', 'items', 'descr', 'current' 'name',...
                if (is_array($v)){
                    foreach($v AS $sk => $sv){
                        // $sk == Item Structure values Key ==  htmlAfter,htamlBefore,class,...
                        // $sk == Item Structure values
                        if (isset($htmlStruct[$k][$sk])){
                            if($sk == 'htmlBefore'){
                                if ($htmlStruct['is_last'] == 1){
                                    $class_position .= ' '.$htmlStruct['last']['class'];
                                }
                                if ($htmlStruct['is_current'] == 1){
                                    $class_position .= ' '.$htmlStruct['current']['class'];
                                }
                                if ($class_position != null)
                                    $class_position_attr = ' class="'.$class_position.'"';
                                else
                                    $class_position_attr = null;

                                $htmlItem[$k][$sk] = str_replace('|#current-last#|',$class_position,$htmlStruct[$k][$sk]);
                                $htmlItem[$k][$sk] = str_replace('|#class-current-last#|',$class_position_attr,$htmlStruct[$k][$sk]);
                                $htmlItem[$k][$sk] = str_replace('|#id#|',$htmlStruct['id'],$htmlItem[$k][$sk]);
                                $htmlItem[$k][$sk] = str_replace('|#url#|',$htmlStruct['url'],$htmlItem[$k][$sk]);
                                $class_position = null;
                            }else{
                                $htmlItem[$k][$sk] = $htmlStruct[$k][$sk];
                            }
                        } elseif (($k == 'current' AND $sk == 'class') OR ($k == 'descr' AND ($sk == 'lenght' OR $sk == 'delemiter')) OR ($sk == 'htmlBefore') OR ($sk == 'htmlAfter') ) {
                            // si aucune valeur pour mon niveau mais que je suis des valeurs d'héritage => récupére la valeur de premier niveaux
                            $htmlItem[$k][$sk] = $sv;
                        } else {
                            // si aucune valeur pour mon niveau
                            $htmlItem[$k][$sk] = null;
                        }
                    }
                }
            }
        }
        return $htmlItem;
    }
    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param numeric $limit
     * @param numeric $current
     * @return numerice
     */
    public function set_pagination_offset($limit,$current){
        $pagination = new magixcjquery_pager_pagination();
        return $pagination->pageOffset($limit,$current);
    }

    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param array $conf
     * @param array $active
     * @return array|null
     */
    public function setDataSql($conf,$active)
    {
        if (!(is_array($conf)))
            return null;

        if (!(array_key_exists('news',$active)))
            return null;

        $ModelNews      =   new frontend_model_news();

        $data['conf']   =   array(
            'id'       =>  $active['news']['tag']['id'],
            'type'      =>  null,
            'limit'     =>  10,
            'offset'    =>  $ModelNews->set_pagination_offset(10,$active['news']['pagination']['id']),
            'lang'      =>  $active['lang']['iso'],
            'level'     =>  'all'
        );

        if (isset($conf['select'])) {
            if( $conf['select'] == 'current') {
                if ($active['tag']['id'] != null) {
                    $data['conf']['id']     =   $active['news']['tag']['id'];
                    $data['conf']['type']   =   'collection';

                }
            } elseif (is_array($conf['select'])) {
                if (array_key_exists($active['lang']['iso'],$conf['select'])) {
                    $data['conf']['id']     =   $conf['select'][$active['lang']['iso']];
                    $data['conf']['type']   =   'collection';

                }
            }
        } elseif(isset($conf['exclude'])) {
            if (is_array($conf['exclude'])) {
                if (array_key_exists($active['lang']['iso'],$conf['exclude'])) {
                    $data['conf']['id']     =   $conf['exclude'][$active['lang']['iso']];
                    $data['conf']['type']   =   'exclude';

                }
            }
        }

        if ($conf['limit']) {
            $data['conf']['limit']          =   $conf['limit'];
            $data['conf']['offset']          =   $ModelNews->set_pagination_offset(
                $data['conf']['limit'],
                $active['news']['pagination']['id']
            );
        }

        if (isset($conf['level'])) {
            if ( $conf['level'] == 'last-news')  {
                $data['conf']['level']  = 'last-news';
            }
        }

        // *** set sql data
        if ($data['conf']['level'] == 'last-news') {
            $data['src'] = parent::s_news(
                $data['conf']['lang'],
                true,
                $data['conf']['limit'],
                0
            );
        } elseif ($data['conf']['id'] != null) {
            $data['src'] = parent::s_news_in_tag(
                $data['conf']['lang'],
                $data['conf']['id'],
                $data['conf']['type'],
                $data['conf']['limit']
            );

        }else {
            $data['src'] = parent::s_news(
                $data['conf']['lang'],
                true,
                $data['conf']['limit'],
                $data['conf']['offset']
            );
            $data['src']['total'] = array_shift(parent::s_news_lang_total($data['conf']['lang']));
            $data['src']['limit'] = $data['conf']['limit'];

        }
        return $data['src'];
    }
}
?>