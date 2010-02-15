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
class frontend_db_news{
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
	static public $publicdbnews;
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
	public static function publicDbNews(){
        if (!isset(self::$publicdbnews)){
         	self::$publicdbnews = new frontend_db_news();
        }
    	return self::$publicdbnews;
    }
/**
	 * Affiche les données d'une news
	 * @param $getsubject
	 */
	function s_news_page($getdate,$getnews){
		$sql = 'SELECT n.subject,n.content,lang.codelang,n.idlang,n.date_sent
				FROM mc_news AS n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				WHERE n.rewritelink = :getnews AND n.date_sent = :getdate';
		return $this->layer->selectOne($sql,array(
			':getnews'=>$getnews,
			':getdate'=>$getdate
		));
	}
	/**
	 * Retourne le nombre maximum de news publié
	 * @return void
	 */
	function s_count_news_publish_max(){
		$sql = 'SELECT count(pub.idnews) as total 
		FROM mc_news_publication as pub
		WHERE pub.publish = 1';
		return $this->layer->selectOne($sql);
	}
	/**
	 * Sélectionne toutes les news publié trié par date
	 */
	function s_news_plugins($limit=false,$max=null,$offset=null){
		$limit = $limit ? ' LIMIT '.$max : '';
    	$offset = !empty($offset) ? ' OFFSET '.$offset: '';
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 ORDER BY n.date_sent'.$limit.$offset;
		return $this->layer->select($sql);
	}
	/**
	 * Sélectionne la dernière news publié
	 */
	function s_lastnews_plugins(){
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND n.idlang = 0 ORDER BY n.idnews DESC LIMIT 1';
		return $this->layer->selectOne($sql);
	}
	/**
	 * Sélectionne la dernière news publié dans une langue spécifique
	 */
	function s_lastnews_lang_plugins($codelang){
		$sql = 'SELECT n.subject,n.content,n.rewritelink,n.idlang,n.date_sent,lang.codelang
				FROM mc_news as n
				LEFT JOIN mc_lang AS lang ON(n.idlang = lang.idlang)
				LEFT JOIN mc_news_publication as pub ON(pub.idnews = n.idnews)
				WHERE pub.publish = 1 AND lang.codelang = :codelang ORDER BY n.idnews DESC LIMIT 1';
		return $this->layer->selectOne($sql,array(':codelang' =>$codelang));
	}
}