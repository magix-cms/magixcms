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
 * Date: 24/02/13
 * Time: 13:49
 * License: Dual licensed under the MIT or GPL Version
 */
class app_controller_analysis{
    /**
     * @return int
     */
    private function check_compare(){
        if (version_compare(phpversion(),'5.0','<')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_mbstring(){
        if (!function_exists('mb_detect_encoding')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_iconv(){
        if (!function_exists('iconv')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_ob_start(){
        if (!function_exists('ob_start')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_simplexml(){
        if (!function_exists('simplexml_load_string')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_dom(){
        if (!function_exists('dom_import_simplexml')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }
    private function check_spl(){
        if (!function_exists('spl_classes')) {
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }

    /**
     * Retourne au format JSON le statut des modules PHP
     */
    private function json_check(){
        $json[]= '{"phpversion":'.json_encode($this->check_compare()).',"mbstring":'.json_encode($this->check_mbstring())
            .',"iconv":'.json_encode($this->check_iconv()).',"ob_start":'.json_encode($this->check_ob_start())
            .',"simplexml":'.json_encode($this->check_simplexml()).',"dom":'.json_encode($this->check_dom())
            .',"spl":'.json_encode($this->check_spl()).'}';
        print '['.implode(',',$json).']';
    }

    /**
     * @param $root
     * @return int
     */
    private function chmod_config($root){
        if(!is_writable($root.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config')){
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }

    /**
     * @param $root
     * @return int
     */
    private function chmod_var($root){
        if(!is_writable($root.DIRECTORY_SEPARATOR.'var')){
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }

    /**
     * @param $root
     * @return int
     */
    private function chmod_caching($root){
        if(!is_writable($root.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'caching')){
            $check = 0;
        }else{
            $check = 1;
        }
        return $check;
    }

    /**
     * Retourne au format JSON les permissions de dossier
     */
    private function json_chmod(){
        $root = magixglobal_model_system::base_path();
        $json[]= '{"var_caching":'.json_encode($this->chmod_var($root))
        .',"config":'.json_encode($this->chmod_config($root))
        .',"caching":'.json_encode($this->chmod_caching($root))
        .'}';
        print '['.implode(',',$json).']';
    }
    /**
     *
     */
    public function run(){
        $header= new magixglobal_model_header();
        if(magixcjquery_filter_request::isGet('json_check')){
            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
            $header->pragma();
            $header->cache_control("nocache");
            $header->getStatus('200');
            $header->json_header("UTF-8");
            $this->json_check();
        }elseif(magixcjquery_filter_request::isGet('json_chmod')){
            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
            $header->pragma();
            $header->cache_control("nocache");
            $header->getStatus('200');
            $header->json_header("UTF-8");
            $this->json_chmod();
        }else{
            app_model_smarty::getInstance()->display('analysis/index.tpl');
        }
    }
}