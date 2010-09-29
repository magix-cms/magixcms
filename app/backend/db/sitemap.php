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
class backend_db_sitemap{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $admindbsitemap;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbSitemap(){
        if (!isset(self::$admindbsitemap)){
         	self::$admindbsitemap = new backend_db_sitemap();
        }
    	return self::$admindbsitemap;
    }
    /**
     * Sélections dans les news pour la construction du sitemap
     */
    function s_news_sitemap(){
    	$sql = 'SELECT n.idnews,n.subject,n.content,lang.codelang,n.idlang,n.date_sent,n.rewritelink,pub.date_publication,pub.publish
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE pub.publish = 1 ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les pages CMS pour la construction du sitemap
     */
    function s_cms_sitemap(){
    	$sql = 'SELECT p.idpage, p.subjectpage, p.contentpage,p.idlang,p.idcategory, p.pathpage,p.metatitle,p.metadescription,p.date_page,
    	c.pathcategory, lang.codelang
				FROM mc_cms_page AS p
				LEFT JOIN mc_cms_category AS c ON ( c.idcategory = p.idcategory )
				LEFT JOIN mc_lang AS lang ON ( p.idlang = lang.idlang )
				ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /*
     * Selectionne les catégories du catalogue
     */
	function s_catalog_category_sitemap(){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle, lang.codelang, c.idlang, c.img_c
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /*
     * Selectionne les sous catégories du catalogue
     */
	function s_catalog_subcategory_sitemap(){
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle, s.pathslibelle, lang.codelang
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections les produits pour la construction du sitemap
     */
    function s_catalog_sitemap(){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * @access public
     * Compte le nombre de catégorie par langue + compte le nombre d'image
     */
	function count_catalog_category_sitemap_by_lang(){
    	$sql = 'SELECT count(c.idclc) as category,count(c.img_c) as catimg, lang.codelang, c.idlang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		GROUP BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Retourne des informations
     * @param $idlang
     */
    function s_catalog_category_images_by_lang($idlang){
    	$sql ='SELECT c.idclc, c.clibelle, c.pathclibelle, c.img_c, lang.codelang
		FROM mc_catalog_c AS c
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE c.idlang = :idlang';
    	return magixglobal_model_db::layerDB()->select($sql,array(':idlang'=>$idlang));
    }
    /**
     * Selectionne les sous catégorie d'une catégorie pour le sitemap image
     * @param $idclc
     */
    function s_catalog_subcategory_images_by_lang($idclc){
    	$sql ='SELECT c.idclc, c.clibelle, c.pathclibelle,s.idcls, s.slibelle,s.img_s ,s.pathslibelle, lang.codelang
		FROM mc_catalog_s AS s
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = c.idlang )
		WHERE c.idclc = :idclc';
    	return magixglobal_model_db::layerDB()->select($sql,array(':idclc'=>$idclc));
    }
    /*
     * Compte le nombre d'image et sous catégorie dans la catégorie
     * @param $idclc (integer)
     */
	function count_catalog_subcategory_sitemap($idclc){
    	$sql = 'SELECT s.idclc,count(s.idcls) as category,count(s.img_s) as subcatimg
		FROM mc_catalog_s AS s
		WHERE s.idclc = :idclc';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':idclc'=>$idclc));
    }
    /**
     * Retourne les images produits du catalogue
     */
 	function s_catalog_product_images(){
    	$sql = 'SELECT p.idproduct, c.idclc, c.clibelle, c.pathclibelle, s.idcls, s.slibelle, s.pathslibelle, card.titlecatalog, card.urlcatalog, img.imgcatalog,lang.codelang
		FROM mc_catalog_product AS p
		LEFT JOIN mc_catalog as card USING ( idcatalog )
        LEFT JOIN mc_catalog_img as img USING ( idcatalog)
		LEFT JOIN mc_catalog_c as c USING ( idclc )
		LEFT JOIN mc_catalog_s as s USING ( idcls )
		LEFT JOIN mc_lang AS lang ON ( lang.idlang = card.idlang )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Sélections dans les plugins (répertorié) pour la construction du sitemap
     */
    function s_plugin_sitemap(){
    	$sql = 'SELECT s.idplugin,p.pname FROM mc_sitemaps_config as s
    			LEFT JOIN mc_plugins_module AS p ON ( s.idplugin = p.idplugin )';
		return magixglobal_model_db::layerDB()->select($sql);
    }
/**
     * Sélections dans les news pour la construction du RSS
     */
    function s_news_rss(){
    	$sql = 'SELECT n.idnews,n.subject,n.content,lang.codelang,n.idlang,n.date_sent,n.rewritelink,pub.date_publication,pub.publish
				FROM mc_news AS n
				LEFT JOIN mc_news_publication AS pub ON(pub.idnews = n.idnews)
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE pub.publish = 1 ORDER BY lang.idlang, n.idnews DESC';
		return magixglobal_model_db::layerDB()->select($sql);
    }
}