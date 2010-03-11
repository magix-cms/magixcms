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
class backend_db_setting{
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
	static public $admindbsetting;
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
	public static function adminDbSetting(){
        if (!isset(self::$admindbgtools)){
         	self::$admindbsetting = new backend_db_setting();
        }
    	return self::$admindbsetting;
    }
    /**
     * Retourne le setting selectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_value($setting_id){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return $this->layer->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
    /**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	function u_uniq_setting_value($setting_id,$setting_value){
    	$sql = 'UPDATE mc_setting SET setting_value = :setting_value WHERE setting_id = :setting_id';
		$this->layer->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_value'=>	$setting_value
			));
    }
}