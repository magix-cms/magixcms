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
 * Date: 17/03/2013
 * Time: 23:07
 * License: Dual licensed under the MIT or GPL Version
 */
function smarty_function_role_admin($params, $template){
    if(isset($_SESSION['id_admin']) AND isset($_SESSION['email_admin']) AND isset($_SESSION['keyuniqid_admin'])){
        $admin = new backend_db_employee();
        $data = $admin->s_data_session($_SESSION['keyuniqid_admin']);
        if(isset($params['items'])){
            if(is_array($params['items'])){
                if(array_key_exists($data['role_name'],$params['items'])){
                    return true;
                }
            }elseif(is_string($params['items'])){
                if($data['role_name'] === $params['items']){
                    return true;
                }
            }
        }

    }
}
?>