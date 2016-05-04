<?php
/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of MAGIX CMS.
# MAGIX CMS, The content management system optimized for users
# Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
#
# OFFICIAL TEAM :
#
#   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com>
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
class frontend_db_country{
    /**
     * @return array
     */
    protected function select($data){
        if(is_array($data)){
            if($data['context'] === 'all'){
                if(($data['type'] === 'list')){
                    $sql = 'SELECT co.*
					FROM mc_country AS co';
                    return magixglobal_model_db::layerDB()->select($sql);
                }
                elseif($data['type'] === 'last'){
                    $sql = 'SELECT co.*
					FROM mc_country AS co ORDER BY `idcountry` DESC LIMIT 0,1';
                    return magixglobal_model_db::layerDB()->select($sql);
                }

            }
        }
    }
}
?>