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
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2014 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name employee
 *
 */
class backend_controller_employee extends backend_db_employee{
    protected $message;
    public $lastname_admin,$firstname_admin,$pseudo_admin,$email_admin,$passwd_admin,$active_admin,$delete_employee;
	public $edit,$action;
	/**
	 * Constructor
	 */
	function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isPost('lastname_admin')){
            $this->lastname_admin = magixcjquery_form_helpersforms::inputClean($_POST['lastname_admin']);
        }
        if(magixcjquery_filter_request::isPost('firstname_admin')){
            $this->firstname_admin = magixcjquery_form_helpersforms::inputClean($_POST['firstname_admin']);
        }
		if(magixcjquery_filter_request::isPost('pseudo_admin')){
			$this->pseudo_admin = magixcjquery_form_helpersforms::inputClean($_POST['pseudo_admin']);
		}
		if(magixcjquery_filter_request::isPost('email_admin')){
			$this->email_admin = magixcjquery_form_helpersforms::inputClean($_POST['email_admin']);
		}
		if(magixcjquery_filter_request::isPost('passwd_admin')){
			$this->passwd_admin = magixcjquery_form_helpersforms::inputClean(sha1($_POST['passwd_admin']));
		}
		if(magixcjquery_filter_request::isPost('id_role')){
			$this->id_role = magixcjquery_filter_isVar::isPostNumeric($_POST['id_role']);
		}
		if(magixcjquery_filter_request::isPost('delete_employee')){
			$this->delete_employee = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_employee']);
		}
        if(magixcjquery_filter_request::isPost('active_admin')){
            $this->active_admin = magixcjquery_filter_isVar::isPostNumeric($_POST['active_admin']);
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

        if($idadmin != null){
            $user_role = parent::s_role_data($idadmin);
            foreach($user_role as $key){
                $id_user_role[]=$key['id_role'];
                $role_user_name[]=$key['role_name'];
            }
            $user_role_conb = array_combine($id_user_role,$role_user_name);
        }else{
            $user_role_conb = null;
        }
        if(parent::s_all_role() != null){
            $id_role = '';
            $role_name = '';
            foreach(parent::s_all_role() as $key){
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
                    'class'         =>  'form-control',
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
        if(parent::s_listing_employee() != null){
            foreach (parent::s_listing_employee() as $key){
                $json[]= '{"idadmin":'.json_encode($key['id_admin']).',"pseudo":'.json_encode($key['pseudo_admin'])
                .',"email":'.json_encode($key['email_admin']).',"role_name":'.json_encode($key['role_name'])
                .'}';
            }
            print '['.implode(',',$json).']';
        }
    }

    /**
     * Insert un nouvel utilisateur
     * @param $create
     */
    private function insert_user(){
		if(isset($this->pseudo_admin) AND isset($this->passwd_admin)){
			parent::i_new_employee(
                magixglobal_model_cryptrsa::uuid_generator(),
                $this->lastname_admin,
                $this->firstname_admin,
                $this->pseudo_admin,
                $this->email_admin,
                $this->passwd_admin
            );
            parent::i_employee_profile(
                magixglobal_model_db::layerDB()->lastInsert(),
                $this->id_role
            );
            $this->message->getNotify('add');
		}
	}

    /**
     * Mise à jour des données utilisateur
     * @param $create
     */
    private function update_user_data(){
        if(isset($this->pseudo_admin) AND isset($this->pseudo_admin)){
            parent::u_edit_employee_infos(
                $this->edit,
                $this->lastname_admin,
                $this->firstname_admin,
                $this->pseudo_admin,
                $this->email_admin
            );
            $this->message->getNotify('update');
        }
    }
    /**
     * @access private
     * Modification d'un statut d'un utilisateur
     * @param $active_admin
     */
    private function edit_active_employee($active_admin){
        if(isset($active_admin)){
            parent::u_statut_employee(
                $this->edit,
                $active_admin
            );
        }
    }
    /**
     * @param $create
     */
    private function update_user_role(){
        if(isset($this->id_role)){
            parent::u_employee_profile(
                $this->edit,
                $this->id_role
            );
            $this->message->getNotify('update');
        }
    }
    /**
     * Mise à jour du mot de passe utilisateur
     * @param $create
     */
    private function update_user_password(){
        if(isset($this->passwd_admin)){
            parent::u_edit_employee_passwd($this->edit,$this->passwd_admin);
            $this->message->getNotify('update');
        }
    }
	/**
	 * Suppression d'utilisateur
	 */
	private function remove_user(){
		if(isset($this->delete_employee)){
			parent::d_employee($this->delete_employee);
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
                    'x'=>magixcjquery_string_convert::upTextCase($key['pseudo_admin']),
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
        $data = parent::s_edit_employee($this->edit);
        $assign_exclude = array(
            'passwd_admin','keyuniqid_admin'
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
                if(isset($this->email_admin)){
                    $this->insert_user();
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
                    $create->display('user/list.tpl');
                }
            }elseif($this->action === 'edit'){
                if(isset($this->email_admin)){
                    $this->update_user_data();
                }elseif(isset($this->id_role)){
                    $this->update_user_role();
                }elseif(isset($this->passwd_admin)){
                    $this->update_user_password();
                }elseif(isset($this->active_admin)){
                    $this->edit_active_employee($this->active_admin);
                }else{
                    $this->load_data($create);
                    $create->assign('role_select',$this->role_select($create,$this->edit));
                    $create->display('user/edit.tpl');
                }
            }elseif($this->action === 'remove'){
                if(isset($this->delete_employee)){
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
                $create->display('user/index.tpl');
            }
        }
	}
}