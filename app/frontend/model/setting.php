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
class frontend_model_setting extends frontend_db_setting{
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
		return parent::publicDbSetting()->s_uniq_setting_value($setting_id);
	}
}