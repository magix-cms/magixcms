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
	function s_catalog_category_corder(){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.codelang FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.corder';
		return $this->layer->select($sql);
    }
	function s_catalog_category_select_construct(){
    	$sql = 'SELECT c.idclc,c.clibelle,c.pathclibelle,lang.codelang FROM mc_catalog_c as c 
    	LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
    	ORDER BY c.idlang';
		return $this->layer->select($sql);
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
	function s_catalog_subcategory_sorder(){
    	$sql = 'SELECT s.idcls,s.slibelle,s.pathslibelle,c.clibelle,lang.codelang FROM mc_catalog_s as s
		LEFT JOIN mc_catalog_c AS c ON(c.idclc = s.idclc)
		LEFT JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
		ORDER BY s.sorder';
		return $this->layer->select($sql);
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
    * Selectionne le maximum des identifiants "order" pour les sous catégories
    */
    function s_max_order_catalog_subcategory(){
    	$sql = 'SELECT max(s.sorder) as clsorder FROM mc_catalog_s as s';
		return $this->layer->selectOne($sql);
    }
	/**
	 * function load row by sub category ID
	 *
	 * @return void
	 */
	function s_json_subcategory($getidclc){
		$sql='SELECT * FROM mc_catalog_s where idclc = :idclc';
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
     * selectionne les pages du catalog avec un paramètre optionnelle du nombre
     * @param $limit
     * @param $max
     */
    function s_catalog_plugin($limit=false,$max=null,$offset=null,$sort){
    	$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
    	$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang,p.idclc,p.idcls, c.clibelle, 
    	s.slibelle,c.pathclibelle,s.pathslibelle,img.imgcatalog, lang.codelang, m.pseudo
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c as c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s as s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( p.idadmin = m.idadmin )
		ORDER BY p.'.$sort.' DESC'.$limit.$offset;
		return $this->layer->select($sql,false,'assoc');
    }
    /**
     * Insert un nouveau produit dans la table mc_catalog
     */
	function i_catalog_product($idclc,$idcls,$idlang,$idadmin,$urlcatalog,$titlecatalog,$desccatalog,$price){
		// récupère le nombre maximum de la colonne order
		$maxorder = self::s_count_catalog_max();
		$sql = 'INSERT INTO mc_catalog (idclc,idcls,idlang,idadmin,urlcatalog,titlecatalog,desccatalog,price,ordercatalog) 
		VALUE(:idclc,:idcls,:idlang,:idadmin,:urlcatalog,:titlecatalog,:desccatalog,:price,:ordercatalog)';
		$this->layer->insert($sql,
		array(
			':idclc'			=>	$idclc,
			':idcls'			=>	$idcls,
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
	 * Selectionne les donnée du formulaire pour la mise à jour d'un produit
	 * @param $editproduct
	 */
	function s_data_forms($editproduct){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.price, p.idclc, p.idcls, c.clibelle, 
    	s.slibelle, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c as c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s as s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcatalog = :editproduct';
		return $this->layer->selectOne($sql,array(
			':editproduct'=>$editproduct
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