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
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.5
 * update 26/10/2011
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name plugins
 *
 */
class frontend_controller_plugins{
	/**
	 * Constante PATHPLUGINS
	 * Défini le chemin vers le dossier des plugins
	 * @var string
	 */
	const PATHPLUGINS = 'plugins';
	/**
	 * Constante pour le dossier de traductions du plugin
	 */
	const I18N = 'i18n';
	/**
	 * 
	 * Define createInstance for Singleton
	 * @static
	 * @var $_createInstance
	 */
	private static $_createInstance = null;
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'public_local_';
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour les emails
	 * @var string
	 */
	private static $MailConfigFile = 'public_mail_';
	/**
	 * Constructor
	 */
	function __construct(){}
	/**
     * instance singleton self (DataObjects)
     * @access public
     */
    public static function create(){
    	if (!isset(self::$_createInstance)){
    		if(is_null(self::$_createInstance)){
    			//$c = __CLASS__;
				self::$_createInstance = new frontend_controller_plugins();
			}
      	}
		return self::$_createInstance;
    }
	/**
	 * @access private
	 * return void
	 * Le chemin du dossier des plugins
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access public
	 * getplugin
	 */
	public function getplugin(){
		if(isset($_GET['magixmod'])){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['magixmod']);
		}
	}
	/**
	 * @access private
	 * Retourne le nom du plugin
	 * @param string $plugin
	 */
	private function controlGetPlugin($plugin=''){
		if(!$plugin == ''){
			$pluginName = $plugin;
		}else{
			$pluginName = $this->getplugin();
		}
		return $pluginName;
	}
	/**
	 * Retourne la langue courante
	 * @return string
	 * @access public 
	 * @static
	 */
	public function getLanguage(){
		if(isset($_GET['strLangue'])){
			if(!empty($_GET['strLangue'])){
				return magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			}
		}
	}
	/**
	 * @access private
	 * Retourne le chemin vers le dossier I18N du plugin
	 * @return string
	 */
	private function path_dir_i18n(){
		return $this->directory_plugins().self::controlGetPlugin().DIRECTORY_SEPARATOR.self::I18N.DIRECTORY_SEPARATOR;
	}
	/**
	 * Chargement du fichier de configuration suivant la langue en cours de session.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile,$filextension=false,$plugin=''){
		try {
			$filextends = $filextension ? $filextension : '.conf';
			if(frontend_model_template::getLanguage() == ''){
				$lang = '';
			}else{
				$lang = frontend_model_template::getLanguage();
			}
			if(file_exists($this->path_dir_i18n())){
				$translate = !empty($lang) ? $lang : 'fr';
				return $this->path_dir_i18n().$configfile.$translate.$filextends;
			}else{
				return frontend_model_smarty::getInstance()->config_dir.'local_'.$lang.$filextends;
			}
		} catch (Exception $e) {
			magixglobal_model_system::magixlog("Error path config", $e);
		}
	}

	/**
     * @deprecated
	 * @access public
	 * Affiche le template du plugin
	 * @param string|object $template
	 * @param string $plugin
	 * @param mixed $cache_id
	 * @param mixed $compile_id
	 * @param object $parent
	 */
	public function append_display($template = null,$plugin='',$cache_id = null,$compile_id = null,$parent = null){
		if(file_exists('skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin))){
			return frontend_model_smarty::getInstance()->display(
				'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
				$cache_id,
				$compile_id,
				$parent
			);
		}else{
			return frontend_model_smarty::getInstance()->display(
				$this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
				$cache_id,
				$compile_id,
				$parent
			);
		}
	}

	/**
	 * @access public
	 * Retourne le template du plugin
	 * @param string|object $template
	 * @param string $plugin
	 * @param mixed $cache_id
	 * @param mixed $compile_id
	 * @param object $parent
	 * @param bool   $display           true: display, false: fetch
     * @param bool   $merge_tpl_vars    if true parent template variables merged in to local scope
     * @param bool   $no_output_filter  if true do not run output filter
     * @return string rendered template output
	 */
	public function append_fetch($template = null,$plugin='',$cache_id = null,$compile_id = null,$parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false){
		if(file_exists('skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin))){
			return frontend_model_smarty::getInstance()->fetch(
				'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
				$cache_id,
				$compile_id,
				$parent,
				$display, 
				$merge_tpl_vars, 
				$no_output_filter
			);
		}else{
			return frontend_model_smarty::getInstance()->fetch(
				$this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
				$cache_id,
				$compile_id,
				$parent,
				$display, 
				$merge_tpl_vars, 
				$no_output_filter
			);
		}
	}

    /**
     * @deprecated
     * @access public
     * Assigne les variables du plugin
     * @param void $tpl_var
     * @param string $value
     * @param bool $nocache
     * @throws Exception
     * @return \Smarty_Internal_Data
     */
    public function append_assign($tpl_var, $value = null, $nocache = false){
        if (is_array($tpl_var)){
            return frontend_model_smarty::getInstance()->assign($tpl_var);
        }else{
            if($tpl_var){
                return frontend_model_smarty::getInstance()->assign($tpl_var,$value,$nocache);
            }else{
                throw new Exception('Unable to assign a variable in template');
            }
        }
    }

    /**
     * @access public
     * Affiche le template du plugin
     * @param string|object $template
     * @param string $plugin
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param object $parent
     */
    public function display($template = null,$plugin='',$cache_id = null,$compile_id = null,$parent = null){
        if(file_exists('skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin))){
            if(!self::isCached($template, $cache_id, $compile_id, $parent)){
                frontend_model_smarty::getInstance()->display(
                    'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent
                );
            }else{
                frontend_model_smarty::getInstance()->display(
                    'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent
                );
            }
        }else{
            if(!self::isCached($template, $cache_id, $compile_id, $parent)){
                frontend_model_smarty::getInstance()->display(
                    $this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent
                );
            }else{
                frontend_model_smarty::getInstance()->display(
                    $this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent
                );
            }
        }
    }

    /**
     * @access public
     * Retourne le template du plugin
     * @param string|object $template
     * @param string $plugin
     * @param mixed $cache_id
     * @param mixed $compile_id
     * @param object $parent
     * @param bool   $display           true: display, false: fetch
     * @param bool   $merge_tpl_vars    if true parent template variables merged in to local scope
     * @param bool   $no_output_filter  if true do not run output filter
     * @return string rendered template output
     */
    public function fetch($template = null,$plugin='',$cache_id = null,$compile_id = null,$parent = null, $display = false, $merge_tpl_vars = true, $no_output_filter = false){
        if(file_exists('skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin))){
            if(!self::isCached($template, $cache_id, $compile_id, $parent)){
                frontend_model_smarty::getInstance()->fetch(
                    'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent,
                    $display,
                    $merge_tpl_vars,
                    $no_output_filter
                );
            }else{
                frontend_model_smarty::getInstance()->fetch(
                    'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent,
                    $display,
                    $merge_tpl_vars,
                    $no_output_filter
                );
            }
        }else{
            if(!self::isCached($template, $cache_id, $compile_id, $parent)){
                frontend_model_smarty::getInstance()->fetch(
                    $this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent,
                    $display,
                    $merge_tpl_vars,
                    $no_output_filter
                );
            }else{
                frontend_model_smarty::getInstance()->fetch(
                    $this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
                    $cache_id,
                    $compile_id,
                    $parent,
                    $display,
                    $merge_tpl_vars,
                    $no_output_filter
                );
            }
        }
    }

	/**
	 * Test si le cache est valide
	 * @param string|object $template
	 * @param string $plugin
	 * @param mixed $cache_id
	 * @param mixed $compile_id
	 * @param object $parent
	 */
	public function isCached($template = null,$plugin='', $cache_id = null, $compile_id = null, $parent = null){
		if(file_exists('skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin))){
			frontend_model_smarty::getInstance()->isCached(
				'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/'.self::controlGetPlugin($plugin).'/'.$template,
				$cache_id,
				$compile_id,
				$parent
			);
		}else{
			frontend_model_smarty::getInstance()->isCached(
				$this->directory_plugins().self::controlGetPlugin($plugin).'/skin/public/'.$template,
				$cache_id,
				$compile_id,
				$parent
			);
		}
	}

    /**
     * @access public
     * Assigne les variables du plugin
     * @param void $tpl_var
     * @param string $value
     * @param bool $nocache
     * @throws Exception
     */
    public function assign($tpl_var, $value = null, $nocache = false){
        if (is_array($tpl_var)){
            frontend_model_smarty::getInstance()->assign($tpl_var);
        }else{
            if($tpl_var){
                frontend_model_smarty::getInstance()->assign($tpl_var,$value,$nocache);
            }else{
                throw new Exception('Unable to assign a variable in template');
            }
        }
    }

	/**
	 * Charge les variables du fichier de configuration
	 * @param string $varname
	 * @param boolean $search_parents
	 */
	public function getConfigVars($varname = null, $search_parents = true){
		frontend_model_smarty::getInstance()->getConfigVars($varname, $search_parents);
	}

    /**
     * Charge le fichier de configuration associer à la langue
     * @param bool|string $sections (optionnel) :la section à charger
     */
	public function configLoad($sections = false){
		frontend_model_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$ConfigFile), 
			$sections
		);
	}

    /**
     * Charge le fichier de configuration pour les mails associer à la langue
     * @param bool|string $sections (optionnel) :la section à charger
     */
	public function configLoadMail($sections = false){
		frontend_model_smarty::getInstance()->configLoad(
			$this->pathConfigLoad(self::$MailConfigFile), 
			$sections
		);
	}
	/**
	 * @access public
	 * Charge une variable venant du template
	 * @param string $varname
	 * @param string $_ptr
	 * @param boolean $search_parents
	 * @return string retourne une valeur ou un tableau de variable
	 */
	public function getTplVars($varname = null, $_ptr = null, $search_parents = true){
		frontend_model_smarty::getInstance()->getTemplateVars($varname, $_ptr, $search_parents);
	}
	/**
	 * @access public
	 * Active le système de debug de smarty 3
	 */
	public function getDebugging(){
		frontend_model_smarty::getInstance()->getDebugging();
	}
	/**
	 * @access public
	 * Active le test de l'installation de smarty 3
	 */
	public function testInstall(){
		frontend_model_smarty::getInstance()->testInstall();
	}
	/**
	 * @access private
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function get_call_class($module){
		try{
			$class =  new $module;
			if($class instanceof $module){
				return $class;
			}else{
				throw new Exception('not instantiate the class: '.$module);
			}
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
	}
	/**
	 * Chargement d'un plugin dans la partie public
	 * @access private
	 */
	private function load_plugin(){
		try{
			plugins_Autoloader::register();
			if(file_exists($this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR.'public.php')){
				if(class_exists('plugins_'.$this->getplugin().'_public')){
					$load = $this->get_call_class('plugins_'.$this->getplugin().'_public');
					if(method_exists($load,'run')){
						$load->run();
					}
				}else{
					throw new Exception ('Class '.$this->getplugin().' not define');
				}
			}
		}catch(Exception $e) {
			magixglobal_model_system::magixlog("Error plugins execute", $e);
		}
	}
	/**
	 * @access public
	 * @static
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	public function display_plugins(){
		if($this->getplugin()){
			try{
				$this->load_plugin();
			}catch(Exception $e) {
				magixglobal_model_system::magixlog("Error plugins execute", $e);
			}
		}
	}
}