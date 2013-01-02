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
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name cms
 *
 */
class frontend_db_cms{
    /**
     * ################################ Pages ###############################
     */
	/**
	 * Collecte les données d'une page CMS
	 * @param $getidpage
	 */
	protected function s_data_current_page($iso,$getidpage){
		$sql = 'SELECT p.idpage,p.idcat_p,title_page,uri_page,content_page,seo_title_page,seo_desc_page,date_register,last_update,lang.iso
				FROM mc_cms_pages as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				WHERE lang.iso = :iso AND p.idpage = :getidpage';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':iso'=>$iso,
			':getidpage'=>$getidpage
		));
	}
	/**
	 * Collecte les données d'une page CMS
	 * @param $getidpage
	 */
	protected function s_data_parent_page($getidpage_p){
		$sql = 'SELECT p.idpage,title_page,uri_page,lang.iso
				FROM mc_cms_pages as p
				JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				WHERE p.idpage = :getidpage_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getidpage_p'=>$getidpage_p
		));
	}

    /**
     * @access protected
     * Collecte les pages de premier niveaux (parents)
     * @param string $lang_iso
     * @param string/numéric $sort_id
     * @param string $sort_type
     * @param numeric $limit
     * @param numeric $level
     */
    protected function s_page($lang_iso,$sort_id=null,$sort_type=null,$limit=null){
        $where_clause = null;
        if ($sort_id != null) {
            $where_clause = 'AND p.idpage';
            $where_clause .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $where_clause .= $sort_id;
            $where_clause .= ') ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        $sql = "SELECT p.idpage,p.title_page,p.uri_page,p.content_page,lang.iso
    	FROM mc_cms_pages AS p
    	JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
    	WHERE lang.iso = :lang_iso AND sidebar_page = 1 AND p.idcat_p = 0
    	  {$where_clause}
    	ORDER BY p.order_page
    	  {$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':lang_iso' => $lang_iso
        ));
    }

    /**
     * @access protected
     * Collecte les pages de second niveaux (enfants)
     * @param string $lang_iso
     * @param string/numéric $sort_id
     * @param string $sort_type
     * @param numeric $limit
     * @param numeric $level
     */
    protected function s_page_child($lang_iso,$sort_id,$sort_type=null,$limit=null){
        if(isset($sort_id)){
            $where_clause = 'AND p.idcat_p ';
            $where_clause .= ($sort_type != 'exclude') ?' IN (' : ' NOT IN (';
            $where_clause .= $sort_id;
            $where_clause .= ') ';
        }else{
            $where_clause = 'AND p.idcat_p != 0 ';
        }
        $limit_clause = null;
        if (is_int($limit)){
            $limit_clause = 'LIMIT '.$limit;
        }
        // ### Querry
        $sql = "
        SELECT p.idpage,p.title_page,p.uri_page,p.content_page,lang.iso,p.idcat_p,page_p.uri_page_p
    	FROM mc_cms_pages AS p
        JOIN (
            SELECT idpage AS idpage_p, uri_page AS uri_page_p
            FROM mc_cms_pages
        ) as page_p on (page_p.idpage_p = p.idcat_p)
    	JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
    	WHERE lang.iso = :lang_iso AND p.sidebar_page = 1
    	  {$where_clause}
    	ORDER BY p.order_page
    	  {$limit_clause}";
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':lang_iso' => $lang_iso
        ));
    }


}