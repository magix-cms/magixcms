<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   DB 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name sessions
 *
 */
class backend_db_sessions{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $admindbsession;
	/**
	 * instance backend_db_config with singleton
	 */
	public static function adminDbSession(){
        if (!isset(self::$admindbsession)){
         	self::$admindbsession = new backend_db_sessions();
        }
    	return self::$admindbsession;
    }
	/**
	 * deletes the current session id
	 * @param $userid
	 * @return void
	 */
	function delCurrent($id_admin){
		$sql = 'DELETE FROM mc_admin_session
		WHERE id_admin = :id_admin';
		magixglobal_model_db::layerDB()->delete($sql,
			array(
				':id_admin'=> $id_admin
				
		)); 
	}
	/**
	 * inserts a new session identifier
	 * @param $userid (ID)
	 * @param $ip (IP)
	 * @return void
	 */
    function insertNewSessionId($id_admin,$ip_session,$browser_admin,$keyuniqid_admin){
        $sql = 'INSERT INTO mc_admin_session (id_admin_session,id_admin,ip_session,browser_admin,keyuniqid_admin)
		VALUE (:id_admin_session,:id_admin,:ip_session,:browser_admin,:keyuniqid_admin)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_admin_session'=> session_id(),
                ':id_admin'=> $id_admin,
                ':ip_session'=> $ip_session,
                ':browser_admin' => $browser_admin,
                ':keyuniqid_admin' => $keyuniqid_admin
            ));
    }
	/**
	 * delete lastest modified max 2 days
	 * @param $limit
	 * @return void
	 */
	function delLast_modified($limit){
		$sql = 'DELETE FROM mc_admin_session
		WHERE TO_DAYS(DATE_FORMAT(NOW(), "%Y%m%d")) - TO_DAYS(DATE_FORMAT(last_modified_session, "%Y%m%d"))
		> :limit';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':limit'=>$limit));
	}
	/**
	 * delete session where sid
	 * @param $sid
	 * @return void
	 */
	function delete_session_sid($id_admin_session){
		$sql = 'DELETE FROM mc_admin_session
		WHERE id_admin_session = :id_admin_session';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':id_admin_session'=>$id_admin_session));
	}
	/**
	 * récupère la session utilisateur via la session actuelle
	 * @return void
	 */
	function getsid(){
		$sql = 'SELECT id_admin_session,id_admin
		FROM mc_admin_session WHERE id_admin_session = :id_admin_session';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(':id_admin_session'=>session_id()));
	}
}
?>