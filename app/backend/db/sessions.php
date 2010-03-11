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
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 */
	protected $layer;
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static public $admindbsession;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
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
		$this->layer->delete($sql,
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
		$this->layer->insert($sql,
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
		$this->layer->delete($sql,
		array(':limit'=>$limit));
	}
	/**
	 * delete session where sid
	 * @param $sid
	 * @return void
	 */
	function delete_session_sid($sid){
		$sql = 'DELETE FROM mc_admin_session WHERE sid = :sid';
		$this->layer->delete($sql,
		array(':sid'=>$sid));
	}
	/**
	 * récupère la session utilisateur via la session actuelle
	 * @return void
	 */
	function getsid(){
		$sql = 'SELECT sid,userid FROM mc_admin_session WHERE sid = :sid';
		return $this->layer->selectOne($sql,
		array(':sid'=>session_id()));
	}
}
?>