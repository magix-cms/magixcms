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
 *
 */
class frontend_db_catalog{
/*####### CATEGORIE #######*/
    protected function s_current_name_category($idclc){
    	$sql = 'SELECT c.clibelle,c.pathclibelle,c.c_content,c.img_c
		FROM mc_catalog_c as c WHERE c.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'=>$idclc
		));
    }
    /**
     * Charge les articles de la catégorie (sans langue) (root catégorie)
     * pour la liste en image
     * @param $idclc
     */
	function s_product_in_category_no_language($idclc){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND catalog.idlang = 0
		ORDER BY p.orderproduct DESC';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc
		));
	}
	/**
     * Charge les articles de la catégorie (avec la langue) pour la liste en image
     * @param $idclc
     * @param $iso
     */
	function s_product_in_category_with_language($idclc,$iso){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND lang.iso = :iso ORDER BY p.orderproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc,
			':iso'=>$iso
		));
	}
	/*############# SOUS CATEGORIE ###################*/
	protected function s_current_name_subcategory($idcls){
    	$sql = 'SELECT
        s.slibelle,s.pathslibelle,s.s_content,s.img_s,
        c.idclc,c.clibelle,c.pathclibelle,
        lang.iso
    	FROM mc_catalog_s as s 
    	LEFT JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE s.idcls = :idcls';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idcls'=>$idcls
		));
    }
	/**
     * Charge les articles de la sous catégorie (sans langue)
     * @param $idclc
     */
	function s_sub_category_page_no_language($idclc,$idcls){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND catalog.idlang = 0 ORDER BY p.orderproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc,
			':idcls'=>$idcls
		));
	}
	/**
     * Charge les articles de la sous catégorie (avec langue)
     * @param $idclc
     * @param $idcls
     * @param $iso
     */
	function s_sub_category_page_with_language($idclc,$idcls,$iso){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND lang.iso = :iso ORDER BY p.orderproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'	=>$idclc,
			':idcls'	=>$idcls,
			':iso' =>$iso
		));
	}
/*############### Product ##############*/
	function s_product_page_no_language($idclc,$idproduct){
		$sql = 'SELECT p.idproduct,p.idcatalog, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.date_catalog, p.idclc, p.idcls, 
		catalog.price,catalog.desccatalog, c.clibelle,c.pathclibelle,s.slibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idproduct = :idproduct AND catalog.idlang = 0';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idproduct'	=>	$idproduct
		));
	}
	protected function s_product_page($idclc,$idproduct){
		$sql = 'SELECT p.idproduct,p.idcatalog, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang,catalog.date_catalog, p.idclc, p.idcls, catalog.price,
		catalog.desccatalog,c.clibelle, c.pathclibelle,s.slibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idproduct'	=>	$idproduct
		));
	}
