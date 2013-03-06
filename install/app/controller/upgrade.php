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
 * Date: 6/03/13
 * Time: 23:14
 * License: Dual licensed under the MIT or GPL Version
 */
class app_controller_upgrade extends app_db_upgrade{

    /**
     * @var string
     */
    public $action,$process;

    /**
     *  @access public construct
     */
    public function __construct(){
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isPost('process')){
            $this->process = magixcjquery_form_helpersforms::inputClean($_POST['process']);
        }
    }

    /**
     * @access private
     * load sql file
     */
    private function load_sql_file(){
        return magixglobal_model_system::base_path().'install'.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'update.2.4.0.sql';
    }

    /**
     * Mise à jour de la base de données
     * @access private
     */
    private function database(){
        if(isset($this->process)){
            if(file_exists($this->load_sql_file())){
                if(magixglobal_model_db::create_new_sqltable($this->load_sql_file())){
                    $data = parent::s_catalog_img();
                    foreach($data as $key){
                        parent::u_catalog_product_image($key['imgcatalog'],$key['idcatalog']);
                    }
                    app_model_smarty::getInstance()->display('upgrade/request/success_table.phtml');
                }
            }
        }
    }

    /**
     * @public private
     */
    public function run(){
        if(isset($this->action)){
            if($this->action === 'add'){
                if(isset($this->process)){
                    $this->database();
                }
            }
        }else{
            app_model_smarty::getInstance()->display('upgrade/index.phtml');
        }
    }
}
?>