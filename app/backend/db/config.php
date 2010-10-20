<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.6
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name config
 *
 */
class backend_db_config{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $admindbconfig;
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
    	return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * Selectionne la configuration global suivant la variable
     * @param $named
     */
    function s_config_named($named){
    	$sql = 'SELECT named,status FROM mc_global_config WHERE named = :named';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
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
		magixglobal_model_db::layerDB()->update($sql,
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
		$sql = 'SELECT r.idrewrite,r.idmetas,lang.codelang,r.strrewrite,r.level,conf.named FROM mc_metas_rewrite as r
		LEFT JOIN mc_global_config AS conf ON(r.idconfig = conf.idconfig)
		LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		'.$id.'
		ORDER BY lang.codelang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	function s_rewrite_v_lang($idconfig,$idlang,$idmetas,$level){
		$sql ='SELECT idrewrite
				FROM mc_metas_rewrite AS r
				WHERE r.idconfig =:idconfig AND r.idmetas =:idmetas AND r.level =:level AND r.idlang =:idlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
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
		$sql ='SELECT lang.idlang,lang.codelang,r.idconfig,r.idrewrite,r.strrewrite,r.idmetas,r.level,conf.named
				FROM mc_metas_rewrite AS r
				LEFT JOIN mc_global_config as conf ON(r.idconfig = conf.idconfig)
				LEFT JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
				WHERE r.idrewrite =:idrewrite';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':idrewrite'	=>	$idrewrite
		));
	}
	/**
	 * insertion d'une réecriture des métas
	 * @param $idconfig
	 * @param $idlang
	 * @param $strrewrite
	 * @param $idmetas
	 * @param $level
	 */
	function i_rewrite_metas($idconfig,$idlang,$strrewrite,$idmetas,$level){
    	$sql = 'INSERT INTO mc_metas_rewrite (idconfig,idlang,strrewrite,idmetas,level) 
				VALUE(:idconfig,:idlang,:strrewrite,:idmetas,:level)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idconfig'			=>	$idconfig,
			':idlang'			=>	$idlang,
			':strrewrite'		=>	$strrewrite,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level
		));
    }
    /**
     * mise à jour de la métas
     * @param $idconfig
     * @param $idlang
     * @param $strrewrite
     * @param $idmetas
     * @param $level
     * @param $idrewrite
     */
	function u_rewrite_metas($idconfig,$idlang,$strrewrite,$idmetas,$level,$idrewrite){
    	$sql = 'UPDATE mc_metas_rewrite 
    	SET idconfig = :idconfig,
    	idlang  = :idlang,
    	strrewrite = :strrewrite,
    	idmetas = :idmetas,
    	level = :level
    	WHERE idrewrite = :idrewrite';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':idconfig'			=>	$idconfig,
			':idlang'			=>	$idlang,
			':strrewrite'		=>	$strrewrite,
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
			magixglobal_model_db::layerDB()->delete($sql,
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
    	return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Sélectionne le nombre de limitation de page par module
	 */
	function s_config_number_module(){
		$sql = 'SELECT idconfig,number FROM mc_config_limited_module WHERE idconfig = 3';
    	return magixglobal_model_db::layerDB()->selectOne($sql);
	}
	/**
	 * Modifie la limitation d'un module
	 * @param $idconfig
	 * @param $number
	 */
	function u_limited_module($idconfig,$number){
		$sql = 'UPDATE mc_config_limited_module SET number = :number WHERE idconfig = :idconfig';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idconfig'			=>	$idconfig,
			':number'			=>	$number
		));
	}
}