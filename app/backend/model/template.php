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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name template
 * Model template
 */
class backend_model_template extends db_theme{
	/**
	 * backendtheme
	 * @access public
	 * @var void
	 */
	static protected $backendtheme;
	/**
	 * @access public
	 * @static
	 * singleton backendTheme
	 */
	public static function backendTheme(){
        if (!isset(self::$backendtheme)){
         	self::$backendtheme = new backend_model_template();
        }
    	return self::$backendtheme;
    }
	/**
	 * Charge le theme selectionné ou le theme par défaut
	 */
	private function load_theme(){
		// Charge le théme courant dans la base de donnée
		$db = parent::backendDBtheme()->s_current_theme();
		if($db['setting_value'] != null){
			if($db['setting_value'] == 'default'){
				if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
					$theme =  'default';
				}
			}elseif(file_exists(magixglobal_model_system::base_path().'/skin/'.$db['setting_value'].'/')){
				$theme =  $db['setting_value'];
			}else{
				try {
					$theme = 'default';
	        		throw new Exception('template '.$db['setting_value'].' is not found');
				} catch (Exception $e){
					magixglobal_model_system::magixlog('An error has occured :',$e);
				}
			}
		}else{
			if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
				$theme =  'default';
			}
		}
		return $theme;
	}
	/**
	 * Function load public theme
	 * @see frontend_config_theme
	 */
	public function themeSelected(){
		if (!self::backendTheme() instanceof backend_model_template){
			throw new Exception('template load is not found');
		}
		return self::backendTheme()->load_theme();
	}
	/**
	 * UpdateTheme
	 * @param string $post
	 */
	public function UpdateTheme($post){
		if(isset($post)){
			if($post != null){
				parent::u_change_theme($post);
			}else{
				throw new Exception('template is null');
			}
		}
	}
}
/**
 * Class db theme
 * Requête SQL pour le chargement du thème approprié au site internet
 * @author Aurelien
 *
 */
class db_theme{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $backenddbtheme;
	/**
	 * instance backend_db_config with singleton
	 */
	protected static function backendDBtheme(){
        if (!isset(self::$backenddbtheme)){
         	self::$backenddbtheme = new db_theme();
        }
    	return self::$backenddbtheme;
    }
    /**
     * Retourne le theme utilisé
     */
    public function s_current_theme(){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = "theme"';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * Change le theme courant
     * @param $theme
     */
    public function u_change_theme($theme){
    	$sql = 'UPDATE mc_setting SET setting_value = :theme WHERE setting_id = "theme"';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':theme'=>$theme
			)
		);
    }
}
?>