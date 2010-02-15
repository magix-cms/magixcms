<?php
/**
 * @category   Model block Dom
 * Model from DOM element dynamic
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_member{
	/**
	 * Retourne l'identifiant du membre
	 */
	public static function s_idadmin(){
		$const_url = backend_db_admin::adminDbMember()->s_t_profil_url($_SESSION['useradmin']);
		return $const_url['idadmin'];
	}
	public static function s_perms_current_admin(){
		$const_url = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		return $const_url['perms'];
	}
}