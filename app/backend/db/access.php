<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of SC BOX.
# SC BOX, The content management system optimized for users
# Copyright (C) 2012 sc-box.com <support@sc-box.com>
#
# OFFICIAL TEAM :
#
#   * Gerits Aurelien (Author - Developer) <aurelien@sc-box.com>
#   * Lesire Samuel (Design) <samuel@sc-box.com>
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

# Do not edit or add to this file if you wish to upgrade SC Box to newer
# versions in the future. If you wish to customize SC Box for your
# needs please refer to http://www.sc-box.com for more information.

/**
 * @author Gerits Aurelien <aurelien@sc-box.com>
 * @copyright  2012 SC BOX
 * @version  Release: $Revision$
 *  Date: 11/08/12
 *  Time: 01:12
 * @license Dual licensed under the MIT or GPL Version 3 licenses.
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
        $sql='SELECT * FROM mc_admin_profile
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
     * @param $name_profile
     */
    protected function i_new_profile($name_profile){
        $sql = 'INSERT INTO mc_admin_profile (name_profile)
        VALUE (:name_profile)';
        component_routing_db::layer()->insert($sql,
            array(
                ':name_profile'=> $name_profile
            )
        );
    }

    /**
     * Edition d'un profile utilisateur
     * @param $edit
     * @param $name_profile
     */
    protected function u_edit_profile($edit,$name_profile){
        $sql = 'UPDATE mc_admin_profile SET name_profile=:name_profile
		WHERE id_role = :edit';
        component_routing_db::layer()->update($sql,array(
            ':edit'=> $edit,
            ':name_profile'=> $name_profile
        ));
    }
    //access
    /**
     * @access protected
     * @param $edit
     * @return mixed
     */
    protected function s_edit_access($edit){
        $sql='SELECT * FROM mc_admin_access
        WHERE id_role = :edit';
        return magixglobal_model_db::layerDB()->select($sql,
            array(
                ':edit'=> $edit
            )
        );
    }

    /**
     * Vérification d'accès utilisateurs pour le profil
     * @param $edit
     * @param $class_name
     * @return mixed
     */
    protected function v_add_access($edit,$class_name){
        $sql='SELECT * FROM mc_admin_access
        WHERE id_role = :edit AND class_name = :class_name';
        return magixglobal_model_db::layerDB()->selectOne($sql,
            array(
                ':edit'=> $edit,
                ':class_name'=> $class_name,
            )
        );
    }

    /**
     * Insertion d'accès utilisateurs pour le profil
     * @param $edit
     * @param $class_name
     * @param $plugins
     * @param $view_access
     * @param $add_access
     * @param $edit_access
     * @param $delete_access
     */
    protected function i_access($edit,$class_name,$plugins,$view_access,$add_access,$edit_access,$delete_access){
        $sql = 'INSERT INTO mc_admin_access (id_role,class_name,plugins,view_access,add_access,edit_access,delete_access)
        VALUE (:id_role,:class_name,:plugins,:view_access,:add_access,:edit_access,:delete_access)';
        component_routing_db::layer()->insert($sql,
            array(
                ':id_role'=> $edit,
                ':class_name'=> $class_name,
                ':plugins'=> $plugins,
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
        component_routing_db::layer()->update($sql,array(
            ':id_access'=> $id_access,
            ':access_value'=> $access_value
        ));
    }
}
?>