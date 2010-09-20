<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_catalog{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbcatalog;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function publicDbCatalog(){
        if (!isset(self::$publicdbcatalog)){
         	self::$publicdbcatalog = new frontend_db_catalog();
        }
    	return self::$publicdbcatalog;
    }
/*####### CATEGORIE #######*/
    function s_current_name_category($idclc){
    	$sql = 'SELECT c.clibelle,c.pathclibelle
		FROM mc_catalog_c as c WHERE c.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'=>$idclc
		));
    }
    /**
     * Charge les articles de la catégorie (sans langue) (root catégorie)
     * pour la liste en image
     * @param $idclc
     */
	function s_product_in_category_no_language($idclc){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND catalog.idlang = 0
		ORDER BY p.idcatalog DESC';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc
		));
	}
	/**
     * Charge les articles de la catégorie (avec la langue) pour la liste en image
     * @param $idclc
     * @param $codelang
     */
	function s_product_in_category_with_language($idclc,$codelang){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND lang.codelang = :codelang ORDER BY p.idcatalog DESC';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc,
			':codelang'=>$codelang
		));
	}
	/*############# SOUS CATEGORIE ###################*/
	function s_current_name_subcategory($idcls){
    	$sql = 'SELECT s.slibelle,s.pathslibelle,c.clibelle,c.pathclibelle
    	FROM mc_catalog_s as s 
    	LEFT JOIN mc_catalog_c AS c ON ( c.idclc = s.idclc )
		WHERE s.idcls = :idcls';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idcls'=>$idcls
		));
    }
	/**
     * Charge les articles de la sous catégorie (sans langue)
     * @param $idclc
     */
	function s_sub_category_page_no_language($idclc,$idcls){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND catalog.idlang = 0 ORDER BY p.idcatalog DESC';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc,
			':idcls'=>$idcls
		));
	}
	/**
     * Charge les articles de la sous catégorie (avec langue)
     * @param $idclc
     * @param $idcls
     * @param $codelang
     */
	function s_sub_category_page_with_language($idclc,$idcls,$codelang){
		$sql = 'SELECT p.idproduct, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,catalog.desccatalog, c.pathclibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND lang.codelang = :codelang ORDER BY p.idcatalog DESC';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'	=>$idclc,
			':idcls'	=>$idcls,
			':codelang' =>$codelang
		));
	}
/*############### Product ##############*/
	function s_product_page_no_language($idclc,$idproduct){
		$sql = 'SELECT p.idproduct,p.idcatalog, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, 
		catalog.price,catalog.desccatalog, c.clibelle,c.pathclibelle,s.slibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idproduct = :idproduct AND catalog.idlang = 0';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idproduct'	=>	$idproduct
		));
	}
	function s_product_page_with_language($idclc,$idproduct,$codelang){
		$sql = 'SELECT p.idproduct,p.idcatalog, catalog.urlcatalog, catalog.titlecatalog, catalog.idlang, p.idclc, p.idcls, catalog.price,
		catalog.desccatalog,c.clibelle, c.pathclibelle,s.slibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS catalog ON ( catalog.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( catalog.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idproduct = :idproduct AND lang.codelang = :codelang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idproduct'	=>	$idproduct,
			':codelang'		=>	$codelang
		));
	}
/*################## menu #############################*/
	/**
	 * construction menu des catégories (sans langue)
	 */
	function s_category_menu_no_lang(){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang = 0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des catégories (avec langue)
	 */
	function s_category_menu_with_lang($codelang){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.codelang = :codelang ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
		':codelang'		=>	$codelang
		));
	}
	/**
	 * construction menu des sous catégories (sans langue)
	 * @param idclc
	 */
	function s_sub_category_menu_no_lang($idclc){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc AND c.idlang =0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc
		));
	}
	/**
	 * construction menu des sous categories (avec langue) + catégories
	 */
	function s_sub_category_menu_all_no_lang(){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang =0 ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des sous catégories (avec langue)
	 * @param idclc
	 * @param codelang
	 */
	function s_sub_category_menu_with_lang($idclc,$codelang){
		$sql = 'SELECT c.idlang, c.clibelle, c.pathclibelle, c.idclc, s.slibelle, s.pathslibelle, s.idcls, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_catalog_s AS s ON ( s.idclc = c.idclc )
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idclc = :idclc AND lang.codelang = :codelang ORDER BY corder';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idclc'=>$idclc,
			':codelang'		=>	$codelang
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang($idcls){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = :idcls AND p.idlang = 0';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcls'=>$idcls
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang_no_cat(){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND p.idlang = 0';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_with_lang_no_cat($codelang){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND lang.codelang = :codelang';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':codelang'		=>	$codelang
		));
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (sans langue)
	 */
	function s_category_withimg_nolang(){
		/*$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
		p.idclc, p.idcls, c.pathclibelle,clibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		JOIN (
			SELECT max( p.idcatalog ) id, c.idclc FROM mc_catalog AS p
			LEFT JOIN mc_catalog_c AS c ON c.idclc = p.idclc
			GROUP BY c.idclc
		)catalog_id_max ON ( p.idcatalog = catalog_id_max.id )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idlang = 0';*/
		$sql = 'SELECT c.idclc,c.pathclibelle,c.clibelle,c.img_c,c.idlang, lang.codelang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE c.idlang = 0';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (avec langue)
	 * @param $codelang (langue)
	 */
	function s_category_withimg_lang($codelang){
		/*$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
		p.idclc, p.idcls, c.pathclibelle,clibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		JOIN (
			SELECT max( p.idcatalog ) id, c.idclc FROM mc_catalog AS p
			LEFT JOIN mc_catalog_c AS c ON c.idclc = p.idclc
			GROUP BY c.idclc
		)catalog_id_max ON ( p.idcatalog = catalog_id_max.id )
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_img AS img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE lang.codelang = :codelang';*/
		$sql = 'SELECT c.idclc,c.pathclibelle,c.clibelle,c.img_c,c.idlang, lang.codelang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		WHERE lang.codelang = :codelang';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':codelang'		=>	$codelang)
		);
	}
	/*################# micro galerie ##################*/
	function s_identifier_catalog($idproduct){
		$sql = 'SELECT product.idcatalog FROM mc_catalog_product as product WHERE idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}
	/**
	 * Compte le nombre d'image pour une galerie catalogue
	 * @param $getimg
	 */
	function count_image_in_galery_product($idcatalog){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_galery as img WHERE idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
/**
 * selectionne les images pour la construction d'une micro galerie d'un produit
 * @param intéger $idcatalog
 */
	function s_microgalery_product($idcatalog){
		$sql = 'SELECT img.idmicro,img.imgcatalog FROM mc_catalog_galery as img WHERE idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
	/**
	 * Produits liés
	 */
	/**
	 * Selectionne les produits liés du produit courant
	 * @param $idcatalog
	 */
	function s_catalog_rel_product($idcatalog){
		$sql = 'SELECT rel.idrelproduct,rel.idproduct FROM mc_catalog_rel_product AS rel
				WHERE rel.idcatalog = :idcatalog';
		return magixglobal_model_db::layerDB()->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
	/**
	 * Retourne les informations de la fiche produit
	 * @param $idproduct
	 */
	function s_catalog_product_info($idproduct){
		$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle,
		card.titlecatalog, card.urlcatalog, lang.codelang,img.imgcatalog
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog AS card USING ( idcatalog )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_catalog_c AS c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		WHERE idproduct = :idproduct';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idproduct'	=>	$idproduct
		));
	}
}