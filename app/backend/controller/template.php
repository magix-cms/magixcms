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
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2013 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name templates
 *
 */
class backend_controller_template{
    /**
     * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
     * @var string
     */
    private static $ConfigFile = 'local_';

    /**
     * @param bool $configDir
     * @return string
     */
    public static function basePathConfig($configDir = false){
        if($configDir != false){
            $dir = $configDir.DIRECTORY_SEPARATOR;
        }else{
            $dir = '';
        }
        return magixglobal_model_system::base_path().PATHADMIN.DIRECTORY_SEPARATOR.'i18n'.DIRECTORY_SEPARATOR.$dir;
    }

    /**
     * Chargement du fichier de configuration suivant la langue en cours de session.
     * @access private
     * return string
     */
    private function pathConfigLoad($configfile){
        try {
            return $configfile.backend_model_language::current_Language().'.conf';
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * Charge le fichier de configuration associer à la langue
     * @param $configfile
     * @param bool|string $section
     */
    public static function configLoad($configfile, $section = ''){
        backend_model_smarty::getInstance()->configLoad(
            $configfile,
            $section
        );
    }

    /**
     * @access public
     * Affiche le template
     * @param string|object $template
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param object $parent
     */
    public static function display($template = null, $cache_id = null, $compile_id = null, $parent = null){
        if(!self::isCached($template, $cache_id, $compile_id, $parent)){
            backend_model_smarty::getInstance()->display($template, $cache_id, $compile_id, $parent);
        }else{
            backend_model_smarty::getInstance()->display($template, $cache_id, $compile_id, $parent);
        }
    }
    /**
     * @access public
     * Retourne le template
     * @param string|object $template
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param object $parent
     * @param bool   $display           true: display, false: fetch
     * @param bool   $merge_tpl_vars    if true parent template variables merged in to local scope
     * @param bool   $no_output_filter  if true do not run output filter
     * @return string rendered template output
     */
    public static function fetch($template = null, $cache_id = null, $compile_id = null, $parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false){
        if(!self::isCached($template, $cache_id, $compile_id, $parent)){
            return backend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }else{
            return backend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }
    }

    /**
     * @access public
     * Assign les variables dans les fichiers phtml
     * @param void $tpl_var
     * @param string $value
     * @param bool $nocache
     * @throws Exception
     */
    public static function assign($tpl_var, $value = null, $nocache = false){
        //return backend_model_smarty::getInstance()->assign($tpl_var,$value);
        if (is_array($tpl_var)){
            backend_model_smarty::getInstance()->assign($tpl_var);
        }else{
            if($tpl_var){
                backend_model_smarty::getInstance()->assign($tpl_var,$value,$nocache);
            }else{
                throw new Exception('Unable to assign a variable in template');
            }
        }
    }
    /**
     * Test si le cache est valide
     * @param string|object $template
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param object $parent
     */
    public static function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null){
        backend_model_smarty::getInstance()->isCached($template, $cache_id, $compile_id, $parent);
    }

    /**
     * Charge les variables du fichier de configuration dans le site
     * @param string $varname
     * @param bool $search_parents
     * @return string
     */
	public static function getConfigVars($varname = null, $search_parents = true){
		return backend_model_smarty::getInstance()->getConfigVars($varname, $search_parents);
	}

    /**
     * Ajoute un dossier de configuration smarty
     * @param $config_dir
     * @param null $key
     */
    public static function addConfigDir($config_dir, $key=null){
        backend_model_smarty::getInstance()->addConfigDir($config_dir,$key);
    }

    /**
     * @param null $index
     */
    public static function getConfigDir($index=null){
        backend_model_smarty::getInstance()->getConfigDir($index);
    }

    /**
     * Ajoute un ou plusieurs dossier de configuration et charge les fichiers associés ainsi que les variables
     * @access public
     * @param array $addConfigDir
     * @param array $load_files
     * @param bool $debug
     * @throws Exception
     * @example:
        backend_controller_template::addConfigFile(array(
            'test'
        ),array('test_'),true);
         *
        backend_controller_template::addConfigFile(array(
            'test'
        ),array('test_'=>'montest'),true);
        OR
        backend_controller_template::addConfigFile(array(
            'test',
            autre'
        ),array('test_'=>array('montest'),'truc_'),true);
     */
    public static function addConfigFile(array $addConfigDir,array $load_files,$debug=false){
        $firebug = new magixcjquery_debug_magixfire();
        if(is_array($addConfigDir)){
            if(class_exists('backend_controller_template')){
                $configDir = array_map(
                    array('backend_controller_template','basePathConfig'),
                    $addConfigDir
                );
                self::addConfigDir($configDir);
            }
        }else{
            throw new Exception('Error: addConfigDir is not array');
        }
        if(is_array($load_files)){
            foreach ($load_files as $key => $val){
                if(is_string($key)){
                    if(array_key_exists($key, $load_files)){
                        self::configLoad(self::pathConfigLoad($key), $val);
                    }
                }else{
                    self::configLoad(self::pathConfigLoad($load_files[$key]));
                }
            }
        }else{
            throw new Exception('Error: load_files is not array');
        }
        //Debug
        if($debug!=false){
            $firebug->magixFireDump('Config Dir', $configDir);
            if(self::getConfigDir() != ''){
                $firebug->magixFireDump('Get Config Dir', self::getConfigDir());
            }
            $firebug->magixFireDump('Load Files in configdir', $load_files);
            $firebug->magixFireDump('Config vars', self::getConfigVars());
        }
    }
}