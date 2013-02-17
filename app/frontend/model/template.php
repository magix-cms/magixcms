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
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
 * @name template
 *
 */
class frontend_model_template extends database_template{
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'local_';
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $frontendtheme;
	/**
	 * 
	 * Constructor
	 */
    public function __construct(){}
	/**
	 * 
	 */
	public static function frontendTheme(){
        if (!isset(self::$frontendtheme)){
         	self::$frontendtheme = new frontend_model_template();
        }
    	return self::$frontendtheme;
    }
    /**
     * @access public static
     * Paramètre de langue get
     */
	public static function getLanguage(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			return magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
	}

	/**
	 * Retourne la langue en cours de session sinon retourne fr par défaut
	 * @return string
	 * @access public 
	 * @static
	 */
	public static function current_Language(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			$lang = self::getLanguage();
		}else{
			$db = frontend_db_lang::s_default_language();
			if($db != null){
				$lang = $db['iso'];
			}else{
				if(magixcjquery_filter_request::isSession('strLangue')){
					$lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
				}
			}
		}
		return $lang;
	}
	/**
	 * @access private
	 * return void
	 * Le chemin du dossier des plugins
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path();
	}
	/**
	 * Chargement du fichier de configuration suivant la langue en cours de session.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile){
		try {
			return $configfile.self::current_Language().'.conf';
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}

	/**
	 * 
	 * Initialise la fonction configLoad de smarty
	 * @param string $section
	 */
	public static function configLoad($section = ''){
		frontend_model_smarty::getInstance()->configLoad(self::pathConfigLoad(self::$ConfigFile), $section);
	}

	/**
	 * Charge le theme selectionné ou le theme par défaut
	 */
	public function load_theme(){
		$db = parent::s_setting_id('theme');
		if($db['setting_value'] != null){
			if($db['setting_value'] == 'default'){
				$theme =  $db['setting_value'];
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
			$theme = 'default';
		}
		return $theme;
	}

	/**
	 * Function load public theme
	 * @see frontend_config_theme
	 */
	public static function themeSelected(){
		if (!self::frontendTheme() instanceof frontend_model_template){
			throw new Exception('template load is not found');
		}
		return self::frontendTheme()->load_theme();
	}

    /**
     * Chargement du type de cache
     * @param $smarty
     * @throws Exception
     * @return void
     */
    public static function loadCache($smarty){
        if (!self::frontendTheme() instanceof frontend_model_template){
            throw new Exception('template instance is not found');
        }else{
            $config = parent::s_setting_id('cache');
            switch($config['setting_value']){
                case 'none':
                    $smarty->setCaching(false);
                    break;
                case 'files':
                    $smarty->setCaching(true);
                    $smarty->setCachingType('file');
                    break;
                case 'apc':
                    $smarty->setCaching(true);
                    $smarty->setCachingType('apc');
                    break;
            }
        }
    }

    /**
     * Chargement des widgets additionnel du template courant
     * @param void $smarty
     * @param void $rootpath
     * @param bool $debug
     * @throws Exception
     * @return void
     */
	public static function addWidgetDir($smarty,$rootpath,$debug=false){
		if (!self::frontendTheme() instanceof frontend_model_template){
			throw new Exception('template instance is not found');
		}else{
			$add_widget_dir = $rootpath."skin/".self::frontendTheme()->load_theme().'/widget/';
			if(file_exists($add_widget_dir)){
				if(is_dir($add_widget_dir)){
					$smarty->addPluginsDir($add_widget_dir);
				}
			}
			if($debug == true){
				$firephp = new magixcjquery_debug_magixfire();
				$firephp->magixFireDump('Widget in skin',$smarty->getPluginsDir());
			}
		}
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
            frontend_model_smarty::getInstance()->display($template, $cache_id, $compile_id, $parent);
        }else{
            frontend_model_smarty::getInstance()->display($template, $cache_id, $compile_id, $parent);
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
            return frontend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }else{
            return frontend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }
    }

    /**
     * @access public
     * Assign les variables dans les fichiers phtml
     * @param void $tpl_var
     * @param string $value
     * @param bool $nocache
     * @throws Exception
     * @return void
     */
	public static function assign($tpl_var, $value = null, $nocache = false){
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
	 * Test si le cache est valide
	 * @param string|object $template
	 * @param mixed $cache_id
	 * @param mixed $compile_id
	 * @param object $parent
	 */
	public function isCached($template = null, $cache_id = null, $compile_id = null, $parent = null){
		frontend_model_smarty::getInstance()->isCached($template, $cache_id, $compile_id, $parent);
	}

    /**
     * Charge les variables du fichier de configuration dans le site
     * @param string $varname
     * @param bool $search_parents
     * @return string
     */
	public static function getConfigVars($varname = null, $search_parents = true){
		return frontend_model_smarty::getInstance()->getConfigVars($varname, $search_parents);
	}

	/**
	 * Ajoute un ou plusieurs dossier de configuration et charge les fichiers associés ainsi que les variables
	 * @access public
	 * @param array $addConfigDir
	 * @param array $load_files
	 * @param bool $debug
	 * @throws Exception
	 */
	public static function addConfigFile(array $addConfigDir,array $load_files,$debug=false){
		if(is_array($addConfigDir)){
			frontend_model_smarty::getInstance()->addConfigDir($addConfigDir);
		}else{
			throw new Exception('Error: addConfigDir is not array');
		}
		if(is_array($load_files)){
			foreach ($load_files as $row=>$val){
				if(is_string($row)){
					if(array_key_exists($row, $load_files)){
						frontend_model_smarty::getInstance()->configLoad(self::pathConfigLoad($row), $val);
					}
				}else{
					frontend_model_smarty::getInstance()->configLoad(self::pathConfigLoad($load_files[$row]));
				}
			}
		}else{
			throw new Exception('Error: load_files is not array');
		}
		if($debug!=false){
			$config_dir = frontend_model_smarty::getInstance()->getConfigDir();
			$firebug = new magixcjquery_debug_magixfire();
			$firebug->magixFireDump('Config Dir', $config_dir);
			$firebug->magixFireDump('Load Files in configdir', $load_files);
			$firebug->magixFireDump('Config vars', frontend_model_smarty::getInstance()->getConfigVars());
		}
	}
}
/**
 * Class db theme
 * Requête SQL pour le chargement du thème approprié au site internet
 * @author Aurelien
 *
 */
class database_template{
    /**
     * @param $setting_id
     * @return array
     */
    protected function s_setting_id($setting_id){
        $sql = 'SELECT setting_label,setting_value
    	FROM mc_setting WHERE setting_id = :setting_id';
        return magixglobal_model_db::layerDB()->selectOne($sql,array(
            ':setting_id'	=>	$setting_id
        ));
    }
}
?>