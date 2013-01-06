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
 * @name config
 *
 */
class backend_db_config{
    /**
     * Selectionne la configuration global suivant la variable
     * @param $attr_name
     * @internal param $named
     * @return array
     */
    protected function s_config_named($attr_name){
    	$sql = 'SELECT attr_name,status FROM mc_config
    	WHERE attr_name = :attr_name';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':attr_name' =>	$attr_name
		));
    }

    /**
     * @return array
     */
    protected function s_data_config(){
        $sql = 'SELECT * FROM mc_config';
        return magixglobal_model_db::layerDB()->select($sql);
    }
    /**
     * mise à jour d'un status global suivant un nom de variable dans la table global_config
     * @param $status
     * @param $attr_name
     */
    protected function u_config_states($status,$attr_name){
    	$sql = 'UPDATE mc_config SET status = :status
    	WHERE attr_name = :attr_name';
		magixglobal_model_db::layerDB()->update($sql,
		array(
			':status'  =>	$status,
			':attr_name'  => $attr_name
		));
    }
	/**
	 * Modifie la limitation d'un module
	 * @param $idconfig
	 * @param $number
	 */
	protected function u_limited_module($idconfig,$max_record){
		$sql = 'UPDATE mc_config SET max_record = :max_record WHERE idconfig = :idconfig';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idconfig'		=>	$idconfig,
			':max_record'	=>	$max_record
		));
	}
    //SETTING
    /**
     * @return array
     */
    protected function s_data_setting(){
        $sql = 'SELECT * FROM mc_setting';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @param $setting_id
     * @return array
     */
    protected function s_setting_id($setting_id){
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
            )
        );
    }

    /**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_label
     */
    protected function u_setting_label($setting_id,$setting_label){
        $sql = 'UPDATE mc_setting SET setting_label = :setting_label WHERE setting_id = :setting_id';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':setting_id'	=>	$setting_id,
                ':setting_label'=>	$setting_label
            ));
    }
    //IMAGES
    /**
     * @access protected
     * Charge la configuration de la taille des images suivant sont attribut
     * @param string $attr_name
     * @return array
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

    /**
     * @param $attr_name
     * @param $config_size_attr
     * @return array
     */
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

    /**
     * @param $attr_name
     * @param $config_size_attr
     * @param $type
     * @return array
     */
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

    /**
     * @return array
     */
    protected function s_config_img_size(){
        $sql = 'SELECT ci.*,c.attr_name
    	FROM mc_config_size_img as ci
    	JOIN mc_config as c USING(idconfig)';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @access protected
     * Mise à jour des tailles d'image
     * @param $width
     * @param $height
     * @param $img_resizing
     * @param $id_size_img
     */
    protected function u_size_img_config($width,$height,$img_resizing,$id_size_img){
        $sql = 'UPDATE mc_config_size_img
		SET width = :width,height = :height,img_resizing = :img_resizing
		WHERE id_size_img = :id_size_img';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':width'  =>	$width,
                ':height'  =>	$height,
                ':img_resizing'  =>	$img_resizing,
                ':id_size_img' =>	$id_size_img
            ));
    }
}