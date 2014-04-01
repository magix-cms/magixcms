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
class backend_db_access{

    //profile
    /**
     * @access protected
     * @return mixed
     */
    public function s_profile(){
        $sql='SELECT * FROM mc_admin_role_user';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * @access protected
     * Retourne un tableau des valeurs du profile
     * @param $edit
     * @return mixed
     */
    protected function s_edit_profile($edit){
        $sql='SELECT * FROM mc_admin_role_user
        WHERE id_role = :edit';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':edit'=> $edit
            )
        );
    }

    /**
     * Insertion d'un profile utilisateur
     * @param $idlang
     * @param $role_name
     */
    protected function i_new_profile($role_name){
        $sql = 'INSERT INTO mc_admin_role_user (role_name)
        VALUE (:role_name)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':role_name'=> $role_name
            )
        );
    }

    /**
     * Edition d'un profile utilisateur
     * @param $edit
     * @param $role_name
     */
    protected function u_edit_profile($edit,$role_name){
        $sql = 'UPDATE mc_admin_role_user SET role_name=:role_name
		WHERE id_role = :edit';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':edit'=> $edit,
            ':role_name'=> $role_name
        ));
    }
    //access
    /**
     * @access protected
     * @param $edit
     * @return mixed
     */
    protected function s_edit_access($edit){
        $sql='SELECT access.*,module.class_name,module.plugins
        FROM mc_admin_access AS access
        JOIN mc_module as module ON(access.id_module = module.id_module)
        WHERE access.id_role = :edit';
        return magixglobal_model_db::layerDB()->select($sql,
            array(
                ':edit'=> $edit
            )
        );
    }

    /**
     * Vérification d'accès utilisateurs pour le profil
     * @param $edit
     * @param $id_module
     * @return mixed
     */
    protected function v_add_access($edit,$id_module){
        $sql='SELECT access.id_access,access.id_role,access.view_access,
        access.add_access,access.edit_access,access.delete_access,module.class_name,module.id_module
        FROM mc_admin_access AS access
        JOIN mc_module AS module ON(access.id_module = module.id_module)
        WHERE access.id_role = :edit AND module.id_module = :id_module';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':edit'=> $edit,
                ':id_module'=> $id_module,
            )
        );
    }

    /**
     * Insertion d'accès utilisateurs pour le profil
     * @param $edit
     * @param $id_module
     * @param $view_access
     * @param $add_access
     * @param $edit_access
     * @param $delete_access
     */
    protected function i_access($edit,$id_module,$view_access,$add_access,$edit_access,$delete_access){
        $sql = 'INSERT INTO mc_admin_access (id_role,id_module,view_access,add_access,edit_access,delete_access)
        VALUE (:id_role,:id_module,:view_access,:add_access,:edit_access,:delete_access)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_role'=> $edit,
                ':id_module'=> $id_module,
                ':view_access'=> $view_access,
                ':add_access'=> $add_access,
                ':edit_access'=> $edit_access,
                ':delete_access'=> $delete_access
            )
        );
    }

    /**
     * Editer les accès utilisateurs
     * @param $id_access
     * @param $access_type
     * @param $access_value
     */
    protected function u_edit_access($id_access,$access_type,$access_value){
        $sql = 'UPDATE mc_admin_access SET '.$access_type.'=:access_value
		WHERE id_access = :id_access';
        magixglobal_model_db::layerDB()->update($sql,array(
            ':id_access'=> $id_access,
            ':access_value'=> $access_value
        ));
    }

    /**
     * @param $id_role
     */
    protected function d_role($id_role){
        $sql = array(
            'DELETE FROM mc_admin_access_rel
             WHERE id_role ='.$id_role,
            'DELETE FROM mc_admin_role_user
             WHERE id_role ='.$id_role);
        magixglobal_model_db::layerDB()->transaction($sql);
    }
    //module
    /**
     * @return array
     */
    protected function s_module(){
        $sql='SELECT module.*
        FROM mc_module AS module';
        return magixglobal_model_db::layerDB()->select($sql);
    }
}
?>