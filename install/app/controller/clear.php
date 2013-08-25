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
 * Date: 3/03/13
 * Time: 18:48
 * License: Dual licensed under the MIT or GPL Version
 */
class app_controller_clear{
    public $action,$cache;
    /**
     * @access public
     * Constructor
     */
    function __construct(){
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isPost('cache')){
            $this->cache = magixcjquery_form_helpersforms::inputClean($_POST['cache']);
        }
    }

    /**
     * @param $dir
     * @return string
     */
    private function pathCacheDir($dir){
        return magixglobal_model_system::base_path().'var'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
    }

    /**
     * @access private
     * @param $dir
     */
    private function cacheDir($dir){
        $makefile = new magixcjquery_files_makefiles();
        $pathDir = $this->pathCacheDir($dir);
        if(file_exists($pathDir)){
            $scandir = $makefile->scanDir($pathDir,array('.htaccess','.gitignore'));
            $clean = '';
            if($scandir != null){
                foreach($scandir as $file){
                    $clean .= $makefile->removeFile($pathDir,$file);
                }
            }
        } else{
            $magixfire = new magixcjquery_debug_magixfire();
            $magixfire->magixFireError(new Exception('Error: var is not exist'));
        }
    }

    /**
     * Execute le suppression du/des caches
     * @access private
     */
    private function removeCache(){
        $this->cacheDir('templates_c');
        $this->cacheDir('tpl_caches');
        $this->cacheDir('caches');
        $this->cacheDir('minify');
    }
    /**
     *  @access public
     */
    public function run(){
        if(isset($this->action)){
            if($this->action == 'remove'){
                if(isset($this->cache)){
                    //Si on veut supprimer les caches
                    $this->removeCache();
                }
            }
        }else{
            app_model_smarty::getInstance()->display('clear/index.tpl');
        }
    }
}
?>