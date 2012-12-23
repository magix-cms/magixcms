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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name lang
 *
 */
class backend_db_lang{
    /**
     * retourne la liste des langues disponible
     */
    protected function s_lang(){
    	$sql = 'SELECT lang.* FROM mc_lang AS lang
    	ORDER BY lang.default_lang DESC,lang.idlang ASC';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * @access protected
     * Retourne les données de la langue sélectionnée
     * @param integer $getlang
     */
    protected function s_language_data($getlang){
    	$sql = 'SELECT lang.idlang,lang.iso,lang.language 
    	FROM mc_lang AS lang WHERE idlang = :getlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getlang'			=>	$getlang
		));
    }
	/**
	 * @access protected
	 * Vérifie si la langue existe déjà dans la table SQL
	 */
    protected function s_verif_lang($iso){
    	$sql = 'SELECT count(lang.idlang) numlang 
    	FROM mc_lang AS lang WHERE lang.iso = :iso';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'	=>	$iso
		));
    }
	/**
	 * @access protected
	 * Retourne le nombre de langue par défaut pour vérification
	 */
    protected function count_default_language(){
    	$sql = 'SELECT count(lang.default_lang) deflanguage 
    	FROM mc_lang AS lang WHERE default_lang = 1';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * @access protected
     * Retourne les données des langues pour l'édition
     * @param integer $idlang
     */
	protected function s_lang_edit($idlang){
    	$sql = 'SELECT lang.idlang,lang.iso,lang.language,lang.default_lang FROM mc_lang AS lang WHERE idlang = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }
    /**
     * ajout d'une nouvelle langue
     * @param $iso
     * @param $language
     */
	protected function i_new_lang($iso,$language,$default_lang){
		$sql = 'INSERT INTO mc_lang (iso,language,default_lang) VALUE(:iso,:language,:default_lang)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':iso'	=>	$iso,
			':language'	=>	$language,
			':default_lang'	=>	$default_lang
		));
	}
	/**
	 * @access protected
	 * Compte le nombre de pages d'accueil et les groupes par langue pour les statistiques
	 */
	protected function count_lang_home(){
		$sql ='SELECT count(h.idhome) as countlang,lang.iso,lang.language
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
				GROUP BY h.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Compte le nombre de pages CMS et les groupes par langue pour les statistiques
	 */
	protected function count_lang_pages(){
		$sql ='SELECT count(cms.idpage) as countpages,lang.iso,lang.language
				FROM mc_cms_pages AS cms
				LEFT JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
				GROUP BY cms.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Compte le nombre de news et les groupes par langue pour les statistiques
	 */
	protected function count_lang_news(){
		$sql = 'SELECT count( news.idnews ) AS countnews, lang.iso, lang.language
				FROM mc_news AS news
				LEFT JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
				GROUP BY news.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Compte le nombre de produits dans le catalogue et les groupes par langue pour les statistiques
	 */
	protected function count_lang_product(){
		$sql = 'SELECT count( catalog.idcatalog ) AS countproduct, lang.iso, lang.language
				FROM mc_catalog AS catalog
				LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
				GROUP BY catalog.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
    protected function s_stats_lang(){
        $sql ='SELECT lang.*,IF(rel_home.home_count>0,rel_home.home_count,0) AS HOME,
        IF(rel_news.news_count>0,rel_news.news_count,0) AS NEWS,
        IF(rel_pages.pages_count>0,rel_pages.pages_count,0) AS PAGES,
        IF(rel_product.product_count>0,rel_product.product_count,0) AS PRODUCT
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang, count( h.idhome ) AS home_count
            FROM mc_page_home AS h
            JOIN mc_lang AS lang ON ( h.idlang = lang.idlang )
            GROUP BY h.idlang
            )rel_home ON ( rel_home.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang, count( n.idnews ) AS news_count
            FROM mc_news AS n
            JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
            GROUP BY n.idlang
            )rel_news ON ( rel_news.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang,count(cms.idpage) AS pages_count
            FROM mc_cms_pages AS cms
            JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
            GROUP BY cms.idlang
            )rel_pages ON ( rel_pages.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang,count( catalog.idcatalog ) AS product_count
            FROM mc_catalog AS catalog
            JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
            GROUP BY catalog.idlang
            )rel_product ON ( rel_product.idlang = lang.idlang )
        GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
	 * Compte et additionne le nombre de pages,news,home
	 * @param $idlang
	 */
	protected function count_idlang_by_module($idlang){
		$sql = 'SELECT (count( news.idnews ) + count( cms.idpage )+ count( h.idhome )) as ctotal
				FROM mc_lang as lang
				LEFT JOIN mc_news AS news ON ( news.idlang = lang.idlang )
				LEFT JOIN mc_cms_pages AS cms ON ( cms.idlang = lang.idlang )
				LEFT JOIN mc_page_home AS h ON ( h.idlang = lang.idlang )
				WHERE lang.idlang = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(
			':idlang'	=>	$idlang
		));
	}
	/**
	 * @access protected
	 * Edition d'une langue
	 * @param string $iso
	 * @param string $language
	 * @param integer $idlang
	 */
	protected function u_lang($iso,$language,$default_lang,$idlang){
		$sql = 'UPDATE mc_lang SET iso=:iso,language=:language,default_lang=:default_lang WHERE idlang = :idlang';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':iso'	=>	$iso,
			':language'	=>	$language,
			':default_lang'	=>	$default_lang,
			':idlang'	=>	$idlang
		));
	}
	/**
	 * 
	 * Modifie le statut de la langue
	 * @param integer $active_lang
	 * @param integer $idlang
	 */
	protected function u_activate_lang_status($active_lang,$idlang){
		$sql = 'UPDATE mc_lang SET active_lang=:active_lang WHERE idlang = :idlang';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':active_lang' =>	$active_lang,
			':idlang'	=>	$idlang
		));
	}
	/**
	 * Suppression de la langue 
	 * @param void $dellang
	 */
	protected function d_lang($dellang){
		$sql = 'DELETE FROM mc_lang WHERE idlang = :dellang';
		magixglobal_model_db::layerDB()->delete($sql,
		array(
				':dellang'	=>	$dellang
		)); 
	}
}