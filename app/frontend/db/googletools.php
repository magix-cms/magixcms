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
class frontend_db_googletools{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbgtools;
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
	public static function publicDbGtools(){
        if (!isset(self::$publicdbgtools)){
         	self::$publicdbgtools = new frontend_db_googletools();
        }
    	return self::$publicdbgtools;
    }
    /**
     * Affiche Google webmaster tools et analytics dans le widget (dashboard)
     */
    function s_google_tools_widget(){
    	$sql = 'SELECT g.webmaster,g.analytics FROM mc_googletools as g';
		return $this->layer->selectOne($sql);
    }
}