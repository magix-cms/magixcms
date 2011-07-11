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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name lang
 *
 */
class backend_db_lang{
    /**
     * retourne la liste des langues disponible
     */
    protected function s_lang(){
    	$sql = 'SELECT lang.* FROM mc_lang AS lang
    	ORDER BY lang.default DESC,lang.idlang ASC';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    protected function s_language_data($getlang){
    	$sql = 'SELECT lang.idlang,lang.iso,lang.language 
    	FROM mc_lang AS lang WHERE idlang = :getlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getlang'			=>	$getlang
		));
    }
	protected function s_exclude_language_data($getlang){
    	$sql = 'SELECT lang.idlang,lang.iso,lang.language 
    	FROM mc_lang AS lang WHERE idlang != :getlang';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':getlang'	=>	$getlang
		));
    }
	/**
     * retourne la liste des langues disponible
     */
    protected function s_full_lang_data(){
    	$sql = 'SELECT lang.iso,lang.idlang,lang.language,lang.default FROM mc_lang AS lang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
     * Vérifie si la langue existe
     */
    protected function s_verif_lang($iso){
    	$sql = 'SELECT lang.idlang FROM mc_lang AS lang WHERE iso = :iso';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'			=>	$iso
		));
    }
	protected function s_lang_edit($idlang){
    	$sql = 'SELECT lang.idlang,lang.iso,lang.language,lang.default FROM mc_lang AS lang WHERE idlang = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }
    /**
     * ajout d'une nouvelle langue
     * @param $iso
     * @param $language
     */
	protected function i_new_lang($iso,$language,$default){
		$sql = 'INSERT INTO mc_lang (iso,language,default) VALUE(:iso,:language,:default)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':iso'	=>	$iso,
			':language'	=>	$language,
			':default'	=>	$default
		));
	}
	/*
	 * Compte et retourne le nombre d'enregistrement dans la table home par langue
	 */
	protected function count_lang_home(){
		$sql ='SELECT count(h.idhome) as countlang,lang.iso,lang.language
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
				GROUP BY h.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/*
	 * Compte et retourne le nombre d'enregistrement dans la table page (cms) par langue
	 */
	protected function count_lang_pages(){
		$sql ='SELECT count(cms.idpage) as countlang,lang.iso,lang.language
				FROM mc_cms_page AS cms
				LEFT JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
				GROUP BY cms.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Compte le nombre de langues dans le module news
	 */
	protected function count_lang_news(){
		$sql = 'SELECT count( news.idnews ) AS countlang, lang.iso, lang.language
				FROM mc_news AS news
				LEFT JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
				GROUP BY news.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Compte le nombre de langues dans le module catalog
	 */
	protected function count_lang_catalog(){
		$sql = 'SELECT count( catalog.idcatalog ) AS countlang, lang.iso, lang.language
				FROM mc_catalog AS catalog
				LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
				GROUP BY catalog.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Compte et additionne le nombre de pages,news,home
	 * @param $idlang
	 */
	protected function global_count($idlang){
		$sql = 'SELECT (count( news.idnews ) + count( cms.idpage )+ count( h.idhome )) as ctotal
				FROM mc_lang as lang
				LEFT JOIN mc_news AS news ON ( news.idlang = lang.idlang )
				LEFT JOIN mc_cms_page AS cms ON ( cms.idlang = lang.idlang )
				LEFT JOIN mc_page_home AS h ON ( h.idlang = lang.idlang )
				WHERE lang.idlang = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(
			':idlang'	=>	$idlang
		));
	}
	protected function u_lang($iso,$language,$idlang){
		$sql = 'UPDATE mc_lang SET iso=:iso,language=:language WHERE idlang = :idlang';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':iso'	=>	$iso,
			':language'	=>	$language,
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