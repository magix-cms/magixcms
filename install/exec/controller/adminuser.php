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
 * @category   Controller 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name adminuser
 *
 */
class exec_controller_adminuser extends dbinstuser{
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $pseudo;
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $email;
	/**
	 * pseudo
	 * @var string $pseudo
	 */
	public $cryptpass;
	/**
	 * constructor
	 * 
	 */
	function __construct(){
		if(isset($_POST['pseudo'])){
			$this->pseudo = magixcjquery_form_helpersforms::inputClean($_POST['pseudo']);
		}
		if(isset($_POST['email'])){
			$this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
		}
		if(isset($_POST['cryptpass'])){
			$this->cryptpass = magixcjquery_form_helpersforms::inputClean(sha1($_POST['cryptpass']));
		}
	}
	/**
	 * Génnération d'une clé public unique pour servir d'identifiant
	 * @return string
	 */
	private function keyuniqid(){
		return magixglobal_model_cryptrsa::uuid_generator();
	}
	protected function insert_admin_members(){
		if(isset($this->pseudo) AND isset($this->cryptpass) AND isset($this->email)){
			if(!empty($this->email)){
				if(magixcjquery_filter_isVar::isMail($this->email)){
					parent::cuser()->i_useradmin($this->pseudo,$this->email,$this->cryptpass,$this->keyuniqid());
					//exec_config_smarty::getInstance()->display('request/success-user.phtml');
				}
			}
		}
	}
	public function display_user_page(){
		exec_config_smarty::getInstance()->display('user.phtml');
	}
	public function display_completes_install(){
		self::insert_admin_members();
		exec_config_smarty::getInstance()->display('end.phtml');
	}
}
class dbinstuser{
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $cuser;
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function cuser(){
        if (!isset(self::$cuser)){
         	self::$cuser = new dbinstuser();
        }
    	return self::$cuser;
    }
	public function i_useradmin($pseudo,$email,$cryptpass,$keyuniqid){
		$sql = array(
			'INSERT INTO mc_admin_member (pseudo,email,cryptpass,keyuniqid) VALUE("'.$pseudo.'","'.$email.'","'.$cryptpass.'","'.$keyuniqid.'")',
			'INSERT INTO mc_admin_perms (perms) VALUE("1")'
		);
		magixglobal_model_db::layerDB()->transaction($sql);
	}
}