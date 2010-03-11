<?php
/**
 * @category   Global Setting
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-01-25
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_setting extends backend_db_setting{
	/**
	 * Constructor
	 */
	function __construct(){}
	/**
	 * Initialise la selection du setting avec l'identifiant
	 * @param (string) $setting_id
	 */
	public function select_uniq_setting($setting_id){
		if(!is_null($setting_id));
		return parent::adminDbSetting()->s_uniq_setting_value($setting_id);
	}
	public function update_setting_value($setting_id,$setting_value){
		if(isset($setting_id)){
			parent::adminDbSetting()->u_uniq_setting_value($setting_id,$setting_value);
		}
	}
}