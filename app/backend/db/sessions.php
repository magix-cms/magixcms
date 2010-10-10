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
	function delCurrent($userid){
		$sql = 'DELETE FROM mc_admin_session WHERE userid = :userid';
		magixglobal_model_db::layerDB()->delete($sql,
			array(
				':userid'=> $userid
				
		)); 
	}
	/**
	 * inserts a new session identifier
	 * @param $userid (ID)
	 * @param $ip (IP)
	 * @return void
	 */
	function insertNewSessionId($userid,$ip,$browser){
		$sql = 'INSERT INTO mc_admin_session (sid, userid, ip, browser) VALUE (:sid,:userid, :ip, :browser)';
		magixglobal_model_db::layerDB()->insert($sql,
			array(
			':sid'=> session_id(),
			':userid'=> $userid,
			':ip'=> $ip,
			':browser' => $browser
		)); 
	}
	/**
	 * delete lastest modified max 2 days
	 * @param $limit
	 * @return void
	 */
	function delLast_modified($limit){
		$sql = 'DELETE FROM mc_admin_session WHERE last_modified < :limit';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':limit'=>$limit));
	}
	/**
	 * delete session where sid
	 * @param $sid
	 * @return void
	 */
	function delete_session_sid($sid){
		$sql = 'DELETE FROM mc_admin_session WHERE sid = :sid';
		magixglobal_model_db::layerDB()->delete($sql,
		array(':sid'=>$sid));
	}
	/**
	 * récupère la session utilisateur via la session actuelle
	 * @return void
	 */
	function getsid(){
		$sql = 'SELECT sid,userid FROM mc_admin_session WHERE sid = :sid';
		return magixglobal_model_db::layerDB()->selectOne($sql,
		array(':sid'=>session_id()));
	}
}
?>