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
     * @param $current
     * @return array|null
     * @todo revoir le nommage de 'current', lui préférant 'active'
     */
    public function setItemData ($row,$current)
    {
        $ModelImagepath     =   new magixglobal_model_imagepath();
        $ModelTemplate      =   new frontend_model_template();
        $ModelRewrite       =   new magixglobal_model_rewrite();

        $data = null;
        if ($row != null) {

            // *** Product
            if (isset($row['titlecatalog'])) {
                $subcat['id']   = (isset($row['idcls'])) ? $row['idcls'] : null;
                $subcat['name'] = (isset($row['pathslibelle'])) ? $row['pathslibelle'] : null;

                $data['img_src']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'img'=>'skin/'.
                                $ModelTemplate->frontendTheme()->themeSelected().
                                '/img/catalog/product-default.png'
                        )
                    );
                if (isset($row['imgcatalog']) != null){
                    $img_size = (isset($row['img_size'])) ? $row['img_size'] : 'product';
                    $data['img_src']   =
                        $ModelImagepath->filterPathImg(
                            array(
                                'filtermod' =>  'catalog',
                                'img'       =>  $img_size.'/'.$row['imgcatalog'],
                                'levelmod'  =>  ''
                            )
                        );
                }

                $data['url']       =
                    $ModelRewrite->filter_catalog_product_url(
                        $row['iso'],
                        $row['pathclibelle'],
                        $row['idclc'],
                        $subcat['name'],
                        $subcat['id'],
                        $row['urlcatalog'],
                        $row['idproduct'],
                        true
                    );

                $data['current']   = false;
                if (is_array($current)) {
                    $data['current']   =
                        (isset($current['product']['id']) AND $current['product']['id'] == $row['idproduct'] )
                            ? true
                            : false;

                } elseif ($current === true) {
                    $data['current']   = true;

                }

                $data['id']        = $row['idproduct'];
                $data['name']      = $row['titlecatalog'];
                $data['price']     = $row['price'];
                $data['content']     = $row['desccatalog'];

            // *** Subcategory
            } elseif (isset($row['slibelle'])) {
                $data['current']   = false;
                if (is_array($current) AND isset($current['subcategory']['id'])) {
                    $data['current']   = ($current['subcategory']['id'] == $row['idcls']) ? true : false;
                }

                $data['img_src']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'img'=>'skin/'.
                            $ModelTemplate->frontendTheme()->themeSelected().
                            '/img/catalog/subcategory-default.png'
                        )
                    );
                if (isset($row['img_s']) != null){
                    $data['img_src']   =
                        $ModelImagepath->filterPathImg(
                            array(
                                'filtermod'=>'catalog',
                                'img'=>$row['img_s'],
                                'levelmod'=>'subcategory'
                            )
                        );
                }

                $data['url']       =
                    $ModelRewrite->filter_catalog_subcategory_url(
                        $row['iso'],
                        $row['pathclibelle'],
                        $row['idclc'],
                        $row['pathslibelle'],
                        $row['idcls'],
                        true
                    );

                $data['id']          = $row['idcls'];
                $data['name']        = $row['slibelle'];
                $data['content']     = ($row['s_content'] != '') ? $row['s_content'] : null;

             // *** Category
            } elseif(isset($row['clibelle'])) {
                $data['current']   =    false;
                if (is_array($current) AND isset($current['category']['id'])) {
                    $data['current']   = ($current['category']['id'] == $row['idclc']) ? true : false;
                }

                $data['img_src']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'img'=>'skin/'.
                                $ModelTemplate->frontendTheme()->themeSelected().
                                '/img/catalog/category-default.png'
                        )
                    );

                if (isset($row['img_c']) != null){
                    $data['img_src']   = $ModelImagepath->filterPathImg(
                        array(
                            'filtermod'=>'catalog',
                            'img'=>$row['img_c'],
                            'levelmod'=>'category'
                        )
                    );
                }

                $data['url']       =
                    $ModelRewrite->filter_catalog_category_url(
                        $row['iso'],
                        $row['pathclibelle'],
                        $row['idclc'],
                        true
                    );
                $data['id']         =    $row['idclc'];
                $data['name']       =    $row['clibelle'];
                $data['content']    =    ($row['c_content'] != '') ? $row['c_content'] : null;

                // *** Micro-gallery (product page)
            } elseif(isset($row['idmicro'])) {
                $data['id']        = $row['idmicro'];
                $data['img_src']['mini']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'filtermod'=>'catalog',
                            'img'=>'mini/'.
                                $row['imgcatalog'],
                            'levelmod'=>'galery'
                        )
                    );
                $data['img_src']['maxi']   =
                    $ModelImagepath->filterPathImg(
                        array(
                            'filtermod'=>'catalog',
                            'img'=>'maxi/'.
                                $row['imgcatalog'],
                            'levelmod'=>'galery'
                        )
                    );
            }
            return $data;
        }
    }
    /**
     * Retourne les données sql sur base des paramètres passés en paramète
     * @param array $custom
     * @param array $current
     * @return array|null
     *
     */
    public static function getData($custom,$current)
    {
        if (!(is_array($custom))) {
            return null;
        }

        if (!(array_key_exists('catalog',$current))) {
            return null;
        }

        $conf           =   array(
            'id'        =>  null,
            'type'      =>  null,
            'limit'     =>  null,
            'lang'      =>  $current['lang']['iso'],
            'context'   =>  array(1 => 'all')
        );
        $current = $current['catalog'];

        if (!(isset($custom['context']))) {
            if (isset($current['product']['id'])) {
                $conf['context'][1]   =   'product';

            } elseif (isset($current['subcategory']['id'])) {
                $conf['id']         =   $current['subcategory']['id'];
                $conf['context'][1]   =   'product';

            } elseif (isset($current['category']['id'])) {
                $conf['id']         =   $current['category']['id'];
                $conf['context'][1] = 'subcategory';

            } else {
                $conf['context'][1] = 'category';
            }
        }

        // custom values: data_sort
        if (isset($custom['select'])) {
            if ($custom['select'] == 'current') {
                if (isset($current['subcategory']['id'])) {
                    $conf['id']     = $current['subcategory']['id'];
                    $conf['type']   = 'collection';

                } elseif($current['category']['id'] != null) {
                    $conf['id'] = $current['category']['id'];
                    $conf['type']   = 'collection';

                }

            } elseif(is_array($custom['select'])) {
                if (array_key_exists($conf['lang'],$custom['select'])) {
                    $conf['id']     = $custom['select'][$conf['lang']];
                    $conf['type']   = 'collection';

                }
            } elseif($custom['select'] = 'all') {
                $conf['id']     = null;
                $conf['type']   = null;

            }
        } elseif(isset($custom['exclude'])) {
            if ( is_array($custom['exclude'])) {
                if (array_key_exists($conf['lang'],$custom['exclude'])) {
                    $conf['id'] = $custom['exclude'][$conf['lang']];
                    $conf['type'] = 'exclude';
                }
            }
        }



        if (isset($custom['limit'])) {
            $conf['limit']  =   $custom['limit'];
        }

        // custom values: display
        if (isset($custom['context'])) {
            if (is_array($custom['context'])) {
                foreach ($custom['context'] as $k => $v)
                {
                    $conf['context'][1]   =   $k;
                    if (is_array($v)) {
                        foreach($v as $k2 => $v2){
                            $conf['context'][2]   =   $k2;
                            $conf['context'][3]   =   $v2;
                        }

                    } else {
                        $conf['context'][2]   =   $v;
                    }
                }
            } else {
                $allowed = array(
                    'category',
                    'subcategory',
                    'product',
                    'last-product',
                    'last-product-cat',
                    'last-product-subcat',
                    'all',
                    'product-gallery'
                );
                if (array_search($custom['context'],$allowed)) {
                    $conf['context'][1]   =   $custom['context'];
                }
            }
        }

        // *** Load SQL data
        $data = null;
        if ($conf['context'][1] == 'category' OR $conf['context'][1] == 'all') {
            // Category
            $data = parent::s_category(
                $conf['lang'],
                $conf['id'],
                $conf['type'],
                $conf['limit']
            );
            if (($conf['context'][2] == 'subcategory' OR $conf['context'][1] == 'all') AND $data != null) {
                foreach ($data as $k1 => $v_1)
                {
                    // Category > subcategory
                    $data_2 =   parent::s_sub_category_in_cat(
                        $v_1['idclc'],
                        $conf['limit']
                    );
                    if ($data_2 != null) {
                        $data[$k1]['subdata']   =   $data_2;
                        if (($conf['context'][3] == 'product' OR $conf['context'][1] == 'all') AND $data_2 != null) {
                            $data_3     =   null;
                            foreach ($data_2 as $k2 => $v_2)
                            {
                                // Category > subcategory > Product
                                $data_3 =   parent::s_product(
                                    $v_2['idclc'],
                                    $v_2['idcls'],
                                    $conf['limit']
                                );
                                if ($data_3 != null) {
                                    $data[$k1]['subdata'][$k2]['subdata']   =   $data_3;
                                }
                            }
                        }
                    }
                }
            } elseif ($conf['context'][2] == 'product' AND $data != null) {
                foreach($data as $k1 => $v_1)
                {
                    // Category > Product
                    $data_2 = parent::s_product(
                        $v_1['idclc'],
                        null,
                        $conf['limit']
                    );
                    if ($data_2 != null) {
                        $data[$k1]['subdata']   =   $data_2;
                    }
                }
            }
        } elseif($conf['context'][1] == 'subcategory') {
            if ($custom['select'] == 'current' AND isset($current['subcategory']['id'])) {
                // Subcategory[current]
                $data       =   parent::s_subcategory(
                    $conf['lang'],
                    $current['subcategory']['id'],
                    $conf['type'],
                    $conf['limit']
                );

            } elseif (isset($current['category']['id']) AND empty($custom['select'])) {
                // Subcategory[in_cat]
                $data   =   parent::s_sub_category_in_cat(
                    $current['category']['id'],
                    $conf['limit']
                );

            } else {
                // Subcategory
                $data   =   parent::s_subcategory(
                    $conf['lang'],
                    $conf['id'],
                    $conf['type'],
                    $conf['limit']
                );
            }

            if ($conf['context'][2] == 'product' AND $data != null) {
                foreach ($data as $k1 => $v_1)
                {
                    // Subcategory > product
                    $data_2 =   parent::s_product(
                        $v_1['idclc'],
                        $v_1['idcls'],
                        $conf['limit']
                    );
                    if ($data_2 != null) {
                        $data[$k1]['subdata']   =   $data_2;
                    }
                }
            }
        } elseif ( $conf['context'][1] == 'product') {
            if (isset($current['product']['id']) AND empty($custom['select'])) {
                // Product[in_product]
                $data   =   parent::s_product_in_product(
                    $current['product']['id'],
                    $conf['id'],
                    $conf['type']
                );

            } elseif ( (isset($current['category']['id']) OR isset($current['subcategory']['id'])) AND empty($custom['select'])) {
                // Product[in_category OR in_subcategory]
                if (isset($current['category']['id'])) {
                    $catId  =   $current['category']['id'];
                    $subcatId  =   (isset($current['subcategory']['id'])) ? $current['subcategory']['id'] : 0;
                } else {
                    $catId  =   null;
                    $subcatId  =   (isset($current['subcategory']['id'])) ? $current['subcategory']['id'] : null;
                }
                $data   =   parent::s_product(
                    $catId,
                    $subcatId
                );
            } else {
                // All products in lang
                $data   =   parent::s_product(
                    $conf['id'],
                    0
                );

            }
        } elseif ($conf['context'][1] == 'last-product' OR $conf['context'][1] == 'last-product-cat') {
            // Product[last]
            // @TODO: mise en place des paramètre 'exclude'
            $data   =   parent::s_product($conf['id'],null,$conf['limit']);

        } elseif ($conf['context'][1] == 'last-product-subcat') {
            $data   =   parent::s_product(null,$conf['id'],$conf['limit']);

        } elseif($conf['context'][1] == 'product-gallery') {
            // Product Gallery
            $data = parent::s_product_gallery($current['product']['id']);

        }
        return $data;
    }
}
?>