<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_db_catalog{
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
	static public $publicdbcatalog;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
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
		return $this->layer->selectOne($sql,array(
			':idclc'=>$idclc
		));
    }
    /**
     * Charge les articles de la catégorie (sans langue) (root catégorie)
     * @param $idclc
     */
	function s_category_page_no_language($idclc){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc, p.idcls,p.desccatalog,p.price, c.pathclibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND p.idlang = 0';
		return $this->layer->select($sql,array(
			':idclc'=>$idclc
		));
	}
	/**
     * Charge les articles de la catégorie (avec la langue)
     * @param $idclc
     * @param $codelang
     */
	function s_category_page_with_language($idclc,$codelang){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc, p.idcls,p.desccatalog,p.price, c.pathclibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = 0 AND lang.codelang = :codelang';
		return $this->layer->select($sql,array(
			':idclc'=>$idclc,
			':codelang'=>$codelang
		));
	}
	/*############# SOUS CATEGORIE ###################*/
	function s_current_name_subcategory($idcls){
    	$sql = 'SELECT s.slibelle,s.pathslibelle
		FROM mc_catalog_s as s WHERE s.idcls = :idcls';
		return $this->layer->selectOne($sql,array(
			':idcls'=>$idcls
		));
    }
	/**
     * Charge les articles de la sous catégorie (sans langue)
     * @param $idclc
     */
	function s_sub_category_page_no_language($idclc,$idcls){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc, p.idcls,p.desccatalog,p.price, c.pathclibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND p.idlang = 0';
		return $this->layer->select($sql,array(
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
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc, p.idcls,p.desccatalog,p.price, c.pathclibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcls = :idcls AND lang.codelang = :codelang';
		return $this->layer->select($sql,array(
			':idclc'	=>$idclc,
			':idcls'	=>$idcls,
			':codelang' =>$codelang
		));
	}
/*############### Product ##############*/
	function s_product_page_no_language($idclc,$idcatalog){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls,c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle, img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcatalog = :idcatalog AND p.idlang = 0';
		return $this->layer->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idcatalog'	=>	$idcatalog
		));
	}
	function s_product_page_with_language($idclc,$idcatalog,$codelang){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.desccatalog, p.idlang, p.idclc, p.idcls, c.clibelle, c.pathclibelle, s.slibelle, s.pathslibelle,img.imgcatalog, lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_catalog_img as img ON ( img.idcatalog = p.idcatalog )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idclc = :idclc AND p.idcatalog = :idcatalog AND lang.codelang = :codelang';
		return $this->layer->selectOne($sql,array(
			':idclc'		=>	$idclc,
			':idcatalog'	=>	$idcatalog,
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
		return $this->layer->select($sql);
	}
	/**
	 * construction menu des catégories (avec langue)
	 */
	function s_category_menu_with_lang($codelang){
		$sql = 'SELECT c.idlang, c.clibelle,c.pathclibelle, c.idclc, lang.codelang
				FROM mc_catalog_c AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.codelang = :codelang ORDER BY corder';
		return $this->layer->select($sql,array(':codelang'		=>	$codelang));
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
		return $this->layer->select($sql,array(
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
		return $this->layer->select($sql);
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
		return $this->layer->select($sql,array(
			':idclc'=>$idclc,
			':codelang'		=>	$codelang
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang($idcls){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc
		, p.idcls, c.pathclibelle, s.pathslibelle,lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = :idcls AND p.idlang = 0';
		return $this->layer->select($sql,array(
			':idcls'=>$idcls
		));
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_no_lang_no_cat(){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc
		, p.idcls, c.pathclibelle, s.pathslibelle,lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND p.idlang = 0';
		return $this->layer->select($sql);
	}
	/**
	 * construction menu des produits (sans langue,avec catégorie)
	 * @param idclc
	 */
	function s_product_menu_with_lang_no_cat($codelang){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.titlecatalog, p.idlang, p.idclc
		, p.idcls, c.pathclibelle, s.pathslibelle,lang.codelang
		FROM mc_catalog AS p
		LEFT JOIN mc_catalog_c AS c ON ( c.idclc = p.idclc )
		LEFT JOIN mc_catalog_s AS s ON ( s.idcls = p.idcls )
		LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
		WHERE p.idcls = 0 AND lang.codelang = :codelang';
		return $this->layer->select($sql,array(
			':codelang'		=>	$codelang
		));
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (sans langue)
	 */
	function s_category_withimg_nolang(){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
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
		WHERE p.idlang = 0';
		return $this->layer->select($sql);
	}
	/**
	 * Construction du menu des catégories avec capture des derniers articles (avec langue)
	 * @param $codelang (langue)
	 */
	function s_category_withimg_lang($codelang){
		$sql = 'SELECT p.idcatalog, p.urlcatalog, p.idlang, 
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
		WHERE lang.codelang = :codelang';
		return $this->layer->select($sql,array(':codelang'		=>	$codelang));
	}
	/*################# micro galerie ##################*/
	/**
	 * Compte le nombre d'image pour une galerie catalogue
	 * @param $getimg
	 */
	function count_image_in_galery_product($idcatalog){
		$sql = 'SELECT count(img.imgcatalog) as cimage FROM mc_catalog_galery as img WHERE idcatalog = :idcatalog';
		return $this->layer->selectOne($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
/**
 * selectionne les images pour la construction d'une micro galerie d'un produit
 * @param intéger $idcatalog
 */
	function s_microgalery_product($idcatalog){
		$sql = 'SELECT img.idmicro,img.imgcatalog FROM mc_catalog_galery as img WHERE idcatalog = :idcatalog';
		return $this->layer->select($sql,array(
			':idcatalog'	=>	$idcatalog
		));
	}
}