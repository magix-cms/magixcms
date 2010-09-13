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
class backend_db_lang{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbhome
	 * @access public
	 * @var void
	 */
	static public $dblang;
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
	public static function dblang(){
        if (!isset(self::$dblang)){
         	self::$dblang = new backend_db_lang();
        }
    	return self::$dblang;
    }
    /**
     * retourne la liste des langues disponible
     */
    public function s_full_lang(){
    	$sql = 'SELECT lang.codelang,lang.idlang FROM mc_lang AS lang';
		return $this->layer->select($sql);
    }
	/**
     * retourne la liste des langues disponible
     */
    public function s_full_lang_data(){
    	$sql = 'SELECT lang.codelang,lang.idlang,lang.desclang FROM mc_lang AS lang';
		return $this->layer->select($sql);
    }
	/**
     * Vérifie si la langue existe
     */
    public function s_verif_lang($codelang){
    	$sql = 'SELECT lang.idlang FROM mc_lang AS lang WHERE codelang = :codelang';
		return $this->layer->selectOne($sql,array(
			':codelang'			=>	$codelang
		));
    }
	public function s_lang_edit($idlang){
    	$sql = 'SELECT lang.idlang,lang.codelang,lang.desclang FROM mc_lang AS lang WHERE idlang = :idlang';
		return $this->layer->selectOne($sql,array(
			':idlang'	=>	$idlang
		));
    }
    /**
     * ajout d'une nouvelle langue
     * @param $codelang
     * @param $desclang
     */
	public function i_new_lang($codelang,$desclang){
		$sql = 'INSERT INTO mc_lang (codelang,desclang) VALUE(:codelang,:desclang)';
		$this->layer->insert($sql,
		array(
			':codelang'			=>	$codelang,
			':desclang'			=>	$desclang
		));
	}
	/*
	 * Compte et retourne le nombre d'enregistrement dans la table home par langue
	 */
	public function count_lang_home(){
		$sql ='SELECT count(h.idhome) as countlang,lang.codelang,lang.desclang
				FROM mc_page_home AS h
				LEFT JOIN mc_lang AS lang ON(h.idlang = lang.idlang)
				GROUP BY h.idlang';
		return $this->layer->select($sql);
	}
	/*
	 * Compte et retourne le nombre d'enregistrement dans la table page (cms) par langue
	 */
	public function count_lang_pages(){
		$sql ='SELECT count(cms.idpage) as countlang,lang.codelang,lang.desclang
				FROM mc_cms_page AS cms
				LEFT JOIN mc_lang AS lang ON(cms.idlang = lang.idlang)
				GROUP BY cms.idlang';
		return $this->layer->select($sql);
	}
	/**
	 * Compte le nombre de langues dans le module news
	 */
	public function count_lang_news(){
		$sql = 'SELECT count( news.idnews ) AS countlang, lang.codelang, lang.desclang
				FROM mc_news AS news
				LEFT JOIN mc_lang AS lang ON ( news.idlang = lang.idlang )
				GROUP BY news.idlang';
		return $this->layer->select($sql);
	}
	/**
	 * Compte et additionne le nombre de pages,news,home
	 * @param $idlang
	 */
	public function global_count($idlang){
		$sql = 'SELECT (count( news.idnews ) + count( cms.idpage )+ count( h.idhome )) as ctotal
				FROM mc_lang as lang
				LEFT JOIN mc_news AS news ON ( news.idlang = lang.idlang )
				LEFT JOIN mc_cms_page AS cms ON ( cms.idlang = lang.idlang )
				LEFT JOIN mc_page_home AS h ON ( h.idlang = lang.idlang )
				WHERE lang.idlang = :idlang';
		return $this->layer->selectOne($sql,
		array(
			':idlang'	=>	$idlang
		));
	}
	public function u_lang($codelang,$desclang,$idlang){
		$sql = 'UPDATE mc_lang SET codelang=:codelang,desclang=:desclang WHERE idlang = :idlang';
		$this->layer->update($sql,
		array(
			':codelang'	=>	$codelang,
			':desclang'	=>	$desclang,
			':idlang'	=>	$idlang
		));
	}
	/**
	 * Suppression de la langue 
	 * @param void $dellang
	 */
	public function d_lang($dellang){
		$sql = 'DELETE FROM mc_lang WHERE idlang = :dellang';
		$this->layer->delete($sql,
		array(
				':dellang'	=>	$dellang
		)); 
	}
}