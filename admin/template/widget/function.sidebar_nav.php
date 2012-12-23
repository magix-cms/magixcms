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

function smarty_function_sidebar_nav($params, $template){
	$active = 'active';
    $nav_header = 'nav-header';
	$parse_url = parse_url('/'.basename($_SERVER['SCRIPT_FILENAME']));
	$pathfile = substr($parse_url['path'],1);
    $menu = array(
        'Configuration'=>array(
            'Utilisateurs'=>'users.php',
            'Paramètres'=>'config.php',
            'Editeur Wysiwyg'=>'editor.php'
        ),
        'Pages'=>array(
            'Accueil'=>'home.php',
            'CMS'=>'cms.php'
        )
    );
    $w = '';
    foreach($menu as $key => $value){
        $header = ' class="'.$nav_header.'"';
        $w.='<li'.$header.'>';
        $w.= $key;
        $w.='</li>';
        if(isset($value)){
            if(is_array($value)){
                foreach($value as $key2=>$value2){
                    if($pathfile == $value2 ){
                        $class = ' class="'.$active.'"';
                    }else{
                        $class = null;
                    }
                    $w.='<li'.$class.'>';
                    $w.= '<a href="'.'/'.PATHADMIN.'/'.$value2.'">'.$key2.'</a>';
                    $w.='</li>';
                }
            }else{
                throw new Exception('menu'.$value.' is not array');
            }
        }
	}
    return $w;
}