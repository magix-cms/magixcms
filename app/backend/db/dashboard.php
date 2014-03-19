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
 * Date: 2/03/13
 * Time: 16:34
 * License: Dual licensed under the MIT or GPL Version
 */
class backend_db_dashboard{
    /**
     * Retourne la liste des utilisateurs
     * @return array
     */
    protected function c_users(){
        $sql='SELECT role.role_name AS ROLE_USER,COUNT(emp.id_admin) AS COUNT_USER
        FROM mc_admin_employee AS emp
        JOIN mc_admin_access_rel as access ON(access.id_admin = emp.id_admin)
        JOIN mc_admin_role_user as role ON(role.id_role = access.id_role)
        GROUP BY role.id_role';
        return magixglobal_model_db::layerDB()->select($sql);
    }
}
?>