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
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
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