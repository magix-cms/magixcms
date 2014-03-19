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
 * @copyright  MAGIX CMS Copyright (c) 2010 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.4
 * @id $Id$
 * @version  $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> $Author$
 * @name news
 *
 */
class backend_db_news{
    /*######################## Statistiques ##############################*/
    /**
     * @return array
     */
    protected function s_stats_pages(){
        $sql = 'SELECT lang.iso, IF( p.page_count >0, p.page_count, 0 ) AS PAGES,
        IF( t.tag_count >0, t.tag_count, 0 ) AS TAGS
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( news.idnews ) AS page_count
            FROM mc_news AS news
            JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
            GROUP BY news.idlang
            )p ON ( p.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, tag.idnews_tag, count( tag.idnews_tag ) AS tag_count
            FROM mc_news AS news
            JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
            JOIN mc_news_tag AS tag ON ( tag.idnews = news.idnews )
            GROUP BY news.idlang
            )t ON ( t.idlang = lang.idlang )
        GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
    /*
     * LISTES
     * */
    /**
     * @param bool $limit
     * @param null $max
     * @param null $offset
     * @return array
     */
    protected function s_news_list($getlang,$limit=false,$max=null,$offset=null){
        $limit = $limit ? ' LIMIT '.$max : '';
        $offset = !empty($offset) ? ' OFFSET '.$offset: '';
        $sql = 'SELECT n.idnews,n.keynews,n.n_title,n.n_image,n.n_content,lang.iso,n.idlang,
        n.date_register,n.n_uri,m.pseudo_admin,n.date_publish,n.published
        FROM mc_news AS n
        JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
        JOIN mc_admin_employee AS m ON ( n.idadmin = m.id_admin )
        WHERE n.idlang = :getlang
        ORDER BY n.idnews DESC'.$limit.$offset;
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'	=>	$getlang
        ));
    }

    /**
     * insertion d'un nouvel enregistrement pour une news
     * @param $keynews
     * @param $getlang
     * @param $idadmin
     * @param $n_title
     * @param $n_uri
     */
    protected function i_news($keynews,$getlang,$idadmin,$n_title,$n_uri){
		$sql = 'INSERT INTO mc_news (keynews,idlang,idadmin,n_title,n_uri)
		VALUE (:keynews,:getlang,:idadmin,:n_title,:n_uri)';
		magixglobal_model_db::layerDB()->insert($sql,array(
			':keynews'		=>	$keynews,
			':getlang'		=>	$getlang,
			':idadmin'		=>	$idadmin,
			':n_title'		=>	$n_title,
			':n_uri'		=>	$n_uri
		));
	}

    /**
     * @access protected
     * Retourne le nombre maximum de news
     * @param $idlang
     * @return void
     */
	protected function s_count_max_news($idlang){
        $sql = 'SELECT count(n.idnews) as total
		FROM mc_news AS n
		WHERE n.idlang = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
            ':idlang'	=>	$idlang
            )
        );
	}

    /**
     * @access protected
     * Affiche les données (dans les champs) pour une modification
     * @param $edit
     * @return array
     */
	protected function s_news_data($edit){
		$sql = 'SELECT n.*, lang.iso, rel.WORD_LIST
        FROM mc_news AS n
        LEFT OUTER JOIN (
            SELECT tag.idnews, GROUP_CONCAT( tag.name_tag ORDER BY tag.idnews_tag SEPARATOR "," ) AS WORD_LIST
                FROM mc_news_tag AS tag
                GROUP BY tag.idnews
            )rel ON ( rel.idnews = n.idnews )
        JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
        JOIN mc_admin_employee AS m ON ( n.idadmin = m.id_admin )
        WHERE n.idnews = :edit';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit'=>$edit
		));
	}

    /**
     * @access protected
     * Sélectionne l'image de la news
     * @param $edit
     * @return array
     */
	protected function s_n_image_news($edit){
		$sql = 'SELECT n.n_image FROM mc_news AS n
		WHERE n.idnews = :edit';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit' => $edit
		));
	}
	/**
	 * @access protected
	 * Retourne la liste des tags de l'agenda courant
	 * @access protected
	 * @param integer $edit
	 */
	protected function s_list_tag($edit){
		$sql = 'SELECT at.* FROM mc_news_tag AS at
		WHERE idnews = :edit';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':edit'	=>	$edit
		));
	}

	/**
     * @access public
     * Recherche le ou les mots dans le titre des news
     * @param $searchpage
     */
    public function s_search_news($news_search){
    	$sql = 'SELECT n.idnews,n.keynews, n.n_title,n.n_uri,lang.iso, n.idlang, n.date_register
    	FROM mc_news as n
        JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
    	WHERE n_title LIKE :news_search';
    	return magixglobal_model_db::layerDB()->select($sql,array(
            ':news_search'=>'%'.$news_search.'%'
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
	protected function u_news_page($n_title,$n_uri,$n_content,$idadmin,$date_publish,$published,$edit){
		$sql = 'UPDATE mc_news 
		SET n_title=:n_title,n_uri=:n_uri, n_content = :n_content, idadmin = :idadmin,
		date_publish = :date_publish, published=:published
		WHERE idnews = :edit';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':n_title'		=>	$n_title,
			':n_uri'		=>	$n_uri,
			':n_content'	=>	$n_content,
			':idadmin'		=>	$idadmin,
			':date_publish'	=>	$date_publish,
			':published'	=>	$published,
			':edit'		=>	$edit
		));
	}
	/**
	 * @access protected
	 * Mise à jour de l'image de la news
	 * @param string $n_image
	 * @param integer $idnews
	 */
	protected function u_news_image($n_image,$idnews){
		$sql = 'UPDATE mc_news SET n_image = :n_image
		WHERE idnews = :idnews';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':n_image'		=>	$n_image,
			':idnews'		=>	$idnews
		));
	}
	/**
	 * @access protected
	 * Mise à jour du statut des news
	 * @param integer $idnews
	 * @param statut $published
	 */
	protected function u_status_published($idnews,$published){
		switch($published){
			case 0:
				$sql = 'UPDATE mc_news SET published = :published WHERE idnews = :idnews';
			break;
			case 1:
				$sql = 'UPDATE mc_news SET date_publish = NOW(),published = :published WHERE idnews = :idnews';
			break;
		}
		magixglobal_model_db::layerDB()->update($sql,array(
			':idnews' 	 => $idnews,
            ':published' => $published
		));
	}
	/**
	 * @access protected
	 * selectionne le sujet suivant la langue pour la réecriture des métas
	 * @param $codelang
	 */
	/*protected function s_news_keyword($codelang){
		$sql = 'SELECT n.subject
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( n.idadmin = m.idadmin )
				WHERE lang.codelang=:codelang ORDER BY idnews DESC LIMIT 1';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':codelang'=>$codelang
		));
	}*/
	/**
	 * Retourne le nombre de news par administrateurs
	 * 
	 */
	protected function c_news_user(){
		$sql = 'SELECT count(n.idnews) as usernews, m.pseudo_admin
				FROM mc_news AS n
				JOIN mc_lang AS lang ON ( n.idlang = lang.idlang )
				JOIN mc_admin_employee AS m ON ( n.idadmin = m.id_admin )
				GROUP BY n.idadmin';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Insertion d'un tag dans une news
	 * @param string $name_tag
	 * @param integer $edit
	 */
	protected function i_reltag($name_tag,$edit){
		$sql = 'INSERT INTO mc_news_tag (name_tag,idnews) 
		VALUE(:name_tag,:edit)';
		magixglobal_model_db::layerDB()->insert($sql,array(
			':name_tag'	=>	$name_tag,
			':edit'	=>	$edit
		));
	}
	/**
	 * @access protected
	 * supprime un article
	 * @param $idnews
	 */
	protected function d_news($idnews){
		$sql = 'DELETE FROM mc_news WHERE idnews = :idnews';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':idnews' 	=> $idnews
		));
	}
	/**
	 * @access protected
	 * Suppression d'un tag des news
	 * @param integer $del_tag
	 */
	protected function d_tagnews($edit,$delete_tag){
		/*$sql = 'DELETE FROM mc_news_tag WHERE idnews_tag = :delete_tag';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':delete_tag' => $delete_tag
		));*/
        $sql = 'DELETE FROM mc_news_tag
        WHERE idnews = :edit AND name_tag = :delete_tag';
        magixglobal_model_db::layerDB()->delete($sql,array(
            ':delete_tag'	=>	$delete_tag,
            ':edit'	=>	$edit
        ));
	}
}