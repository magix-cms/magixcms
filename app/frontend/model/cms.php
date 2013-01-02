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
class frontend_model_cms extends frontend_db_cms {

    /**
     * Formate les valeurs principales d'un élément suivant la ligne passées en paramètre
     * @param $row
     * @param $id_current
     * @return array|null
     */
    public function set_data_item($row,$id_current){
        $data_item = null;
        if ($row != null){
            $data_item['id']        = $row['idpage'];
            $data_item['name']      = $row['title_page'];
            $data_item['uri']       = ($row['idcat_p'] != 0) ? magixglobal_model_rewrite::filter_cms_url($row['iso'], $row['idcat_p'], $row['uri_page_p'], $row['idpage'], $row['uri_page'],true) : magixglobal_model_rewrite::filter_cms_url($row['iso'], NULL, NULL, $row['idpage'], $row['uri_page'],true);
            if ($row['idpage'] == $id_current['page']){
                $data_item['current']   = ($id_current['page_p'] != null) ? 'parent' : 'true';
            }else {
                $data_item['current']   = 'false';
            }
            $data_item['descr']     = $row['content_page'];
            return $data_item;
        }
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
            array_unshift($default['display'][$k],null);
        }
        return $default;
    }
    /**
     * Construction du tableau contenant la structure html pour un élément donné
     * @params array $htmlStruct
     * @params numeric $o
     * @params numeric $i
    @TODO-maintenance => remplacer le nom de variable $order/$o, par $deep
     */
    public function set_html_struct_item($htmlStruct,$order,$i){
        $htmlItem = null;
        $o = ($order != 1) ?'_'.$order : null; // level order
        $class_position = null;
        $class_position_att = null;

        // Gestion de l'élément last
        $htmlStruct['is_last'] = 0;
        if (is_numeric($htmlStruct['last']['col'.$o])) {
            if (is_int($htmlStruct['last']['col'.$o]/ $i) AND ($i != 1 AND $htmlStruct['last']['col'] != 1)){
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
                        // @TODO some issues with str_replace
                        if (isset($htmlStruct[$k][$sk.$o])){
                            if($sk == 'htmlBefore'){
                                if ($htmlStruct['is_last'] == 1){
                                    $class_position .= ' '.$htmlStruct['last']['class'.$o];
                                }
                                if ($htmlStruct['is_current'] == 1){
                                    $class_position .= ' '.$htmlStruct['current']['class'.$o];
                                }
                                if ($class_position != null)
                                    $class_position_attr = ' class="'.$class_position.'"';
                                $htmlItem[$k][$sk] = str_replace('|#current-last#|',$class_position,$htmlStruct[$k][$sk.$o]);
                                $htmlItem[$k][$sk] = str_replace('|#class-current-last#|',$class_position_attr,$htmlStruct[$k][$sk.$o]);
                                $htmlItem[$k][$sk] = str_replace('|#id#|',$htmlStruct['id'],$htmlItem[$k][$sk]);
                                $htmlItem[$k][$sk] = str_replace('|#url#|',$htmlStruct['url'],$htmlItem[$k][$sk]);
                                $class_position = null;
                            }else{
                                $htmlItem[$k][$sk] = $htmlStruct[$k][$sk.$o];
                            }
                        }elseif (($k == 'current' AND $sk == 'class') OR ($k == 'descr' AND ($sk == 'lenght' OR $sk == 'delemiter')) OR ($sk == 'htmlBefore') OR ($sk == 'htmlAfter') ) {
                            // si aucune valeur pour mon niveaux mais que je suis des valeurs d'héritage => récupére la valeur de premier niveaux
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
     * @param array $sort_config
     * @param array $id_current
     * @return array|null
     *
     */
    public static function set_sql_data($sort_config,$id_current){
        if(!(is_array($sort_config)))
            exit;

        // default values: data_sort
        $data_sort['id']    =   null;
        $data_sort['type']  =   null;
        $data_sort['limit'] =   null;
        $lang               =   frontend_model_template::current_Language();

        // default values: level
        $level[1] = 'parent';
        // custom values: data_sort
        if ( isset($sort_config['select']) ){
            if( $sort_config['select'] == 'current'){
                if ($_SERVER['SCRIPT_NAME'] == '/cms.php'){
                    $data_sort['id'] = $id_current['page_p'] != null ? $id_current['page_p'] : $id_current['page'];
                }
            }elseif( is_array($sort_config['select']) ){
                if (array_key_exists($lang,$sort_config['select'])){
                    $data_sort['id'] = $sort_config['select'][$lang];
                }
            }
        }elseif(isset($sort_config['exclude'])){
            if( is_array($sort_config['exclude'])){
                if (array_key_exists($lang,$sort_config['exclude'])){
                    $data_sort['id'] = $sort_config['exclude'][$lang];
                    $data_sort['type'] = 'exclude';
                }
            }
        }

        // custom values: display
        if (isset($sort_config['level'])){
            if ( is_array($sort_config['level'])){
                foreach($sort_config['level'] as $k => $v){
                    $level[1] = $k;
                    if (is_array($v)) {
                        foreach($v as $k2 => $v2){
                            $level[2] = $k2;
                            $level[3] = $v2;
                        }
                    }else{
                        $level[2] = $v;
                    }
                }
            }else{
                if ( $sort_config['level'] == 'all') {  $level[1] = 'parent'; $level[2] = 'child'; }
                if ( $sort_config['level'] == 'parent') {  $level[1] = 'parent'; }
                if ( $sort_config['level'] == 'child')  {  $level[1] = 'child';  }
            }
        }

        // *** Load SQL data
        if ($level[1] == 'parent'){
            $data = parent::s_page($lang,$data_sort['id'],$data_sort['type'],$data_sort['limit']);
            if($data != null AND $level[2] == 'child')
            {
                foreach ($data as $k1 => $v1){
                     $data_2 = parent::s_page_child($lang,$v1['idpage']);
                     if ($data_2 != null)
                         $data[$k1]['subdata'] = $data_2;
                 }
                $data_2 = null;
            }
        }elseif ($level[1] == 'child'){
            $data = parent::s_page_child($lang,$data_sort['id'],$data_sort['type'],$data_sort['limit']);
        }
        return $data;
    }


}
?>