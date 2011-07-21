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
class frontend_db_block_news{
	/**
	 * Affiche les données métas d'une page CMS
	 * @param $getpurl
	 */
	public function s_lastnews_plugins($iso){
		$sql = 'SELECT n.n_title,n.n_content,n.n_uri,n.idlang,n.date_register,n.date_publish,n.keynews,lang.iso
				FROM mc_news as n
				JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE n.published = 1 AND lang.iso = :iso ORDER BY n.idnews DESC LIMIT 1';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':iso' =>$iso));
	}
	/**
	 * 
	 * Enter description here ...
	 * @param string $iso
	 */
	public function s_count_news($iso){
		$sql = 'SELECT count(n.idnews) as total FROM mc_news AS n
		JOIN mc_lang AS lang USING(idlang)
		WHERE lang.iso = :iso AND n.published = 1';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'=>$iso
		));
	}
	/**
	 * 
	 * Retourne la liste des news avec la pagination
	 * @param string $iso
	 * @param integer $limit
	 * @param integer $max
	 * @param integer $offset
	 */
	public function s_news_listing($iso,$limit=false,$max=null,$offset=null){
		$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT n.idnews,n.n_title,n.n_content,n.n_image,n.n_uri,n.idlang,n.date_register,n.date_publish,n.keynews,lang.iso
				FROM mc_news as n
				JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE n.published = 1 AND lang.iso = :iso 
				ORDER BY n.date_register DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'=>$iso
		));
	}
	/**
	 * @access public
	 * Sélectionne les tags de la news
	 * @param integer $idnews
	 */
	public function s_news_tag($idnews){
		$sql = 'SELECT tag.* 
				FROM mc_news_tag AS tag
				WHERE idnews = :idnews';
		return magixglobal_model_db::layerDB()->select($sql,array('idnews'=>$idnews));
	}
	/**
	 * @access protected
	 * 
	 */
	public function s_sort_tagnews($tagnews){
		$sql = 'SELECT n.*,lang.iso FROM mc_news AS n
		LEFT JOIN mc_lang AS lang USING(idlang) 
		LEFT JOIN mc_news_tag as tag USING(idnews)
		WHERE tag.name_tag LIKE "%'.$tagnews.'%" AND published = 1 
		ORDER BY n.date_register DESC';
		return magixglobal_model_db::layerDB()->select($sql);
	}
}