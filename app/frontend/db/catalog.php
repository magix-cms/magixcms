<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @author Sire Sam <samuel.lesire@gmail.com>
 */
class frontend_db_catalog
{
    /**
     * Load data category by id
     * @access protected
     * @param int $idclc
     * @return array
     */
    protected function s_category_data($idclc)
    {
    	$select = 'SELECT
            c.idclc,c.clibelle,c.pathclibelle,c.c_content,c.img_c,lang.iso
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
	protected function s_subcategory_data($idcls)
    {
        $select = 'SELECT
                s.idcls,s.slibelle,s.pathslibelle,s.s_content,s.img_s,
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
	protected function s_product_data($idproduct)
    {
        $select = 'SELECT
                p.idproduct,p.idcatalog,p.idclc, p.idcls,
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
     * @param string $lang_iso
     * @param string $sort_id
     * @param string $sort_type
     * @param int $limit
     * @return array
     */
    protected static function s_category($lang_iso,$sort_id=null,$sort_type=null,$limit=null)
    {
        $filter = null;
        if ($sort_id != null) {
            $filter = 'AND c.idclc';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = ' LIMIT '.$limit;
        }
        $select = "SELECT
                c.idlang, c.clibelle,c.pathclibelle, c.idclc, c.c_content, c.img_c,
                lang.iso
				FROM mc_catalog_c AS c
				JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso
				{$filter}
				ORDER BY corder
				{$limit_clause}";
        return magixglobal_model_db::layerDB()->select(
            $select,
            array(
                ':iso'	=>	$lang_iso
            )
        );
    }
    /**
     * Select all categories by lang, or by option params sort
     * @access protected
     * @param string $lang_iso
     * @param string $sort_id
     * @param string $sort_type
     * @param int $limit
     * @return array
     */
    protected static function s_subcategory($lang_iso,$sort_id=null,$sort_type=null,$limit=null)
    {
        $filter = null;
        if ($sort_id != null) {
            $filter = 'AND s.idcls';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)) {
            $limit_clause = ' LIMIT '.$limit;
        }
        $select = "SELECT
              c.idlang, c.clibelle, c.pathclibelle, c.idclc,
              s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s,
              lang.iso
          FROM mc_catalog_s AS s
		  JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
		  JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		  WHERE lang.iso = :iso
		  {$filter}
		  ORDER BY sorder
		  {$limit_clause}
		";
        return magixglobal_model_db::layerDB()->select(
            $select,
            array(
                ':iso'	=>	$lang_iso
            )
        );
    }
    /**
     * Select all subcategories in idclc
     * @access protected
     * @param int $idclc
     * @param int $limit
     * @return array
     */
    protected static function s_sub_category_in_cat($idclc,$limit=null)
    {
        $limit_clause = null;
        if (is_int($limit)) {
            $limit_clause = ' LIMIT '.$limit;
        }
        $select = "SELECT
                c.idlang, c.clibelle, c.pathclibelle, c.idclc,
                s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s,
                lang.iso
            FROM mc_catalog_s AS s
            JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
            JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
            WHERE c.idclc = :idclc
            ORDER BY sorder
            {$limit_clause}
		";
        return magixglobal_model_db::layerDB()->select(
            $select,
            array(
                ':idclc'	=>	$idclc
            )
        );
    }
    /**
     * Select all product in idclc or idcls
     * @access protected
     * @param int $idclc
     * @param int $idcls
     * @param int $limit
     * @return array
     */
    protected static function s_product($idclc=null,$idcls=0,$limit=null,$sort='id')
    {
        switch($sort){
            case 'id':
                $order_clause = 'ORDER BY p.idproduct DESC';
                break;
            case 'product':
                $order_clause = 'ORDER BY p.orderproduct ASC';
                break;
            case 'name':
                $order_clause = 'ORDER BY catalog.titlecatalog ASC';
                break;
        }

        if (isset($idclc) OR isset($idcls)) {
            $where_clause      = 'WHERE ';
            $where_clause     .= (isset($idclc)) ? 'p.idclc = '.$idclc : '';
            $where_clause     .= (isset($idclc) AND isset($idcls)) ? ' AND ' : '';
            $where_clause     .= (isset($idcls)) ? 'p.idcls = '.$idcls.' ' : '';
        } else {
            // @TODO devrait recevoir la langue en paramète
            $where_clause = 'WHERE lang.iso = \''.frontend_model_template::current_Language().'\'';
        }
        $limit_clause = null;
        if (is_int($limit)) {
            $limit_clause = 'LIMIT '.$limit;
        }
        $select = "SELECT
                p.idproduct,p.idclc, p.idcls,
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
            {$limit_clause}
		";
        return magixglobal_model_db::layerDB()->select($select);
    }
    /**
     * Select all product related to idproduct
     * @access protected
     * @param int $idproduct
     * @param string $sort_id
     * @param string $sort_type
     * @param int $limit
     * @return array
     */
    protected static function s_product_in_product($idproduct,$sort_id=null,$sort_type=null,$limit=null)
    {
        // set CLAUSE
        $filter = null;
        if ($sort_id != null) {
            $filter = 'WHERE p.idclc';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)) {
            $limit_clause = 'LIMIT '.$limit;
        }
        // SQL
        $select = "SELECT
                p.idproduct,p.idclc, p.idcls,
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
            LEFT JOIN mc_catalog_rel_product as rel_p ON (cur_p.idcatalog = rel_p.idcatalog)
            LEFT JOIN mc_catalog_product as p ON (rel_p.idproduct = p.idproduct)
            LEFT JOIN mc_catalog as catalog ON (p.idcatalog = catalog.idcatalog)
            LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
            LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
            JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
            {$filter}
            ORDER BY p.orderproduct
            {$limit_clause}
        ";
        return magixglobal_model_db::layerDB()->select(
            $select,
            array(
                ':idproduct'	=>	$idproduct
            )
        );
    }
    /**
     * Select all image gallery related to idproduct
     * @access protected
     * @param int $idproduct
     * @return array
     */
    protected static function s_product_gallery($idproduct)
    {
        $select = 'SELECT
              gallery.idmicro,gallery.imgcatalog
            FROM (
                  SELECT idcatalog
                  FROM mc_catalog_product
                  WHERE idproduct = :idproduct
                ) AS cur_p
            JOIN mc_catalog_galery as gallery ON (cur_p.idcatalog = gallery.idcatalog)';
        return magixglobal_model_db::layerDB()->select(
            $select,
            array(
                ':idproduct'	=>	$idproduct
            )
        );
    }
}
