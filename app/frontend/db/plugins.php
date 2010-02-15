<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name Plugins
 * @version 1.0
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