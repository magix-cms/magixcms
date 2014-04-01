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
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @copyright  MAGIX CMS Copyright (c) 2010 -2014 Gerits Aurelien,
 * @version  Release: 1.0
 * Date: 07/03/14
 * @license Dual licensed under the MIT or GPL Version 3 licenses.
 */
class backend_model_access extends backend_db_employee{
    /**
     * @return array
     */
    public static function default_access(){
        return self::$default_access;
    }
    public function listPlugins(){
        $pathplugins = new backend_controller_plugins();
        /**
         * Si le dossier est accessible en lecture
         */
        if(!is_readable($pathplugins->directory_plugins())){
            throw new exception('Plugin dir is not minimal permission');
        }
        $makefiles = new magixcjquery_files_makefiles();
        $dir = $makefiles->scanRecursiveDir($pathplugins->directory_plugins());
        if($dir != null){
            plugins_Autoloader::register();
            $list = '';
            foreach($dir as $d){
                if(file_exists($pathplugins->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
                    $pluginPath = $pathplugins->directory_plugins().$d;
                    if($makefiles->scanDir($pluginPath) != null){
                        //Nom de la classe pour le test de la méthode
                        $class = 'plugins_'.$d.'_admin';
                        //Si la méthode run existe on ajoute le plugin dans le menu
                        if(method_exists($class,'run')){
                            $plugin[$class]= $d;
                        }
                    }
                }
            }
            return $plugin;
        }
    }
    /*
     * Retourne un tableau des données de sessions
     */
    public function data_session(){
        $data_session = parent::s_data_session($_SESSION['keyuniqid_admin']);
        return $data_session;
    }

    /**
     * @param $data_session
     * @param $class_name
     * @param null $plugin
     * @return array
     */
    public function data_employee($data_session,$class_name, $plugin = null){
        $id_admin = $data_session['id_admin'];
        $id_role = $data_session['id_role'];
        $data_access = parent::s_access_profile($id_role,$class_name);
        $access['view']   = $data_access['view_access'];
        $access['add']    = $data_access['add_access'];
        $access['edit']   = $data_access['edit_access'];
        $access['delete'] = $data_access['delete_access'];
        return $access;
    }

    /**
     * @param $data_session
     * @return array
     */
    public function all_data_employee($data_session){
        $id_role = $data_session['id_role'];
        $array_access = parent::s_all_access_profile($id_role);
        foreach($array_access as $key){
            $class_name[$key['class_name']]= array(
                'view_access'   =>  $key['view_access'],
                'add_access'    =>  $key['add_access'],
                'edit_access'   =>  $key['edit_access'],
                'delete_access' =>  $key['delete_access']
            );
        }
        return $class_name;
    }

    /**
     * @param $class_name
     * @return array
     */
    public function module_access($class_name){
        $all_access = self::all_data_employee(self::data_session());
        $access['view']   = $all_access[$class_name]['view_access'];
        $access['add']    = $all_access[$class_name]['add_access'];
        $access['edit']   = $all_access[$class_name]['edit_access'];
        $access['delete'] = $all_access[$class_name]['delete_access'];
        return $access;
    }
}
?>