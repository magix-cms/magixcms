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
 * Date: 5/01/13
 * Time: 16:38
 * License: Dual licensed under the MIT or GPL Version
 */
class backend_controller_theming extends backend_db_theming{
    /**
     * constante
     * @var string
     */
    const skin = 'skin';
    /**
     * ptheme
     * @var string
     */
    public $ptheme,$action;
    /**
     * function construct
     */
    function __construct(){
        if(magixcjquery_filter_request::isPost('theme')){
            $this->ptheme = magixcjquery_form_helpersforms::inputClean($_POST['theme']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
    }

    /**
     * @access private
     * return void
     */
    protected function directory_skin(){
        try{
            return magixglobal_model_system::base_path().self::skin.DIRECTORY_SEPARATOR;
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * @access private
     * Charge le theme selectionné ou le theme par défaut
     */
    private function load_theme(){
        // Charge le théme courant dans la base de donnée
        $db = parent::s_current_theme();
        if($db['setting_value'] != null){
            if($db['setting_value'] == 'default'){
                if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
                    $theme =  'default';
                }
            }elseif(file_exists(magixglobal_model_system::base_path().'/skin/'.$db['setting_value'].'/')){
                $theme =  $db['setting_value'];
            }else{
                try {
                    $theme = 'default';
                    throw new Exception('template '.$db['setting_value'].' is not found');
                } catch (Exception $e){
                    magixglobal_model_system::magixlog('An error has occured :',$e);
                }
            }
        }else{
            if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
                $theme =  'default';
            }
        }
        return $theme;
    }

    /**
     * @access private
     * Scanne le dossier skin (public) et retourne les images ou capture des thèmes
     */
    private function scanTemplateDir(){
        $skin = $this->directory_skin();
        if(!is_readable($skin)){
            throw new exception('skin is not minimal permission');
        }
        $makefiles = new magixcjquery_files_makefiles();
        $dir = $makefiles->scanRecursiveDir($skin,'.svn');
        $count = count($dir);
        if($count == 0){
            throw new exception('skin is not found');
        }
        if(!is_array($dir)){
            throw new exception('skin is not array');
        }
        $template = null;
        foreach($dir as $d){
            if($d == $this->load_theme()){
                $btn_class = ' btn-primary';
                $btn_title = 'Sélectionner';
            }else{
                $ctpl = '';
                $btn_class = '';
                $btn_title = 'Choisir';
            }
            $themePath = self::directory_skin().$d;
            if($makefiles->scanDir($themePath) != null){
                if(file_exists($themePath.'/screenshot.png')){
                    $img = magixcjquery_html_helpersHtml::getUrl().'/skin/'.$d.'/screenshot.png';
                }else{
                    $img = magixcjquery_html_helpersHtml::getUrl().'/skin/default/screenshot.png';
                }
                $template .= '<li class="span3">';
                $template .= '<div class="thumbnail">';
                $template .= '<img src="'.$img.'" data-src="holder.js/260x180" alt="'.$btn_title.'">';
                $template .= '<div class="caption">';
                $template .= '<h3>'.$d.'</h3>';
                $template .= '<p><a data-skin="'.$d.'" class="skin-tpl btn btn-large btn-block'.$btn_class.'" href="#">'.$btn_title.'</a></p>';
                $template .= '</div>';
                $template .= '</div>';
                $template .= '</li>';
            }
        }
        return $template;
    }

    /**
     * @access private
     * Met à jour le template dans la configuration
     */
    private function update(){
        if(isset($this->ptheme)){
            parent::u_change_theme($this->ptheme);
            backend_controller_template::display('theming/request/success_update.phtml');
        }
    }

    /**
     * Execute le module dans l'administration
     * @access public
     */
    public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        if(isset($this->action)){
            if($this->action == 'list'){
                if(magixcjquery_filter_request::isGet('ajax_tpl')){
                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                    $header->pragma();
                    $header->cache_control("nocache");
                    $header->getStatus('200');
                    $header->html_header("UTF-8");
                    $create->assign('themes',$this->scanTemplateDir());
                    $create->display('theming/req.phtml');
                }
            }elseif($this->action == 'edit'){
                if(isset($this->ptheme)){
                    $this->update();
                }
            }
        }else{
            $create->assign('themes',$this->scanTemplateDir());
            $create->display('theming/index.phtml');
        }
    }
}
?>