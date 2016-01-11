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
    	ORDER BY c.idclc DESC,c.corder';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'=>$getlang
        ));
    }

    /**
     * Retourne la liste des catégories dans un produit
     * @param $getlang
     * @return array
     */
    protected function s_catalog_list_category_data($getlang){
        $sql = 'SELECT c.*,lang.iso
        FROM mc_catalog_c AS c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idlang = :getlang
    	ORDER BY c.clibelle ASC';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'=>$getlang
        ));
    }

    /**
     * @param $idlang
     * @param $clibelle
     * @return array
     */
    protected function s_catalog_category_list($idlang,$clibelle){
        $sql = 'SELECT c.*,lang.iso
        FROM mc_catalog_c AS c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
		WHERE c.idlang = :idlang AND c.clibelle LIKE :clibelle';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'	=>	$idlang,
            ':clibelle'=>'%'.$clibelle.'%'
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
     * Vérifie le nombre de sous catégories
     * @param $edit
     * @return array
     */
    protected function v_catalog_subcategory($edit){
        $sql = 'SELECT count(s.idcls) AS COUNT_SUB_CAT
        FROM mc_catalog_c AS c
    	JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	JOIN mc_catalog_s as s ON (s.idclc = c.idclc)
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

    /**
     * @param $i
     * @param $id
     */
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

    /**
     * @param $img_c
     * @param $edit
     */
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

    /**
     * Suppression des catégories avec une transaction pour la suppression des produits liés
     * @param $delete_category
     */
    protected function d_category($delete_category){
        $sql = array(
            'DELETE FROM mc_catalog_product WHERE idclc = '.$delete_category,
            'DELETE FROM mc_catalog_c WHERE idclc = '.$delete_category
        );
        magixglobal_model_db::layerDB()->transaction($sql);
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

    /**
     * Suppression des sous catégories avec une transaction pour la suppression des produits liés
     * @param $delete_subcategory
     */
    protected function d_subcategory($delete_subcategory){
        $sql = array(
            'DELETE FROM mc_catalog_product WHERE idcls = '.$delete_subcategory,
            'DELETE FROM mc_catalog_s WHERE idcls = '.$delete_subcategory
        );
        magixglobal_model_db::layerDB()->transaction($sql);
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
        lang.iso, m.pseudo_admin
		FROM mc_catalog AS cl
		JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
		LEFT JOIN mc_admin_employee AS m ON(m.id_admin = cl.idadmin)
		WHERE cl.idlang = :idlang
		ORDER BY cl.'.$sort.' DESC'.$limit.$offset;
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'	=>	$idlang
        ));
    }

    /**
     * Retourne la liste des produits après une recherche
     * @param $idlang
     * @param $titlecatalog
     * @return array
     */
    protected function s_catalog_list($idlang,$titlecatalog){
        $sql = 'SELECT cl.idcatalog, cl.urlcatalog, cl.titlecatalog, cl.idlang, lang.iso
		FROM mc_catalog AS cl
		JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
		WHERE cl.idlang = :idlang AND cl.titlecatalog LIKE :titlecatalog';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':idlang'	=>	$idlang,
            ':titlecatalog'=>'%'.$titlecatalog.'%'
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
        $sql = 'SELECT cl.*, lang.iso
		FROM mc_catalog AS cl
		JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
		WHERE cl.idcatalog = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'=>$edit
        ));
    }

    /**
     * Retourne les données du dernier produit inséré
     * @return array
     */
    protected function s_catalog_last_insert(){
        $sql = 'SELECT cl.*, lang.iso
            FROM mc_catalog AS cl
            JOIN mc_lang AS lang ON ( cl.idlang = lang.idlang )
            WHERE cl.idcatalog = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':edit'=> magixglobal_model_db::layerDB()->lastInsert()
            )
        );
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
     * Copie du produit
     * @param $edit
     * @param $idadmin
     */
    protected function i_catalog_product_copy($idlang,$idadmin,$titlecatalog,$urlcatalog,$desccatalog,$price,$imgcatalog){
        $sql = 'INSERT INTO mc_catalog (idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,imgcatalog)
        VALUE(:idlang,:idadmin,:urlcatalog,:titlecatalog,:desccatalog,:price,:imgcatalog)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':idlang'			=>	$idlang,
                ':idadmin'			=>	$idadmin,
                ':titlecatalog'		=>	$titlecatalog,
                ':urlcatalog'		=>	$urlcatalog,
                ':desccatalog'		=>	$desccatalog,
                ':price'		    =>	$price,
                ':imgcatalog'		=>	$imgcatalog
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

    /**
     * Retourne L'url du produit
     * @param $titlecatalog
     * @return array
     */
    protected function s_product_url($titlecatalog){
        $sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls,
        s.slibelle, s.pathslibelle, cl.titlecatalog, cl.urlcatalog, lang.iso
		FROM mc_catalog_product AS p
		JOIN mc_catalog as cl USING ( idcatalog )
		JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		JOIN mc_lang AS lang ON ( lang.idlang = cl.idlang )
		WHERE cl.titlecatalog LIKE :titlecatalog';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':titlecatalog'=>'%'.$titlecatalog.'%'
        ));
    }

    /**
     * @param $delete_catalog
     */
    protected function d_product($delete_catalog){
        $sql = array(
            'DELETE FROM mc_catalog_galery WHERE idcatalog = '.$delete_catalog,
            'DELETE FROM mc_catalog_rel_product WHERE idcatalog = '.$delete_catalog,
            'DELETE FROM mc_catalog_product WHERE idcatalog = '.$delete_catalog,
            'DELETE FROM mc_catalog WHERE idcatalog = '.$delete_catalog
        );
        magixglobal_model_db::layerDB()->transaction($sql);
    }

    /**
     * Déplacement d'un produit en supprimant les relations
     * @param $move
     * @param $idlang
     */
    protected function u_move_product($move,$idlang){
        $sql = array(
            'DELETE FROM mc_catalog_rel_product WHERE idcatalog = '.$move,
            'DELETE FROM mc_catalog_product WHERE idcatalog = '.$move,
            'UPDATE mc_catalog SET idlang = '.$idlang.' WHERE idcatalog = '.$move
        );
        magixglobal_model_db::layerDB()->transaction($sql);
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

    /**
     * Suppression du produit (relatif)
     * @param $delete_product
     */
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
        $sql = 'SELECT rel.idrelproduct,rel.idproduct, cl.idcatalog, c.idclc, c.clibelle, s.idcls, s.slibelle, cl.titlecatalog
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
		$sql = 'SELECT img.idmicro,img.imgcatalog,img.idcatalog
		FROM mc_catalog_galery as img WHERE idcatalog = :edit';
		return magixglobal_model_db::layerDB()->select($sql,array(
            ':edit'	=>	$edit
		));
	}

    protected function s_product_galery_data($edit){
        $sql = 'SELECT img.idmicro,img.imgcatalog,img.idcatalog
		FROM mc_catalog_galery as img WHERE idmicro = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':edit'	=>	$edit
        ));
    }
    /**
     * Met à jour l'ordre d'affichage des images de la galerie
     * @param $i
     * @param $id
     */
    protected function u_order_galery($i,$id){
        $sql = 'UPDATE mc_catalog_galery SET img_order = :i WHERE idmicro = :id';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':i'=>$i,
                ':id'=>$id
            )
        );
    }
    /**
     * Insertion d'une image galerie dans le produit
     * @param $imgcatalog
     * @param $edit
     */
    protected function i_product_galery($imgcatalog,$edit){
        $sql = 'INSERT INTO mc_catalog_galery (idcatalog,imgcatalog,img_order)
        VALUE(:edit,:imgcatalog,(SELECT COUNT(g.img_order) FROM mc_catalog_galery AS g WHERE g.idcatalog = :edit))';
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