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
    	$sql = 'SELECT c.idclc, c.clibelle, c.pathclibelle, lang.codelang
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
 	function s_catalog_images(){
    	$sql = 'SELECT imgcatalog FROM mc_catalog_img';
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