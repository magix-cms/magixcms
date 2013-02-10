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
 * @version    3.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @name catalog
 *
 */
class backend_db_catalog{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	//static public $admindbcatalog;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbCatalog(){
        if (!isset(self::$admindbcatalog)){
         	self::$admindbcatalog = new backend_db_catalog();
        }
    	return self::$admindbcatalog;
    }
    /**
     * ############ Categorie ############
     */
    /**
     * Selectionne les catégories suivant l'ordre défini dans l'administration
     */
	function s_catalog_category_corder($getlang){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.iso FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idlang = :getlang
    	ORDER BY c.corder';
		return magixglobal_model_db::layerDB()->select($sql,array(':getlang'=>$getlang));
    }
    /**
     * Requête de construction du menu select avec optgroup
     */
	function s_catalog_category_select_construct(){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.iso FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * 
     * Construction du menu select des catégories suivant la langue
     * @param $idlang
     */
	function s_catalog_getlang_category_select($idlang){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle FROM mc_catalog_c as c WHERE c.idlang = :idlang';
		return magixglobal_model_db::layerDB()->select($sql,array(":idlang"=>$idlang));
    }
    /**
     * Requête pour récupérer le contenu d'une catégorie
     * @param $upcat
     */
	function s_catalog_category_id($upcat){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,img_c,c.c_content,lang.iso FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idclc = :upcat';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':upcat'=>$upcat));
    }
    /**
    * Selectionne le maximum des identifiants "order" pour les catégories
    */
    function s_max_order_catalog_category(){
    	$sql = 'SELECT max(c.corder) as clcorder FROM mc_catalog_c as c';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
	/**
     * Selectionne les produits correspondant à la catégorie (niveau ROOT)
     * @param $upcat
     */
	function s_product_in_category($upcat){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle,  p.idcls,card.titlecatalog, card.urlcatalog,p.orderproduct
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		WHERE p.idclc = :upcat AND p.idcls = 0 ORDER BY p.orderproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(':upcat'=>$upcat));
    }
	function s_count_product_in_category($idclc){
    	$sql = 'SELECT count( pr.idcls ) AS cproduct
		FROM mc_catalog_product pr
		WHERE pr.idclc =:idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':idclc'=>$idclc));
	}
    /**
     * insertion d'une nouvelle catégorie
     * @param $clibelle
     * @param $pathclibelle
     * @param $idlang
     * @param $corder
     * @deprecated
     */
	/*function i_catalog_category($clibelle,$pathclibelle,$img_c,$idlang){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_max_order_catalog_category();
		$sql = 'INSERT INTO mc_catalog_c (clibelle,pathclibelle,img_c,idlang,corder) 
		VALUE(:clibelle,:pathclibelle,:img_c,:idlang,:corder)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':clibelle'			=>	$clibelle,
			':pathclibelle'		=>	$pathclibelle,
			':img_c'			=>	$img_c,
			':idlang'			=>	$idlang,
			':corder'			=>	$maxorder['clcorder'] + 1
		));
	}*/
	/**
	 * Met à jour l'ordre d'affichage des catégories
	 * @param $i
	 * @param $id
	 */
	function u_order_catalog_category($i,$id){
		$sql = 'UPDATE mc_catalog_c SET corder = :i WHERE idclc = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * Met à jour l'ordre d'affichage des produits dans la catégorie
	 * @param $i
	 * @param $id
	 */
	/*function u_order_product_category($i,$id){
		$sql = 'UPDATE mc_catalog_product SET orderproduct = :i WHERE idproduct = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}*/
	/**
	 * Mise à jour d'une catégorie
	 * @param $clibelle
	 * @param $pathclibelle
	 * @param $upcat
	 */
	/*function u_catalog_category($clibelle,$pathclibelle,$c_content,$upcat){
		$sql = 'UPDATE mc_catalog_c SET clibelle = :clibelle,pathclibelle = :pathclibelle,c_content = :c_content WHERE idclc = :upcat';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':clibelle'		=>	$clibelle,
			':pathclibelle'	=>	$pathclibelle,
			':c_content'	=>	$c_content,
			':upcat'		=>	$upcat
			)
		);
	}*/
	/*function u_catalog_category_image($img_c,$upcat){
		$sql = 'UPDATE mc_catalog_c SET img_c = :img_c WHERE idclc = :upcat';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':img_c'		=>	$img_c,
			':upcat'		=>	$upcat
			)
		);
	}*/
	/**
     * Suppression d'une sous catégorie
     * @param $delc
     */
	function d_catalog_category($delc){
		$sql = array('DELETE FROM mc_catalog_s WHERE idclc = '.$delc,'DELETE FROM mc_catalog_c WHERE idclc = '.$delc);
			magixglobal_model_db::layerDB()->transaction($sql); 
	}
	/*
	 * ########### Sous categorie #############
	 */
	/**
     * Selectionne les sous catégories suivant l'ordre défini dans l'administration
     */
	/*function s_catalog_subcategory_sorder(){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,c.clibelle,lang.iso FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
		ORDER BY c.idlang,s.sorder';
		return magixglobal_model_db::layerDB()->select($sql);
    }*/
	function s_catalog_subcategory_sorder($idclc){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,c.clibelle,lang.iso FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
		WHERE s.idclc = :idclc
		ORDER BY s.sorder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc
		));
    }
	/**
     * Requête pour récupérer le contenu d'une sous catégorie
     * @param $upcat
     */
	function s_catalog_subcategory_id($upsubcat){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,s.s_content,s.img_s,c.clibelle,lang.iso 
    	FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE s.idcls = :upsubcat';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':upsubcat'=>$upsubcat));
    }
	/**
    * Selectionne le maximum des identifiants "order" pour les sous catégories
    */
    function s_max_order_catalog_subcategory(){
    	$sql = 'SELECT max(s.sorder) as clsorder FROM mc_catalog_s as s';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
	/**
    * 
    */
    function s_count_catalog_subcategory_in_category($idclc){
    	$sql = 'SELECT count(s.idcls) as csubcat FROM mc_catalog_s as s WHERE s.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'=>$idclc
		));
    }
	/**
	 * Selectionne les sous catégorie d'une catégorie
	 *
	 * @param getidclc
	 */
	function s_json_subcategory($getidclc){
		$sql='SELECT s.idcls,s.slibelle FROM mc_catalog_c as c
		JOIN mc_catalog_s as s USING (idclc)
		where idclc = :idclc
		ORDER BY s.sorder';
		return magixglobal_model_db::layerDB()->select($sql,array(':idclc'=>$getidclc));
	}
	/**
     * Selectionne les produits correspondant à la sous catégorie
     * @param $upsubcat
     */
	function s_product_in_subcategory($upsubcat){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle,  p.idcls,card.titlecatalog, card.urlcatalog,p.orderproduct
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		WHERE p.idcls = :upsubcat ORDER BY p.orderproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(':upsubcat'=>$upsubcat));
    }
	/**
	 * Met à jour l'ordre d'affichage des produits dans la sous catégorie
	 * @param $i
	 * @param $id
	 */
	function u_order_product_subcategory($i,$id){
		$sql = 'UPDATE mc_catalog_product SET orderproduct = :i WHERE idproduct = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * insertion d'une nouvelle sous catégorie
	 * @param $slibelle
	 * @param $pathslibelle
	 * @param $idlang
	 * @param $sorder
	 */
	/*function i_catalog_subcategory($slibelle,$pathslibelle,$img_s,$idclc){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_max_order_catalog_subcategory();
		$sql = 'INSERT INTO mc_catalog_s (slibelle,pathslibelle,img_s,idclc,sorder) VALUE(:slibelle,:pathslibelle,:img_s,:idclc,:sorder)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':slibelle'			=>	$slibelle,
			':pathslibelle'		=>	$pathslibelle,
			':idclc'			=>	$idclc,
			':img_s'			=>	$img_s,
			':sorder'			=>	$maxorder['clsorder'] + 1
		));
	}*/
	/**
	 * Met à jour l'ordre d'affichage des sous catégories
	 * @param $i
	 * @param $id
	 */
	function u_order_catalog_subcategory($i,$id){
		$sql = 'UPDATE mc_catalog_s SET sorder = :i WHERE idcls = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * Mise à jour d'une sous catégorie
	 * @param $clibelle
	 * @param $pathclibelle
	 * @param $upcat
	 */
	/*function u_catalog_subcategory($slibelle,$pathslibelle,$s_content,$upsubcat){
		$sql = 'UPDATE mc_catalog_s SET slibelle = :slibelle,pathslibelle = :pathslibelle,s_content = :s_content WHERE idcls = :upsubcat';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':slibelle'		=>	$slibelle,
			':pathslibelle'	=>	$pathslibelle,
			':s_content'	=>	$s_content,
			':upsubcat'		=>	$upsubcat
			)
		);
	}*/
	/*function u_catalog_subcategory_image($img_s,$upsubcat){
		$sql = 'UPDATE mc_catalog_s SET img_s = :img_s WHERE idcls = :upsubcat';
		magixglobal_model_db::layerDB()->update($sql,
			array(
			':img_s'		=>	$img_s,
			':upsubcat'		=>	$upsubcat
			)
		);
	}*/
	/**
     * Suppression d'une sous catégorie
     * @param $dels
     */
	function d_catalog_subcategory($dels){
		$sql = array(
		'DELETE FROM mc_catalog_s WHERE idcls ='.$dels,
		'DELETE FROM mc_catalog_product WHERE idcls ='.$dels
		);
			magixglobal_model_db::layerDB()->transaction($sql); 
	}
	/**
	 * CATALOG PAGE
	 */
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	function s_count_catalog_max(){
		$sql = 'SELECT count(p.idcatalog) as total FROM mc_catalog as p';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	function s_count_catalog_pager_max(){
		$sql = 'SELECT count(p.idcatalog) as total FROM mc_catalog as p';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Retourne l'url du produit courant pour la génération d'image intelligente
	 * @param $getimg
	 */
	function s_uniq_url_catalog($getimg){
		$sql = 'SELECT urlcatalog FROM mc_catalog WHERE idcatalog = :getimg';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getimg'=>$getimg
		));
	}
	/**
     * selectionne les pages du catalog avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    function s_catalog_plugin($limit=false,$max=null,$offset=null,$sort){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
    	$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang,img.imgcatalog, lang.iso, m.pseudo
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( p.idadmin = m.idadmin )
		ORDER BY p.'.$sort.' DESC'.$limit.$offset;
		return magixglobal_model_db::layerDB()->select($sql,false,'assoc');
    }
    /**
     * Selectionne les produits correspondant au catalogue
     * @param $editproduct
     */
	/*function s_catalog_product($editproduct){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE idcatalog = :editproduct';
		return magixglobal_model_db::layerDB()->select($sql,array(":editproduct"=>$editproduct));
    }*/
	/**
     * Selectionne les produits correspondant à la langue du catalogue
     * @param $editproduct
     */
	/*function s_catalog_product_for_lang($getidclc){
    	$sql = 'SELECT p.idproduct, c.clibelle, s.idcls,s.slibelle, card.titlecatalog
				FROM mc_catalog_product AS p
				LEFT JOIN mc_catalog AS card USING ( idcatalog )
				LEFT JOIN mc_catalog_c AS c USING ( idclc )
				LEFT JOIN mc_catalog_s AS s USING ( idcls )
				WHERE c.idclc =:idclc ORDER BY s.idcls';
		return magixglobal_model_db::layerDB()->select($sql,array("idclc"=>$getidclc));
    }*/
	/**
	 * Selectionne les donnée du formulaire pour la mise à jour d'un produit
	 * @param $editproduct
	 */
	function s_data_forms($editproduct){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.price, lang.iso
		FROM mc_catalog AS p
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcatalog = :editproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':editproduct'=>$editproduct
		));
	}
	/**
	 * Retourne une liste contenant l'identifiant de chaque produit
	 * @return array()
	 */
	function s_idcatalog_product(){
		$sql = 'SELECT p.idcatalog,p.titlecatalog FROM mc_catalog as p';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Sélectionne une image spécifique à une fiche catalogue
	 * @param $getimg
	 */
	function s_image_product($getimg){
		$sql = 'SELECT img.imgcatalog FROM mc_catalog_img as img WHERE idcatalog = :getimg';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Compte le nombre d'image pour une fiche catalogue
	 * @param $getimg
	 */
	function count_image_product($getimg){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_img as img WHERE idcatalog = :getimg';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	function s_catalog_max_rel_product(){
		$sql = 'SELECT count(idrelproduct) as max FROM mc_catalog_rel_product';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/*function s_catalog_product_info($idproduct){
		$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.iso
				FROM mc_catalog_product AS p
				LEFT JOIN mc_catalog AS card USING ( idcatalog )
				LEFT JOIN mc_catalog_c AS c USING ( idclc )
				LEFT JOIN mc_catalog_s AS s USING ( idcls )
				LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
				WHERE idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}*/
	/*function s_catalog_rel_product($idcatalog){
		$sql = 'SELECT rel.idrelproduct,rel.idproduct FROM mc_catalog_rel_product AS rel
				WHERE rel.idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}*/
	/**
	 * Fonctions de recherche de produits dans les titres
	 * @param $searchpage
	 */
	function r_search_catalog_title($searchpage){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang,img.imgcatalog, lang.iso, m.pseudo
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( p.idadmin = m.idadmin )
		WHERE p.titlecatalog LIKE "%'.$searchpage.'%"';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * 
	 * recherche les produits suivant un mot clé
	 * @param string $search
	 */
	function r_search_complete_product($search){
		$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE card.titlecatalog LIKE "%'.$search.'%"';
		return magixglobal_model_db::layerDB()->select($sql);
	}
    /**
     * Insert un nouveau produit dans la table mc_catalog
     */
	function i_catalog_card_product($idlang,$idadmin,$urlcatalog,$titlecatalog,$desccatalog,$price){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_count_catalog_max();
		$sql = 'INSERT INTO mc_catalog (idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog) 
		VALUE(:idlang,:idadmin,:urlcatalog,:titlecatalog,:desccatalog,:price,:ordercatalog)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':urlcatalog'		=>	$urlcatalog,
			':titlecatalog'		=>	$titlecatalog,
			':desccatalog'		=>	$desccatalog,
			':price'			=>	$price,
			':ordercatalog'		=>	$maxorder['total'] + 1
		));
	}
	/**
	 * 
	 * Insertion d'un produit dans la table mc_catalog_product pour la liaison à une catégorie/sous catégorie
	 * @param $idcatalog
	 * @param $idclc
	 * @param $idcls
	 */
	/*function i_catalog_product($idcatalog,$idclc,$idcls){
		$sql = 'INSERT INTO mc_catalog_product (idcatalog,idclc,idcls) VALUE(:idcatalog,:idclc,:idcls)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idcatalog'=>	$idcatalog,
			':idclc'	=>	$idclc,
			':idcls'	=>	$idcls
		));
	}*/
	/**
	 * 
	 * Insertion d'un produit lié
	 * @param $idrelproduct
	 * @param $idcatalog
	 * @param $idproduct
	 */
	/*function i_catalog_rel_product($idcatalog,$idproduct){
		$sql = 'INSERT INTO mc_catalog_rel_product (idcatalog,idproduct) 
		VALUE(:idcatalog,:idproduct)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idcatalog'	=>	$idcatalog,
			':idproduct'	=>	$idproduct
		));
	}*/
	/**
	 * Copie un enregistrement dans une autre catégorie, sous catégorie et langue
	 * @param $idadmin
	 * @param $idlang
	 * @param $copyproduct
	 */
	function copy_catalog_product($idlang,$idadmin,$copyproduct){
		$sql = 'INSERT INTO mc_catalog (idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog) 
		SELECT :idlang,:idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog FROM mc_catalog
		WHERE idcatalog = :copyproduct';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':copyproduct'		=>	$copyproduct
		));
	}
	/**
	 * Insère une image dans le catalogue
	 * @param $idcatalog
	 * @param $imgcatalog
	 */
	function i_image_catalog($idcatalog,$imgcatalog){
		$sql = 'INSERT INTO mc_catalog_img (idcatalog,imgcatalog) VALUE(:idcatalog,:imgcatalog)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idcatalog'	=>	$idcatalog,
			':imgcatalog'	=>	$imgcatalog
		));
	}
	/**
	 * Mise à jour d'une fiche produit dans le catalogue
	 * @param $idadmin
	 * @param $urlcatalog
	 * @param $titlecatalog
	 * @param $desccatalog
	 * @param $price
	 * @param $editproduct
	 */
	/*function u_catalog_product($idadmin,$titlecatalog,$urlcatalog,$desccatalog,$price,$editproduct){
		$sql = 'UPDATE mc_catalog SET idadmin=:idadmin,titlecatalog=:titlecatalog
		,urlcatalog=:urlcatalog,desccatalog=:desccatalog,price=:price,date_catalog=NOW() 
		WHERE idcatalog=:editproduct';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':titlecatalog'		=>	$titlecatalog,
			':urlcatalog'		=>	$urlcatalog,
			':desccatalog'		=>	$desccatalog,
			':price'			=>	$price,
			':editproduct'		=>	$editproduct
		));
	}*/
	/**
	 * Déplace un produit dans une autre catégorie
	 * @param $idadmin
	 * @param $idclc
	 * @param $idcls
	 * @param $moveproduct
	 */
	function u_catalog_product_move($idlang,$idadmin,$moveproduct){
		$sql = 'UPDATE mc_catalog SET idadmin=:idadmin,idlang=:idlang
		WHERE idcatalog=:moveproduct';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':idlang'			=>	$idlang,
			':idadmin'			=>	$idadmin,
			':moveproduct'		=>	$moveproduct
		));
	}
	/**
	 * Met à jour une image dans le catalogue
	 * @param $idcatalog
	 * @param $imgcatalog
	 */
	function u_image_catalog($idcatalog,$imgcatalog){
		$sql = 'UPDATE mc_catalog_img SET imgcatalog = :imgcatalog WHERE idcatalog = :idcatalog';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':idcatalog'	=>	$idcatalog,
			':imgcatalog'	=>	$imgcatalog
		));
	}
	/**
	 * Suppression d'un produit
	 * @param $delproduct
	 */
	function d_catalog_product($delproduct){
		$sql = array(
		'DELETE FROM mc_catalog_img WHERE idcatalog = '.$delproduct,
		'DELETE FROM mc_catalog_rel_product WHERE idcatalog ='.$delproduct,
		'DELETE FROM mc_catalog_product WHERE idcatalog = '.$delproduct
		,'DELETE FROM mc_catalog WHERE idcatalog = '.$delproduct);
		magixglobal_model_db::layerDB()->transaction($sql); 
	}
	/**
	 * Suppression des produits ainsi que des produits lié à celui-ci
	 * @param $d_in_product
	 */
	function d_in_product($d_in_product){
		$sql = array('DELETE FROM mc_catalog_rel_product WHERE idproduct ='.$d_in_product,
		'DELETE FROM mc_catalog_product WHERE idproduct ='.$d_in_product);
		magixglobal_model_db::layerDB()->transaction($sql); 
	}
	/**
	 * Suppression des produits associé ou liaison de produits à une fiche
	 * @param $d_in_product
	 */
	function d_rel_product($d_rel_product){
		$sql = 'DELETE FROM mc_catalog_rel_product WHERE idrelproduct = :d_rel_product';
		magixglobal_model_db::layerDB()->delete($sql,array(':d_rel_product'=>$d_rel_product)); 
	}
	/**
	 * ################ Galerie d'image pour un produit ###################
	 */
	/**
	 * Sélectionne la denière image ajouter dans la base de donnée galery (catalogue)
	 * 
	 */
	/*function s_galery_image_product(){
		$sql = 'SELECT img.imgcatalog FROM mc_catalog_galery as img WHERE idmicro = '.magixglobal_model_db::layerDB()->lastInsert();
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Récupère le nom de l'image avant la suppression (micro galerie)
	 * 
	 */
	/*function s_galery_image_micro($delmicro){
		$sql = 'SELECT imgcatalog FROM mc_catalog_galery WHERE idmicro = :delmicro';
		return magixglobal_model_db::layerDB()->selectOne($sql,
			array(
				':delmicro'	=>	$delmicro
			)); 
	}
	/**
	 * Compte le nombre d'image pour une galerie catalogue
	 * @param $getimg
	 */
	/*function count_image_in_galery_product($getimg){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_galery as img WHERE idcatalog = :getimg';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Selectionne toutes les images dans une galerie d'un produit
	 * @param $getimg
	 */
	/*function s_image_in_galery_product($getimg){
		$sql = 'SELECT img.idmicro,img.imgcatalog FROM mc_catalog_galery as img WHERE idcatalog = :getimg';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Insère une image dans la galerie du produit
	 * @param $idcatalog
	 * @param $imgcatalog
	 */
	/*function i_galery_image_catalog($idcatalog,$imgcatalog){
		$sql = 'INSERT INTO mc_catalog_galery (idcatalog,imgcatalog) VALUE(:idcatalog,:imgcatalog)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idcatalog'	=>	$idcatalog,
			':imgcatalog'	=>	$imgcatalog
		));
	}
	/**
	 * Supprime Une image dans une galerie catalogue
	 * @param $delmicro
	 */
	/*function d_galery_image_catalog($delmicro){
		$sql = 'DELETE FROM mc_catalog_galery WHERE idmicro = :delmicro';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delmicro'	=>	$delmicro
			)); 
	}
	/**
	 * Statistic catalog
	 */
	/**
	 * 
	 * Compte le nombre de produit visible sur le site internet
	 */
	function count_global_product(){
		$sql = 'SELECT count(idproduct) as globalproduct FROM mc_catalog_product';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	function count_global_subfolder_product(){
		$sql = 'SELECT count(idcls) as subfolder FROM mc_catalog_product WHERE idcls != 0';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * 
	 * Compte le nombre de produit lié sur le site internet
	 */
	function count_global_rel_product(){
		$sql = 'SELECT count(idrelproduct) as relproduct FROM mc_catalog_rel_product';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * 
	 * Compte le nombre de produit lié sur le site internet
	 */
	function count_global_folder(){
		$sql = 'SELECT count(idclc) as folder FROM mc_catalog_c';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	function count_global_subfolder(){
		$sql = 'SELECT count(idcls) as subfolder FROM mc_catalog_s';
		return magixglobal_model_db::layerDB()->selectOne($sql);
	}
    //GRAPH

    /**
     * Retourne les statistiques
     * @return array
     */
    protected function s_stats_catalog(){
        $sql = 'SELECT lang.iso, IF( c.cat_count >0, c.cat_count, 0 ) AS CATEGORY,
        IF( s.subcat_count >0, s.subcat_count, 0 ) AS SUBCATEGORY,
        IF( catalog.catalog_count >0, catalog.catalog_count, 0 ) AS CATALOG
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( c.idclc ) AS cat_count
            FROM mc_catalog_c AS c
            JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
            GROUP BY c.idlang
        )c ON ( c.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( s.idcls ) AS subcat_count
            FROM mc_catalog_s AS s
            JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
            JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
            GROUP BY c.idlang
        )s ON ( s.idlang = lang.idlang )
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( catalog.idcatalog ) AS catalog_count
            FROM mc_catalog AS catalog
		    JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
            GROUP BY catalog.idlang
        )catalog ON ( catalog.idlang = lang.idlang )
        GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
    //CATEGORY
    /**
     * Retourne la liste des catégories dans la langue
     * @param $getlang
     * @return array
     */
    protected function s_catalog_category($getlang){
        $sql = 'SELECT c.*,lang.iso
        FROM mc_catalog_c AS c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idlang = :getlang
    	ORDER BY c.corder';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'=>$getlang
        ));
    }

    /**
     * Retourne les données de la catégorie pour édition
     * @param $edit
     * @return array
     */
    protected function s_catalog_category_data($edit){
        $sql = 'SELECT c.*,lang.iso
        FROM mc_catalog_c as c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idclc = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'=>$edit
        ));
    }

    /**
     * Insertion d'une catégorie
     * @param $clibelle
     * @param $pathclibelle
     * @param $idlang
     */
    protected function i_catalog_category($clibelle,$pathclibelle,$idlang){
        $sql = 'INSERT INTO mc_catalog_c (clibelle,pathclibelle,idlang,corder)
		VALUE(:clibelle,:pathclibelle,:idlang,(SELECT COUNT(c.corder) FROM mc_catalog_c as c WHERE c.idlang = :idlang))';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':clibelle'			=>	$clibelle,
                ':pathclibelle'		=>	$pathclibelle,
                ':idlang'			=>	$idlang
            ));
    }

    /**
     * Met à jour l'ordre d'affichage des catégories
     * @param $i
     * @param $id
     */
    protected function u_order_category($i,$id){
        $sql = 'UPDATE mc_catalog_c SET corder = :i WHERE idclc = :id';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':i'=>$i,
                ':id'=>$id
            )
        );
    }
    protected function u_order_category_product($i,$id){
        $sql = 'UPDATE mc_catalog_product SET orderproduct = :i WHERE idproduct = :id';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':i'=>$i,
                ':id'=>$id
            )
        );
    }

    /**
     * Mise à jour de la catégorie
     * @param $clibelle
     * @param $pathclibelle
     * @param $c_content
     * @param $edit
     */
    protected function u_catalog_category($clibelle,$pathclibelle,$c_content,$edit){
        $sql = 'UPDATE mc_catalog_c SET clibelle = :clibelle, pathclibelle = :pathclibelle,
        c_content = :c_content WHERE idclc = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':clibelle'		=>	$clibelle,
                ':pathclibelle'	=>	$pathclibelle,
                ':c_content'	=>	$c_content,
                ':edit'		    =>	$edit
            )
        );
    }
    protected function u_catalog_category_image($img_c,$edit){
        $sql = 'UPDATE mc_catalog_c SET img_c = :img_c WHERE idclc = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':img_c'	=>	$img_c,
                ':edit'		=>	$edit
            )
        );
    }
    /**
     * Retourne les catégories/ou sous catégories du produit
     * @param $edit
     * @return array
     */
    protected function s_catalog_category_product($edit){
        $sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle,
        cl.idcatalog,cl.titlecatalog, cl.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		JOIN mc_catalog as cl USING ( idcatalog )
		JOIN mc_catalog_c as c USING ( idclc )
		JOIN mc_lang AS lang ON ( lang.idlang = cl.idlang )
		WHERE p.idclc = :edit AND p.idcls = 0 ORDER BY orderproduct ASC';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ":edit"=>$edit
        ));
    }
    //SOUS CATEGORIE

    /**
     * Retourne la liste des sous catégories dans la catégorie
     * @param $edit
     * @return array
     */
    protected function s_catalog_subcategory($edit){
        $sql = 'SELECT c.clibelle,c.pathclibelle,s.*,lang.iso
        FROM mc_catalog_c AS c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	JOIN mc_catalog_s as s ON (s.idclc = c.idclc)
    	WHERE c.idclc = :edit
    	ORDER BY s.sorder';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':edit'=>$edit
        ));
    }

    /**
     * Retourne les données pour l'édition de la sous catégorie
     * @param $edit
     * @return array
     */
    protected function s_catalog_subcategory_data($edit){
        $sql = 'SELECT c.clibelle, c.pathclibelle, s . * , lang.iso
        FROM mc_catalog_s AS s
        JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
        JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
        WHERE s.idcls = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'=>$edit
        ));
    }
    /**
     * Retourne les catégories/ou sous catégories du produit
     * @param $edit
     * @return array
     */
    protected function s_catalog_subcategory_product($edit){
        $sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle,
        cl.idcatalog,cl.titlecatalog, cl.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		JOIN mc_catalog as cl USING ( idcatalog )
		JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		JOIN mc_lang AS lang ON ( lang.idlang = cl.idlang )
		WHERE p.idcls = :edit ORDER BY orderproduct ASC';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ":edit"=>$edit
        ));
    }

    /*function s_catalog_subcategory($getidclc){
        $sql='SELECT s.idcls,s.slibelle FROM mc_catalog_c as c
		JOIN mc_catalog_s as s USING (idclc)
		where idclc = :idclc
		ORDER BY s.sorder';
        return magixglobal_model_db::layerDB()->select($sql,array(':idclc'=>$getidclc));
    }*/
    /**
     * Insertion d'une sous catégorie
     * @param $slibelle
     * @param $pathslibelle
     * @param $idclc
     */
    protected function i_catalog_subcategory($slibelle,$pathslibelle,$idclc){
        $sql = 'INSERT INTO mc_catalog_s (idclc,slibelle,pathslibelle,sorder)
		VALUE(:idclc,:slibelle,:pathslibelle,(SELECT COUNT(s.sorder) FROM mc_catalog_s AS s WHERE s.idclc = :idclc))';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':slibelle'			=>	$slibelle,
                ':pathslibelle'		=>	$pathslibelle,
                ':idclc'            =>  $idclc
            )
        );
    }

    /**
     * Met à jour l'ordre d'affichage des sous catégories
     * @param $i
     * @param $id
     */
    protected function u_order_subcategory($i,$id){
        $sql = 'UPDATE mc_catalog_s SET sorder = :i WHERE idcls = :id';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':i'=>$i,
                ':id'=>$id
            )
        );
    }

    /**
     * Mise à jour de la sous catégorie
     * @param $slibelle
     * @param $pathslibelle
     * @param $s_content
     * @param $edit
     */
    protected function u_catalog_subcategory($slibelle,$pathslibelle,$s_content,$edit){
        $sql = 'UPDATE mc_catalog_s SET slibelle = :slibelle,pathslibelle = :pathslibelle,
        s_content = :s_content WHERE idcls = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':slibelle'		=>	$slibelle,
                ':pathslibelle'	=>	$pathslibelle,
                ':s_content'	=>	$s_content,
                ':edit'		    =>	$edit
            )
        );
    }

    /**
     * Mise
     * @param $img_s
     * @param $edit
     */
    protected function u_catalog_subcategory_image($img_s,$edit){
        $sql = 'UPDATE mc_catalog_s SET img_s = :img_s WHERE idcls = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':img_s'	=>	$img_s,
                ':edit'		=>	$edit
            )
        );
    }
    //PRODUCT

    /**
     * @param $idlang
     * @param $select_role
     * @param bool $limit
     * @param null $max
     * @param null $offset
     * @param $sort
     * @return array
     */
    protected function s_catalog($idlang,$select_role,$limit=false,$max=null,$offset=null,$sort){
        $limit = $limit ? ' LIMIT '.$max : '';
        $offset = !empty($offset) ? ' OFFSET '.$offset: '';
        $sql = 'SELECT cl.idcatalog, cl.urlcatalog, cl.titlecatalog, cl.desccatalog, cl.price, cl.idlang, cl.imgcatalog,
        lang.iso, m.pseudo
		FROM mc_catalog AS cl
		JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
		JOIN mc_admin_member as m ON ( cl.idadmin = m.idadmin )
		WHERE cl.idlang = :idlang AND m.id_role IN('.$select_role.')
		ORDER BY cl.'.$sort.' DESC'.$limit.$offset;
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'	=>	$idlang
        ));
    }

    /**
     * Compte le nombre de produit dans la langue
     * @param $idlang
     * @return array
     */
    protected function s_catalog_count($idlang){
        $sql = 'SELECT count(cl.idcatalog) AS total
        FROM mc_catalog AS cl
        WHERE cl.idlang = :idlang';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':idlang'	=>	$idlang
        ));
    }

    /**
     * Retourne les données d'un produit
     * @param $edit
     * @return array
     */
    protected function s_catalog_data($edit){
        $sql = 'SELECT cl.idcatalog, cl.urlcatalog, cl.titlecatalog, cl.desccatalog, cl.idlang, cl.price,cl.imgcatalog, lang.iso
		FROM mc_catalog AS cl
		JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
		WHERE cl.idcatalog = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'=>$edit
        ));
    }

    /**
     * Retourne les catégories/ou sous catégories du produit
     * @param $edit
     * @return array
     */
    protected function s_catalog_product_category($edit){
        $sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle,
        cl.idcatalog,cl.titlecatalog, cl.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		JOIN mc_catalog as cl USING ( idcatalog )
		JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		JOIN mc_lang AS lang ON ( lang.idlang = cl.idlang )
		WHERE idcatalog = :edit ORDER BY orderproduct ASC';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ":edit"=>$edit
        ));
    }

    /**
     * Mise à jour d'une image de produit
     * @param $imgcatalog
     * @param $edit
     */
    protected function u_catalog_product_image($imgcatalog,$edit){
        $sql = 'UPDATE mc_catalog SET imgcatalog = :imgcatalog WHERE idcatalog = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':imgcatalog'	=>	$imgcatalog,
                ':edit'		    =>	$edit
            )
        );
    }

    /**
     * Mise à jour d'un produit
     * @param $titlecatalog
     * @param $urlcatalog
     * @param $desccatalog
     * @param $price
     * @param $edit
     * @param $idadmin
     */
    protected function u_catalog_product($titlecatalog,$urlcatalog,$desccatalog,$price,$edit,$idadmin){
        $sql = 'UPDATE mc_catalog SET idadmin=:idadmin,titlecatalog=:titlecatalog
		,urlcatalog=:urlcatalog,desccatalog=:desccatalog,price=:price,date_catalog=NOW()
		WHERE idcatalog=:edit';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':titlecatalog'		=>	$titlecatalog,
                ':urlcatalog'		=>	$urlcatalog,
                ':desccatalog'		=>	$desccatalog,
                ':price'			=>	$price,
                ':edit'		        =>	$edit,
                ':idadmin'			=>	$idadmin
            ));
    }

    /**
     * Insertion d'un nouveau produit
     * @param $titlecatalog
     * @param $urlcatalog
     * @param $idlang
     * @param $idadmin
     */
    protected function i_catalog_product($titlecatalog,$urlcatalog,$idlang,$idadmin){
        $sql = 'INSERT INTO mc_catalog (titlecatalog,urlcatalog,idlang,idadmin)
		VALUE(:titlecatalog,:urlcatalog,:idlang,:idadmin)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':titlecatalog'		=>	$titlecatalog,
                ':urlcatalog'		=>	$urlcatalog,
                ':idlang'			=>	$idlang,
                ':idadmin'			=>	$idadmin
            ));
    }

    /**
     * Insertion d'un produit dans une catégorie/ou sous catégorie
     * @param $edit
     * @param $idclc
     * @param $idcls
     */
    protected function i_catalog_product_category($edit,$idclc,$idcls){
        $sql = 'INSERT INTO mc_catalog_product (idcatalog,idclc,idcls,orderproduct)
        VALUE(:edit,:idclc,:idcls,(SELECT COUNT(p.orderproduct) FROM mc_catalog_product AS p WHERE p.idclc = :idclc AND p.idcls = :idcls))';
        magixglobal_model_db::layerDB()->insert($sql,
        array(
            ':edit'     =>	$edit,
            ':idclc'	=>	$idclc,
            ':idcls'	=>	$idcls
        ));
    }

    /**
     * Suppression des catégories dans le produit
     * @param $delete_product
     */
    protected function d_product_category($delete_product){
        $sql = 'DELETE FROM mc_catalog_product WHERE idproduct = :delete_product';
        magixglobal_model_db::layerDB()->delete($sql,array(
            ':delete_product'=>$delete_product
        ));
    }
    /*
     * PRODUIT RELATED
     *
     * */
    /**
     * Retourne un tableau des produits relatifs pour pour la recherche
     * @param $titlecatalog
     * @return array
     */
    protected function s_product($titlecatalog){
        $sql = 'SELECT p.idproduct, c.idclc, c.clibelle, s.idcls, s.slibelle, cl.titlecatalog
        FROM mc_catalog_product AS p
        JOIN mc_catalog AS cl USING ( idcatalog )
        JOIN mc_catalog_c AS c USING ( idclc )
        LEFT JOIN mc_catalog_s AS s USING ( idcls )
        WHERE cl.titlecatalog LIKE :titlecatalog';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ":titlecatalog"=>'%'.$titlecatalog.'%'
        ));
    }

    /**
     * Insertion d'un produit relatif
     * @param $edit
     * @param $idproduct
     */
    protected function i_product_rel($edit,$idproduct){
        $sql = 'INSERT INTO mc_catalog_rel_product (idcatalog,idproduct)
		VALUE(:edit,:idproduct)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':edit'	    =>	$edit,
                ':idproduct'=>	$idproduct
            ));
    }

    protected function d_product_rel($delete_product){
        $sql = 'DELETE FROM mc_catalog_rel_product WHERE idrelproduct = :delete_product';
        magixglobal_model_db::layerDB()->delete($sql,array(
            ':delete_product'=>$delete_product
        ));
    }
    /**
     * Retourne un tableau des produits relatifs
     * @param $edit
     * @return array
     */
    protected function s_product_rel($edit){
        $sql = 'SELECT rel.idrelproduct,rel.idproduct, rel.idcatalog, c.idclc, c.clibelle, s.idcls, s.slibelle, cl.titlecatalog
        FROM mc_catalog_rel_product AS rel
        JOIN mc_catalog_product AS p ON(rel.idproduct = p.idproduct)
        JOIN mc_catalog AS cl ON (cl.idcatalog = p.idcatalog)
        JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
        LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
        WHERE rel.idcatalog = :edit';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ":edit"=>$edit
        ));
    }
    /**
     * ################ Galerie d'image pour un produit ###################
     */

    /**
     * Retourne les images de galerie produit
     * @param $edit
     * @return array
     */
	protected function s_product_galery($edit){
		$sql = 'SELECT img.idmicro,img.imgcatalog
		FROM mc_catalog_galery as img WHERE idcatalog = :edit';
		return magixglobal_model_db::layerDB()->select($sql,array(
            ':edit'	=>	$edit
		));
	}

    protected function s_product_galery_data($edit){
        $sql = 'SELECT img.idmicro,img.imgcatalog
		FROM mc_catalog_galery as img WHERE idmicro = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'	=>	$edit
        ));
    }

    /**
     * Insertion d'une image galerie dans le produit
     * @param $imgcatalog
     * @param $edit
     */
    protected function i_product_galery($imgcatalog,$edit){
        $sql = 'INSERT INTO mc_catalog_galery (idcatalog,imgcatalog)
        VALUE(:edit,:imgcatalog)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':edit'	=>	$edit,
                ':imgcatalog'	=>	$imgcatalog
            ));
    }
    /**
     * Suppression des galeries dans le produit
     * @param $delete_galery
     */
    protected function d_product_galery($delete_galery){
        $sql = 'DELETE FROM mc_catalog_galery WHERE idmicro = :delete_galery';
        magixglobal_model_db::layerDB()->delete($sql,array(
            ':delete_galery'    =>  $delete_galery
        ));
    }
}