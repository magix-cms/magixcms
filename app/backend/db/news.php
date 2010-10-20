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
 * @version    2.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name news
 *
 */
class backend_db_news{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $admindbnews;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbNews(){
        if (!isset(self::$admindbnews)){
         	self::$admindbnews = new backend_db_news();
        }
    	return self::$admindbnews;
    }
    /**
     * selectionne les news avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    function s_news_plugin($limit=false,$max=null,$offset=null){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
    	$sql = 'SELECT n.idnews,n.subject,n.content,lang.codelang,n.idlang,n.date_sent,n.rewritelink,m.pseudo,pub.date_publication,pub.publish
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_admin_member AS m ON(n.idadmin = m.idadmin) ORDER BY n.idnews DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,false,'assoc');
    }
	/**
	 * insertion d'un nouvel enregistrement pour une news
	 * @param $subject
	 * @param $content
	 * @param $idlang
	 * @param $idadmin
	 */
	function i_new_news($subject,$rewritelink,$content,$idlang,$idadmin){
		$sql = array('INSERT INTO mc_news (subject,rewritelink,content,idlang,idadmin,date_sent) 
				VALUE('.magixglobal_model_db::layerDB()->escape_string($subject).','.magixglobal_model_db::layerDB()->escape_string($rewritelink).','.magixglobal_model_db::layerDB()->escape_string($content).',"'.$idlang.'","'.$idadmin.'",NOW())',
		'INSERT INTO mc_news_publication (date_publication,publish) VALUE("0000-00-00 00:00:00","0")');
		magixglobal_model_db::layerDB()->transaction($sql);
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
	 * Retourne le nombre maximum de news
	 * @return void
	 */
	function s_count_news_pager_max(){
		$sql = 'SELECT count(n.idnews) as total
		FROM mc_news AS n';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Affiche les données (dans les champs) pour une modification
	 * @param $getnews
	 */
	function s_news_record($getnews){
		$sql = 'SELECT n.idnews, n.subject, n.rewritelink, n.content, pub.publish, lang.codelang, n.idlang, n.date_sent, m.pseudo
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON ( n.idnews = pub.idnews )
				LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( n.idadmin = m.idadmin )
				WHERE n.idnews = :getnews';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
		':getnews'=>$getnews
		));
	}
	/**
	 * Mise à jour d'un enregistrement d'une news
	 * @param $subject
	 * @param $content
	 * @param $idlang
	 * @param $idadmin
	 * @param $idnews
	 */
	function u_news_page($subject,$rewritelink,$content,$idlang,$idadmin,$idnews,$date_publication,$publish){
		/*$sql = 'UPDATE mc_news 
		SET subject=:subject,rewritelink = :rewritelink,content=:content,idlang=:idlang,idadmin=:idadmin
		WHERE idnews = :idnews';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':subject'			=>	$subject,
			':rewritelink'		=>	$rewritelink,
			':content'			=>	$content,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':idnews'			=>	$idnews
		));*/
		$sql = array('UPDATE mc_news SET subject='.magixglobal_model_db::layerDB()->escape_string($subject).',rewritelink ='.magixglobal_model_db::layerDB()->escape_string($rewritelink).',content='.magixglobal_model_db::layerDB()->escape_string($content).',idlang="'.$idlang.'",idadmin="'.$idadmin.'" 
		WHERE idnews ='.$idnews,'UPDATE mc_news_publication SET date_publication="'.$date_publication.'",publish="'.$publish.'" WHERE idnews ='.$idnews);
		magixglobal_model_db::layerDB()->transaction($sql);
	}
	/**
	 * selectionne le sujet suivant la langue pour la réecriture des métas
	 * @param $codelang
	 */
	function s_news_keyword($codelang){
		$sql = 'SELECT n.subject
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( n.idadmin = m.idadmin )
				WHERE lang.codelang=:codelang ORDER BY idnews DESC LIMIT 1';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':codelang'=>$codelang
		));
	}
	/**
	 * Retourne le nombre de news par administrateurs
	 * 
	 */
	function c_news_user(){
		$sql = 'SELECT count(n.idnews) as usernews, m.pseudo
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( n.idadmin = m.idadmin )
				GROUP BY n.idadmin';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * supprime un article
	 * @param $idnews
	 */
	function d_news($idnews){
		$sql = array(
		'DELETE FROM mc_news_publication WHERE idnews = "'.$idnews.'"',
		'DELETE FROM mc_news WHERE idnews = "'.$idnews.'"'
		);
		magixglobal_model_db::layerDB()->transaction($sql);
	}
}