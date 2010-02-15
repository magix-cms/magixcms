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
class backend_db_plugins{
	/**
	 * ini class magixLayer
	 * singleton dbplugins
	 * @access public
	 * @var void
	 */
	static public $layerPlugins;
	/**
	 * instance backend_controller_plugins with singleton
	 */
	public static function layerPlugins(){
        if (!isset(self::$layerPlugins)){
         	self::$layerPlugins = new magixcjquery_magixdb_layer();
        }
    	return self::$layerPlugins;
    }
    /**
     * Requête pour la construction du menu des plugins disponible
     */
	function s_plugins_navigation_construct(){
    	$sql = 'SELECT p.idplugin,p.pname FROM mc_plugins_module AS p WHERE p.pageadmin = 1';
		return self::layerPlugins()->select($sql);
    } 
    /**
     * 
     * @param $getplugin
     */
    function s_plugins_page_index($getplugin){
    	$sql = 'SELECT p.idplugin,p.pname FROM mc_plugins_module AS p WHERE pname = :getplugin';
		return self::layerPlugins()->selectOne($sql,array(
			':getplugin'=>$getplugin
		));
    } 
}