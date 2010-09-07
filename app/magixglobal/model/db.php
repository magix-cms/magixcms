<?php
/**
 * @category   Model 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-09-06
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name db
 * @version 1.0
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