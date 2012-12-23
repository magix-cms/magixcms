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
     * @param $named
     */
    protected function s_config_named($attr_name){
    	$sql = 'SELECT attr_name,status FROM mc_config WHERE attr_name = :attr_name';
    	return magixglobal_model_db::layerDB()->selectOne($sql,array(
			':attr_name' =>	$attr_name
		));
    }
    /**
     * mise à jour d'un status global suivant un nom de variable dans la table global_config
     * @param $status
     * @param $named
     */
    protected function u_config_states($status,$attr_name){
    	$sql = 'UPDATE mc_config SET status = :status WHERE attr_name = :attr_name';
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
}