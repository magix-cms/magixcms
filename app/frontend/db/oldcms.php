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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_cms{
    /**
     * ################################ Pages ###############################
     */
	/**
	 * Affiche les données d'une page CMS
	 * @param $getpurl
	 */
	protected function s_cms_page($getidpage){
		$sql = 'SELECT p.subjectpage,p.contentpage,p.idlang,lang.iso,c.pathcategory,c.category,p.date_page
				FROM mc_cms_page as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				JOIN mc_cms_category as c ON(c.idcategory = p.idcategory)
				WHERE p.idpage = :getidpage';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getidpage'=>$getidpage
		));
	}
	/**
	 * ######################### Menu ou sidebar #########################
	 */
	/**
	 * sélectionne les pages classique (catégorie + langue)
	 * @param $codelang
	 */
	/*function s_page_cms($codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory, lang.iso
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.iso =:codelang AND p.idcategory != 0
				ORDER BY p.orderpage,c.idorder';
		return magixglobal_model_db::layerDB()->select($sql,array('codelang'=>$codelang));
	}*/
	/**
	 * sélectionne les pages sans la langue
	 */
	/*function s_page_cms_without_lang(){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND p.idlang =0 AND p.idcategory != 0
				ORDER BY p.orderpage,c.idorder';
		return magixglobal_model_db::layerDB()->select($sql);
	}*/
	/**
	 * sélectionne les pages avec une langue et sans catégorie
	 */
	protected function s_root_page_cms($codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang, p.pathpage,p.idcategory,lang.iso
				FROM mc_cms_page AS p
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.iso =:codelang AND p.idcategory = 0
				ORDER BY p.orderpage';
		return magixglobal_model_db::layerDB()->select($sql,array('codelang'=>$codelang));
	}
	/**
	 * Selectionne les pages suivant l'identifiant de la catégorie avec la langue
	 * @param $codelang
	 * @param $idcategory
	 */
	protected function s_page_cms_join_category($idcategory,$codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.iso =:codelang AND p.idcategory = :idcategory
				ORDER BY p.orderpage';
		return magixglobal_model_db::layerDB()->select($sql,array(':idcategory'=>$idcategory,'codelang'=>$codelang));
	}
	/**
	 * Retourne toutes les catégories cms
	 */
	protected function s_all_category_cms(){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				ORDER BY c.idorder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * ################## Sélection des Catégories ##########
	 */
	/**
	 * Selectionne les catégories sans langue
	 */
	public function s_category_cms_without_lang(){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang = 0
				ORDER BY c.idorder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Selectionne les catégories avec une langue
	 * @param $codelang
	 */
	public function s_category_cms($codelang){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,lang.iso,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.iso = :iso
				ORDER BY c.idorder';
		return magixglobal_model_db::layerDB()->select($sql,array(':iso'=>$codelang));
	}
}