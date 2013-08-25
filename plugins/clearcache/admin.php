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
 * MAGIX CMS
 * @category   clear 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    3.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name clearcache
 * Le plugin clearcache nettoie les caches tpl et GZ de l'installation
 *
 */
class plugins_clearcache_admin{
	/**
	 * @access public
	 * @var POST clear
	 */
	public $action,$tab,$clear;
	/**
	 * @access public
	 * Constructor
	 */
	function __construct(){
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
		if(magixcjquery_filter_request::isPost('clear')){
			$this->clear = (string) magixcjquery_form_helpersforms::inputClean($_POST['clear']);
		}
	}

    /**
     * @param $app
     * @param $dir
     * @return string
     */
    private function pathCacheDir($app,$dir){
        switch($app){
            case 'public':
                $pathDir = magixglobal_model_system::base_path().'var'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
                break;
            case 'admin':
                $pathDir = magixglobal_model_system::base_path().PATHADMIN.DIRECTORY_SEPARATOR.'caching'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR;
                break;
        }
        return $pathDir;
    }

    /**
     * @access private
     * @param $app
     * @param $dir
     */
	private function cacheDir($app,$dir){
        $makefile = new magixcjquery_files_makefiles();
		$pathDir = $this->pathCacheDir($app,$dir);
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
     * @param $create
     */
    private function removeCache($create){
		switch($this->clear){
			case "public_caches":
                $this->cacheDir('public','templates_c');
                $this->cacheDir('public','tpl_caches');
			    break;
			case "admin_caches":
                $this->cacheDir('admin','templates_c');
                $this->cacheDir('admin','tpl_caches');
			    break;
            case "public_minify":
                $this->cacheDir('public','caches');
                $this->cacheDir('public','minify');
                break;
            case "admin_minify":
                $this->cacheDir('admin','caches');
                $this->cacheDir('admin','minify');
                break;

		}
        $create->display('success_update.tpl');
	}

    /**
     * Set Configuration pour le menu
     * @return array
     */
    public function setConfig(){
        return array(
            'url'   =>  array(
                'lang'  =>  'none',
                'action'=>  ''
            ),
            'icon'  =>  array(
                'type'  =>  'image',
                'name'  =>  'icon.png'
            )
        );
    }
	/**
	 * @access public
	 * Execute le plugin
	 */
	public function run(){
        $create = new backend_controller_plugins();
        if(isset($this->action)){
            if($this->action == 'remove'){
                if(isset($this->clear)){
                    //Si on veut supprimer les caches
                    $this->removeCache($create);
                }
            }
        }else{
            if(isset($this->tab)){
                $create->display('about.tpl');
            }else{
                // Retourne la page index.tpl
                $create->display('index.tpl');
            }
		}
	}
}