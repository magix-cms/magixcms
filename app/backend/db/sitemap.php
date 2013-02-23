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
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name sitemap
 *
 */
class backend_db_sitemap{
    /**
     * @param $attr_name
     * @return array
     */
    protected function s_config_named_data($attr_name){
        $sql = 'SELECT attr_name,status FROM mc_config
    	WHERE attr_name = :attr_name';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':attr_name' =>	$attr_name
        ));
    }

	/**
     * Sélections dans les news pour la construction du sitemap
     */
    protected function s_root_news_sitemap(){
    	$sql = 'SELECT count(n.idnews) as cidnews, lang.iso
		FROM mc_news AS n
		LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
		WHERE lang.active_lang = 1
		GROUP BY n.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les news pour la construction du sitemap
     */
    protected function s_news_sitemap($idlang){
    	$sql = 'SELECT n.idnews,n.n_title,n.n_content,n.n_image,n.n_uri,n.idlang,
    	n.date_register,n.date_publish,n.keynews,lang.iso
		FROM mc_news as n
		JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
		WHERE n.published = 1 AND lang.active_lang = 1 AND lang.idlang = :idlang';
		return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }
	/**
	 * Retourne le nombre maximum de news
	 * @return void
	 */
	protected function s_count_news_max(){
		$sql = 'SELECT count(n.idnews) as total
		FROM mc_news AS n';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
    /**
     * Sélections dans les pages CMS pour la construction du sitemap
     */
    protected function s_cms_sitemap($idlang){
    	$sql = 'SELECT p.idpage,p.idlang,p.idcat_p, p.uri_page,lang.iso, subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE lang.active_lang = 1 AND lang.idlang = :idlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	protected function s_count_cms_max(){
		$sql = 'SELECT count(p.idpage) as total
		FROM mc_cms_pages AS p';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}

    /**
     * Compte le nombre de produit dans la langue
     * @param $idlang
     * @return array
     */
    protected function s_catalog_count($idlang){
        $sql = 'SELECT count(cl.idcatalog) AS total
        FROM mc_catalog AS cl
        WHERE cl.idlang = :idlang';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':idlang'	=>	$idlang
        ));
    }

    /*
     * Selectionne les catégories du catalogue
     */
	protected function s_catalog_category($idlang){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle, lang.iso, c.idlang, c.img_c
		FROM mc_catalog_c AS c
		JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE lang.active_lang = 1 AND lang.idlang = :idlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }
    /*
     * Selectionne les sous catégories du catalogue
     */
	protected function s_catalog_subcategory_sitemap($idlang){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle, s.pathslibelle, lang.iso
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE lang.active_lang = 1 AND lang.idlang = :idlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }
    /**
     * Sélections les produits pour la construction du sitemap
     */
    protected function s_catalog_sitemap($idlang){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle,
        card.titlecatalog, card.urlcatalog,card.imgcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE lang.active_lang = 1 AND lang.idlang = :idlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }
    /**
     * @access public
     * Compte le nombre de catégorie par langue + compte le nombre d'image
     */
	protected function c_catalog_category($idlang){
    	$sql = 'SELECT count(c.idclc) as category,count(c.img_c) as catimg, lang.iso, c.idlang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE lang.active_lang = 1 AND lang.idlang = :idlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'=>$idlang
        ));
    }

    /**
     * Selectionne les sous catégorie d'une catégorie pour le sitemap image
     * @param $idclc
     */
    protected function s_catalog_subcategory_images_by_lang($idclc){
    	$sql ='SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle,s.img_s ,s.pathslibelle, lang.iso
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE c.idclc = :idclc AND lang.active_lang = 1';
    	return magixglobal_model_db::layerDB()->select($sql,array(':idclc'=>$idclc));
    }
    /*
     * Compte le nombre d'image et sous catégorie dans la catégorie
     * @param $idclc (integer)
     */
	protected function c_catalog_subcategory($idclc){
    	$sql = 'SELECT s.idclc,count(s.idcls) as category,count(s.img_s) as subcatimg
		FROM mc_catalog_s AS s
		WHERE s.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':idclc'=>$idclc));
    }
    /**
     * Retourne les images produits du catalogue
     */
 	protected function s_catalog_product_images(){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, img.imgcatalog,lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
        LEFT JOIN mc_catalog_img as img USING ( idcatalog)
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE lang.active_lang = 1
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les plugins (répertorié) pour la construction du sitemap
     */
    protected function s_plugin_sitemap(){
    	$sql = 'SELECT s.idplugin,p.pname FROM mc_sitemaps_config as s
    			LEFT JOIN mc_plugins_module AS p ON ( s.idplugin = p.idplugin )';
		return magixglobal_model_db::layerDB()->select($sql);
    }
}