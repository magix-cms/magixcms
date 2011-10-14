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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name setting
 *
 */
class backend_db_setting{
	/**
	 * @access protected
	 * Retourne les données de configuration suivant sont attribut
	 * @param string $attr_name
	 */
	protected function array_data_config($attr_name){
		$sql = 'SELECT * FROM mc_config WHERE attr_name = :attr_name';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':attr_name' =>	$attr_name
		));
	}
	/**
	 * @access protected
	 * Charge la configuration de la taille des images suivant sont attribut
	 * @param string $attr_name
	 */
	protected function s_attribute_img_size_config($attr_name){
    	$sql = 'SELECT ci.*,c.attr_name 
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)
    	WHERE c.attr_name = :attr_name
    	ORDER BY id_size_img,config_size_attr ASC';
    	return magixglobal_model_db::layerDB()->select($sql,array(
    		':attr_name'=>$attr_name
    	));
    }
	/*protected function s_load_img_size($name_size){
    	$sql = 'SELECT ci.* FROM mc_config_size_img as ci
    	WHERE ci.name_size = :name_size';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
    		':name_size'=>$name_size
    	));
    }*/
    protected function s_load_img_size($attr_name,$config_size_attr){
    	$sql = 'SELECT ci.*,c.attr_name 
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)
    	WHERE c.attr_name = :attr_name AND config_size_attr = :config_size_attr';
    	return magixglobal_model_db::layerDB()->select($sql,array(
    		':attr_name'=>$attr_name,
    		':config_size_attr'=>$config_size_attr
    	));
    }
	protected function s_uniq_img_size($attr_name,$config_size_attr,$type){
    	$sql = 'SELECT ci.*,c.attr_name 
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)
    	WHERE c.attr_name = :attr_name AND config_size_attr = :config_size_attr AND type = :type';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
    		':attr_name'=>$attr_name,
    		':config_size_attr'=>$config_size_attr,
    		':type'=>$type
    	));
    }
	protected function s_config_img_size(){
    	$sql = 'SELECT ci.*,c.attr_name 
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)';
    	return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
     * Retourne le setting sélectionner
     * @param setting_id (string) identifiant du setting
     */
    protected function s_uniq_setting($setting_id){
    	$sql = 'SELECT setting_label,setting_value 
    	FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':setting_id'	=>	$setting_id
		));
    }
	/**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	protected function u_setting_value($setting_id,$setting_value){
    	$sql = 'UPDATE mc_setting SET setting_value = :setting_value 
    	WHERE setting_id = :setting_id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_value'=>	$setting_value
			));
    }
	/**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	protected function u_setting_label($setting_id,$setting_label){
    	$sql = 'UPDATE mc_setting SET setting_label = :setting_label WHERE setting_id = :setting_id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_label'=>	$setting_label
			));
    }
}