<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    3.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_plugins{
	/**
	 * ini class magixLayer
	 * singleton dbplugins
	 * @access public
	 * @var void
	 */
	static public $layerPlugins;
	/**
	 * instance frontend_controller_plugins with singleton
	 */
	public static function layerPlugins(){
        if (!isset(self::$layerPlugins)){
         	self::$layerPlugins = new magixcjquery_magixdb_layer();
        }
    	return self::$layerPlugins;
    }
}