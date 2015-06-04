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
 * Date: 7/03/13
 * Time: 22:16
 * License: Dual licensed under the MIT or GPL Version
 */
class plugins_translation_admin{
    protected $message;
    /**
     * @var string
     */
    public $action,$tab,$section,$getlang,$pluginame,$config_var,$config_value;
    //private $result = array();
    /**
     *
     */
    function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('section')){
            $this->section = magixcjquery_form_helpersforms::inputClean($_GET['section']);
        }
        if(magixcjquery_filter_request::isGet('pluginame')){
            $this->pluginame = magixcjquery_form_helpersforms::inputClean($_GET['pluginame']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
        }
        if(magixcjquery_filter_request::isPost('config_var')){
            $this->config_var = magixcjquery_form_helpersforms::arrayClean($_POST['config_var']);
        }
        if(magixcjquery_filter_request::isPost('config_value')){
            $this->config_value = $_POST['config_value'];
        }
    }

    /**
     * Retourne un tableau de la liste des plugins
     * @param $create
     * @return array
     */
    private function list_plugin($create){
        $makefiles = new magixcjquery_files_makefiles();
        $dir = $makefiles->scanRecursiveDir($create->directory_plugins());
        $iso = backend_db_block_lang::s_data_iso($this->getlang);
        if($dir != null){
            foreach($dir as $d){
                if(file_exists($create->directory_plugins().$d.DIRECTORY_SEPARATOR.'i18n')){
                    if(file_exists($create->directory_plugins().$d.DIRECTORY_SEPARATOR.'i18n'.DIRECTORY_SEPARATOR.'public_local_'.$iso['iso'].'.conf')){
                        $array_plugin[]=$d;
                    }
                }
            }
            return $array_plugin;
        }
    }

    /**
     * Parse le fichier de configuration
     * @param $file
     * @return mixed
     * @throws Exception
     */
    private function parse_ini($file){
        $result = array();
        if ($lines = file($file)) {
            foreach ($lines as $line){
                if (!preg_match('/[0-9a-z]/i', $line) or preg_match('/^#/', $line)){
                    continue;
                }
                //if (preg_match('/(.*)=(.*)/', $line, $match)){
                if (preg_match('/^([^=]+)=(.*)$/', $line, $match)){

                    $result[trim($match[1])] = trim($match[2]);
                }
            }
        } else {
            throw new Exception("No valid file specified");
        }
        return $result;
    }

    /**
     * @param $path
     * @param $filename
     * @return string
     */
    private function pathConfigFile($path,$filename){
        return magixglobal_model_system::base_path().$path.$filename;
    }

    /**
     * @param $path
     * @param $filename
     * @return array
     */
    private function setConfigFile($path,$filename){
        $files = $this->pathConfigFile($path,$filename);
        $data = $this->parse_ini($files);
        return $data;
    }

    /**
     * Retourne un tableau contenant la configuration
     * @param $tab
     * @return array
     */
    private function getConfigFile($tab){
        if(isset($this->getlang)){
            $iso = backend_db_block_lang::s_data_iso($this->getlang);
            switch($tab){
                case 'core':
                    $file = $this->setConfigFile(
                        'locali18n/',
                        'local_'.$iso['iso'].'.conf'
                    );
                    break;
                case 'plugin':
                    $file = $this->setConfigFile(
                        'plugins/'.$this->pluginame.'/i18n/',
                        'public_local_'.$iso['iso'].'.conf'
                    );
                    break;
            }
            return $file;
        }
    }

    /**
     * Sauvegarde le fichier de configuration
     * @param $create
     * @param $tab
     */
    private function saveFiles($create,$tab){
        if(isset($this->config_var) AND isset($this->config_value)){
            $iso = backend_db_block_lang::s_data_iso($this->getlang);
            switch($tab){
                case 'core':
                    $path = 'locali18n/';
                    $filename = 'local_'.$iso['iso'].'.conf';
                    break;
                case 'plugin':
                    $path = 'plugins/'.$this->pluginame.'/i18n/';
                    $filename = 'public_local_'.$iso['iso'].'.conf';
                    break;
            }
            $files = $this->pathConfigFile($path,$filename);
            $data = $this->setConfigFile($path,$filename);
            $replace_with = array_combine(
                $this->config_var,
                $this->config_value
            );
            if(is_writable($files)){
                // Open the file for writing.
                $fh = fopen($files, 'w');
                // Loop through the data.
                foreach ( $data as $key => $value ){
                    // If a value exists that should replace the current one, use it.
                    //if ( ! empty($replace_with[$key]) )
                        $value = $replace_with[$key];

                    // Write to the file.
                    fwrite($fh, "{$key} = {$value}" . PHP_EOL);
                }
                // Close the file handle.
                fclose($fh);
                $this->message->getNotify('update');
            }else{
                $this->message->getNotify('error_writable');
            }
        }
    }

    /**
     * Execution du plugin
     */
    public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_plugins();
        if(magixcjquery_filter_request::isGet('getlang')){
            if(isset($this->action)){
                if($this->action == 'list'){
                    $create->assign('array_plugin_i18n',$this->list_plugin($create));
                    $create->display('list.tpl');
                }elseif($this->action == 'edit'){
                    if(isset($this->section)){
                        if(isset($this->config_value)){
                            $header->html_header("UTF-8");
                            $this->saveFiles($create,$this->section);
                        }else{
                            $create->assign('array_config_file',$this->getConfigFile($this->section));
                            $create->display('edit.tpl');
                        }
                    }
                }
            }elseif(isset($this->tab)){
                $create->display('about.tpl');
            }
        }
    }

    /**
     * Set Configuration pour le menu
     * @return array
     */
    public function setConfig(){
        return array(
            'url'=> array(
                'lang'=>'list',
                'action'=>'list'
            )
        );
    }
}
?>