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
class backend_db_googletools{
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
	static public $admindbgtools;
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
	public static function adminDbGtools(){
        if (!isset(self::$admindbgtools)){
         	self::$admindbgtools = new backend_db_googletools();
        }
    	return self::$admindbgtools;
    }
    /**
     * Affiche Google webmaster tools et analytics dans le widget (dashboard)
     */
    function s_google_tools_widget(){
    	$sql = 'SELECT g.webmaster,g.analytics FROM mc_googletools as g';
		return $this->layer->selectOne($sql);
    }
    /**
     * Mise à jour des Google Tools (webmaster et analytics)
     * @param $webmaster
     * @param $analytics
     */
	function u_google_tools($webmaster,$analytics){
    	$sql = 'UPDATE mc_googletools SET webmaster=:webmaster,analytics =:analytics WHERE idgoogle = 1';
		$this->layer->update($sql,
		array(
			':webmaster'	=>	$webmaster,
			':analytics'	=>	$analytics
		));
    }
}