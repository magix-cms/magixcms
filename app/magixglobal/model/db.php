<?php
/**
 * MAGIX CMS
 * @category   Model 
 * @package    magixglobal
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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