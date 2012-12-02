<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name ADMIN
 *
 */
class backend_controller_admin{
	/**
	 *
	 *
	 * @var string
	 */
	public $acmail;
	/**
	 *
	 *
	 * @var string
	 */
	public $acsclose;
	/**
	 *
	 *
	 * @var param
	 */
	public $smarty;
	/**
	 * instance lang setting conf
	 *
	 * @var string
	 */
	public $lang;
	/**
	 * input type hidden 
	 * @access protected
	 *
	 * @var string
	 */
	public $hashtoken;
	/**
	 * private var password re-genere
	 *
	 * @var string
	 * @access private
	 */
	protected $acpass;
	/**
	 * protected var for dbLayer
	 *
	 * @var void
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('acpass')){
		    $this->acpass = (string) sha1(magixcjquery_form_helpersforms::inputClean($_POST['acpass']));
          }
		if(magixcjquery_filter_request::isPost('hashtoken')){
          	$this->hashtoken = magixcjquery_filter_var::escapeHTML($_POST['hashtoken']);
        }
        if (magixcjquery_filter_request::isGet('acsclose')) {
        	$this->acsclose = magixcjquery_filter_isVar::isPostAlpha($_GET['acsclose']);
        }
		if(magixcjquery_filter_request::isPost('acmail')){
         	 $this->acmail = magixcjquery_filter_isVar::isMail($_POST['acmail']); 
        }
	}
	/**
	 * Crypt md5
	 * @param string $hash
	 * @static
	 * @access protected
	 */
	static protected function hashPassCreate($hash){
		return md5($hash);
	}
	/**
	 * @access private
	 * Initialisation du token de session
	 */
	private function tokenInitSession(){
		if (empty($_SESSION['mc_auth_token'])){
			return $_SESSION['mc_auth_token'] = magixglobal_model_cryptrsa::tokenId();
		}else{
			if (isset($_SESSION['mc_auth_token'])){
				return $_SESSION['mc_auth_token'];
			}
		}
	}
	/**
	 * @access private
	 * SESSION START
	 */
	private function start_session(){
		session_name('adminlang');
		ini_set('session.hash_function',1);
		session_start();
	}
	/**
	 * @access private
	 * Vérification de la session pour accèder à l'administration
	 * @param bool $debug
	 */
	private function authSession($debug = false){
		$token = isset($_SESSION['mc_auth_token']) ? $_SESSION['mc_auth_token'] : magixglobal_model_cryptrsa::tokenId();
		$tokentools = $this->hashPassCreate($token);
		backend_config_smarty::getInstance()->assign('hashpass',$tokentools);
		if (isset($this->acpass) AND isset($this->acmail) AND isset($this->hashtoken)) {
			if(strcasecmp($this->hashtoken,$tokentools) == 0){
				if($debug == true){
					$firebug = new magixcjquery_debug_magixfire();
					$firebug->magixFireGroup('tokentest');
					if($this->hashtoken){
						if(strcasecmp($this->hashtoken,$tokentools) == 0){
							$firebug->magixFireLog('session compatible');
						}else{
							$firebug->magixFireError('session incompatible');
						}
					}
					$firebug->magixFireLog($_SESSION);
					$firebug->magixFireGroupEnd();
				}
				if(count(backend_db_admin::adminDbMember()->s_auth_exist($this->acmail,$this->acpass)) == true){
					$session = new backend_model_sessions();
					$string = $_SERVER['HTTP_USER_AGENT'];
					$string .= 'SHIFLETT';
					/* Add any other data that is consistent */
					$fingerprint = md5($string);
					//Fermeture de la première session, ses données sont sauvegardées.
					session_write_close();
					$this->start_session();
					$const_url = backend_db_admin::adminDbMember()->s_t_profil_url($this->acmail);
					if (!isset($_SESSION['useradmin']) AND !isset($_SESSION['userkeyid'])) {
						$session->openSession($const_url['idadmin'],session_regenerate_id(true), $const_url['keyuniqid']);
						//session_regenerate_id(true);
		    			$_SESSION['useradmin'] = $this->acmail;
		    			$_SESSION['userkeyid'] = $const_url['keyuniqid'];
						if($debug == true){
							$firebug = new magixcjquery_debug_magixfire();
							$firebug->magixFireGroup('usersession');
							$firebug->magixFireDump('User session',$_SESSION);
							$firebug->magixFireGroupEnd();
						}
		    			magixglobal_model_redirect::backend_redirect_login(false);	
					}else{
						$session->openSession($const_url['idadmin'],null, $const_url['keyuniqid']);
						$_SESSION['useradmin'] = $this->acmail;
						$_SESSION['userkeyid'] = $const_url['keyuniqid'];
						if($debug == true){
							$firebug = new magixcjquery_debug_magixfire();
							$firebug->magixFireGroup('usersession');
							$firebug->magixFireDump('User session',$_SESSION);
							$firebug->magixFireGroupEnd();
						}
						magixglobal_model_redirect::backend_redirect_login(false);	
					}
				}else{
					$fetch = backend_config_smarty::getInstance()->fetch('login/request/failed.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
				}
			}else{
					$fetch = backend_config_smarty::getInstance()->fetch('login/request/hash.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
			}
		}
	}
	/**
	 * function secure page with session verif
	 * @return header
	 */
	public function securePage(){
		//ini_set("session.cookie_lifetime",3600);
		$this->start_session();
		if (!isset($_SESSION["useradmin"]) || empty($_SESSION['useradmin'])){
			if (!isset($this->acmail)) {
				magixglobal_model_redirect::backend_redirect_login(true);	
			}
		}elseif(!backend_model_sessions::compareSessionId()){
			magixglobal_model_redirect::backend_redirect_login(true);	
		}
	}
	/**
	* function close Session in erase cookies
	* @return header
	*/
	public function closeSession(){
		if (isset($this->acsclose)) {
			if (isset($_SESSION['useradmin']) AND isset($_SESSION['userkeyid'])){	
				$session = new backend_model_sessions();
				$session->closeSession();
				session_unset();
				$_SESSION = array();
				session_destroy();
				session_start();
				magixglobal_model_redirect::backend_redirect_login(true);	
			}
		}
	}
	/**
	 * Affiche le formulaire d'identification
	 * @return void
	 */
	public function login($debug){
		$this->start_session();
		$this->tokenInitSession();
		$this->authSession($debug);
		backend_config_smarty::getInstance()->display('login/index.phtml');
	}
}