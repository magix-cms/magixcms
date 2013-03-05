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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.8.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
class frontend_db_news{
	/**
	 * Sélectionne les news par langue avec options pour une pagination
	 * @param string $iso
	 * @param integer $limit
	 * @param integer $max
	 * @param integer $offset
	 */
	protected function s_list_news($iso,$limit=false,$max=null,$offset=null){
		$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT n.*,lang.iso FROM mc_news AS n
		LEFT JOIN mc_lang AS lang USING(idlang) 
		WHERE lang.iso = :iso AND n.published = 1 ORDER BY n.date_register DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'=>$iso
		));
	}
	/**
	 * @access private
	 * Sélectionne la liste des news
	 * @param string $iso
	 * @param integer $limit
	 */
	protected function s_home_list_news($iso,$limit){
		$sql = 'SELECT n.*,lang.iso FROM mc_news AS n
		LEFT JOIN mc_lang AS lang USING(idlang) 
		WHERE lang.iso = :iso AND published = 1 ORDER BY date_register DESC LIMIT 0,'.$limit;
		return magixglobal_model_db::layerDB()->select($sql,array(
			':iso'=>$iso
		));
	}
	/**
	 * @access protected
	 * Retourne la news sélectionné
	 * @param string $keynews
	 * @param string $date_register
	 */
	protected function s_specific_news($keynews,$date_register){
		$sql = 'SELECT n.*,lang.iso FROM mc_news AS n
		LEFT JOIN mc_lang AS lang USING(idlang)
		WHERE n.keynews = :keynews AND CAST(n.date_register AS DATE) = CAST(:date_register AS DATE)';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':keynews' 	 	=> $keynews,
			':date_register'=> $date_register
		));
	}
    /**
     * Retourne la liste des news
     * @param string $iso
     * @param integer $limit
     * @param integer $max
     * @param integer $offset
     */
    protected function s_news($iso,$limit=false,$max=null,$offset=null,$sort_id=null,$sort_type=null){
        $where_clause = 'WHERE n.published = 1 AND lang.iso = :iso';
        if ($sort_id != null){
            $where_clause .= ' AND n.idnews';
            $where_clause .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $where_clause .= $sort_id;
            $where_clause .= ') ';
        }
        $order_clause = 'ORDER BY n.date_register DESC';
        $limit_clause = $limit ? ' LIMIT '.$max : '';
        $offset_clause = !empty($offset) ? ' OFFSET '.$offset: '';

        $sql = "SELECT n.idnews,n.n_title,n.n_content,n.n_image,n.n_uri,n.idlang,n.date_register,n.date_publish,n.keynews,lang.iso
				FROM mc_news as n
				JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				{$where_clause}
				{$order_clause}
				{$limit_clause}
				{$offset_clause}";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':iso'=>$iso
        ));
    }
    /**
     * Retourne la liste des news suivant list de Tag
     * @param string $iso
     * @param integer $tag
     * @param integer $limit
     */
    protected function s_news_in_tag($iso,$sort_tag,$sort_type='select',$limit=null){
        $tag = explode(',',$sort_tag);
        $i = 0;
        $where_clause = ' AND lang.iso = \''.$iso.'\'';
        $where_clause .= ' AND tag.name_tag';
        $where_clause .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
        foreach($tag as $tag_name) {
            $where_clause .= ($i == 0) ? '' : ',';
            $where_clause .= ' \''.$tag_name.'\'';
            $i = 1;
        }
        $where_clause .= ')';
        $where_clause .= ' GROUP BY news.idnews ';
        $limit_clause = $limit ? ' LIMIT '.$limit : '';
        $sql = "SELECT news.*,lang.iso
        FROM mc_news_tag as tag
		LEFT JOIN mc_news AS news ON (tag.idnews = news.idnews)
		LEFT JOIN mc_lang AS lang on (news.idlang = lang.idlang)
        WHERE news.published = 1
          {$where_clause}
        ORDER BY news.date_register DESC
        {$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * Return all tag in language grouped by name and related to published news
     * @param string $lang_iso
     * @return array
     */
    protected function s_tag_all($lang_iso){
        $sql = 'SELECT tag.name_tag, lang.iso
            FROM mc_news_tag AS tag
            LEFT JOIN mc_news AS news ON (news.idnews = tag.idnews)
            LEFT JOIN mc_lang AS lang ON (lang.idlang = news.idlang)
            WHERE lang.iso = :lang_iso AND news.published = 1
            GROUP BY tag.name_tag';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':lang_iso'=> $lang_iso
        ));
    }
    /**
     * Retourne la liste des tag liées à une news
     * @access protected
     * @param int $idnews
     */
    protected function s_tagByNews($idnews){
        $sql ='SELECT
              tag.*
			FROM mc_news_tag AS tag
			WHERE idnews = :idnews';
        return magixglobal_model_db::layerDB()->select(
            $sql,
            array('idnews'=>$idnews)
        );
    }
    /**
     *
     * Retourne le nombre total de news pour la langue
     * @param string $iso
     */
    protected function s_news_lang_total($iso){
        $sql = 'SELECT count(n.idnews) as total FROM mc_news AS n
		JOIN mc_lang AS lang USING(idlang)
		WHERE lang.iso = :iso AND n.published = 1';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':iso'=>$iso
        ));
    }
}