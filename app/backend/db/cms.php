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
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name cms
 *
 */
class backend_db_cms{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $admindbcms;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbCms(){
        if (!isset(self::$admindbcms)){
         	self::$admindbcms = new backend_db_cms();
        }
    	return self::$admindbcms;
    }
    /**
     * Affiche le block "sortable" des categories
     */
    function s_block_category(){
    	$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder,lang.codelang,c.idlang FROM mc_cms_category AS c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.idorder';
		//return $this->layer->select($sql);
		return magixglobal_model_db::layerDB()->select($sql);
    }
	function s_json_category($idlang){
    	$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder,lang.codelang,c.idlang FROM mc_cms_category AS c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idlang= :idlang';
		//return $this->layer->select($sql);
		return magixglobal_model_db::layerDB()->select($sql,array(':idlang'=>$idlang));
    }
    /**
     * Selectionne le maximum des identifiants "order" pour les catégories
     */
    function s_max_order_category(){
    	$sql = 'SELECT max(c.idorder) as catorder FROM mc_cms_category AS c';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * compte le nombre de catégorie par langue
     * @return
     */
	function s_count_category(){
    	$sql = 'SELECT count(c.idcategory) as countcat,lang.codelang
    	FROM mc_cms_category AS c
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	GROUP BY c.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélection de la catégorie suivant l'identifiant
     * @param $ucategory
     */
	public function s_cms_category_id($ucategory){
    	$sql = 'SELECT c.idcategory,c.category
    	FROM mc_cms_category AS c WHERE idcategory = :ucategory';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			'ucategory' => $ucategory
		));
    }
    /**
     * @access public
     * Recherche le ou les mots dans le titre des pages
     * @param $searchpage
     */
    public function s_search_page($searchpage){
    	$sql = 'SELECT * FROM mc_cms_page WHERE subjectpage LIKE "%:searchpage%"';
    	return magixglobal_model_db::layerDB()->select($sql,array(
			'searchpage' => $searchpage
		));
    }
    /**
     * insertion d'une nouvel catégorie
     * @param $category (string)
     * @param $pathcategory (string)
     * @param $idlang (integer)
     */
	function i_category($category,$pathcategory,$idlang){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_max_order_category();
		$sql = 'INSERT INTO mc_cms_category (category,pathcategory,idlang,idorder) 
		VALUE(:category,:pathcategory,:idlang,:idorder)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':category'			=>	$category,
			':pathcategory'		=>	$pathcategory,
			':idlang'			=>	$idlang,
			':idorder'			=>	$maxorder['catorder'] + 1
		));
	}
	/**
	 * Mise à jour d'une catégorie dans le cms
	 * @param $category (string)
	 * @param $pathcategory (string)
	 * @param $ucategory (integer)
	 */
	function u_cms_category($category,$pathcategory,$ucategory){
		$sql = 'UPDATE mc_cms_category SET category = :category,pathcategory = :pathcategory WHERE idcategory = :ucategory';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':category'		=>	$category,
			':pathcategory'	=>	$pathcategory,
			':ucategory'	=>	$ucategory
			)
		);
	}
	/**
	 * Supprime une catégorie dans le CMS
	 * @param $dcmscat
	 */
	function d_cms_category($dcmscat){
		$sql = 'DELETE FROM mc_cms_category WHERE idcategory = :dcmscat';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':dcmscat'	=>	$dcmscat
			)); 
	}
	/**
	 * Compte le nombre de page par catégorie groupé par langue
	 */
	function statistic_category_page(){
		$sql = 'SELECT count( page.idcategory ) AS cat, lang.codelang
				FROM mc_cms_page page
				LEFT JOIN mc_lang AS lang ON(page.idlang = lang.idlang)
				GROUP BY page.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	function s_count_cms_max(){
		$sql = 'SELECT count(p.idpage) as total
		FROM mc_cms_page AS p';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Retourne le nombre maximum de pages pour la pagination
	 * @return void
	 */
	function s_count_cms_pager_max(){
		$sql = 'SELECT count(p.idpage) as total
		FROM mc_cms_page AS p';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
     * selectionne les pages CMS avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    function s_cms_plugin($limit=false,$max=null,$offset=null){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
    	$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory, p.pathpage,p.metatitle,p.metadescription,c.pathcategory, lang.codelang, m.pseudo
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( p.idadmin = m.idadmin )
				ORDER BY p.idpage DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,false,'assoc');
    }
	/**
     * Selectionne le maximum des identifiants "order" pour les catégories
     */
    function s_max_order_page(){
    	$sql = 'SELECT max(p.orderpage) porder FROM mc_cms_page AS p';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * insert une nouvelle page
     * @param $subjectpage
     * @param $pathpage
     * @param $contentpage
     * @param $idcategory
     * @param $idlang
     * @param $idadmin
     * @param $metatitle
     * @param $metadescription
     */
	function i_news_page($subjectpage,$pathpage,$contentpage,$idcategory,$idlang,$idadmin,$metatitle,$metadescription){
		// récupère le nombre maximum de la colonne order page
		$orderpage = self::s_max_order_page();
		$sql = 'INSERT INTO mc_cms_page (subjectpage,pathpage,contentpage,idcategory,idlang,idadmin,metatitle,metadescription,orderpage) 
		VALUE(:subjectpage,:pathpage,:contentpage,:idcategory,:idlang,:idadmin,:metatitle,:metadescription,:orderpage)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':subjectpage'		=>	$subjectpage,
			':pathpage'			=>	$pathpage,
			':contentpage'		=>	$contentpage,
			':idcategory'		=>	$idcategory,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':metatitle'		=>	$metatitle,
			':metadescription'	=>	$metadescription,
			':orderpage'		=>	$orderpage['porder'] + 1
		));
	}
	/**
	 * Charge les données de la table cms page pour la construction du menu
	 */
	function s_cms_navigation(){
    	$sql = 'SELECT p.idpage, p.subjectpage,p.orderpage,p.viewpage,lang.codelang
				FROM mc_cms_page AS p
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				ORDER BY p.orderpage';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Charge les identifiants de la vue d'une page CMS
     */
	function s_cms_form_navigation(){
    	$sql = 'SELECT p.idpage, p.subjectpage,p.orderpage,p.viewpage,lang.codelang
				FROM mc_cms_page AS p
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * mise à jour de la configuration d'une page dans le menu (view/hidden)
     * @param $viewpage
     * @param $idpage
     */
	function u_viewpage($viewpage,$idpage){
		$sql = 'UPDATE mc_cms_page SET viewpage = :viewpage WHERE idpage = :idpage';
		magixglobal_model_db::layerDB()->update($sql,array(
			':viewpage'=>$viewpage,
			':idpage'  =>$idpage
		));
	}
	/**
	 * Met à jour l'ordre d'affichage des pages
	 * @param $i
	 * @param $id
	 */
	function u_orderpage($i,$id){
		$sql = 'UPDATE mc_cms_page SET orderpage = :i WHERE idpage = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * Met à jour l'ordre d'affichage des catégories
	 * @param $i
	 * @param $id
	 */
	function u_ordercategory($i,$id){
		$sql = 'UPDATE mc_cms_category SET idorder = :i WHERE idcategory = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * Selectionne les donnée du formulaire pour la mise à jour
	 * @param $getpage
	 */
	function s_data_forms($getpage){
		$sql = 'SELECT p.idpage,p.subjectpage, p.contentpage,p.idlang,p.idcategory, p.pathpage,p.metatitle,p.metadescription, lang.codelang,c.category,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE idpage=:getpage';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getpage'=>$getpage
		));
	}
	/**
	 * mise à jour d'une page CMS
	 * @param $subjectpage
	 * @param $pathpage
	 * @param $contentpage
	 * @param $idcategory
	 * @param $idlang
	 * @param $idadmin
	 * @param $metatitle
	 * @param $metadescription
	 * @param $getpage
	 */
	function u_cms_page($subjectpage,$pathpage,$contentpage,$idcategory,$idlang,$idadmin,$metatitle,$metadescription,$getpage){
		$sql = 'UPDATE mc_cms_page 
		SET subjectpage=:subjectpage,pathpage=:pathpage,contentpage=:contentpage,idcategory=:idcategory,idlang=:idlang,idadmin=:idadmin,metatitle=:metatitle,metadescription=:metadescription,date_page=NOW()
		WHERE idpage=:getpage';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':subjectpage'		=>	$subjectpage,
			':pathpage'			=>	$pathpage,
			':contentpage'		=>	$contentpage,
			':idcategory'		=>	$idcategory,
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':metatitle'		=>	$metatitle,
			':metadescription'	=>	$metadescription,
			':getpage'			=>	$getpage
		));
	}
	function u_cms_page_move($idlang,$idcategory,$idadmin,$movepage){
		$sql = 'UPDATE mc_cms_page SET idadmin=:idadmin,idlang=:idlang,idcategory=:idcategory
		WHERE idpage=:movepage';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':idlang'		=>	$idlang,
			':idcategory'	=>	$idcategory,
			':idadmin'		=>	$idadmin,
			':movepage'		=>	$movepage
		));
	}
	/**
	 * @access public
	 * Suppression d'une page CMS via son identifiant
	 * @param $delpage
	 */
	function d_cms_page($delpage){
		$sql = 'DELETE FROM mc_cms_page WHERE idpage = :delpage';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delpage'	=>	$delpage
			)); 
	}
	/**
	 * Retourne le nombre de page CMS par administrateurs
	 * 
	 */
	function c_cms_user(){
		$sql = 'SELECT count( page.idpage ) AS usercms, m.pseudo
				FROM mc_cms_page page
				LEFT JOIN mc_lang AS lang ON ( page.idlang = lang.idlang )
				LEFT JOIN mc_admin_member AS m ON ( page.idadmin = m.idadmin )
				GROUP BY page.idadmin';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Fonctions de recherche de page cms dans les titres
	 * @param $searchpage
	 */
	function r_search_cms_title($searchpage){
		$sql = 'SELECT p.idpage, p.subjectpage
		FROM mc_cms_page p
		WHERE p.subjectpage LIKE "%'.$searchpage.'%"';
		return magixglobal_model_db::layerDB()->select($sql);
	}
}