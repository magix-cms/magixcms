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
 * Date: 27/12/12
 * Time: 01:55
 * License: Dual licensed under the MIT or GPL Version
 */
class backend_model_role {
    /**
     * @var
     */
    public $useridadmin,$useradmin,$userkeyid;

    /**
     * Constructor
     */
    public function __construct(){
        if(magixcjquery_filter_request::isSession('id_admin')){
            $this->id_admin = $_SESSION['id_admin'];
        }
        if(magixcjquery_filter_request::isSession('email_admin')){
            $this->email_admin = $_SESSION['email_admin'];
        }
        if(magixcjquery_filter_request::isSession('keyuniqid_admin')){
            $this->keyuniqid_admin = $_SESSION['keyuniqid_admin'];
        }
    }

    /**
     * @return mixed
     */
    public function data(){
        if(isset($this->keyuniqid_admin)){
            $admin = new backend_db_employee();
            $data = $admin->s_data_session($this->keyuniqid_admin);
            $role['id']   = $data['id_role'];
            $role['name'] = $data['role_name'];
            return $role;
        }
    }

    /**
     * @return string
     */
    public function sql_arg(){
        $role = $this->data();
        switch($role['id']){
            case 1:
                $data = "1,2,3,4";
                break;
            case 2:
                $data = "2,3,4";
                break;
            case 3:
                $data = "3,4";
                break;
            case 4:
                $data = "4";
                break;
        }
        return $data;
    }
}
?>