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
}