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
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name cms
 *
 */
class backend_db_cms{
	protected function s_parent_p($getlang){
    	$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idlang = :getlang AND cms.idcat_p = 0
    	ORDER BY cms.order_page';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':getlang' => $getlang
		));
	}
	protected function s_child_page($get_page_p){
		$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idcat_p = :get_page_p
    	ORDER BY cms.order_page';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':get_page_p' => $get_page_p
		));
	}
	private function s_max_parent_order_page($idlang){
    	$sql = 'SELECT max(cms.order_page) porder 
    	FROM mc_cms_pages AS cms
    	WHERE cms.idlang = :idlang AND cms.idcat_p = 0';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }
	private function s_max_child_order_page($get_page_p){
    	$sql = 'SELECT max(cms.order_page) porder 
    	FROM mc_cms_pages AS cms
    	WHERE cms.idcat_p = :get_page_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':get_page_p' => $get_page_p
		));
    }
	protected function s_current_page_p($get_page_p){
    	$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idpage = :get_page_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':get_page_p' => $get_page_p
		));
	}
	protected function s_edit_page($edit){
    	$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idpage = :edit';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit' => $edit
		));
	}
	/**
	 * Affiche les données d'une page CMS
	 * @param $getidpage
	 */
	protected function s_data_parent_page($get_page_p){
		$sql = 'SELECT p.idpage,title_page,uri_page,lang.iso
				FROM mc_cms_pages as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				WHERE p.idpage = :get_page_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':get_page_p'=>$get_page_p
		));
	}
	/*###################### SEARCH #####################*/
	/**
     * @access public
     * Recherche le ou les mots dans le titre des pages
     * @param $searchpage
     */
    public function s_search_page($searchpage){
    	$sql = 'SELECT * FROM mc_cms_pages WHERE title_page LIKE "%:searchpage%"';
    	return magixglobal_model_db::layerDB()->select($sql,array(
			'searchpage' => $searchpage
		));
    }
	/**
	 * Fonctions de recherche de page cms dans les titres
	 * @param $searchpage
	 */
	function r_search_cms_title($searchpage){
		$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo,subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_member AS m ON ( p.idadmin = m.idadmin ) 
		WHERE p.title_page LIKE "%'.$searchpage.'%"';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	protected function i_new_parent_page($idadmin,$idlang,$title_page,$uri_page,$content_page,$seo_title_page,$seo_desc_page){
		$order_page = $this->s_max_parent_order_page($idlang);
		$sql = 'INSERT INTO mc_cms_pages (idadmin,idlang,title_page,uri_page,content_page,seo_title_page,seo_desc_page,order_page) 
		VALUE(:idadmin,:idlang,:title_page,:uri_page,:content_page,:seo_title_page,:seo_desc_page,:order_page)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':idlang'			=>	$idlang,
			':title_page'		=>	$title_page,
			':uri_page'			=>	$uri_page,
			':content_page'		=>	$content_page,
			':seo_title_page'	=>	$seo_title_page,
			':seo_desc_page'	=>	$seo_desc_page,
			':order_page'		=>	$order_page['porder'] + 1
		));
	}
	protected function i_new_child_page($idadmin,$idlang,$idcat_p,$title_page,$uri_page,$content_page,$seo_title_page,$seo_desc_page){
		$order_page = $this->s_max_child_order_page($idlang);
		$sql = 'INSERT INTO mc_cms_pages (idadmin,idlang,idcat_p,title_page,uri_page,content_page,seo_title_page,seo_desc_page,order_page) 
		VALUE(:idadmin,:idlang,:idcat_p,:title_page,:uri_page,:content_page,:seo_title_page,:seo_desc_page,:order_page)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':idlang'			=>	$idlang,
			':idcat_p'			=>	$idcat_p,
			':title_page'		=>	$title_page,
			':uri_page'			=>	$uri_page,
			':content_page'		=>	$content_page,
			':seo_title_page'	=>	$seo_title_page,
			':seo_desc_page'	=>	$seo_desc_page,
			':order_page'		=>	$order_page['porder'] + 1
		));
	}
	protected function u_page($idadmin,$title_page,$uri_page,$content_page,$seo_title_page,$seo_desc_page,$edit){
		$sql = 'UPDATE mc_cms_pages 
		SET idadmin=:idadmin,title_page=:title_page,uri_page=:uri_page,content_page=:content_page,seo_title_page=:seo_title_page,seo_desc_page=:seo_desc_page
		WHERE idpage = :edit';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':title_page'		=>	$title_page,
			':uri_page'			=>	$uri_page,
			':content_page'		=>	$content_page,
			':seo_title_page'	=>	$seo_title_page,
			':seo_desc_page'	=>	$seo_desc_page,
			':edit'				=>	$edit
		));
	}
}