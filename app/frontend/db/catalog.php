<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com support[at]magix-cms[point]com
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com>
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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2016 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 */
class frontend_db_catalog
{
    /**
     * Load data category by id
     * @access protected
     * @param int $idclc
     * @return array
     */
    public function s_category_data($idclc)
    {
    	$select = 'SELECT
            c.idclc,c.clibelle,c.pathclibelle,c.c_content,c.img_c, c.corder, c.idlang, lang.iso
	      FROM mc_catalog_c as c
	      JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		  WHERE c.idclc = :idclc
		';
        return magixglobal_model_db::layerDB()->selectOne(
            $select,
            array(
			    ':idclc'=>$idclc
		    )
        );
    }
    /**
     * Load data subcategory by id
     * @access protected
     * @param int $idcls
     * @return array
     */
	public function s_subcategory_data($idcls)
    {
        $select = 'SELECT
                s.idcls,s.slibelle,s.pathslibelle,s.s_content,s.img_s,s.sorder,
                c.idclc,c.clibelle,c.pathclibelle,
                lang.iso
            FROM mc_catalog_s as s
            LEFT JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
            JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
            WHERE s.idcls = :idcls
        ';
		return magixglobal_model_db::layerDB()->selectOne(
            $select,
            array(
			    ':idcls'=>$idcls
		    )
        );
    }
    /**
     * Load data product by id
     * @access protected
     * @param int $idproduct
     * @return array
     */
	public function s_product_data($idproduct)
    {
        $select = 'SELECT
                p.idproduct,p.idcatalog,p.idclc, p.idcls,p.orderproduct,
                catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.date_catalog,
                catalog.price,catalog.desccatalog,
                c.clibelle,c.pathclibelle,s.slibelle,
                s.pathslibelle,
                catalog.imgcatalog,
                lang.iso
            FROM mc_catalog_product AS p
            LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
            LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
            LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
            JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
            WHERE p.idproduct = :idproduct
        ';
		return magixglobal_model_db::layerDB()->selectOne(
            $select,
            array(
			    ':idproduct'    =>	$idproduct
    		)
        );
	}

    /**
     * Select all categories by lang, or by option params sort
     * @access protected
     * @param $data
     * @return array
     */
    public static function fetchCategory($data){
        if(is_array($data)){
            if(array_key_exists('fetch',$data)){
                $fetch = $data['fetch'];
            }else{
                $fetch = 'all';
            }
            if($fetch == 'all'){
                if(array_key_exists('sort_order',$data)){
                    $sort_order = $data['sort_order'];
                }else{
                    $sort_order = 'DESC';
                }
                if(array_key_exists('sort_type',$data)) {
                    switch ($data['sort_type']) {
                        case 'id':
                            $order_clause = " ORDER BY c.idclc {$sort_order}";
                            break;
                        case 'order':
                            $order_clause = " ORDER BY c.corder {$sort_order}";
                            break;
                        case 'name':
                            $order_clause = " ORDER BY c.clibelle {$sort_order}";
                            break;
                    }
                }else{
                    $order_clause = " ORDER BY c.corder {$sort_order}";
                }
                if(array_key_exists('limit',$data)) {
                    $limit_clause = null;
                    if (is_int($data['limit'])) {
                        $limit_clause = ' LIMIT ' . $data['limit'];
                    }
                }
                if(array_key_exists('selectmode',$data)) {
                    $where_clause = null;
                    if($data['selectmodeid']){
                        $where_clause .= ' AND c.idclc';
                        $where_clause .= ($data['selectmode'] != 'exclude') ? ' IN (' : ' NOT IN (';
                        $where_clause .= $data['selectmodeid'];
                        $where_clause .= ') ';
                    }
                }
                if(array_key_exists('iso',$data)) {
                    $query = "SELECT
                    c.idlang, c.clibelle,c.pathclibelle, c.idclc, c.c_content, c.img_c, c.corder,
                    lang.iso
                    FROM mc_catalog_c AS c
                    JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                    WHERE lang.iso = :iso
                    {$where_clause}
                    {$order_clause}
                    {$limit_clause}";
                    return magixglobal_model_db::layerDB()->select(
                        $query,
                        array(
                            ':iso' => $data['iso']
                        )
                    );
                }else{
                    $query = "SELECT
                    c.idlang, c.clibelle,c.pathclibelle, c.idclc, c.c_content, c.img_c, c.corder,
                    lang.iso
                    FROM mc_catalog_c AS c
                    JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                    {$where_clause}
                    {$order_clause}
                    {$limit_clause}";
                    return magixglobal_model_db::layerDB()->select($query);
                }
            }
        }
    }

