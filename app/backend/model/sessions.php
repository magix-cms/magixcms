<?php
/**
 * @category   Model session
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class backend_model_sessions extends session_register{
	/**
	 * 
	 * @var instance dbsession
	 */
	protected $dbsessions;
	/**
	 * 
	 * class construct
	 */
	function __construct(){
		$this->dbsessions = new backend_db_sessions();
	}
	/**
	 * Open session
	 * @param $userid
	 * @return true
	 */
	public function openSession($userid,$session_id){
		$this->dbsessions->delCurrent($userid);
		$this->dbClean();
		// Re-génération du sid
		$session_id;
		//On ajoute un nouvel identifiant de session dans la table
		$this->dbsessions->insertNewSessionId($userid,parent::getIp(),parent::getBrowser());
		return true;
	}
	/**
	 * clean old register 2 days
	 * @return void
	 */
	protected function dbClean() {
		//On supprime les enregistrements de plus de deux jours
		$limit = date('Y-m-d H-i-s', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
		$this->dbsessions->delLast_modified($limit);
	}
	/**
	 * close session
	 * @return void
	 */
	public function closeSession() {
		$this->dbsessions->delete_session_sid(session_id());
	}
	/**
	 * Compare la session avec une entrée session mysql
	 * @return void
	 */
	function compareSessionId(){
		return $this->dbsessions->getsid();
	}
}
/**
 * Abtsract class register 
 * @author Aurelien
 *
 */
abstract class session_register{
	/**
	 * function register real IP
	 * @return string
	 */
	function getIp(){
	   if (isset($_SERVER)) {
		    if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		     	$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		    } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		     	$realip = $_SERVER["HTTP_CLIENT_IP"];
		    } else {
		     	$realip = $_SERVER["REMOTE_ADDR"];
		    }
	   }else{
		    if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
		     	$realip = getenv( 'HTTP_X_FORWARDED_FOR' );
		    } elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
		     	$realip = getenv( 'HTTP_CLIENT_IP' );
		    } else {
		     	$realip = getenv( 'REMOTE_ADDR' );
		    }
	   }
	   return $realip;
	}
	/**
	 * function getBrowser
	 * @return browser
	 */
	function getBrowser(){
		$user_agent = getenv("HTTP_USER_AGENT");
		if ((strpos($user_agent, "Nav") !== FALSE) || (strpos($user_agent, "Gold") !== FALSE) ||
		(strpos($user_agent, "X11") !== FALSE) || (strpos($user_agent, "Mozilla") !== FALSE) ||
		(strpos($user_agent, "Netscape") !== FALSE)
		AND (!strpos($user_agent, "MSIE") !== FALSE) 
		AND (!strpos($user_agent, "Konqueror") !== FALSE)
		AND (!strpos($user_agent, "Firefox") !== FALSE)
		AND (!strpos($user_agent, "Safari") !== FALSE))
		        $browser = "Netscape";
		elseif (strpos($user_agent, "Opera") !== FALSE)
		        $browser = "Opera";
		elseif (strpos($user_agent, "MSIE") !== FALSE)
		        $browser = "MSIE";
		elseif (strpos($user_agent, "Lynx") !== FALSE)
		        $browser = "Lynx";
		elseif (strpos($user_agent, "WebTV") !== FALSE)
		        $browser = "WebTV";
		elseif (strpos($user_agent, "Konqueror") !== FALSE)
		        $browser = "Konqueror";
		elseif (strpos($user_agent, "Safari") !== FALSE)
		        $browser = "Safari";
		elseif (strpos($user_agent, "Firefox") !== FALSE)
		        $browser = "Firefox";
		elseif ((stripos($user_agent, "bot") !== FALSE) || (strpos($user_agent, "Google") !== FALSE) ||
		(strpos($user_agent, "Slurp") !== FALSE) || (strpos($user_agent, "Scooter") !== FALSE) ||
		(stripos($user_agent, "Spider") !== FALSE) || (stripos($user_agent, "Infoseek") !== FALSE))
		        $browser = "Bot";
		else
		        $browser = "Autre";
		return $browser;
	}
}