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
 * @name user
 *
 */
class backend_controller_user extends backend_db_admin{
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
	/**
	 * perms (permission)
	 * @var string
	 */
	public $id_role;
	/**
	 * deluser
	 * @var string
	 */
	public $delele_user;
	/**
	 * edit
	 * @var string
	 */
	public $edit,$action;
	/**
	 * Constructor
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('pseudo')){
			$this->pseudo = magixcjquery_form_helpersforms::inputClean($_POST['pseudo']);
		}
		if(magixcjquery_filter_request::isPost('email')){
			$this->email = magixcjquery_form_helpersforms::inputClean($_POST['email']);
		}
		if(magixcjquery_filter_request::isPost('cryptpass')){
			$this->cryptpass = magixcjquery_form_helpersforms::inputClean(sha1($_POST['cryptpass']));
		}
		if(magixcjquery_filter_request::isPost('id_role')){
			$this->id_role = magixcjquery_filter_isVar::isPostNumeric($_POST['id_role']);
		}
		if(magixcjquery_filter_request::isPost('delele_user')){
			$this->delele_user = magixcjquery_filter_isVar::isPostNumeric($_POST['delele_user']);
		}
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
	}

    /**
     * Construction du menu select pour les rôles
     * @param $create
     * @param null $idadmin
     * @return null|string
     */
    private function role_select($create,$idadmin=null){
        $create->configLoad('local_'.backend_model_language::current_Language().'.conf');
        $role = new backend_model_role();
        if($idadmin != null){
            $user_role = parent::s_user_role($idadmin);
            foreach($user_role as $key){
                $id_user_role[]=$key['id_role'];
                $role_user_name[]=$key['role_name'];
            }
            $user_role_conb = array_combine($id_user_role,$role_user_name);
        }else{
            $user_role_conb = null;
        }
        if(parent::s_role($role->sql_arg()) != null){
            $id_role = '';
            $role_name = '';
            foreach(parent::s_role($role->sql_arg()) as $key){
                $id_role[]=$key['id_role'];
                $role_name[]=$key['role_name'];
            }
            $role_conb = array_combine($id_role,$role_name);
            $select = backend_model_forms::select_static_row(
                $role_conb
                ,
                array(
                    'attr_name'     =>  'id_role',
                    'attr_id'       =>  'id_role',
                    'default_value' =>  $user_role_conb,
                    'empty_value'   =>  $create->getConfigVars('select_role'),
                    'upper_case'    =>  false
                )
            );
        }else{
            $select = null;
        }
        return $select;
    }

    /**
     * Retourne au format JSON la liste des utilisateurs
     */
    private function json_list_user(){
        $role = new backend_model_role();
        if(parent::s_users($role->sql_arg()) != null){
            foreach (parent::s_users($role->sql_arg()) as $key){
                $json[]= '{"idadmin":'.json_encode($key['idadmin']).',"pseudo":'.json_encode($key['pseudo'])
                .',"email":'.json_encode($key['email']).',"role_name":'.json_encode($key['role_name'])
                .'}';
            }
            print '['.implode(',',$json).']';
        }
    }

    /**
     * Insert un nouvel utilisateur
     * @param $create
     */
    private function insert_user($create){
		if(isset($this->pseudo) AND isset($this->cryptpass)){
			parent::i_new_user(
                $this->id_role,
                $this->pseudo,
                $this->email,
                $this->cryptpass,
                magixglobal_model_cryptrsa::uuid_generator()
            );
            $create->display('user/request/success_add.phtml');
		}
	}

    /**
     * Mise à jour des données utilisateur
     * @param $create
     */
    private function update_user_data($create){
        if(isset($this->pseudo) AND isset($this->email)){
            parent::u_user_data($this->edit,$this->pseudo,$this->email,$this->id_role);
            $create->display('user/request/success_update.phtml');
        }
    }

    /**
     * Mise à jour du mot de passe utilisateur
     * @param $create
     */
    private function update_user_password($create){
        if(isset($this->cryptpass)){
            parent::u_user_password($this->edit,$this->cryptpass);
            $create->display('user/request/success_update.phtml');
        }
    }
	/**
	 * Suppression d'utilisateur
	 */
	private function remove_user(){
		if(isset($this->delele_user)){
			parent::d_user($this->delele_user);
		}
	}
    /**
     * @access private
     * Requête JSON pour les statistiques des langues
     */
    private function json_graph(){
        if(parent::s_stats_user() != null){
            foreach (parent::s_stats_user() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['pseudo']),
                    'y'=>$key['HOME'],
                    'z'=>$key['NEWS'],
                    'a'=>$key['PAGES'],
                    'b'=>$key['PRODUCT']
                );
            }
            print json_encode($stat);
        }
    }

    /**
     * Chargement des données pour l'édition de l'utilisateur
     * @param $create
     */
    private function load_data($create){
        $data = parent::s_member_data($this->edit);
        $assign_exclude = array(
            'cryptpass','keyuniqid'
        );
        foreach($data as $key => $val){
            if( !(array_search($key,$assign_exclude) ) ){
                $create->assign($key,$val);
            }
        }
    }
	/**
	 * 
	 * run
	 */
	public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'users'
            ),array('users_'),false
        );
        if(isset($this->action)){
            if($this->action === 'add'){
                if(isset($this->email)){
                    $this->insert_user($create);
                }
            }elseif($this->action === 'list'){
                if(magixcjquery_filter_request::isGet('json_list_user')){
                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                    $header->pragma();
                    $header->cache_control("nocache");
                    $header->getStatus('200');
                    $header->json_header("UTF-8");
                    $this->json_list_user();
                }else{
                    $create->assign('role_select',$this->role_select($create));
                    $create->display('user/list.phtml');
                }
            }elseif($this->action === 'edit'){
                if(isset($this->email)){
                    $this->update_user_data($create);
                }elseif(isset($this->cryptpass)){
                    $this->update_user_password($create);
                }else{
                    $this->load_data($create);
                    $create->assign('role_select',$this->role_select($create,$this->edit));
                    $create->display('user/edit.phtml');
                }
            }elseif($this->action === 'remove'){
                if(isset($this->delele_user)){
                    $this->remove_user();
                }
            }
        }else{
            if(magixcjquery_filter_request::isGet('json_graph')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_graph();
            }else{
                $create->display('user/index.phtml');
            }
        }
	}
}