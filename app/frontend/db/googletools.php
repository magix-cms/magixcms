<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_googletools{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbgtools;
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
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
}