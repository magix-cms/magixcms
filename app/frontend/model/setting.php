<?php
/**
 * MAGIX CMS
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name settings
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