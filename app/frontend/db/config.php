<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_config{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $frontenddbconfig;
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
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
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
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
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
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':named' =>	$named
		));
    }
}