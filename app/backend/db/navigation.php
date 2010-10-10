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
	 * singleton dbnavigation
	 * @access public
	 * @var void
	 */
	static public $admindbnav;
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
		return magixglobal_model_db::layerDB()->select($sql,array(":blockmenu"=>$blockmenu));
    }
}