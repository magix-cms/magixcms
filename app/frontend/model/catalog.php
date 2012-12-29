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
 * Time: 15:03
 * License: Dual licensed under the MIT or GPL Version
 */
class frontend_model_catalog extends frontend_db_catalog {
    /**
     * Formate les valeurs principales d'un élément suivant la ligne passées en paramètre
     * @param $row
     * @param $id_current
     * @return array|null
     */
    public function set_data_item($row,$id_current){
        $data_item = null;
        $filter_img = new magixglobal_model_imagepath;
        if ($row != null){
            if (isset($row['titlecatalog'])){
                /** PRODUCT
                 * Catch Casual Data **/
                $scat_id                = (isset($row['idcls'])) ? $row['idcls'] : null;
                $scat_libelle           = (isset($row['pathslibelle'])) ? $row['pathslibelle'] : null;
                /** data to Array**/
                $data_item['id']        = $row['idproduct'];
                $data_item['name']      = $row['titlecatalog'];
                $data_item['uri']       = magixglobal_model_rewrite::filter_catalog_product_url($row['iso'],$row['pathclibelle'],$row['idclc'],$scat_libelle,$scat_id,$row['urlcatalog'],$row['idproduct'],true);
                $data_item['current']   = ($row['idproduct'] == $id_current['product']) ? 'true' : 'false';
                $data_item['price']     = $row['price'];
                $data_item['descr']     = $row['desccatalog'];
                if (isset($row['imgcatalog']) != null){
                    $img_size = (isset($row['img_size'])) ? $row['img_size'] : null;
                    $data_item['img_src']   = $filter_img->filterPathImg(array('filtermod'=>'catalog','img'=>$img_size.'/'.$row['imgcatalog'],'levelmod'=>'product'));
                }else{
                    $data_item['img_src']   = $filter_img->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/product-default.png'));
                }
            }elseif(isset($row['slibelle'])){
                /** SUBCATEGORY
                 * data to Array**/
                $data_item['id']        = $row['idcls'];
                $data_item['name']      = $row['slibelle'];
                $data_item['uri']       = magixglobal_model_rewrite::filter_catalog_subcategory_url($row['iso'],$row['pathclibelle'],$row['idclc'],$row['pathslibelle'],$row['idcls'],true);
                if ($row['idcls'] == $id_current['subcategory']){
                    $data_item['current']   = ($id_current['product'] != null) ? 'parent' : 'true';
                }else {
                    $data_item['current']   = 'false';
                }
                $data_item['descr']     = ($row['s_content'] != '') ? $row['s_content'] : null;
                if (isset($row['img_s']) != null){
                    $data_item['img_src']   = $filter_img->filterPathImg(array('filtermod'=>'catalog','img'=>$row['img_s'],'levelmod'=>'subcategory'));
                }else{
                    $data_item['img_src']   = $filter_img->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/subcategory-default.png'));
                }
            }elseif(isset($row['clibelle'])){
                /** CATEGORY
                 * data to Array**/
                $data_item['id']        = $row['idclc'];
                $data_item['name']      = $row['clibelle'];
                $data_item['uri']       = magixglobal_model_rewrite::filter_catalog_category_url($row['iso'],$row['pathclibelle'],$row['idclc'],true);
                if ($row['idclc'] == $id_current['category']){
                    if ($id_current['product'] != null OR $id_current['subcategory'] != null){
                        $data_item['current']   = 'parent';
                    }else{
                        $data_item['current']   = 'true';
                    }
                }else {
                    $data_item['current']   = 'false';
                }
                $data_item['descr']     = ($row['c_content'] != '') ? $row['c_content'] : null;
                if (isset($row['img_c']) != null){
                    $data_item['img_src']   = $filter_img->filterPathImg(array('filtermod'=>'catalog','img'=>$row['img_c'],'levelmod'=>'category'));
                }else{
                    $data_item['img_src']   = $filter_img->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/category-default.png'));
                }            }
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
        $data_sort['id'] = null;
        $data_sort['type'] = null;
        $data_sort['limit'] = null;
        $lang =  frontend_model_template::current_Language();

        // default values: display
        if ($id_current['subcategory'] != null) {
            $level[1] = 'product';
        }elseif ($id_current['category'] != null){
            $level[1] = 'subcategory';
        }else{
            $level[1] = 'category';
        }

        // custom values: data_sort
        if (isset($sort_config['select'])){
            if( $sort_config['select'] == 'current'){
                if ($id_current['subcategory'] != null){
                    $data_sort['id'] = $id_current['subcategory'];
                    $data_sort['type'] = 'collection';
                }elseif ($id_current['category'] != null){
                    $data_sort['id'] = $id_current['category'];
                    $data_sort['type'] = 'collection';
                }
            } elseif( is_array($sort_config['select'])){
                if (array_key_exists($lang,$sort_config['select'])){
                    $data_sort['id'] = $sort_config['select'][$lang];
                    $data_sort['type'] = 'collection';
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
        if ($sort_config['limit']) {
            $data_sort['limit'] = $sort_config['limit'];
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
                if ( $sort_config['level'] == 'category') {  $level[1] = 'category';}
                if ( $sort_config['level'] == 'subcategory')  {  $level[1] = 'subcategory';}
                if ( $sort_config['level'] == 'product')  {  $level[1] = 'product';}
                if ( $sort_config['level'] == 'last-product')  {  $level[1] = 'last-product';}
                if ( $sort_config['level'] == 'all')  {  $level[1] = 'all';}
            }
        }

        // SET SQL DATA
        // *************
        $data = null;
        if ( $level[1] == 'category' OR $level[1] == 'all' ){
            $data = parent::s_category($lang,$data_sort['id'],$data_sort['type'],$data_sort['limit']);
            if (($level[2] == 'subcategory' OR $level[1] == 'all') AND $data != null){
                foreach($data as $k1 => $v_1){
                    $data_2 = parent::s_sub_category_in_cat($v_1['idclc'],$data_sort['limit']);
                    if($data_2 != null){
                        $data[$k1]['subdata'] = $data_2;
                        if (($level[3] == 'product' OR $level[1] == 'all') AND $data_2 != null){
                            $data_3 = null;
                            foreach($data_2 as $k2 => $v_2){
                                $data_3 = parent::s_product($v_2['idclc'],$v_2['idcls'],$data_sort['limit']);
                                if ($data_3 != null){
                                    $data[$k1]['subdata'][$k2]['subdata'] = $data_3;
                                }
                            }
                        }
                    }
                }
            }elseif($level[2] == 'product' AND $data != null){
                foreach($data as $k1 => $v_1){
                    $data_2 = parent::s_product($v_1['idclc'],null,$data_sort['limit']);
                    if($data_2 != null){
                        $data[$k1]['subdata'] = $data_2;
                    }
                }
            }
        }elseif ( $level[1] == 'subcategory'){
            if($sort_config['select'] == 'current' AND $id_current['subcategory'] != null){
                $data_sort['id'] = $id_current['subcategory'];
                $data = parent::s_subcategory($lang,$data_sort['id'],$data_sort['type'],$data_sort['limit']);
            }elseif($id_current['category'] != null AND empty($sort_config['select'])){
                $data_sort['id'] = $id_current['category'];
                $data = parent::s_sub_category_in_cat($data_sort['id'],$data_sort['limit']);
            }else{
                $data = parent::s_subcategory($lang,$data_sort['id'],$data_sort['type'],$data_sort['limit']);
            }

            if($level[2] == 'product' AND $data != null){
                foreach($data as $k1 => $v_1){
                    $data_2 = parent::s_product($v_1['idclc'],$v_1['idcls'],$data_sort['limit']);
                    if($data_2 != null){
                        $data[$k1]['subdata'] = $data_2;
                    }
                }
            }
        }elseif ( $level[1] == 'product'){
            if( $id_current['product'] != null){
                // Sélections des produits relationels
                // Tris sur les id_categorie des produit liés (select exclude)
                $data = parent::s_product_in_product($id_current['product'],$data_sort['id'],$data_sort['type']);
            }elseif( $id_current['category'] != null OR $id_current['subcategory'] != null){
                $data = parent::s_product($id_current['category'],$id_current['subcategory']);
            }
        }elseif ($level[1] == 'last-product'){
            $data = parent::s_product(null,null,$data_sort['limit']);
        }
        return $data;
    }
}
?>