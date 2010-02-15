<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_db_navigation{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnavigation
	 * @access public
	 * @var void
	 */
	static public $admindbnav;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbNav(){
        if (!isset(self::$admindbnav)){
         	self::$admindbnav = new backend_db_navigation();
        }
    	return self::$admindbnav;
    }
	function s_block_menu_cms($blockmenu){
    	$sql = 'SELECT elmenu FROM mc_public_menu 
    	WHERE blockmenu = :blockmenu';
		return $this->layer->select($sql,array(":blockmenu"=>$blockmenu));
    }
}