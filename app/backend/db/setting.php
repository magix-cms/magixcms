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
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name setting
 *
 */
class backend_db_setting{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $adminDbSetting;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbSetting(){
        if (!isset(self::$adminDbSetting)){
         	self::$adminDbSetting = new backend_db_setting();
        }
    	return self::$adminDbSetting;
    }
    /**
     * Retourne la valeur du setting selectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_value($setting_id){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
	/**
     * Retourne le label du setting sélectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_label($setting_id){
    	$sql = 'SELECT setting_label FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
	/**
     * Retourne le setting sélectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_complete_setting($setting_id){
    	$sql = 'SELECT setting_label,setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
    /**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	function u_uniq_setting_value($setting_id,$setting_value){
    	$sql = 'UPDATE mc_setting SET setting_value = :setting_value WHERE setting_id = :setting_id';
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
	function u_uniq_setting_label($setting_id,$setting_label){
    	$sql = 'UPDATE mc_setting SET setting_label = :setting_label WHERE setting_id = :setting_id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_label'=>	$setting_label
			));
    }
}