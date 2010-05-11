<?php
/**
 * @category   Global Setting Model
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-01-25
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_setting{
	/**
	 * Constructor
	 */
	function __construct(){}
	/**
	 * Retourne la valeur de la configuration suivant l'identifiant
	 * @param (string) $setting_id
	 */
	public static function select_uniq_setting($setting_id){
		if(!is_null($setting_id));
		return backend_db_setting::adminDbSetting()->s_uniq_setting_value($setting_id);
	}
	/**
	 * 
	 * @param (string) $setting_id
	 * @param (string) $setting_value
	 */
	public static function update_setting_value($setting_id,$setting_value){
		if(isset($setting_id)){
			backend_db_setting::adminDbSetting()->u_uniq_setting_value($setting_id,$setting_value);
		}
	}
}