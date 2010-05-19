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
class frontend_db_config{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $frontenddbconfig;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance backend_db_config with singleton
	 */
	public static function frontendDCconfig(){
        if (!isset(self::$frontenddbconfig)){
         	self::$frontenddbconfig = new frontend_db_config();
        }
    	return self::$frontenddbconfig;
    }
    /**
     * selectionne la réécriture des métas par langue
     * @param $idconfig
     * @param $idmetas
     * @param $codelang
     */
	function s_plugin_rewrite_meta($idconfig,$idmetas,$level,$codelang){
		$sql = 'SELECT r.strrewrite FROM mc_metas_rewrite as r
		LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		WHERE r.idconfig = :idconfig
		AND r.idmetas = :idmetas
		AND r.level = :level
		AND lang.codelang = :codelang';
		return $this->layer->selectOne($sql,array(
			':idconfig'	=>	$idconfig,
			':idmetas'	=>	$idmetas,
			':level'	=>	$level,
			':codelang'	=>	$codelang
		));
	}
	/**
	 * selectionne la réécriture des métas sans langue
	 * @param $idconfig
	 * @param $idmetas
	 */
	function s_plugin_rewrite_meta_emptylanguage($idconfig,$idmetas,$level){
		$sql = 'SELECT r.strrewrite FROM mc_metas_rewrite as r
		LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		WHERE r.idconfig = :idconfig
		AND r.idmetas = :idmetas
		AND r.level = :level
		AND r.idlang = 0';
		return $this->layer->selectOne($sql,array(
			':idconfig'	=>	$idconfig,
			':idmetas'	=>	$idmetas,
			':level'	=>	$level
		));
	}
	/**
     * Selectionne la configuration global suivant la variable
     * @param $named
     */
    function s_public_config_named($named){
    	$sql = 'SELECT named,status FROM mc_global_config WHERE named = :named';
    	return $this->layer->selectOne($sql,array(
			':named' =>	$named
		));
    }
}