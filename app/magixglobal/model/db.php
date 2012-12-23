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
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name db
 *
 */
class magixglobal_model_db{
	/**
	 * ini class magixLayer
	 * singleton dbplugins
	 * @access public
	 * @var void
	 */
	static public $layerDB;
	/**
	 * instance backend_controller_plugins with singleton
	 */
	public static function layerDB(){
        if (!isset(self::$layerDB)){
         	self::$layerDB = new magixcjquery_magixdb_layer();
        }
    	return self::$layerDB;
    }
    /**
     * Chargement du fichier SQL pour la lecture du fichier
     * @param $sqlfile
     */
	private function load_sql_file($sqlfile){
		$db_structure = "";
		$structureFile = $sqlfile;
		if(!file_exists($structureFile)){
			throw new Exception("Error : Not File exist .sql");
		}else{ 
			$db_structure = preg_split("/;\\s*[\r\n]+/",file_get_contents($structureFile));
			if($db_structure != null){
				$tables = $db_structure;
			}else{
				magixcjquery_debug_magixfire::magixFireError("Error : SQL File is empty");
				return false;
			}
		}
		return $tables;
	}
	/**
	 * Création des tables avec la lecture du fichier SQL
	 * @param void $sqlfile
	 */
	public static function create_new_sqltable($sqlfile){
		if(self::load_sql_file($sqlfile) != false){
			foreach(self::load_sql_file($sqlfile) as $query){
				$query = magixcjquery_filter_var::trimText($query);
				self::layerDB()->createTable($query);
			}
			return true;
		}
	}
}