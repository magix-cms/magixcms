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
class frontend_db_cms{
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
	static public $publicdbcms;
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
	public static function publicDbCms(){
        if (!isset(self::$publicdbcms)){
         	self::$publicdbcms = new frontend_db_cms();
        }
    	return self::$publicdbcms;
    }
    /**
     * ################################ Pages ###############################
     */
	/**
	 * Affiche les données d'une page CMS
	 * @param $getpurl
	 */
	function s_cms_page($getpurl){
		$sql = 'SELECT p.subjectpage,p.contentpage,p.idlang,lang.codelang,c.pathcategory,c.category
				FROM mc_cms_page as p
				LEFT JOIN mc_lang AS lang ON(p.idlang = lang.idlang)
				LEFT JOIN mc_cms_category as c ON(c.idcategory = p.idcategory)
				WHERE p.pathpage = :getpurl';
		return $this->layer->selectOne($sql,array(
			':getpurl'=>$getpurl
		));
	}
	/**
	 * Affiche les données métas d'une page CMS
	 * @param $getpurl
	 */
	function s_cms_seo($getpurl){
		$sql = 'SELECT p.metatitle,p.metadescription
				FROM mc_cms_page as p
				WHERE p.pathpage = :getpurl';
		return $this->layer->selectOne($sql,array(
			':getpurl'=>$getpurl
		));
	}
	/**
	 * ######################### Menu ou sidebar #########################
	 */
	/**
	 * sélectionne les pages classique (catégorie + langue)
	 * @param $codelang
	 */
	/*function s_page_cms($codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory, lang.codelang
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.codelang =:codelang AND p.idcategory != 0
				ORDER BY p.orderpage,c.idorder';
		return $this->layer->select($sql,array('codelang'=>$codelang));
	}*/
	/**
	 * sélectionne les pages sans la langue
	 */
	/*function s_page_cms_without_lang(){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND p.idlang =0 AND p.idcategory != 0
				ORDER BY p.orderpage,c.idorder';
		return $this->layer->select($sql);
	}*/
	/**
	 * sélectionne les pages avec une langue et sans catégorie
	 */
	function s_root_page_cms($codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang, p.pathpage,p.idcategory,lang.codelang
				FROM mc_cms_page AS p
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.codelang =:codelang AND p.idcategory = 0
				ORDER BY p.orderpage';
		return $this->layer->select($sql,array('codelang'=>$codelang));
	}
	/**
	 * sélectionne les pages sans la langue et sans la catégorie
	 */
	function s_root_page_cms_without_lang(){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage, p.pathpage,p.idcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND p.idlang =0 AND p.idcategory = 0
				ORDER BY p.orderpage';
		return $this->layer->select($sql);
	}
	/**
	 * Selectionne les pages suivant l'identifiant de la catégorie
	 * @param $idcategory
	 */
	function s_page_cms_join_category_without_lang($idcategory){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND p.idlang =0 AND p.idcategory = :idcategory
				ORDER BY p.orderpage';
		return $this->layer->select($sql,array(':idcategory'=>$idcategory));
	}
	/**
	 * Selectionne les pages suivant l'identifiant de la catégorie avec la langue
	 * @param $codelang
	 * @param $idcategory
	 */
	function s_page_cms_join_category($idcategory,$codelang){
		$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory,c.category, p.pathpage,c.pathcategory
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				WHERE viewpage = 1 AND lang.codelang =:codelang AND p.idcategory = :idcategory
				ORDER BY p.orderpage';
		return $this->layer->select($sql,array(':idcategory'=>$idcategory,'codelang'=>$codelang));
	}
	/*function s_all_category_cms(){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				ORDER BY c.idorder';
		return $this->layer->select($sql);
	}*/
	/**
	 * ################## Sélection des Catégories ##########
	 */
	/**
	 * Selectionne les catégories sans langue
	 */
	public function s_category_cms_without_lang(){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE c.idlang = 0
				ORDER BY c.idorder';
		return $this->layer->select($sql);
	}
	/**
	 * Selectionne les catégories avec une langue
	 * @param $codelang
	 */
	public function s_category_cms($codelang){
		$sql = 'SELECT c.idcategory,c.category,c.pathcategory,lang.codelang,c.idorder
				FROM mc_cms_category AS c
				LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
				WHERE lang.codelang = :codelang
				ORDER BY c.idorder';
		return $this->layer->select($sql,array('codelang'=>$codelang));
	}
}