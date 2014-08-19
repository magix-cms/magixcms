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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name role
 *
 */

class backend_controller_access extends backend_db_access{
    /**
     * @var admin_model_access
     */
    protected $model_access,$message;
    /**
     * @var bool
     */
    public $action,$edit;
    /**
     * @var $name_profile
     */
    public $role_name,$delete_role;
    public $id_module,$plugins,$view_access,$add_access,$edit_access,$delete_access;

    /**
     * edit access
     */
    public $id_access;
    /**
     * Constructor
     */
    public function __construct(){
        $this->message = new backend_model_message();
        if(class_exists('backend_model_access')){
            $this->model_access = new backend_model_access();
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('edit')){
            $this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
        }
        //profile
        if(magixcjquery_filter_request::isPost('role_name')){
            $this->role_name = magixcjquery_form_helpersforms::inputClean($_POST['role_name']);
        }
        //access

        if(magixcjquery_filter_request::isPost('id_module')){
            $this->id_module = magixcjquery_filter_isVar::isPostNumeric($_POST['id_module']);
        }
        if(magixcjquery_filter_request::isPost('plugins')){
            $this->plugins = magixcjquery_form_helpersforms::inputClean($_POST['plugins']);
        }
        if(magixcjquery_filter_request::isPost('view_access')){
            $this->view_access = magixcjquery_form_helpersforms::inputClean($_POST['view_access']);
        }
        if(magixcjquery_filter_request::isPost('add_access')){
            $this->add_access = magixcjquery_form_helpersforms::inputClean($_POST['add_access']);
        }
        if(magixcjquery_filter_request::isPost('edit_access')){
            $this->edit_access = magixcjquery_form_helpersforms::inputClean($_POST['edit_access']);
        }
        if(magixcjquery_filter_request::isPost('delete_access')){
            $this->delete_access = magixcjquery_form_helpersforms::inputClean($_POST['delete_access']);
        }
        if(magixcjquery_filter_request::isPost('id_access')){
            $this->id_access = magixcjquery_form_helpersforms::inputClean($_POST['id_access']);
        }
        if(magixcjquery_filter_request::isPost('delete_role')){
            $this->delete_role = magixcjquery_form_helpersforms::inputClean($_POST['delete_role']);
        }
    }

    /**
     * @access private
     * Liste des profiles pour les accès utilisateurs
     */
    private function listing_profile(){
        $http_json = new magixglobal_model_json();
        foreach(parent::s_profile() as $value){
            $json[]= '{"id_role":'.json_encode($value['id_role']).
                ',"role_name":'.json_encode($value['role_name'])
            .'}';
        }
        print $http_json->encode($json,array('[',']'));
    }

    /**
     * @access private
     * Chargement des données de profil
     */
    private function load_data_profile($create){
        if(isset($this->edit)){
            $data = parent::s_edit_profile($this->edit);
            $select = parent::s_module();
            $create->assign('role_name',$data['role_name']);
            $create->assign('selectAccess',$select);
        }
    }

    /**
     * @access private
     * Retourne sous format JSON la liste des accès de ce profil
     */
    private function listing_access(){
        $http_json = new magixglobal_model_json();
        if(parent::s_edit_access($this->edit) != null){
            foreach(parent::s_edit_access($this->edit) as $value){
                $json[]= '{"id_role":'.json_encode($value['id_role']).
                    ',"id_access":'.json_encode($value['id_access']).
                    ',"class_name":'.json_encode($value['class_name']).
                    ',"view_access":'.json_encode($value['view_access']).
                    ',"add_access":'.json_encode($value['add_access']).
                    ',"edit_access":'.json_encode($value['edit_access']).
                    ',"delete_access":'.json_encode($value['delete_access']).
                    ',"plugins":'.json_encode($value['plugins']).
                    '}';
            }
            print $http_json->encode($json,array('[',']'));
        }else{
            print '{}';
        }
    }

