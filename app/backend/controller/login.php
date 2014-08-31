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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name ADMIN
 *
 */
class backend_controller_login extends backend_db_employee{
    //SESSION
    /**
     * @var $logout
     */
    public $logout;
    /**
     * input type hidden
     * @access protected
     *
     * @var string
     */
    protected $hashtoken,$message;
    /**
     * @var $email_admin,$passwd_admin
     */
    public $email_admin,$lo_email_admin,$passwd_admin;
	/**
	 * protected var for dbLayer
	 *
	 * @var void
	 */
	function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
		if(magixcjquery_filter_request::isPost('passwd_admin')){
		    $this->passwd_admin = sha1(magixcjquery_form_helpersforms::inputClean($_POST['passwd_admin']));
          }
		if(magixcjquery_filter_request::isPost('hashtoken')){
          	$this->hashtoken = magixcjquery_filter_var::escapeHTML($_POST['hashtoken']);
        }
        if (magixcjquery_filter_request::isGet('logout')) {
        	$this->logout = magixcjquery_filter_isVar::isPostAlpha($_GET['logout']);
        }
		if(magixcjquery_filter_request::isPost('email_admin')){
         	 $this->email_admin = magixcjquery_filter_isVar::isMail($_POST['email_admin']);
        }

        //LOSTPASSWORD
        if(magixcjquery_filter_request::isPost('lo_email_admin')){
            $this->lo_email_admin = magixcjquery_filter_isVar::isMail($_POST['lo_email_admin']);
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
        //Language model init class
        $language = new backend_model_language();
        $language->run();
		$token = isset($_SESSION['mc_auth_token']) ? $_SESSION['mc_auth_token'] : magixglobal_model_cryptrsa::tokenId();
		$tokentools = $this->hashPassCreate($token);
		backend_controller_template::assign('hashpass',$tokentools);
        if (isset($this->email_admin) AND isset($this->passwd_admin) AND isset($this->hashtoken)) {
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
                $auth_exist = parent::s_auth_exist($this->email_admin,$this->passwd_admin);

				if(count($auth_exist['id_admin']) == true){
					$session = new backend_model_sessions();
                    $lang = new backend_model_language();
					$string = $_SERVER['HTTP_USER_AGENT'];
					$string .= 'SHIFLETT';
					/* Add any other data that is consistent */
					$fingerprint = md5($string);
					//Fermeture de la première session, ses données sont sauvegardées.
					session_write_close();
					$this->start_session();
                    $data = parent::s_data_session($auth_exist['keyuniqid_admin']);
                    if (!isset($_SESSION['email_admin']) AND !isset($_SESSION['keyuniqid_admin'])) {
						$lang = new backend_model_language();
                        $session->openSession($data['id_admin'],session_regenerate_id(true), $data['keyuniqid_admin']);
						//session_regenerate_id(true);
                        $_SESSION['id_admin'] = $data['id_admin'];
		    			$_SESSION['email_admin'] = $data['email_admin'];
		    			$_SESSION['keyuniqid_admin'] = $data['keyuniqid_admin'];
                        $_SESSION['adminLanguage'] = $lang->run();
						if($debug == true){
							$firebug = new magixcjquery_debug_magixfire();
							$firebug->magixFireGroup('adminsession');
							$firebug->magixFireDump('User session',$_SESSION);
							$firebug->magixFireGroupEnd();
						}
		    			magixglobal_model_redirect::backend_redirect_login(false);	
					}else{
						$session->openSession($data['id_admin'],null, $data['keyuniqid_admin']);
                        $_SESSION['id_admin'] = $data['id_admin'];
                        $_SESSION['email_admin'] = $data['email_admin'];
                        $_SESSION['keyuniqid_admin'] = $data['keyuniqid_admin'];
                        $_SESSION['adminLanguage'] = $lang->run();
						if($debug == true){
							$firebug = new magixcjquery_debug_magixfire();
                            $firebug->magixFireGroup('adminsession');
                            $firebug->magixFireDump('User session',$_SESSION);
							$firebug->magixFireGroupEnd();
						}
						magixglobal_model_redirect::backend_redirect_login(false);	
					}
				}else{
                    $this->message->getNotify('error_login',array('method'=>'fetch','assignFetch'=>'login_message'));
				}
			}else{
                $this->message->getNotify('error_hash',array('method'=>'fetch','assignFetch'=>'login_message'));
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
        if (!isset($_SESSION["email_admin"]) || empty($_SESSION['email_admin'])){
			if (!isset($this->email_admin)) {
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
		if (isset($this->logout)) {
            if (isset($_SESSION['email_admin']) AND isset($_SESSION['keyuniqid_admin'])){
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
     * @param $debug
     * @return void
     */
	public function login($debug){
		$this->start_session();
		$this->tokenInitSession();
		$this->authSession($debug);
		backend_controller_template::display('login/index.tpl');
	}
}