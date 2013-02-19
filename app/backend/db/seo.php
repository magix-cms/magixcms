<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.6
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name rewritemetas
 *
 */
class backend_db_seo{
/**
     * selectionne la métas suivant la catégorie, la langue et le type (title ou description)
     * @param $codelang (langue)
     * @param $attribute (module ex: rewritenews = 5)
     * @param $idmetas (1 ou 2) (title ou description)
     */
	/*protected function s_rewrite_meta($attribute=null){
		if($attribute != null){
			$id = 'WHERE r.attribute = '.$attribute;
		}else{
			$id = null;
		}
		$sql = 'SELECT r.idrewrite,r.idmetas,lang.iso,r.strrewrite,r.level,r.attribute 
		FROM mc_metas_rewrite as r
		JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		'.$id.'
		ORDER BY lang.iso';
		return magixglobal_model_db::layerDB()->select($sql);
	}*/
    /*######################## Statistiques ##############################*/
    /**
     * @return array
     */
    protected function s_stats_rewrite(){
        $sql = 'SELECT lang.iso, IF( r.rewrite_count >0, r.rewrite_count, 0 ) AS REWRITE
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( r.idrewrite ) AS rewrite_count
            FROM mc_metas_rewrite AS r
            JOIN mc_lang AS lang ON ( r.idlang = lang.idlang )
            GROUP BY r.idlang
            )r ON ( r.idlang = lang.idlang )
        GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    protected function s_rewrite_meta($getlang){
        $sql = 'SELECT r.idrewrite,r.idmetas,lang.iso,r.strrewrite,r.level,r.attribute
		FROM mc_metas_rewrite as r
		JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
		WHERE r.idlang = :getlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'  => $getlang
        ));
    }
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	protected function v_rewrite_meta($getlang,$attribute,$idmetas,$level){
		$sql ='SELECT idrewrite
        FROM mc_metas_rewrite AS r
        WHERE r.attribute =:attribute
        AND r.idmetas =:idmetas
        AND r.level =:level
        AND r.idlang =:getlang';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':getlang' 	=>	$getlang,
            ':attribute'=>	$attribute,
            ':idmetas'	=>	$idmetas,
            ':level'	=>	$level
		));
	}
	/**
	 * selectionne les données suivant la langue
	 * @param $idlang
	 */
	protected function s_rewrite_data($edit){
		$sql ='SELECT lang.idlang,lang.iso,r.attribute,r.idrewrite,r.strrewrite,r.idmetas,r.level
        FROM mc_metas_rewrite AS r
        JOIN mc_lang AS lang ON(r.idlang = lang.idlang)
        WHERE r.idrewrite =:edit';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':edit'	=>	$edit
		));
	}

    /**
     * insertion d'une réecriture des métas
     * @param $getlang
     * @param $attribute
     * @param $strrewrite
     * @param $idmetas
     * @param $level
     */
	protected function i_rewrite_metas($getlang,$attribute,$strrewrite,$idmetas,$level){
    	$sql = 'INSERT INTO mc_metas_rewrite (idlang,attribute,strrewrite,idmetas,level)
        VALUE(:getlang,:attribute,:strrewrite,:idmetas,:level)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':attribute'		=>	$attribute,
			':getlang'			=>	$getlang,
			':strrewrite'		=>	$strrewrite,
			':idmetas'			=>	$idmetas,
			':level'			=>	$level
		));
    }
    /**
     * mise à jour de la métas
     * @param $attribute
     * @param $idlang
     * @param $strrewrite
     * @param $idmetas
     * @param $level
     * @param $idrewrite
     */
	protected function u_rewrite_metas($getlang,$attribute,$strrewrite,$idmetas,$level,$edit){
    	$sql = 'UPDATE mc_metas_rewrite 
    	SET attribute = :attribute,idlang = :getlang, strrewrite = :strrewrite, idmetas = :idmetas, level = :level
    	WHERE idrewrite = :edit';
		magixglobal_model_db::layerDB()->update($sql,
		array(
            ':getlang'			=>	$getlang,
            ':attribute'		=>	$attribute,
            ':strrewrite'		=>	$strrewrite,
            ':idmetas'			=>	$idmetas,
            ':level'			=>	$level,
            ':edit'		        =>	$edit
		));
    }
    /**
     * supprime une réecriture des métas
     * @param $delconfig
     */
	protected function d_rewrite_metas($delconfig){
		$sql = 'DELETE FROM mc_metas_rewrite WHERE idrewrite = :delconfig';
			magixglobal_model_db::layerDB()->delete($sql,
			array(
				':delconfig'	=>	$delconfig
		)); 
	}
}