    /**
     * @access private
     * Insertion d'un nouveau profile d'accès
     * @param $role_name
     */
    private function add_profile($role_name){
        if(isset($role_name)){
            if(empty($role_name)){

            }else{
                parent::i_new_profile($role_name);
                $this->message->getNotify('add');
            }
        }
    }

    /**
     * @access private
     * Edition d'un profil d'accès
     * @param $role_name
     */
    private function edit_profile($role_name){
        if(isset($role_name)){
            if(empty($role_name)){

            }else{
                parent::u_edit_profile($this->edit,$role_name);
                $this->message->getNotify('update');
            }
        }
    }

    /**
     * Ajout des permissions d'accès pour le profil
     * @param $class_name
     */
    private function add_new_access($id_module){
        if(isset($id_module)){
            if(!empty($id_module)){
                if(empty($this->plugins)){
                    $plugins = 0;
                }else{
                    $plugins = $this->plugins;
                }
                if(empty($this->view_access)){
                    $view_access = 0;
                }else{
                    $view_access = $this->view_access;
                }
                if(empty($this->add_access)){
                    $add_access = 0;
                }else{
                    $add_access = $this->add_access;
                }
                if(empty($this->edit_access)){
                    $edit_access = 0;
                }else{
                    $edit_access = $this->edit_access;
                }
                if(empty($this->delete_access)){
                    $delete_access = 0;
                }else{
                    $delete_access = $this->delete_access;
                }
                $verify = parent::v_add_access($this->edit,$id_module);
                if($verify['id_module'] == null){
                    parent::i_access(
                        $this->edit,
                        $id_module,
                        $view_access,
                        $add_access,
                        $edit_access,
                        $delete_access
                    );
                }
            }
        }
    }

    /**
     * @access private
     * Edition des permissions d'accès pour le profil
     */
    private function edit_access(){
        if(isset($this->id_access)){
            if(isset($this->view_access)){
                $access_type = 'view_access';
                $access_value = $this->view_access;
            }elseif(isset($this->add_access)){
                $access_type = 'add_access';
                $access_value = $this->add_access;
            }elseif(isset($this->edit_access)){
                $access_type = 'edit_access';
                $access_value = $this->edit_access;
            }elseif(isset($this->delete_access)){
                $access_type = 'delete_access';
                $access_value = $this->delete_access;
            }
            parent::u_edit_access($this->id_access,$access_type,$access_value);
        }
    }
    /**
     * Suppression d'un rôle
     */
    private function remove_role($delete_role){
        if(isset($delete_role)){
            if($delete_role != '1'){
                parent::d_role($delete_role);
            }
        }
    }
    /**
     * execution du module d'accès
     */
    public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'users'
            ),array('users_'),false
        );
        $access = $this->model_access->module_access("backend_controller_access");
        $all_access = $this->model_access->all_data_employee($this->model_access->data_session());
        //print_r($all_access);
        $create->assign('access',$access);
        $create->assign('all_access',$all_access);
        //if($access['view'] == 1)
        if($this->action == 'add'){
            if(isset($this->role_name)){
                $this->add_profile($this->role_name);
            }elseif(isset($this->id_module)){
                $this->add_new_access($this->id_module);
            }else{
                $create->display('access/add.tpl');
            }
        }elseif($this->action == 'list'){
            if(magixcjquery_filter_request::isGet('json_profiles')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->listing_profile();
            }elseif(magixcjquery_filter_request::isGet('json_access')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->listing_access();
            }else{
                $create->display('access/list.tpl');
            }
        }elseif($this->action == 'edit'){
            if(isset($this->role_name)){
                $this->edit_profile($this->role_name);
            }elseif($this->id_access){
                $this->edit_access();
            }else{
                $this->load_data_profile($create);
                $create->display('access/edit.tpl');
            }
        }elseif($this->action == 'remove'){
            if(isset($this->delete_role)){
                $this->remove_role($this->delete_role);
            }
        }else{
            $access = new backend_model_access();
            /*print "<pre>";
            print_r($access->listPlugins());
            print "</pre>";*/
            $create->display('access/list.tpl');
        }
    }
}
?>