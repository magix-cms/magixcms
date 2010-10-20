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
 * @version    1.8.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
class frontend_db_news{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbnews;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function publicDbNews(){
        if (!isset(self::$publicdbnews)){
         	self::$publicdbnews = new frontend_db_news();
        }
    	return self::$publicdbnews;
    }
/**
	 * Affiche les données d'une news
	 * @param $getsubject
	 */
	function s_news_page($getdate,$getnews){
		$sql = 'SELECT n.subject,n.content,lang.codelang,n.idlang,n.date_sent,pub.date_publication
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE n.rewritelink = :getnews AND n.date_sent = :getdate';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getnews'=>$getnews,
			':getdate'=>$getdate
		));
	}
	/**
	 * Retourne le nombre maximum de news publié
	 * @return void
	 */
	function s_count_news_publish_max(){
		$sql = 'SELECT count(pub.idnews) as total 
		FROM mc_news_publication as pub
		WHERE pub.publish = 1';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	function s_news_plugins($limit=false,$max=null,$offset=null){
		$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,pub.date_publication,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND n.idlang = 0 ORDER BY n.date_sent DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Sélectionne toutes les news publié trié par date
	 */
	function s_news_plugins_lang($codelang,$limit=false,$max=null,$offset=null){
		$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,pub.date_publication,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND lang.codelang = :codelang ORDER BY n.date_sent DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,array(':codelang' =>$codelang));
	}
	/**
	 * Sélectionne la dernière news publié
	 */
	function s_lastnews_plugins(){
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,pub.date_publication,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND n.idlang = 0 ORDER BY n.idnews DESC LIMIT 1';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Sélectionne la dernière news publié dans une langue spécifique
	 */
	function s_lastnews_lang_plugins($codelang){
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,pub.date_publication,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND lang.codelang = :codelang ORDER BY n.idnews DESC LIMIT 1';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':codelang' =>$codelang));
	}
}