    /**
     * Select sub categories by lang, or by option params sort
     * @access protected
     * @param $data
     * @return array
     */
    public static function fetchSubCategory($data){
        if(is_array($data)){
            if(array_key_exists('fetch',$data)){
                $fetch = $data['fetch'];
            }else{
                $fetch = 'all';
            }
            if(array_key_exists('sort_order',$data)){
                $sort_order = $data['sort_order'];
            }else{
                $sort_order = 'DESC';
            }
            if(array_key_exists('sort_type',$data)) {
                switch ($data['sort_type']) {
                    case 'id':
                        $order_clause = " ORDER BY s.idcls {$sort_order}";
                        break;
                    case 'order':
                        $order_clause = " ORDER BY s.sorder {$sort_order}";
                        break;
                    case 'name':
                        $order_clause = " ORDER BY s.slibelle {$sort_order}";
                        break;
                }
            }else{
                $order_clause = " ORDER BY s.sorder {$sort_order}";
            }
            if(array_key_exists('limit',$data)) {
                $limit_clause = null;
                if (is_int($data['limit'])) {
                    $limit_clause = ' LIMIT ' . $data['limit'];
                }
            }
            // Return list
            if($fetch == 'all'){
                //Select all sub categories by lang, or by option params sort
                if(array_key_exists('selectmode',$data)) {
                    $where_clause = null;
                    if($data['selectmodeid']){
                        $where_clause .= ' AND s.idcls';
                        $where_clause .= ($data['selectmode'] != 'exclude') ? ' IN (' : ' NOT IN (';
                        $where_clause .= $data['selectmodeid'];
                        $where_clause .= ') ';
                    }
                }
                if(array_key_exists('iso',$data)) {
                    $query = "SELECT
                      c.idlang, c.clibelle, c.pathclibelle, c.idclc,
                      s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s, s.sorder,
                      lang.iso
                  FROM mc_catalog_s AS s
                  JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
                  JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                  WHERE lang.iso = :iso
                  {$where_clause}
                  {$order_clause}
                  {$limit_clause}
				";
                    return magixglobal_model_db::layerDB()->select(
                        $query,
                        array(
                            ':iso' => $data['iso']
                        )
                    );
                }else{
                    $query = "SELECT
                      c.idlang, c.clibelle, c.pathclibelle, c.idclc,
                      s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s, s.sorder,
                      lang.iso
                  FROM mc_catalog_s AS s
                  JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
                  JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                  {$where_clause}
                  {$order_clause}
                  {$limit_clause}
				";
                    return magixglobal_model_db::layerDB()->select(
                        $query
                    );
                }
            }elseif($fetch == 'in_cat'){
                //Select all sub categories in category
                if(array_key_exists('idclc',$data)){
                    $query = "SELECT
                    c.idlang, c.clibelle, c.pathclibelle, c.idclc,
                    s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s, s.sorder,
                    lang.iso
                        FROM mc_catalog_s AS s
                        JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
                        JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                        WHERE c.idclc = :idclc
                        {$order_clause}
                        {$limit_clause}
                    ";
                    return magixglobal_model_db::layerDB()->select(
                        $query,
                        array(
                            ':idclc'	=>	$data['idclc']
                        )
                    );
                }
            }
        }
    }


