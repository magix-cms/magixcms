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
class app_db_upgrade{

    /**
     * @return array
     */
    protected function s_catalog_img(){
        $sql = 'SELECT cl.idcatalog,cl.imgcatalog
        FROM mc_catalog_img AS cl';
        return magixglobal_model_db::layerDB()->select($sql);
    }

    /**
     * Mise à jour d'une image de produit
     * @param $imgcatalog
     * @param $edit
     */
    protected function u_catalog_product_image($imgcatalog,$edit){
        $sql = 'UPDATE mc_catalog SET imgcatalog = :imgcatalog WHERE idcatalog = :edit';
        magixglobal_model_db::layerDB()->update($sql,
            array(
                ':imgcatalog'	=>	$imgcatalog,
                ':edit'		    =>	$edit
            )
        );
    }

    /**
     * @return array
     *
     */
    protected function s_old_member(){
        $query = 'SELECT keyuniqid, pseudo,email,cryptpass
        FROM mc_admin_member';
        return magixglobal_model_db::layerDB()->select($query);
    }
    /**
     * Transfère le compte member dans le compte définitif suivant la clé unique
     * @param $keyuniqid
     */
    protected function transfertProfil($keyuniqid){
        $sql = array(
            'INSERT INTO mc_admin_employee (keyuniqid_admin,pseudo_admin,email_admin,passwd_admin,active_admin)
            SELECT keyuniqid, pseudo,email,cryptpass,"1" FROM mc_admin_member WHERE keyuniqid ='.magixglobal_model_db::layerDB()->escape_string("$keyuniqid")
            );
        magixglobal_model_db::layerDB()->transaction($sql);
    }

    /**
     * Drop Table
     * @param $table
     */
    protected function dropTable($table){
        $sql = array('DROP TABLE '.$table);
        magixglobal_model_db::layerDB()->transaction($sql);
    }
}
?>