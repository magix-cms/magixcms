<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name catalog
 * @version 3.0
 *
 */
class backend_db_catalog{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $admindbcatalog;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
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
	function s_catalog_category_corder(){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.codelang FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.corder';
		return $this->layer->select($sql);
    }
    /**
     * Requête de construction du menu select avec optgroup
     */
	function s_catalog_category_select_construct(){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.codelang FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.idlang';
		return $this->layer->select($sql);
    }
    /**
     * 
     * Construction du menu select des catégories suivant la langue
     * @param $idlang
     */
	function s_catalog_getlang_category_select($idlang){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle FROM mc_catalog_c as c WHERE c.idlang = :idlang';
		return $this->layer->select($sql,array(":idlang"=>$idlang));
    }
    /**
     * Requête pour récupérer le contenu d'une catégorie
     * @param $upcat
     */
	function s_catalog_category_id($upcat){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.codelang FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE c.idclc = :upcat';
		return $this->layer->selectOne($sql,array(':upcat'=>$upcat));
    }
    /**
    * Selectionne le maximum des identifiants "order" pour les catégories
    */
    function s_max_order_catalog_category(){
    	$sql = 'SELECT max(c.corder) as clcorder FROM mc_catalog_c as c';
		return $this->layer->selectOne($sql);
    }
    /**
     * insertion d'une nouvelle catégorie
     * @param $clibelle
     * @param $pathclibelle
     * @param $idlang
     * @param $corder
     */
	function i_catalog_category($clibelle,$pathclibelle,$idlang){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_max_order_catalog_category();
		$sql = 'INSERT INTO mc_catalog_c (clibelle,pathclibelle,idlang,corder) 
		VALUE(:clibelle,:pathclibelle,:idlang,:corder)';
		$this->layer->insert($sql,
		array(
			':clibelle'			=>	$clibelle,
			':pathclibelle'		=>	$pathclibelle,
			':idlang'			=>	$idlang,
			':corder'			=>	$maxorder['clcorder'] + 1
		));
	}
	/**
	 * Met à jour l'ordre d'affichage des catégories
	 * @param $i
	 * @param $id
	 */
	function u_order_catalog_category($i,$id){
		$sql = 'UPDATE mc_catalog_c SET corder = :i WHERE idclc = :id';
		$this->layer->update($sql,
			array(
			':i'=>$i,
			':id'=>$id
			)
		);
	}
	/**
	 * Mise à jour d'une catégorie
	 * @param $clibelle
	 * @param $pathclibelle
	 * @param $upcat
	 */
	function u_catalog_category($clibelle,$pathclibelle,$upcat){
		$sql = 'UPDATE mc_catalog_c SET clibelle = :clibelle,pathclibelle = :pathclibelle WHERE idclc = :upcat';
		$this->layer->update($sql,
			array(
			':clibelle'		=>	$clibelle,
			':pathclibelle'	=>	$pathclibelle,
			':upcat'		=>	$upcat
			)
		);
	}
	/**
     * Suppression d'une sous catégorie
     * @param $delc
     */
	function d_catalog_category($delc){
		$sql = array('DELETE FROM mc_catalog_s WHERE idclc = '.$delc,'DELETE FROM mc_catalog_c WHERE idclc = '.$delc);
			$this->layer->transaction($sql); 
	}
	/*
	 * ########### Sous categorie #############
	 */
	/**
     * Selectionne les sous catégories suivant l'ordre défini dans l'administration
     */
	function s_catalog_subcategory_sorder(){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,c.clibelle,lang.codelang FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
		ORDER BY s.sorder';
		return $this->layer->select($sql);
    }
	/**
     * Requête pour récupérer le contenu d'une sous catégorie
     * @param $upcat
     */
	function s_catalog_subcategory_id($upsubcat){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,c.clibelle,lang.codelang FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	WHERE s.idcls = :upsubcat';
		return $this->layer->selectOne($sql,array(':upsubcat'=>$upsubcat));
    }
	/**
    * Selectionne le maximum des identifiants "order" pour les sous catégories
    */
    function s_max_order_catalog_subcategory(){
    	$sql = 'SELECT max(s.sorder) as clsorder FROM mc_catalog_s as s';
		return $this->layer->selectOne($sql);
    }
	/**
	 * Selectionne les sous catégorie d'une catégorie
	 *
	 * @param getidclc
	 */
	function s_json_subcategory($getidclc){
		$sql='SELECT s.idcls,s.slibelle FROM mc_catalog_c as c
		LEFT JOIN mc_catalog_s as s USING (idclc)
		where idclc = :idclc';
		return $this->layer->select($sql,array(':idclc'=>$getidclc));
	}
	/**
	 * insertion d'une nouvelle sous catégorie
	 * @param $slibelle
	 * @param $pathslibelle
	 * @param $idlang
	 * @param $sorder
	 */
	function i_catalog_subcategory($slibelle,$pathslibelle,$idclc){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_max_order_catalog_subcategory();
		$sql = 'INSERT INTO mc_catalog_s (slibelle,pathslibelle,idclc,sorder) VALUE(:slibelle,:pathslibelle,:idclc,:sorder)';
		$this->layer->insert($sql,
		array(
			':slibelle'			=>	$slibelle,
			':pathslibelle'		=>	$pathslibelle,
			':idclc'			=>	$idclc,
			':sorder'			=>	$maxorder['clsorder'] + 1
		));
	}
	/**
	 * Met à jour l'ordre d'affichage des sous catégories
	 * @param $i
	 * @param $id
	 */
	function u_order_catalog_subcategory($i,$id){
		$sql = 'UPDATE mc_catalog_s SET sorder = :i WHERE idcls = :id';
		$this->layer->update($sql,
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
	function u_catalog_subcategory($slibelle,$pathslibelle,$upsubcat){
		$sql = 'UPDATE mc_catalog_s SET slibelle = :slibelle,pathslibelle = :pathslibelle WHERE idcls = :upsubcat';
		$this->layer->update($sql,
			array(
			':slibelle'		=>	$slibelle,
			':pathslibelle'	=>	$pathslibelle,
			':upsubcat'		=>	$upsubcat
			)
		);
	}
	/**
     * Suppression d'une sous catégorie
     * @param $dels
     */
	function d_catalog_subcategory($dels){
		$sql = 'DELETE FROM mc_catalog_s WHERE idcls = :dels';
			$this->layer->delete($sql,
			array(
				':dels'	=>	$dels
			)); 
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
		return $this->layer->selectOne($sql);
	}
	/**
	 * Retourne le nombre maximum de pages
	 * @return void
	 */
	function s_count_catalog_pager_max(){
		$sql = 'SELECT count(p.idcatalog) as total FROM mc_catalog as p';
		return $this->layer->select($sql);
	}
	/**
	 * Retourne l'url du produit courant pour la génération d'image intelligente
	 * @param $getimg
	 */
	function s_uniq_url_catalog($getimg){
		$sql = 'SELECT urlcatalog FROM mc_catalog WHERE idcatalog = :getimg';
		return $this->layer->selectOne($sql,array(
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
    	$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang,img.imgcatalog, lang.codelang, m.pseudo
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( p.idadmin = m.idadmin )
		ORDER BY p.'.$sort.' DESC'.$limit.$offset;
		return $this->layer->select($sql,false,'assoc');
    }
    /**
     * Selectionne les produits correspondant au catalogue
     * @param $editproduct
     */
	function s_catalog_product($editproduct){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE idcatalog = :editproduct';
		return $this->layer->select($sql,array(":editproduct"=>$editproduct));
    }
	/**
     * Selectionne les produits correspondant à la langue du catalogue
     * @param $editproduct
     */
	function s_catalog_product_for_lang($getidclc){
    	$sql = 'SELECT p.idproduct, c.clibelle, s.slibelle, card.titlecatalog
				FROM mc_catalog_product AS p
				LEFT JOIN mc_catalog AS card USING ( idcatalog )
				LEFT JOIN mc_catalog_c AS c USING ( idclc )
				LEFT JOIN mc_catalog_s AS s USING ( idcls )
				WHERE c.idclc =:idclc ORDER BY s.idcls';
		return $this->layer->select($sql,array("idclc"=>$getidclc));
    }
	/**
	 * Selectionne les donnée du formulaire pour la mise à jour d'un produit
	 * @param $editproduct
	 */
	function s_data_forms($editproduct){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.price, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcatalog = :editproduct';
		return $this->layer->selectOne($sql,array(
			':editproduct'=>$editproduct
		));
	}
	/**
	 * Retourne une liste contenant l'identifiant de chaque produit
	 * @return array()
	 */
	function s_idcatalog_product(){
		$sql = 'SELECT p.idcatalog,p.titlecatalog FROM mc_catalog as p';
		return $this->layer->select($sql);
	}
	/**
	 * Sélectionne une image spécifique à une fiche catalogue
	 * @param $getimg
	 */
	function s_image_product($getimg){
		$sql = 'SELECT img.imgcatalog FROM mc_catalog_img as img WHERE idcatalog = :getimg';
		return $this->layer->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Compte le nombre d'image pour une fiche catalogue
	 * @param $getimg
	 */
	function count_image_product($getimg){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_img as img WHERE idcatalog = :getimg';
		return $this->layer->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	function s_catalog_max_rel_product(){
		$sql = 'SELECT count(idrelproduct) as max FROM mc_catalog_rel_product';
		return $this->layer->selectOne($sql);
	}
	function s_catalog_product_info($idproduct){
		$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.codelang
				FROM mc_catalog_product AS p
				LEFT JOIN mc_catalog AS card USING ( idcatalog )
				LEFT JOIN mc_catalog_c AS c USING ( idclc )
				LEFT JOIN mc_catalog_s AS s USING ( idcls )
				LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
				WHERE idproduct = :idproduct';
		return $this->layer->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}
	function s_catalog_rel_product($idcatalog){
		$sql = 'SELECT rel.idrelproduct,rel.idproduct FROM mc_catalog_rel_product AS rel
				WHERE rel.idcatalog = :idcatalog';
		return $this->layer->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
    /**
     * Insert un nouveau produit dans la table mc_catalog
     */
	function i_catalog_card_product($idlang,$idadmin,$urlcatalog,$titlecatalog,$desccatalog,$price){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_count_catalog_max();
		$sql = 'INSERT INTO mc_catalog (idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog) 
		VALUE(:idlang,:idadmin,:urlcatalog,:titlecatalog,:desccatalog,:price,:ordercatalog)';
		$this->layer->insert($sql,
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
	function i_catalog_product($idcatalog,$idclc,$idcls){
		$sql = 'INSERT INTO mc_catalog_product (idcatalog,idclc,idcls) VALUE(:idcatalog,:idclc,:idcls)';
		$this->layer->insert($sql,
		array(
			':idcatalog'=>	$idcatalog,
			':idclc'	=>	$idclc,
			':idcls'	=>	$idcls
		));
	}
	/**
	 * 
	 * Insertion d'un produit lié
	 * @param $idrelproduct
	 * @param $idcatalog
	 * @param $idproduct
	 */
	function i_catalog_rel_product($idrelproduct,$idcatalog,$idproduct){
		$sql = 'INSERT INTO mc_catalog_rel_product (idrelproduct,idcatalog,idproduct) 
		VALUE(:idrelproduct,:idcatalog,:idproduct)';
		$this->layer->insert($sql,
		array(
			':idrelproduct'	=>	$idrelproduct,
			':idcatalog'	=>	$idcatalog,
			':idproduct'	=>	$idproduct
		));
	}
	/**
	 * Copie un enregistrement dans une autre catégorie, sous catégorie et langue
	 * @param $idadmin
	 * @param $idclc
	 * @param $idcls
	 * @param $idlang
	 * @param $copyproduct
	 */
	function copy_catalog_product($idclc,$idcls,$idlang,$idadmin,$copyproduct){
		$sql = 'INSERT INTO mc_catalog (idclc,idcls,idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog) 
		SELECT :idclc,:idcls,:idlang,:idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog FROM mc_catalog
		WHERE idcatalog = :copyproduct';
		$this->layer->insert($sql,
		array(
			':idclc'			=>	$idclc,
			':idcls'			=>	$idcls,
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
		$this->layer->insert($sql,
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
	function u_catalog_product($idadmin,$titlecatalog,$urlcatalog,$desccatalog,$price,$editproduct){
		$sql = 'UPDATE mc_catalog SET idadmin=:idadmin,titlecatalog=:titlecatalog
		,urlcatalog=:urlcatalog,desccatalog=:desccatalog,price=:price 
		WHERE idcatalog=:editproduct';
		$this->layer->insert($sql,
		array(
			':idadmin'			=>	$idadmin,
			':titlecatalog'		=>	$titlecatalog,
			':urlcatalog'		=>	$urlcatalog,
			':desccatalog'		=>	$desccatalog,
			':price'			=>	$price,
			':editproduct'		=>	$editproduct
		));
	}
	/**
	 * Déplace un produit dans une autre catégorie
	 * @param $idadmin
	 * @param $idclc
	 * @param $idcls
	 * @param $moveproduct
	 */
	function u_catalog_product_move($idclc,$idcls,$idadmin,$moveproduct){
		$sql = 'UPDATE mc_catalog SET idadmin=:idadmin,idclc=:idclc,idcls=:idcls
		WHERE idcatalog=:moveproduct';
		$this->layer->update($sql,
		array(
			':idclc'			=>	$idclc,
			':idcls'			=>	$idcls,
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
		$this->layer->update($sql,
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
		'DELETE FROM mc_catalog_img WHERE idcatalog = '.$delproduct
		,'DELETE FROM mc_catalog WHERE idcatalog = '.$delproduct);
		$this->layer->transaction($sql); 
	}
	/**
	 * Suppression des produits ainsi que des produits lié à celui-ci
	 * @param $d_in_product
	 */
	function d_in_product($d_in_product){
		$sql = array('DELETE FROM mc_catalog_rel_product WHERE idproduct ='.$d_in_product,
		'DELETE FROM mc_catalog_product WHERE idproduct ='.$d_in_product);
		$this->layer->transaction($sql); 
	}
	/**
	 * Suppression des produits associé ou liaison de produits à une fiche
	 * @param $d_in_product
	 */
	function d_rel_product($d_in_product){
		$sql = 'DELETE FROM mc_catalog_rel_product WHERE idproduct = :d_in_product';
		$this->layer->delete($sql,array(':d_in_product'=>$d_in_product)); 
	}
	/**
	 * ################ Galerie d'image pour un produit ###################
	 */
	/**
	 * Sélectionne la denière image ajouter dans la base de donnée galery (catalogue)
	 * 
	 */
	function s_galery_image_product(){
		$sql = 'SELECT img.imgcatalog FROM mc_catalog_galery as img WHERE idmicro = '.$this->layer->lastInsert();
		return $this->layer->selectOne($sql);
	}
	/**
	 * Récupère le nom de l'image avant la suppression (micro galerie)
	 * 
	 */
	function s_galery_image_micro($delmicro){
		$sql = 'SELECT imgcatalog FROM mc_catalog_galery WHERE idmicro = :delmicro';
		return $this->layer->selectOne($sql,
			array(
				':delmicro'	=>	$delmicro
			)); 
	}
	/**
	 * Compte le nombre d'image pour une galerie catalogue
	 * @param $getimg
	 */
	function count_image_in_galery_product($getimg){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_galery as img WHERE idcatalog = :getimg';
		return $this->layer->selectOne($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Selectionne toutes les images dans une galerie d'un produit
	 * @param $getimg
	 */
	function s_image_in_galery_product($getimg){
		$sql = 'SELECT img.idmicro,img.imgcatalog FROM mc_catalog_galery as img WHERE idcatalog = :getimg';
		return $this->layer->select($sql,array(
			':getimg'	=>	$getimg
		));
	}
	/**
	 * Insère une image dans la galerie du produit
	 * @param $idcatalog
	 * @param $imgcatalog
	 */
	function i_galery_image_catalog($idcatalog,$imgcatalog){
		$sql = 'INSERT INTO mc_catalog_galery (idcatalog,imgcatalog) VALUE(:idcatalog,:imgcatalog)';
		$this->layer->insert($sql,
		array(
			':idcatalog'	=>	$idcatalog,
			':imgcatalog'	=>	$imgcatalog
		));
	}
	/**
	 * Supprime Une image dans une galerie catalogue
	 * @param $delmicro
	 */
	function d_galery_image_catalog($delmicro){
		$sql = 'DELETE FROM mc_catalog_galery WHERE idmicro = :delmicro';
			$this->layer->delete($sql,
			array(
				':delmicro'	=>	$delmicro
			)); 
	}
}