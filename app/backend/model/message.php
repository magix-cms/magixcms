<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @copyright  MAGIX CMS Copyright (c) 2010 -2014 Gerits Aurelien,
 * @version  Release: 1.0
 * Date: 20/08/2014
 * @license Dual licensed under the MIT or GPL Version 3 licenses.
 */
class backend_model_message{
    /**
     * @var backend_controller_template
     */
    protected $template,$plugins;

    /**
     *
     */
    public function __construct(){
        $this->template = new backend_controller_template();
        $this->plugins = new backend_controller_plugins();
    }

    /**
     * Retourne le message de notification
     * @param $type
     * @param array $option
     */
    public function getNotify($type,$option = array('template'=>'message.tpl','method'=>'display','assignFetch'=>'','plugin'=>'false')){
        if(array_key_exists('template',$option)){
            $skin = $option['template'];
        }else{
            $skin = 'message.tpl';
        }
        if(array_key_exists('plugin',$option)){
            $plugin = $option['plugin'];
        }else{
            $plugin = 'false';
        }
        if(array_key_exists('method',$option)){
            $method = $option['method'];
        }else{
            $method = 'display';
        }
        if(array_key_exists('assignFetch',$option)){
            $assignFetch = $option['assignFetch'];
        }else{
            $assignFetch = '';
        }
        if($plugin === 'true'){
            if($method === 'fetch'){
                $this->plugins->assign('message',$type);
                $fetch = $this->plugins->$method($skin);
                $this->plugins->assign($assignFetch,$fetch);
            }elseif($method === 'display'){
                $this->plugins->assign('message',$type);
                $this->plugins->$method($skin);
            }
        }else{
            if($method === 'fetch'){
                $this->template->assign('message',$type);
                $fetch = $this->template->$method($skin);
                $this->template->assign($assignFetch,$fetch);
            }elseif($method === 'display'){
                $this->template->assign('message',$type);
                $this->template->$method($skin);
            }
        }
    }
}
?>