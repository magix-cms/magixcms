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
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be> | <gerits.aurelien@gmail.com>
 * @name session
 *
 */
class frontend_model_session{
	/**
	 * 
	 * Nom de la session
	 * @var session_name
	 */
	private $session_name;
	/**
	 * 
	 * Constructor
	 * @param string $session_name
	 */
	public function __construct(){}
	/**
	 * @access private
	 * Démarre une nouvelle session
	 */
	public function _start_session($session_name='magix_default_s'){
		if(isset($session_name)){
			if($session_name != 'adminlang'){
				$name = $session_name;
			}else{
				$name = 'magix_default_s';
			}
		}
		$string = $_SERVER['HTTP_USER_AGENT'];
		$string .= 'SHIFLETT';
		/* Add any other data that is consistent */
		$fingerprint = md5($string);
		//Fermeture de la première session, ses données sont sauvegardées.
		session_write_close();
		session_name($name);
		ini_set('session.hash_function',1);
		session_start();
	}
	/**
	 * 
	 * initialise les variables de session
	 * @param array() $session
	 * @param bool $debug
	 * @throws Exception
	 */
	private function ini_session_var($session){
		if(is_array($session)){
			foreach($session as $row => $val){
				//if(!magixcjquery_filter_request::isSession($row)){
					$_SESSION[$row] = $val;
				/*}else{
					$_SESSION[$row];
				}*/
			}
		}else{
			throw new Exception('session init is not array');
		}
	}
	/**
	 * @access public
	 * Initialise la session ou renouvelle la session
	 * @param array $session
	 * @param bool $debug
	 */
	public function session_run($session_tabs){
		try {
			$lang = new frontend_model_IniLang();
			$lang->autoLangSession();
			$this->ini_session_var($session_tabs);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * 
		$session = new frontend_model_session();
		if(!magixcjquery_filter_request::isSession('panier')){
			$array_sess = array(
				'panier'=>magixglobal_model_cryptrsa::uniq_id(),
				'outils'=>'Le marteau du peuple'
			);
			$session->_start_session('masession');
			$session->session_run($array_sess);
		}else{
			$session->debug();
			frontend_model_template::assign('session_super', $_SESSION['panier']);
		}
	 */
	/**
	 * @access public
	 * Affiche le debug pour les sessions
	 */
	public function debug(){
		if (M_FIREPHP) {
	  		$firebug = new magixcjquery_debug_magixfire();
			$firebug->magixFireGroup('Magix Session');
			//$firebug->magixFireLog($_SESSION);
			$firebug->magixFireDump('session run',$_SESSION);
			$firebug->magixFireGroupEnd();
        }else{
        	var_dump($_SESSION);
        }
	}
}