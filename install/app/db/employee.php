<?php
/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of MAGIX CMS.
# MAGIX CMS, The content management system optimized for users
# Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 25/02/13
 * Time: 23:12
 * License: Dual licensed under the MIT or GPL Version
 */
class app_db_employee{
    /**
     * Insert un nouvel utilisateur
     * @param $keyuniqid_admin
     * @param $lastname_admin
     * @param $firstname_admin
     * @param $pseudo_admin
     * @param $email_admin
     * @param $passwd_admin
     */
    protected function i_new_employee($keyuniqid_admin,$lastname_admin,$firstname_admin,$pseudo_admin,$email_admin,$passwd_admin){
        $sql = 'INSERT INTO mc_admin_employee (keyuniqid_admin,lastname_admin,firstname_admin,pseudo_admin,email_admin,passwd_admin,active_admin,last_change_admin)
        VALUE (:keyuniqid_admin,:lastname_admin,:firstname_admin,:pseudo_admin,:email_admin,:passwd_admin,1,NOW())';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':keyuniqid_admin'  => $keyuniqid_admin,
                ':lastname_admin'   => $lastname_admin,
                ':firstname_admin'  => $firstname_admin,
                ':pseudo_admin'     => $pseudo_admin,
                ':email_admin'      => $email_admin,
                ':passwd_admin'     => $passwd_admin
            )
        );
    }
    /**
     * @access protected
     * Insertion d'un employee dans la table des accès
     * @param $id_admin
     * @param $id_role
     */
    protected function i_employee_profile($id_admin,$id_role){
        $sql = 'INSERT INTO mc_admin_access_rel (id_admin,id_role)
        VALUE (:id_admin,:id_role)';
        magixglobal_model_db::layerDB()->insert($sql,
            array(
                ':id_admin' => $id_admin,
                ':id_role'  => $id_role
            )
        );
    }
}
?>