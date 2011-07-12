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
 * @copyright  MAGIX CMS Copyright (c) 2010 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.4
 * @id $Id$
 * @version  $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> $Author$
 * @name news
 *
 */
class backend_db_news{
	/**
	 * insertion d'un nouvel enregistrement pour une news
	 * @param $subject
	 * @param $content
	 * @param $idlang
	 * @param $idadmin
	 */
	protected function i_new_news($keynews,$idlang,$idadmin,$n_title,$n_uri,$n_content){
		/*$sql = array('INSERT INTO mc_news (subject,rewritelink,content,idlang,idadmin,date_sent) 
				VALUE('.magixglobal_model_db::layerDB()->escape_string($subject).','.magixglobal_model_db::layerDB()->escape_string($rewritelink).','.magixglobal_model_db::layerDB()->escape_string($content).',"'.$idlang.'","'.$idadmin.'",NOW())',
		'INSERT INTO mc_news_publication (date_publication,publish) VALUE("0000-00-00 00:00:00","0")');
		magixglobal_model_db::layerDB()->transaction($sql);*/
		$sql = 'INSERT INTO mc_news (keynews,idlang,idadmin,n_title,n_uri,n_content)
		VALUE (:keynews,:idlang,:idadmin,:n_title,:n_uri,:n_content)';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':keynews'		=>	$keynews,
			':idlang'		=>	$idlang,
			':idadmin'		=>	$idadmin,
			':n_title'		=>	$n_title,
			':n_uri'		=>	$n_uri,
			':n_content'	=>	$n_content
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
	 * Retourne le nombre maximum de news
	 * @return void
	 */
	protected function s_count_news_pager_max(){
		$sql = 'SELECT count(n.idnews) as total
		FROM mc_news AS n';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Affiche les données (dans les champs) pour une modification
	 * @param $getnews
	 */
	protected function s_news_record($getnews){
		$sql = 'SELECT n.idnews,n.keynews, n.n_title,n.n_uri, n.n_image, n.n_content, n.published, lang.iso, n.idlang, n.date_register, m.pseudo
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( n.idadmin = m.idadmin )
				WHERE n.idnews = :getnews';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getnews'=>$getnews
		));
	}
	/**
	 * 
	 * Enter description here ...
	 */
	protected function s_count_news_by_lang(){
		$sql = 'SELECT count( news.idnews ) AS countnews, lang.iso, lang.language
				FROM mc_news AS news
				LEFT JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
				GROUP BY news.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Mise à jour d'un enregistrement d'une news
	 * @param $subject
	 * @param $content
	 * @param $idlang
	 * @param $idadmin
	 * @param $idnews
	 */
	protected function u_news_page($n_title,$n_uri,$n_content,$idadmin,$date_publish,$published,$idnews){
		$sql = 'UPDATE mc_news 
		SET n_title=:n_title,n_uri=:n_uri, n_content = :n_content,idadmin = :idadmin,date_publish = :date_publish, published=:published 
		WHERE idnews = :idnews';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':n_title'		=>	$n_title,
			':n_uri'		=>	$n_uri,
			':n_content'	=>	$n_content,
			':idadmin'		=>	$idadmin,
			':date_publish'	=>	$date_publish,
			':published'	=>	$published,
			':idnews'		=>	$idnews
		));
	}
	protected function u_status_publication_of_news($idnews,$published){
		switch($published){
			case 0:
				$sql = 'UPDATE mc_news SET date_publish = "0000-00-00 00:00:00",published = 0 WHERE idnews = :idnews';
			break;
			case 1:
				$sql = 'UPDATE mc_news SET date_publish = NOW(),published = 1 WHERE idnews = :idnews';
			break;
		}
		magixglobal_model_db::layerDB()->update($sql,array(
			':idnews' 	 => $idnews
		));
	}
	/**
	 * selectionne le sujet suivant la langue pour la réecriture des métas
	 * @param $codelang
	 */
	protected function s_news_keyword($codelang){
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
	protected function c_news_user(){
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
	protected function d_news($idnews){
		$sql = 'DELETE FROM mc_news WHERE idnews = :idnews';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':idnews' 	=> $idnews
		));
	}
}