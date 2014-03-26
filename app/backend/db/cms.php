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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name cms
 *
 */
class backend_db_cms{
    /**
     * @access protected
     * Sélectionne les pages parentes dans la langue
     * @param integer $getlang
     * @param $select_role
     * @return array
     */
	protected function s_parent_p($getlang){
    	$sql = 'SELECT cms.*,lang.iso
        FROM mc_cms_pages AS cms
        JOIN mc_admin_employee AS m ON(m.id_admin=cms.idadmin)
        JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
        WHERE cms.idlang = :getlang AND cms.idcat_p = 0
        ORDER BY cms.order_page';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':getlang' => $getlang
		));
	}
	/**
	 * @access protected
	 * Sélectionne les pages enfants du parent
	 * @param integer $get_page_p
	 */
	protected function s_child_page($get_page_p){
		$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms
    	JOIN mc_admin_employee AS m ON(m.id_admin=cms.idadmin)
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idcat_p = :get_page_p
    	ORDER BY cms.order_page';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':get_page_p' => $get_page_p
		));
	}
	/**
	 * @access protected
	 * Compte le nombre de page parente dans la langue
	 * @param integer $idlang
	 */
	private function s_max_parent_order_page($idlang){
    	$sql = 'SELECT count(cms.order_page) porder 
    	FROM mc_cms_pages AS cms
    	WHERE cms.idlang = :idlang AND cms.idcat_p = 0';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }
    /**
     * @access protected
     * Compte le nombre de page enfant du parent
     * @param integer $get_page_p
     */
	private function s_max_child_order_page($get_page_p){
    	$sql = 'SELECT count(cms.order_page) porder 
    	FROM mc_cms_pages AS cms
    	WHERE cms.idcat_p = :get_page_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':get_page_p' => $get_page_p
		));
    }
	/*private function s_max_related_lang_order_page($idlang){
    	$sql = 'SELECT count(cms.order_page) porder 
    	FROM mc_cms_pages AS cms
    	WHERE cms.idlang_p = :idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }*/
    /**
     * @access protected
     * Retourne les données de la page parente pour la page courante
     * @param integer $get_page_p
     */
	protected function s_current_page_p($get_page_p){
    	$sql = 'SELECT cms.*,lang.iso
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idpage = :get_page_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':get_page_p' => $get_page_p
		));
	}
	/**
	 * @access protected
	 * Retourne les données pour l'édition de la page
	 * @param integer $edit
	 */
	protected function s_edit_page($edit){
    	$sql = 'SELECT cms.*,lang.iso,rel.parent_title
    	FROM mc_cms_pages AS cms
    	LEFT OUTER JOIN (
            SELECT parent.idpage,parent.title_page AS parent_title
            FROM mc_cms_pages AS parent
        )rel ON (rel.idpage = cms.idcat_p)
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idpage = :edit';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit' => $edit
		));
	}
	/**
	 * @access protected
	 * Retourne les pages relative dans une autre langue
	 * @param integer $getlang_p
	 */
	protected function s_child_lang_current_page($getlang_p){
    	$sql = 'SELECT relang.idrel_lang,p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo_admin,subp.uri_page as uri_category
		FROM mc_cms_rel_lang AS relang
		LEFT JOIN mc_cms_pages p ON(relang.idlang_p=p.idpage)
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_employee AS m ON ( p.idadmin = m.id_admin )
		WHERE relang.idpage = :getlang_p';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':getlang_p' => $getlang_p
		));
	}
	/**
	 * @access protected
	 * Vérifie si la page contient une relation dans cette langue
	 * @param integer $edit
	 * @param integer $idlang_p
	 */
	protected function verify_rel_lang($edit,$idlang_p){
		$sql = 'SELECT count(relang.idrel_lang) as rel_lang_count 
		FROM mc_cms_rel_lang AS relang
		WHERE relang.idpage = :edit AND relang.idlang_p = :idlang_p';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit'=>$edit,
			':idlang_p'=>$idlang_p
		));
	}
	/**
	 * @access protected
	 * Compte le nombre d'enfant de la page parente
	 * @param integer $idpage
	 */
	protected function verify_idcat_p($idpage){
		$sql = 'SELECT count(p.idcat_p) as childpages 
		FROM mc_cms_pages AS p
		WHERE p.idcat_p = :idpage';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idpage'=>$idpage
		));
	}
	/*protected function s_child_lang_page($idlang_p){
    	$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo,subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_employee AS m ON ( p.idadmin = m.idadmin )
    	WHERE p.idpage = :idlang_p';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idlang_p' => $idlang_p
		));
	}*/
	/**
	 * @access protected
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
			':searchpage' => $searchpage
		));
    }
	/**
     * @deprecated
	 * Fonctions de recherche de page cms dans les titres
	 * @param $searchpage
     * @return array
     */
	/*public function r_search_cms_title($searchpage){
		$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p,
		p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo,subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_employee AS m ON ( p.idadmin = m.idadmin ) 
		WHERE p.title_page LIKE :searchpage';
		return magixglobal_model_db::layerDB()->select($sql,array(
            ':searchpage'=>'%'.$searchpage.'%'
        ));
	}*/
	/*######################## Statistiques ##############################*/
    /**
     * Retourne les statistiques des pages
     * @return array
     */
    protected function s_stats_pages(){
        $sql = 'SELECT lang.iso, IF(parent.p_count>0,parent.p_count,0) AS PARENT,
        IF(child.p_count>0,child.p_count,0) AS CHILD
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang,lang.iso,count(cms.idpage) as p_count
            FROM mc_cms_pages AS cms
            JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
            WHERE cms.idcat_p = 0
            GROUP BY cms.idlang
        )parent ON (parent.idlang = lang.idlang)
        LEFT OUTER JOIN (
            SELECT lang.idlang,lang.iso,count(cms.idpage) as p_count
            FROM mc_cms_pages AS cms
            JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
            WHERE cms.idcat_p != 0
            GROUP BY cms.idlang
        )child ON (child.idlang = lang.idlang)
		GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
	 * @access protected
	 * Compte le nombre de page parente par langue
	 */
	protected function count_lang_parent_p(){
		$sql = 'SELECT lang.iso,count(cms.idpage) as parent_p_count 
		FROM mc_cms_pages AS cms
		JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
		WHERE cms.idcat_p = 0
		GROUP BY cms.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Compte le nombre de page enfant par langue
	 */
	protected function count_lang_child_p(){
		$sql = 'SELECT lang.iso,count(cms.idpage) as child_p_count 
		FROM mc_cms_pages AS cms
		JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
		WHERE cms.idcat_p != 0
		GROUP BY cms.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Compte le nombre de page relative dans chaque langue
	 */
	protected function count_related_lang(){
		$sql = 'SELECT count(relang.idpage) as rel_lang_child 
		FROM mc_cms_rel_lang AS relang
		GROUP BY relang.idpage';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Retourne les langues pour la constitution des statistiques
	 */
	protected function s_iso_lang(){
    	$sql = 'SELECT lang.iso FROM mc_lang AS lang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /*###################### AUTOCOMPLETE #########################*/
    /**
     *
     * Recherche une page dans la langue sélectionner
     * @param $title_search
     * @param $getlang
     * @return array
     */
	protected function s_title_search($title_search,$getlang){
		$sql = 'SELECT p.idpage, p.title_page, p.idlang
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS parent ON ( parent.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_employee AS m ON ( p.idadmin = m.id_admin )
		WHERE p.idlang = :idlang AND p.title_page LIKE :title_search';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idlang'=>$getlang,
            ':title_search'=>'%'.$title_search.'%'
		));
	}
    /* ############## SEARCH #############*/
    protected function s_page_url($page_search){
        $sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p,
		p.uri_page AS url_page, subp.uri_page as url_category, subp.title_page as page_category,lang.iso
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.title_page LIKE :page_search';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':page_search'=>'%'.$page_search.'%'
        ));
    }
    /**
     * 
     * Recherche une page dans la langue sélectionner
     * @param string $title_p_lang
     * @param integer $idlang
     */
	protected function s_cat_p_lang($title_p_lang,$idlang){
		$sql = 'SELECT p.idpage, p.title_page, p.content_page,p.idlang,p.idcat_p, p.uri_page,p.seo_title_page,p.seo_desc_page, lang.iso, m.pseudo_admin,subp.uri_page as uri_category
		FROM mc_cms_pages AS p
		LEFT JOIN mc_cms_pages AS subp ON ( subp.idpage = p.idcat_p )
		JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		JOIN mc_admin_employee AS m ON ( p.idadmin = m.id_admin )
		WHERE p.idlang = :idlang AND p.title_page LIKE "%'.$title_p_lang.'%"';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idlang'=>$idlang
		));
	}
	/* ########################### module page maximum ######################*/
	/**
	 * Retourne le nombre maximum de pages par langue
	 * @return void
	 */
	protected function s_count_page_max_by_language($getlang){
		$sql = 'SELECT count(cms.idpage) as total
    	FROM mc_cms_pages AS cms 
    	JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
    	WHERE cms.idlang = :getlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getlang' => $getlang
		));
	}
	/* ########################### Insertion #############################*/
	/**
	 * 
	 * Insertion d'une nouvelle page parent
	 * @param integer $idadmin
	 * @param integer $idlang
	 * @param string $title_page
	 * @param string $uri_page
	 * @param string $content_page
	 * @param string $seo_title_page
	 * @param string $seo_desc_page
	 */
	protected function i_new_parent_page($idadmin,$idlang,$title_page,$uri_page){
		$order_page = $this->s_max_parent_order_page($idlang);
		$sql = 'INSERT INTO mc_cms_pages (idadmin,idlang,title_page,uri_page,date_register,order_page)
		VALUE(:idadmin,:idlang,:title_page,:uri_page,NOW(),:order_page)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':idlang'			=>	$idlang,
			':title_page'		=>	$title_page,
			':uri_page'			=>	$uri_page,
			':order_page'		=>	$order_page['porder'] + 1
		));
	}
	/**
	 * @access protected
	 * insertion d'une nouvelle page enfant dans un parent
	 * @param integer $idadmin
	 * @param integer $idlang
	 * @param integer $idcat_p
	 * @param string $title_page
	 * @param string $uri_page
	 * @param string $content_page
	 * @param string $seo_title_page
	 * @param string $seo_desc_page
	 */
	protected function i_new_child_page($idadmin,$idlang,$get_page_p,$title_page,$uri_page){
		$order_page = $this->s_max_child_order_page($get_page_p);
		$sql = 'INSERT INTO mc_cms_pages (idadmin,idlang,idcat_p,title_page,uri_page,date_register,order_page)
		VALUE(:idadmin,:idlang,:get_page_p,:title_page,:uri_page,NOW(),:order_page)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':idlang'			=>	$idlang,
			':title_page'		=>	$title_page,
			':uri_page'			=>	$uri_page,
            ':get_page_p'	    =>	$get_page_p,
			':order_page'		=>	$order_page['porder'] + 1
		));
	}
	/**
	 * @access protected
	 * Insertion d'une nouvelle relation de langue
	 * @param integer $edit
	 * @param integer $idlang_p
	 */
	protected function i_new_rel_lang($edit,$idlang_p){
		$sql = 'INSERT INTO mc_cms_rel_lang (idpage,idlang_p) 
		VALUE(:edit,:idlang_p)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':edit'				=>	$edit,
			':idlang_p'			=>	$idlang_p,
		));
	}
	/**
	 * @access protected
	 * Modifie une page CMS
	 * @param integer $idadmin
	 * @param string $title_page
	 * @param string $uri_page
	 * @param string $content_page
	 * @param string $seo_title_page
	 * @param string $seo_desc_page
	 * @param integer $edit
	 */
	protected function u_page($idadmin,$title_page,$uri_page,$content_page,$seo_title_page,$seo_desc_page,$edit){
		$sql = 'UPDATE mc_cms_pages 
		SET idadmin=:idadmin,title_page=:title_page,uri_page=:uri_page,content_page=:content_page,seo_title_page=:seo_title_page,seo_desc_page=:seo_desc_page
		WHERE idpage = :edit';
		magixglobal_model_db::layerDB()->update($sql,
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
	/**
	 * Met à jour l'ordre d'affichage des pages
	 * @param $i
	 * @param $id
	 */
	protected function u_orderpage($i,$id){
		$sql = 'UPDATE mc_cms_pages SET order_page = :i WHERE idpage = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * @access protected
	 * Mise à jour du status de la page CMS
	 * @param integer $sidebar_page
	 * @param integer $idpage
	 */
	protected function u_status_sidebar_page($sidebar_page,$idpage){
		$sql = 'UPDATE mc_cms_pages SET sidebar_page = :sidebar_page WHERE idpage = :idpage';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':sidebar_page'	=>	$sidebar_page,
			':idpage'		=>	$idpage
			)
		);
	}
	protected function u_move_page($idlang,$idcat_p,$movepage){
		$sql = 'UPDATE mc_cms_pages 
		SET idlang=:idlang,idcat_p=:idcat_p
		WHERE idpage=:movepage';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':idlang'		=>	$idlang,
			':idcat_p'		=>	$idcat_p,
			':movepage'		=>	$movepage
		));
	}
	/**
	 * @access protected
	 * Supprime une relation de page
	 * @param integer $delrelangpage
	 */
	protected function d_rel_lang_p($delrelangpage){
		$sql = 'DELETE FROM mc_cms_rel_lang WHERE idrel_lang = :delrelangpage';
		magixglobal_model_db::layerDB()->delete($sql,
		array(
			':delrelangpage'=>$delrelangpage
		));
	}
	/**
	 *  @access protected
	 * Supprime une page CMS
	 * @param integer $delpage
	 */
	protected function d_page($delpage){
		$sql = 'DELETE FROM mc_cms_pages WHERE idpage = :delpage';
		magixglobal_model_db::layerDB()->delete($sql,
		array(
			':delpage'=>$delpage
		));
	}
}