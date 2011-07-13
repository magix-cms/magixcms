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
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name sitemap
 *
 */
class backend_db_sitemap{
	/**
     * Sélections dans les news pour la construction du sitemap
     */
    function s_root_news_sitemap(){
    	$sql = 'SELECT count(n.idnews) AS numbnews,n.date_sent,lang.iso
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE pub.publish = 1 GROUP BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les news pour la construction du sitemap
     */
    function s_news_sitemap(){
    	$sql = 'SELECT n.idnews,n.subject,n.content,lang.iso,n.idlang,n.date_sent,n.rewritelink,pub.date_publication,pub.publish
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE pub.publish = 1 ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
	 * Retourne le nombre maximum de news
	 * @return void
	 */
	function s_count_news_max(){
		$sql = 'SELECT count(n.idnews) as total
		FROM mc_news AS n';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
    /**
     * Sélections dans les pages CMS pour la construction du sitemap
     */
    function s_cms_sitemap(){
    	$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	function s_count_cms_max(){
		$sql = 'SELECT count(p.idpage) as total
		FROM mc_cms_page AS p';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
    /*
     * Selectionne les catégories du catalogue
     */
	function s_catalog_category_sitemap(){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle, lang.iso, c.idlang, c.img_c
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /*
     * Selectionne les sous catégories du catalogue
     */
	function s_catalog_subcategory_sitemap(){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle, s.pathslibelle, lang.iso
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections les produits pour la construction du sitemap
     */
    function s_catalog_sitemap(){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * @access public
     * Compte le nombre de catégorie par langue + compte le nombre d'image
     */
	function count_catalog_category_sitemap_by_lang(){
    	$sql = 'SELECT count(c.idclc) as category,count(c.img_c) as catimg, lang.iso, c.idlang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		GROUP BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Retourne des informations
     * @param $idlang
     */
    function s_catalog_category_images_by_lang($idlang){
    	$sql ='SELECT c.idclc, c.clibelle, c.pathclibelle, c.img_c, lang.iso
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE c.idlang = :idlang';
    	return magixglobal_model_db::layerDB()->select($sql,array(':idlang'=>$idlang));
    }
    /**
     * Selectionne les sous catégorie d'une catégorie pour le sitemap image
     * @param $idclc
     */
    function s_catalog_subcategory_images_by_lang($idclc){
    	$sql ='SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle,s.img_s ,s.pathslibelle, lang.iso
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE c.idclc = :idclc';
    	return magixglobal_model_db::layerDB()->select($sql,array(':idclc'=>$idclc));
    }
    /*
     * Compte le nombre d'image et sous catégorie dans la catégorie
     * @param $idclc (integer)
     */
	function count_catalog_subcategory_sitemap($idclc){
    	$sql = 'SELECT s.idclc,count(s.idcls) as category,count(s.img_s) as subcatimg
		FROM mc_catalog_s AS s
		WHERE s.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':idclc'=>$idclc));
    }
    /**
     * Retourne les images produits du catalogue
     */
 	function s_catalog_product_images(){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, img.imgcatalog,lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
        LEFT JOIN mc_catalog_img as img USING ( idcatalog)
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les plugins (répertorié) pour la construction du sitemap
     */
    function s_plugin_sitemap(){
    	$sql = 'SELECT s.idplugin,p.pname FROM mc_sitemaps_config as s
    			LEFT JOIN mc_plugins_module AS p ON ( s.idplugin = p.idplugin )';
		return magixglobal_model_db::layerDB()->select($sql);
    }
}