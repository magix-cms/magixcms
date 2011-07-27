<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   Model 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name forms
 * Model sessions and session register
 */
class backend_model_sessions extends session_register{
	/**
	 * clean old register 2 days
	 * @access private 
	 * @return void
	 */
	private function dbClean() {
		//On supprime les enregistrements de plus de deux jours
		$limit = date('Y-m-d H-i-s', mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')));
		backend_db_sessions::adminDbSession()->delLast_modified($limit);
	}
	/**
	 * Open session
	 * @param $userid
	 * @return true
	 */
	public function openSession($userid,$session_id,$keyuniqid){
		backend_db_sessions::adminDbSession()->delCurrent($userid);
		self::dbClean();
		// Re-génération du sid
		$session_id;
		//On ajoute un nouvel identifiant de session dans la table
		backend_db_sessions::adminDbSession()->insertNewSessionId($userid,parent::getIp(),parent::getBrowser(),$keyuniqid);
		return true;
	}
	/**
	 * close session
	 * @return void
	 */
	public function closeSession() {
		backend_db_sessions::adminDbSession()->delete_session_sid(session_id());
	}
	/**
	 * Compare la session avec une entrée session mysql
	 * @return void
	 */
	public function compareSessionId(){
		return backend_db_sessions::adminDbSession()->getsid();
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