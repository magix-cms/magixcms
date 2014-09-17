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
 * Date: 6/04/13
 * Time: 12:09
 * License: Dual licensed under the MIT or GPL Version
 */
class backend_controller_ajax{
    /**
     * @var int
     */
    public $getlang,$tab,$action;

    /**
     * Constructor
     */
    public function __construct(){
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
        }
    }

    /**
     * Parcourt le dossier des snippets HTML
     * @param $dir
     */
    private function jsSnippet($dir){
        $path = magixglobal_model_system::base_path().PATHADMIN.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$dir;

        $directory = new RecursiveDirectoryIterator($path,RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new RecursiveIteratorIterator($directory,RecursiveIteratorIterator::LEAVES_ONLY);
        //extension
        $extensions = array("html");
        // delimiteur
        $delimiter = "\n";
        if(is_object($iterator)){
            foreach ($iterator as $fileinfo) {
                // Compatibility with php < 5.3.6
                if (version_compare(phpversion(), '5.3.6', '<')) {
                    $getExtension = pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION);
                }else{
                    $getExtension = $fileinfo->getExtension();
                }
                if (in_array($getExtension, $extensions)) {
                    $pos = strpos($fileinfo->getPathname(),PATHADMIN);
                    $len = strlen($pos);
                    if(stripos($_SERVER['HTTP_USER_AGENT'],'win')){
                        $url = '/'.PATHADMIN.'/template/'.$dir.'/'.$fileinfo->getFilename();
                    }else{
                        $url = DIRECTORY_SEPARATOR.substr($fileinfo->getPathname(),$pos);
                    }
                    $files[] = $delimiter.'{'
                        . 'title:"'. $fileinfo->getBasename('.'.$getExtension)
                        . '", url:"'
                        . $url
                        . '"}';
                }
            }
            if(is_array($files)){
                asort($files,SORT_REGULAR);
                $ouput = 'templates = [';
                $ouput .= implode(',',$files);
                $ouput .= $delimiter.']';
                print $ouput;
            }
        }
    }

    /**
     * Execution des scripts de la classe
     */
    public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        if(magixcjquery_filter_request::isGet('getlang')){

        }else{
            if(isset($this->action)){
                if($this->action == 'list'){
                    if(isset($this->tab)){
                        if($this->tab === 'snippet'){
                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                            $header->pragma();
                            $header->cache_control("nocache");
                            $header->getStatus('200');
                            $header->javascript_header("UTF-8");
                            $this->jsSnippet('snippet');
                        }
                    }
                }
            }
        }
    }
}
?>