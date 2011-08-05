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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_block_catalog{
	public static function s_category_widget($iso,$idclc,$type = null){
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
		switch($type){
			case 'collection':
				$filter = 'AND c.idclc IN ';
				$filter .= '( '. $idclc . ' ) ';
				break;
			case 'exclude':
				$filter = 'AND c.idclc NOT IN ';
				$filter .= '( '. $idclc . ' ) ';
				break;
			default:
				$filter = '';	
				break;
		}
		$sql = "SELECT c.idclc,c.pathclibelle,c.clibelle,c.img_c,c.idlang,c.c_content,lang.iso
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE lang.iso = :iso {$filter} ORDER BY corder";
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'	=>	$iso)
		);
	}
	public static function s_product_in_category($idclc,$iso){
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
	public static function s_product_category_by_date($idclc,$iso){
	    $sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog,catalog.date_catalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.iso
	    FROM mc_catalog_product AS p
	    LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
	    LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
	    LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
	    JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
	    LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
	    WHERE p.idclc = :idclc AND p.idcls = 0 AND lang.iso = :iso ORDER BY catalog.date_catalog DESC';
	    return magixglobal_model_db::layerDB()->select($sql,array(
	      ':idclc'=>$idclc,
	      ':iso'=>$iso
	    ));
	  }
	public static function s_current_name_category_widget($idclc){
    	$sql = 'SELECT c.clibelle,c.pathclibelle,c.c_content
		FROM mc_catalog_c as c WHERE c.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'=>$idclc
		));
    }
	/**
     * Charge les articles de la sous catégorie (avec langue)
     * @param $idclc
     * @param $idcls
     * @param $iso
     */
	public static function s_sub_category_page($idclc,$idcls,$iso){
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
	/*################# micro galerie ##################*/
	public static function s_identifier_catalog($idproduct){
		$sql = 'SELECT product.idcatalog FROM mc_catalog_product as product 
		WHERE idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}
	/**
	 * Compte le nombre d'image pour une galerie catalogue
	 * @param $getimg
	 */
	public static function count_image_in_galery_product($idcatalog){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_galery as img 
		WHERE idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
	/**
	 * selectionne les images pour la construction d'une micro galerie d'un produit
	 * @param intéger $idcatalog
	 */
	public static function s_microgalery_product($idcatalog){
		$sql = 'SELECT img.idmicro,img.imgcatalog FROM mc_catalog_galery as img 
		WHERE idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
	/**
	 * Produits liés
	 */
	/**
	 * Selectionne les produits liés du produit courant
	 * @param $idcatalog
	 */
	public static function s_catalog_rel_product($idcatalog){
		$sql = 'SELECT rel.idrelproduct,rel.idproduct 
		FROM mc_catalog_rel_product AS rel
		WHERE rel.idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
	public static function s_catalog_product_info($idproduct){
		$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle,s.idcls,s.pathslibelle,
		card.titlecatalog, card.urlcatalog, card.desccatalog, lang.iso,img.imgcatalog
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS card USING ( idcatalog )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c USING ( idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}
	/*################ MENU #################*/
	/**
	 * construction menu des catégories (avec langue)
	 */
	public static function s_category_menu_with_exclude($iso,$exclude_sql){
		$sql = "SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.iso
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso AND c.idclc NOT IN ({$exclude_sql})
				ORDER BY corder";
		return magixglobal_model_db::layerDB()->select($sql,array(
		':iso'		=>	$iso
		));
	}	
	/**
	 * construction menu des sous catégories (avec langue)
	 * @param iso
	 * @param idclc
	 */
	public static function s_sub_category_menu($iso,$idclc){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, s.img_s, lang.iso
				FROM mc_catalog_c AS c
				JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc AND lang.iso = :iso ORDER BY sorder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'		=>	$iso,
			':idclc'	=>	$idclc
		));
	}
	/**
	 * construction menu des catégories (avec langue)
	 */
	public static function s_category_menu($iso){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.iso
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
		':iso'		=>	$iso
		));
	}
	/*public static function s_sub_category_menu($idclc,$iso){
	    $sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, s.idclc, s.img_s, lang.iso
	        FROM mc_catalog_c AS c
	        LEFT JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
	        LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
	        WHERE s.idclc = :idclc AND lang.iso = :iso ORDER BY sorder';
	    return magixglobal_model_db::layerDB()->select($sql,array(
	      ':idclc'=>$idclc,
	      ':iso'   =>  $iso
	    ));
	}*/
}