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
class backend_db_config{
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
	static public $admindbconfig;
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
	public static function adminDbConfig(){
        if (!isset(self::$admindbconfig)){
         	self::$admindbconfig = new backend_db_config();
        }
    	return self::$admindbconfig;
    }
    function s_config_named_all(){
    	$sql = 'SELECT * FROM mc_global_config WHERE idconfig >= 5';
    	return $this->layer->select($sql);
    }
    /**
     * Selectionne la configuration global suivant la variable
     * @param $named
     */
    function s_config_named($named){
    	$sql = 'SELECT named,status FROM mc_global_config WHERE named = :named';
    	return $this->layer->selectOne($sql,array(
			':named' =>	$named
		));
    }
    /**
     * mise à jour d'un status global suivant un nom de variable dans la table global_config
     * @param $status
     * @param $named
     */
    function u_config_states($status,$named){
    	$sql = 'UPDATE mc_global_config SET status = :status WHERE named = :named';
		$this->layer->update($sql,
		array(
			':status'  =>	$status,
			':named'   =>	$named
		));
    }
    /**
     * selectionne la métas suivant la catégorie, la langue et le type (title ou description)
     * @param $codelang (langue)
     * @param $idconfig (module ex: rewritenews = 5)
     * @param $idmetas (1 ou 2) (title ou description)
     */
	function s_rewrite_meta($idconfig=null){
		if($idconfig != null){
			$id = 'WHERE r.idconfig = '.$idconfig;
		}else{
			$id = null;
		}
		$sql = 'SELECT r.idrewrite,r.idmetas,lang.codelang,r.phrase1,r.phrase2,r.phrase3,r.level,conf.named FROM mc_metas_rewrite as r
		LEFT JOIN mc_global_config AS conf ON(r.idconfig = conf.idconfig)
		LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		'.$id.'
		ORDER BY lang.codelang';
		return $this->layer->select($sql);
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	function s_rewrite_v_lang($idconfig,$idlang,$idmetas,$level){
		$sql ='SELECT idrewrite
				FROM mc_metas_rewrite AS r
				WHERE r.idconfig =:idconfig AND r.idmetas =:idmetas AND r.level =:level AND r.idlang =:idlang';
		return $this->layer->selectOne($sql,array(
		':idconfig'	=>	$idconfig,	
		':idlang' 	=>	$idlang,
		':idmetas'	=>	$idmetas,
		':level'	=>	$level
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	function s_rewrite_for_edit($idrewrite){
		$sql ='SELECT lang.idlang,lang.codelang,r.idconfig,r.idrewrite,r.phrase1,r.phrase2,r.phrase3,r.idmetas,r.level,conf.named
				FROM mc_metas_rewrite AS r
				LEFT JOIN mc_global_config as conf ON(r.idconfig = conf.idconfig)
				LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
				WHERE r.idrewrite =:idrewrite';
		return $this->layer->selectOne($sql,array(
			':idrewrite'	=>	$idrewrite
		));
	}
	/**
	 * insertion d'une réecriture des métas
	 * @param $idconfig
	 * @param $idlang
	 * @param $phrase1
	 * @param $phrase2
	 * @param $phrase3
	 * @param $idmetas
	 * @param $level
	 */
	function i_rewrite_metas($idconfig,$idlang,$phrase1,$phrase2,$phrase3,$idmetas,$level){
    	$sql = 'INSERT INTO mc_metas_rewrite (idconfig,idlang,phrase1,phrase2,phrase3,idmetas,level) 
				VALUE(:idconfig,:idlang,:phrase1,:phrase2,:phrase3,:idmetas,:level)';
		$this->layer->insert($sql,
		array(
			':idconfig'			=>	$idconfig,
			':idlang'			=>	$idlang,
			':phrase1'			=>	$phrase1,
			':phrase2'			=>	$phrase2,
			':phrase3'			=>	$phrase3,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level
		));
    }
    /**
     * mise à jour de la métas
     * @param $idconfig
     * @param $idlang
     * @param $phrase1
     * @param $phrase2
     * @param $phrase3
     * @param $idmetas
     * @param $level
     * @param $idrewrite
     */
	function u_rewrite_metas($idconfig,$idlang,$phrase1,$phrase2,$phrase3,$idmetas,$level,$idrewrite){
    	$sql = 'UPDATE mc_metas_rewrite 
    	SET idconfig = :idconfig,
    	idlang  = :idlang,
    	phrase1 = :phrase1,
    	phrase2 = :phrase2,
    	phrase3 = :phrase3,
    	idmetas = :idmetas,
    	level = :level
    	WHERE idrewrite = :idrewrite';
		$this->layer->update($sql,
		array(
			':idconfig'			=>	$idconfig,
			':idlang'			=>	$idlang,
			':phrase1'			=>	$phrase1,
			':phrase2'			=>	$phrase2,
			':phrase3'			=>	$phrase3,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level,
			':idrewrite'		=>	$idrewrite
		));
    }
    /**
     * supprime une réecriture des métas
     * @param $delconfig
     */
	function d_rewrite_metas($delconfig){
		$sql = 'DELETE FROM mc_metas_rewrite WHERE idrewrite = :delconfig';
			$this->layer->delete($sql,
			array(
				':delconfig'	=>	$delconfig
		)); 
	}
	function config_limited_module(){}
	/**
	 * Vérifie que le module exist dans la table
	 */
	function s_limited_module_exist(){
		$sql = 'SELECT idconfig FROM mc_config_limited_module WHERE idconfig = 3';
    	return $this->layer->selectOne($sql);
	}
	/**
	 * Sélectionne le nombre de limitation de page par module
	 */
	function s_config_number_module(){
		$sql = 'SELECT idconfig,number FROM mc_config_limited_module WHERE idconfig = 3';
    	return $this->layer->selectOne($sql);
	}
	/**
	 * Modifie la limitation d'un module
	 * @param $idconfig
	 * @param $number
	 */
	function u_limited_module($idconfig,$number){
		$sql = 'UPDATE mc_config_limited_module SET number = :number WHERE idconfig = :idconfig';
		$this->layer->insert($sql,
		array(
			':idconfig'			=>	$idconfig,
			':number'			=>	$number
		));
	}
}