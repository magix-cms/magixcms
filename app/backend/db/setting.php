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
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $adminDbSetting;
	/**
	 * instance frontend_db_home with singleton
	 */
	public static function adminDbSetting(){
        if (!isset(self::$adminDbSetting)){
         	self::$adminDbSetting = new backend_db_setting();
        }
    	return self::$adminDbSetting;
    }
    /**
     * Retourne la valeur du setting selectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_value($setting_id){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
	/**
     * Retourne le label du setting sélectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_setting_label($setting_id){
    	$sql = 'SELECT setting_label FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
	/**
     * Retourne le setting sélectionner
     * @param setting_id (string) identifiant du setting
     */
    public function s_uniq_complete_setting($setting_id){
    	$sql = 'SELECT setting_label,setting_value FROM mc_setting WHERE setting_id = :setting_id';
		return magixglobal_model_db::layerDB()->selectOne($sql,array(':setting_id'	=>	$setting_id));
    }
    /**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	function u_uniq_setting_value($setting_id,$setting_value){
    	$sql = 'UPDATE mc_setting SET setting_value = :setting_value WHERE setting_id = :setting_id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_value'=>	$setting_value
			));
    }
	/**
     * Mise à jour du setting selectionner
     * @param $setting_id
     * @param $setting_value
     */
	function u_uniq_setting_label($setting_id,$setting_label){
    	$sql = 'UPDATE mc_setting SET setting_label = :setting_label WHERE setting_id = :setting_id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':setting_id'	=>	$setting_id,
				':setting_label'=>	$setting_label
			));
    }
}