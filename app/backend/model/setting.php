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
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name setting
 * Model setting
 */
class backend_model_setting extends db_setting{
	/**
	 * Constructor
	 */
	function __construct(){}
	/**
	 * @access public
	 * @static
	 * Retourne la valeur de la configuration suivant l'identifiant
	 * @param (string) $setting_id
	 */
	public static function select_uniq_setting($setting_id){
		if(!is_null($setting_id));
		return backend_db_setting::adminDbSetting()->s_uniq_setting_value($setting_id);
	}
	/**
	 * @access public
	 * @static
	 * @param (string) $setting_id
	 * @param (string) $setting_value
	 */
	public static function update_setting_value($setting_id,$setting_value){
		if(isset($setting_id)){
			backend_db_setting::adminDbSetting()->u_uniq_setting_value($setting_id,$setting_value);
		}
	}
	/**
	 * @access public
	 * Retourne la valeur unique dans un tableau
	 * @param string $attr_name
	 */
	public static function tabs_load_config($attr_name){
		return parent::array_data_config($attr_name);
	}
	/**
	 * @access private
	 * Assign les variables pour les paramètres des tailles images
	 */
	public function assign_img_size($attr_name){
		if(!is_null($attr_name)){
			foreach (parent::s_all_img_size_config($attr_name) as $conf){
				backend_controller_template::assign($conf['config_size_attr'],$conf['width'],$conf['height']);
			}
		}
	}
	public function load_img_size($name_size){
		if(!is_null($name_size)){
			$db = parent::s_load_img_size($name_size);
			return $db['num_size'];
		}
	}
	public function fetch_img_size($attr_name){
		return parent::s_attribute_img_size_config($attr_name);
	}
	public function dataSizeImg(){}
}
/**
 * 
 * Classe pour les requêtes SQL vers les tables de configuration
 * @author aureliengerits
 *
 */
class db_setting{
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
	protected function s_load_img_size($name_size){
    	$sql = 'SELECT ci.* FROM mc_config_size_img as ci
    	WHERE ci.name_size = :name_size';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
    		':name_size'=>$name_size
    	));
    }
	protected function s_config_img_size(){
    	$sql = 'SELECT ci.*,c.attr_name 
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)';
    	return magixglobal_model_db::layerDB()->select($sql);
    }
}