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
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name user
 *
 */
class backend_controller_user extends statesUserAdmin{
	/**
	 * Pseudo
	 * @var string
	 */
	public $pseudo;
	/**
	 * Email
	 * @var string
	 */
	public $email;
	/**
	 * Cryptpass
	 * @var string
	 */
	public $cryptpass;
	public $keyuniqid;
	/**
	 * perms (permission)
	 * @var string
	 */
	public $perms;
	/**
	 * deluser
	 * @var string
	 */
	public $deluser;
	/**
	 * edit
	 * @var string
	 */
	public $edit;
	/**
	 * Constructor
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
		if(isset($_POST['perms'])){
			$this->perms = magixcjquery_form_helpersforms::inputClean(magixcjquery_filter_isVar::isPostNumeric($_POST['perms']));
		}
		if(isset($_GET['deluser'])){
			$this->deluser = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['deluser']);
		}
		if(isset($_GET['edit'])){
			$this->edit = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('keyuniqid')){
			$this->keyuniqid = magixcjquery_form_helpersforms::inputClean($_POST['keyuniqid']);
		}
	}
	/**
	 * Génnération d'une clé public unique pour servir d'identifiant
	 * @return string
	 */
	private function keyuniqid(){
		return magixglobal_model_cryptrsa::uuid_generator();
	}
	/**
	 * Insert un nouvel utilisateur
	 */
	protected function insert_members(){
		if(isset($this->pseudo) AND isset($this->cryptpass)){
			backend_db_admin::adminDbMember()->i_n_members($this->pseudo,$this->email,$this->cryptpass,$this->keyuniqid(),$this->perms);
			backend_config_smarty::getInstance()->display('user/request/success.phtml');
		}
	}
	/**
	 * Update un utilisateur
	 */
	protected function update_members(){
		if(isset($this->edit)){
			if(isset($this->pseudo) AND isset($this->cryptpass)){
				try{
					if(isset($this->keyuniqid) == '' OR isset($this->keyuniqid) == null){
						backend_db_admin::adminDbMember()->u_n_members($this->pseudo,$this->email,$this->cryptpass,$this->keyuniqid(),$this->perms,$this->edit);
					}else{
						backend_db_admin::adminDbMember()->u_n_members($this->pseudo,$this->email,$this->cryptpass,null,$this->perms,$this->edit);
					}
					backend_config_smarty::getInstance()->display('user/request/update.phtml');
				}catch(Exception $e) {
		         	magixcjquery_debug_magixfire::magixFireError($e);
				} 
			}
		}
	}
	/**
	 * Block pour afficher le nombre total de membres
	 */
	private function block_states_members(){
		$states = null;
		$states .=  parent::count_maximum_members();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de membres suivant les permissions
	 */
	private function block_members_perms(){
		$states = null;
		$states .=  parent::count_members_in_perms();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de news par membres
	 */
	private function block_news_members(){
		$states = null;
		$states .=  parent::count_news_by_members();
		return $states;
	}
	/**
	 * Block pour afficher le nombre total de page CMS par membres
	 */
	private function block_cms_members(){
		$states = null;
		$states .=  parent::count_cms_by_members();
		return $states;
	}
	/**
	 * Requête POST pour l'insertion des membres
	 */
	private function post(){
		self::insert_members();
	}
	/**
	 * Requête POST pour la mise à jour des membres
	 */
	private function update_post(){
		self::update_members();
	}
	/**
	 * Suppression d'utilisateur
	 */
	private function delete_user(){
		if(isset($this->deluser)){
			backend_db_admin::adminDbMember()->d_members_user($this->deluser);
		}
	}
	/**
	 * Affiche la page des utilisateurs
	 */
	private function display(){
		backend_config_smarty::getInstance()->assign('block_states_users',self::block_states_members());
		backend_config_smarty::getInstance()->assign('block_members_perms',self::block_members_perms());
		backend_config_smarty::getInstance()->assign('block_news_members',self::block_news_members());
		backend_config_smarty::getInstance()->assign('block_cms_members',self::block_cms_members());
		backend_config_smarty::getInstance()->display('user/index.phtml');
	}
	/**
	 * Affiche la page des utilisateurs
	 */
	private function display_edit(){
		parent::load_param_form($this->edit);
		backend_config_smarty::getInstance()->assign('current_perm',backend_model_member::s_perms_current_admin());
		backend_config_smarty::getInstance()->display('user/edit.phtml');
	}
	public function run(){
		if(magixcjquery_filter_request::isGet('add')){
			self::post();
		}elseif(magixcjquery_filter_request::isGet('deluser')){
			self::delete_user();
		}elseif(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_post();
			}else{
				self::display_edit();
			}
		}else{
			self::display();
		}
	}
}
/**
 * Class pour les statistiques utilisateurs
 * @author Gérits Aurelien
 *
 */
class statesUserAdmin{
	/**
	 * Compte le nombre de membres
	 */
	protected static function count_maximum_members(){
		$dbmembers = backend_db_admin::adminDbMember()->c_max_members();
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-bookmark"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							</tr>
						</thead>
						<tbody>';
		$states .= '<tr class="line">';
		$states .=	'<td class="maximal">Total</td>';
		$states .=	'<td class="nowrap">'.$dbmembers['countadmin'].'</td>';
		$states .= '</tr>';
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Compte 
	 */
	protected static function count_members_in_perms(){
		$perms = null;
		$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-key"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_admin::adminDbMember()->c_members_by_perms() as $members){
			switch($members['perms']){
					case 1:
						$perms = 'Seo Agency';
						break;
					case 2:
						$perms = 'Web Agency';
						break;
					case 3:
						$perms = 'User admin';
						break;
					case 4:
						$perms = 'User';
						break;
			}
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$perms.'</td>';
			$states .=	'<td class="nowrap">'.$members['countadmin'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Compte le nombre de news inserer par membre
	 */
	protected static function count_news_by_members(){
		/*$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-calendar"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_news::adminDbNews()->c_news_user() as $members){
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$members['pseudo'].'</td>';
			$states .=	'<td class="nowrap">'.$members['usernews'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;*/
	}
	/**
	 * Compte le nombre de page par membre
	 */
	protected static function count_cms_by_members(){
		/*$states = '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-document-b"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_cms::adminDbCms()->c_cms_user() as $members){
			$states .= '<tr class="line">';
			$states .=	'<td class="maximal">'.$members['pseudo'].'</td>';
			$states .=	'<td class="nowrap">'.$members['usercms'].'</td>';
			$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;*/
	}
	/**
	 * Charge les donnée du formulaire de mise à jour
	 */
	protected static function load_param_form($edit){
		$userperm = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		$info = backend_db_admin::adminDbMember()->view_info_members($edit);
		backend_config_smarty::getInstance()->assign('user_perms',$info['perms']);
		backend_config_smarty::getInstance()->assign('pseudo',$info['pseudo']);
		backend_config_smarty::getInstance()->assign('email',$info['email']);
		backend_config_smarty::getInstance()->assign('keyuniqid',$info['keyuniqid']);
	}
}