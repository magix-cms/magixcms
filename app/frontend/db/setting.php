<?php
/**
 * @category   DB CLass 
 * @package    Magix CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class frontend_db_setting{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $publicdbsetting;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function publicDbSetting(){
        if (!isset(self::$publicdbsetting)){
         	self::$publicdbsetting = new frontend_db_setting();
        }
    	return self::$publicdbsetting;
    }
    /**
     * Retourne le setting selectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_value($setting_id){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
}