    /**
     * Select product
     * @param $data
     * @return array
     */
    public static function fetchProduct($data){
        if(is_array($data)) {
            if (array_key_exists('fetch', $data)) {
                $fetch = $data['fetch'];
            } else {
                $fetch = 'all';
            }
            if (array_key_exists('sort_order', $data)) {
                $sort_order = $data['sort_order'];
            } else {
                $sort_order = 'DESC';
            }
            if (array_key_exists('limit', $data)) {
                $limit_clause = null;
                if (is_int($data['limit'])) {
                    $limit_clause = ' LIMIT ' . $data['limit'];
                }
            }
            if ($fetch == 'all') {
                // Select all product
                if(array_key_exists('sort_type',$data)) {
                    switch ($data['sort_type']) {
                        case 'id':
                            $order_clause = " ORDER BY p.idproduct {$sort_order}";
                            break;
                        case 'product':
                            $order_clause = " ORDER BY p.orderproduct {$sort_order}";
                            break;
                        case 'name':
                            $order_clause = " ORDER BY catalog.titlecatalog {$sort_order}";
                            break;
                    }
                }else{
                    $order_clause = " ORDER BY p.idproduct {$sort_order}";
                }
                $iso = frontend_model_template::current_Language();
                $where_clause = 'WHERE lang.iso = :iso';
                switch($data['context']){
                    case 'last-product-cat':
                        if($data['selectmode']){
                            $where_clause .= ' AND p.idclc';
                            $where_clause .= ($data['selectmode'] != 'exclude') ?' IN (' : ' NOT IN (';
                            $where_clause .= $data['selectmodeid'];
                            $where_clause .= ') ';
                        }
                        break;
                    case 'last-product-subcat':
                        if($data['selectmode']){
                            $where_clause .= ' AND p.idcls';
                            $where_clause .= ($data['selectmode'] != 'exclude') ?' IN (' : ' NOT IN (';
                            $where_clause .= $data['selectmodeid'];
                            $where_clause .= ') ';
                        }
                        break;
                    case 'product':
                        if($data['selectmode']){
                            $where_clause .= ' AND p.idproduct';
                            $where_clause .= ($data['selectmode'] != 'exclude') ?' IN (' : ' NOT IN (';
                            $where_clause .= $data['selectmodeid'];
                            $where_clause .= ') ';
                        }
                        break;
                }
                $query = "SELECT
                    p.idcatalog,p.idproduct,p.idclc, p.idcls,
                    catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.price,catalog.desccatalog,
                    c.pathclibelle,
                    s.pathslibelle,
                    catalog.imgcatalog,
                    lang.iso
                FROM mc_catalog_product AS p
                LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
                LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
                LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
                JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
                {$where_clause}
                {$order_clause}
                {$limit_clause}";
                return magixglobal_model_db::layerDB()->select(
                    $query,
                    array(
                        ':iso'	=>	$data['iso']
                    )
                );
            }elseif ($fetch == 'all_in') {
                // Select all product in idclc or idcls
                if (array_key_exists('sort_type', $data)) {
                    switch ($data['sort_type']) {
                        case 'id':
                            $order_clause = "ORDER BY p.idproduct {$sort_order}";
                            break;
                        case 'product':
                            $order_clause = "ORDER BY p.orderproduct {$sort_order}";
                            break;
                        case 'name':
                            $order_clause = "ORDER BY catalog.titlecatalog {$sort_order}";
                            break;
                    }
                }else{
                    $order_clause = " ORDER BY p.idproduct {$sort_order}";
                }

                if (array_key_exists('idclc', $data) OR array_key_exists('idcls', $data)) {
                    if (isset($data['idclc']) OR isset($data['idcls'])) {
                        $where_clause = 'WHERE ';
                        $where_clause .= (isset($data['idclc'])) ? 'p.idclc = ' . $data['idclc'] : '';
                        $where_clause .= (isset($data['idclc']) AND isset($data['idcls'])) ? ' AND ' : '';
                        $where_clause .= (isset($data['idcls'])) ? 'p.idcls = ' . $data['idcls'] . ' ' : '';
                    }else {
                        // @TODO devrait recevoir la langue en paramète
                        $where_clause = 'WHERE lang.iso = \'' . frontend_model_template::current_Language() . '\'';
                    }
                } else {
                    // @TODO devrait recevoir la langue en paramète
                    $where_clause = 'WHERE lang.iso = \'' . frontend_model_template::current_Language() . '\'';
                }
                $query = "SELECT
                p.idcatalog,p.idproduct,p.idclc, p.idcls,
                catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.price,catalog.desccatalog,
                c.pathclibelle,
                s.pathslibelle,
                catalog.imgcatalog,
                lang.iso
                FROM mc_catalog_product AS p
                LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
                LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
                LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
                JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
                {$where_clause}
                {$order_clause}
                {$limit_clause}";
                return magixglobal_model_db::layerDB()->select($query);

            }elseif ($fetch == 'related') {
                //Select all product related to idproduct
                if (array_key_exists('sort_type', $data)) {
                    switch ($data['sort_type']) {
                        case 'id':
                            $order_clause = " ORDER BY p.idproduct {$sort_order}";
                            break;
                        case 'product':
                            $order_clause = " ORDER BY p.orderproduct {$sort_order}";
                            break;
                        case 'name':
                            $order_clause = " ORDER BY catalog.titlecatalog {$sort_order}";
                            break;
                    }
                }else{
                    $order_clause = " ORDER BY p.idproduct {$sort_order}";
                }
                $where_clause = null;
                if(array_key_exists('selectmode',$data)) {
                    if ($data['selectmode']) {
                        $where_clause .= 'WHERE p.idclc';
                        $where_clause .= ($data['selectmode'] != 'exclude') ? ' IN (' : ' NOT IN (';
                        $where_clause .= $data['selectmodeid'];
                        $where_clause .= ') ';
                    }
                }
                $query = "SELECT
                p.idproduct,p.idclc, p.idcls,p.orderproduct,
                catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.price,catalog.desccatalog,
                c.pathclibelle,
                s.pathslibelle,
                catalog.imgcatalog,
                lang.iso
                FROM (
                  SELECT idcatalog
                  FROM mc_catalog_product
                  WHERE idproduct = :idproduct
                ) AS cur_p
                JOIN mc_catalog_rel_product AS rel_p ON (cur_p.idcatalog = rel_p.idcatalog)
                JOIN mc_catalog_product AS p ON (rel_p.idproduct = p.idproduct)
                LEFT JOIN mc_catalog AS catalog ON (p.idcatalog = catalog.idcatalog)
                LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
                LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
                JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
                {$where_clause}
                {$order_clause}
                {$limit_clause}
                ";
                return magixglobal_model_db::layerDB()->select(
                    $query,
                    array(
                        ':idproduct'	=>	$data['idproduct']
                    )
                );
            }elseif ($fetch == 'galery') {
                if (array_key_exists('sort_type', $data)) {
                    switch ($data['sort_type']) {
                        case 'id':
                            $order_clause = " ORDER BY gallery.idmicro {$sort_order}";
                            break;
                        case 'product':
                            $order_clause = " ORDER BY gallery.img_order {$sort_order}";
                            break;
                        case 'name':
                            $order_clause = " ORDER BY gallery.imgcatalog {$sort_order}";
                            break;
                    }
                }else{
                    $order_clause = " ORDER BY gallery.idmicro {$sort_order}";
                }
                $query = "SELECT
                    gallery.idmicro,gallery.imgcatalog,gallery.img_order
                    FROM (
                          SELECT idcatalog
                          FROM mc_catalog_product
                          WHERE idproduct = :idproduct
                        ) AS cur_p
                    JOIN mc_catalog_galery as gallery ON (cur_p.idcatalog = gallery.idcatalog)
                    {$order_clause}
                    {$limit_clause}";
                return magixglobal_model_db::layerDB()->select(
                    $query,
                    array(
                        ':idproduct'	=>	$data['idproduct']
                    )
                );
            }
        }
    }
}
