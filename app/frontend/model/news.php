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
    public function set_data_item($row,$id_current){
        $data_item = null;
        $imagePath = new magixglobal_model_imagepath();
        $dateFormat = new magixglobal_model_dateformat();
        if (isset($row['idnews'])){
            // Tag list
            $data_item['tag'] = null;
            $tag['data'] = frontend_db_block_news::s_news_tag($row['idnews']);
            if (is_array($tag['data'])){
                foreach ($tag['data'] as $t){
                    $t['uri'] = magixglobal_model_rewrite::filter_news_tag_url($row['iso'],$t['name_tag'],true);
                    $data_item['tag'] .= '<a href="'.$t['uri'].'" title="'.$t['name_tag'].'">'.$t['name_tag'].'</a> ';
                }
            }
            // img
            if (isset($row['n_image']) != null){
                // $img_size = (isset($row['img_size'])) ? $row['img_size'] : null; => need core enhancement
                $data_item['img_src']   = $imagePath->filterPathImg(array('filtermod'=>'news','img'=>'s_'.$row['n_image']));
            }else{
                $data_item['img_src']   = $imagePath->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/news/news-default.png'));
            }
            /** data to Array**/
            $data_item['id']        = $row['idnews'];
            $data_item['name']      = $row['n_title'];
            $data_item['uri']       = magixglobal_model_rewrite::filter_news_url($row['iso'],$dateFormat->date_europeen_format($row['date_publish']),$row['n_uri'],$row['keynews'],true);
            $data_item['current']   = ($row['idnews'] == $id_current['news']) ? 'true' : 'false';
            $data_item['date']      = $dateFormat->SQLDate($row['date_publish']);
            $data_item['descr']     = $row['n_content'];
        }
        return $data_item;
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
                        }elseif (($k == 'current' AND $sk == 'class') OR ($k == 'descr' AND ($sk == 'lenght' OR $sk == 'delemiter')) OR ($sk == 'htmlBefore') OR ($sk == 'htmlAfter') ) {
                            // si aucune valeur pour mon niveau mais que je suis des valeurs d'héritage => récupére la valeur de premier niveaux
                            $htmlItem[$k][$sk] = $sv;
                        }else{
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
     * @param array $sort_config
     * @param array $id_current
     * @return array|null
     *
     */
    public function set_sql_data($sort_config,$id_current){
        if(!(is_array($sort_config)))
            exit;

        $controller = new frontend_controller_news();
        $model      = new frontend_model_news();
        // default values: data_sort
        $data_sort['tag'] = $id_current['tag']; // sot tags (string)
        $data_sort['type'] = null; // sort type (string)
        $data_sort['limit'] = 10;
        $data_sort['offset'] = $model->set_pagination_offset($data_sort['limit'],$id_current['pagination']);
        $lang =  frontend_model_template::current_Language();

        // custom values: data_sort
        if (isset($sort_config['select'])){
            if( $sort_config['select'] == 'current'){
                if ($id_current['tag'] != null){
                    $data_sort['tag'] = $id_current['tag'];
                    $data_sort['type'] = 'collection';
                }
            } elseif( is_array($sort_config['select'])){
                if (array_key_exists($lang,$sort_config['select'])){
                    $data_sort['tag'] = $sort_config['select'][$lang];
                    $data_sort['type'] = 'collection';
                }
            }
        }elseif(isset($sort_config['exclude'])){
            if( is_array($sort_config['exclude'])){
                if (array_key_exists($lang,$sort_config['exclude'])){
                    $data_sort['tag'] = $sort_config['exclude'][$lang];
                    $data_sort['type'] = 'exclude';
                }
            }
        }
        if ($sort_config['limit']) {
            $data_sort['limit'] = $sort_config['limit'];
            $data_sort['offset'] = $model->set_pagination_offset($data_sort['limit'],$id_current['pagination']);
        }
        if (isset($sort_config['level'])){
            if ( $sort_config['level'] == 'last-news')  {  $level = 'last-news';}
        }
        // *** set sql data
        if ($data_sort['tag'] != null){
            $data = parent::s_news_in_tag($lang,$data_sort['tag'],$data_sort['type'],$data_sort['limit']);
        }elseif ($level == 'last-news'){
            $data = parent::s_news($lang,true,$data_sort['limit'],0);
        }else {
            $data = parent::s_news($lang,true,$data_sort['limit'],$data_sort['offset']);
            $data['total'] = parent::s_news_lang_total($lang);
            $data['total'] = $data['total']['total']; // @TODO revoir autre function pour acepté numerice en place de array
            $data['limit'] = $data_sort['limit'];
        }
        return $data;
    }

}
?>