/*################## menu #############################*/
	/**
	 * construction menu des catégories (sans langue)
	 */
	function s_category_menu_no_lang(){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.iso
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang = 0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des catégories (avec langue)
	 */
	function s_category_menu_with_lang($iso){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.iso
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
		':iso'		=>	$iso
		));
	}
	/**
	 * construction menu des sous catégories (sans langue)
	 * @param idclc
	 */
	function s_sub_category_menu_no_lang($idclc){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.iso
				FROM mc_catalog_c AS c
				JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc AND c.idlang =0 ORDER BY sorder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc
		));
	}
	/**
	 * construction menu des sous categories (avec langue) + catégories
	 */
	function s_sub_category_menu_all_no_lang(){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.iso
				FROM mc_catalog_c AS c
				JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang = 0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des sous catégories (avec langue)
	 * @param iso
	 * @param idclc
	 */
	function s_sub_category_menu_with_lang($iso,$idclc){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.iso
				FROM mc_catalog_c AS c
				JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc AND lang.iso = :iso ORDER BY sorder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'		=>	$iso,
			':idclc'		=>	$idclc
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang($idcls){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.iso
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = :idcls AND p.idlang = 0';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcls'=>$idcls
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang_no_cat(){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.iso
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND p.idlang = 0';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_with_lang_no_cat($iso){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.iso
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND lang.iso = :iso';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'		=>	$iso
		));
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (sans langue)
	 */
	function s_category_withimg_nolang(){
		/*$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
		p.idclc, p.idcls, c.pathclibelle,clibelle, img.imgcatalog, lang.iso
		FROM mc_catalog AS p
		JOIN (
			SELECT max( p.idcatalog ) id, c.idclc FROM mc_catalog AS p
			LEFT JOIN mc_catalog_c AS c ON c.idclc = p.idclc
			GROUP BY c.idclc
		)catalog_id_max ON ( p.idcatalog = catalog_id_max.id )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idlang = 0';*/
		$sql = 'SELECT c.idclc,c.pathclibelle,c.clibelle,c.img_c,c.idlang, lang.iso
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE c.idlang = 0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (avec langue)
	 * @param $iso (langue)
	 */
	function s_category_withimg_lang($iso){
		/*$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
		p.idclc, p.idcls, c.pathclibelle,clibelle, img.imgcatalog, lang.iso
		FROM mc_catalog AS p
		JOIN (
			SELECT max( p.idcatalog ) id, c.idclc FROM mc_catalog AS p
			LEFT JOIN mc_catalog_c AS c ON c.idclc = p.idclc
			GROUP BY c.idclc
		)catalog_id_max ON ( p.idcatalog = catalog_id_max.id )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE lang.iso = :iso';*/
		$sql = 'SELECT c.idclc,c.pathclibelle,c.clibelle,c.img_c,c.idlang, lang.iso
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE lang.iso = :iso ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'		=>	$iso)
		);
	}

    /*
     * Extend function for list & nav display
     ***************************************/

    /**
     * @access public
     * Sélection des catégorie
     * @param string $lang_iso
     * @param string $sort_id
     * @param string $sort_type
     */
    protected static function s_category($lang_iso,$sort_id=null,$sort_type=null,$limit=null){
        $filter = null;
        if ($sort_id != null) {
            $filter = 'AND c.idclc';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        $sql = "SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, c.c_content, lang.iso, c.img_c
				FROM mc_catalog_c AS c
				JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso
				{$filter}
				ORDER BY corder
				{$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':iso'	=>	$lang_iso
        ));
    }
    /**
     * @access public
     * Sélection des catégorie
     * @param string $lang_iso
     * @param string $sort_id
     * @param string $sort_type
     */
    protected static function s_subcategory($lang_iso,$sort_id=null,$sort_type=null,$limit=null){
        $filter = null;
        if ($sort_id != null) {
            $filter = 'AND s.idcls';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        $sql = "SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s, lang.iso
				FROM mc_catalog_s AS s
				JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
				JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso {$filter}
				{$limit_clause}
				ORDER BY sorder";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':iso'	=>	$lang_iso
        ));
    }
    /**
     * @access public
     * Sélection des sous-catégorie d'une catégorie
     * @param iso
     * @param idclc
     */
    protected static function s_sub_category_in_cat($idclc,$limit=null){
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        $sql = "SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.s_content, s.pathslibelle, s.idcls, s.img_s, lang.iso
				FROM mc_catalog_s AS s
				JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
				JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc
				{$limit_clause}
				ORDER BY sorder";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idclc'	=>	$idclc
        ));
    }

    /**
     * @access public
     * Charge les articles de la sous catégorie (avec langue)
     * @param $idclc
     * @param $idcls
     */
    protected static function s_product($idclc=null,$idcls=null,$limit=null){
        $order_clause = 'ORDER BY p.orderproduct';
        if($idclc == null and $idcls == null){
            $where_clause = 'WHERE lang.iso = \''.frontend_model_template::current_Language().'\'';
            $order_clause = 'ORDER BY p.idproduct';
        } else {
            $where_clause      = 'WHERE ';
            $where_clause     .= ($idclc != null) ? 'p.idclc = '.$idclc.' AND ' : '';
            $where_clause     .= ($idcls != null) ? 'p.idcls = '.$idcls.' ' : 'p.idcls = 0 ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }

        $sql = "SELECT
        p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		{$where_clause}
		{$order_clause}
		{$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * @access public
     * Charge les produits liés à un produit
     * @param $idproduct
     */
    protected static function s_product_in_product($idproduct,$sort_id=null,$sort_type=null,$limit=null) {
        // set CLAUSE
        $filter = null;
        if ($sort_id != null) {
            $filter = 'WHERE p.idclc';
            $filter .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $filter .= $sort_id;
            $filter .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        // SQL
        $sql = "
            SELECT
            p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
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
            LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
            JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
            {$filter}
            ORDER BY p.orderproduct
            {$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idproduct'	=>	$idproduct
        ));
    }
    /**
     * @access public
     * Charge les produits liés à un produit
     * @param $idproduct
     */
    protected static function s_product_gallery($idproduct) {
        $sql = 'SELECT gallery.idmicro,gallery.imgcatalog
        FROM (
              SELECT idcatalog
              FROM mc_catalog_product
              WHERE idproduct = :idproduct
            ) AS cur_p
        LEFT JOIN mc_catalog_galery as gallery ON (cur_p.idcatalog = gallery.idcatalog)';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idproduct'	=>	$idproduct
        ));
    }

}