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
 * update 19/01/2013
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name plugins
 *
 */
class backend_controller_plugins{
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
	 * 
	 * @var string
	 */
	public $getplugin,$action,$tab;
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'admin_local_';
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour les emails
	 * @var string
	 */
	private static $MailConfigFile = 'admin_mail_';
	/**
	 * Constructor
	 */
	public function __construct(){
		if(magixcjquery_filter_request::isGet('name')){
			$this->getplugin = magixcjquery_form_helpersforms::inputClean($_GET['name']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
	}
	/**
     * instance singleton self (DataObjects)
     * @access public
     */
    public static function create(){
    	if (!isset(self::$_createInstance)){
    		if(is_null(self::$_createInstance)){
    			//$c = __CLASS__;
				self::$_createInstance = new backend_controller_plugins();
			}
      	}
		return self::$_createInstance;
    }
	/**
	 * @access private
	 * return void
	 */
	public function directory_plugins(){
		return magixglobal_model_system::base_path().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * @access public
	 * Retourne la configuration des accès au plugin depuis un fichier xml
	 * @param string $plugin_folder
	 */
	public function allow_access_config($plugin_folder){
		$pathxml = $this->pluginDir($plugin_folder).'config.xml';
		if(file_exists($pathxml)){
			/*try {
				$xml = new SimpleXMLElement($pathxml,0, TRUE);
				$v = $xml->acl->admin->allow_access;
			} catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
			return $v;*/
			try {
				$xml = new XMLReader();
				$xml->open($pathxml, "UTF-8");
				while($xml->read()){
					if ($xml->nodeType == XMLREADER::ELEMENT && $xml->localName == "authorized") {
						$v = $xml->expand();
						$v = new SimpleXMLElement('<authorized>'.$xml->readInnerXML().'</authorized>');
						return $v->allow_access;
					}
				}
			} catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}else{
			return '*';
		}
	}
	/**
	 * @access public
	 * Chargement des données de configuration dans le fichier XML
	 */
	public function load_config_info(){
		$pathxml = $this->pluginDir().'config.xml';
		if(file_exists($pathxml)){
			try {
				$xml = new XMLReader();
				$xml->open($pathxml, "UTF-8");
				// Configuration d'analyse XML
				//$xml->setParserProperty(XMLReader::VALIDATE, true);
				//if($xml->isValid()){
				while($xml->read()){
					if ($xml->nodeType == XMLREADER::ELEMENT && $xml->localName == "infos") {
						$v = $xml->expand();
						$v = new SimpleXMLElement('<infos>'.$xml->readInnerXML().'</infos>',0, false);
						//echo ReflectionObject::export($v); 
						//echo ReflectionObject::export($v['attr']);
						$r = '';
						if($v->version){
							$r .= '<table class="table-plugin-info">
								<tr>
									<td class="small-icon">Création:</td>
									<td>'.$v->version->date_create.'</td>
								</tr>
								<tr>
									<td class="small-icon">Update:</td>
									<td>'.$v->version->date_update.'</td>
								</tr>
								<tr>
									<td class="small-icon">Version:</td>
									<td>'.$v->version->number.' '.$v->version->phase.'</td>
								</tr>';
							if($v->version->support->forum['href'] != false){
								$r .= '<tr>
									<td class="small-icon">Support:</td>
									<td><a style="text-decoration:underline;" class="targetblank" href="'.$v->version->support->forum['href'].'">'.$v->version->support->forum.'</a></td>
								</tr>';
							}
							if($v->version->support->ticket['href'] != false){
								$r .= '<tr>
									<td class="small-icon">Tickets:</td>
									<td><a style="text-decoration:underline;" class="targetblank" href="'.$v->version->support->ticket['href'].'"><span class="lfloat magix-icon magix-icon-bug-plus"></span>Signaler un bug</a></td>
								</tr>';
							}
							if($v->version->support->svn['href'] != false){
								$r .= '<tr>
									<td class="small-icon">SVN:</td>
									<td><a class="targetblank" href="'.$v->version->support->svn['href'].'"><span class="lfloat magix-icon magix-icon-subversion"></span></a></td>
								</tr>';
							}
							if($v->version->support->git['href'] != false){
								$r .= '<tr>
									<td class="small-icon">GIT:</td>
									<td><a class="targetblank" href="'.$v->version->support->git['href'].'"><span class="lfloat magix-icon magix-icon-git"></span></a></td>
								</tr>';
							}
							$r .= '</table>';
						}
						if($v->authors){
							$r .= '<table class="table-plugin-author">
								<thead>
									<tr style="padding:3px;" class="ui-widget ui-widget-header">
										<th>Author</th>
										<th>Website</th>
									</tr>
								</thead>
								<tbody>';
							foreach($v->authors->author as $row){
								$r.= '<tr>';
								$r.= '<td class="medium-cell">'.$row->name.'</td>';
								$r .= '<td><ul>';
								$t = '';
								foreach($row->link->children() as $link){
									$r .= '<li><a style="text-decoration:underline;" class="targetblank"'; 									$r .= 'href="'.$link->attributes()->href.'">'.$link->attributes()->href.'</a></li>';
								}
								$r.='</ul></td>';
								$r.= '</tr>';
							}
							$r.='</tbody></table>';
							}
						return $r;
					}
				}
				//}
			} catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * @access protected
	 * getplugin
	 */
	private function getplugin(){
		if(isset($this->getplugin) != null){
			return magixcjquery_filter_isVar::isPostAlpha($_GET['name']);
		}
	}
	/**
	 * @access private
	 * Retourne le chemin vers le dossier I18N du plugin
	 */
	private function path_dir_i18n(){
		$dir_i18n = $this->directory_plugins().$this->getplugin().self::I18N.DIRECTORY_SEPARATOR;
		if(file_exists($dir_i18n)){
			return $dir_i18n;
		}
	}
	/**
	 * Retourne l'icon du plugin si elle existe
	 * @param $plugin (string)
	 * @return string
	 */
	private function icon_plugin($plugin){
		if(file_exists($this->directory_plugins().$plugin.DIRECTORY_SEPARATOR.'icon.png')){
			$icon = '<img src="/plugins/'.$plugin.'/icon.png" width="16" height="16" alt="icon '.$plugin.'" />';
		}else{
			$icon = '<span class="icon-file"></span>';
		}
		return $icon;
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function execute_plugins($className){
		if(class_exists($className)){
			try{
				$class =  new $className;
				if($class instanceof $className){
					return $class;
				}else{
					throw new Exception('not instantiate the class: '.$className);
				}
			}catch(Exception $e) {
				magixglobal_model_system::magixlog("Error plugins execute", $e);
			}
		}
	}
	/**
	 * Récupération des options pour la génération
	 * @param string $module
	 */
	/*private function ini_options_mod($class,$module_name=false){
		if(method_exists($this->execute_plugins($class),'init_config_plugin')){
			/* Appelle la  fonction utilisateur init_config_plugin contenue dans le module */
			/*if($module_name != false){
				call_user_func_array(
					$call_options = array($this->execute_plugins($class),'init_config_plugin'), 
					array($module_name)
				);
			}else{
				$call_options = call_user_func(
					array($this->execute_plugins($class),'init_config_plugin')
				);
			}
			if(is_array($call_options)){
				return $call_options;
			}else{
				throw new Exception('ini_options_mod '.$class.' is not array');
			}
		}else{
			return null;
		}
	}*/
	/**
	 * @access private
	 * Construction de la liste des plugins
	 */
	private function listing_plugin($debug=false){
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable($this->directory_plugins())){
			throw new exception('Plugin dir is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
		if($dir != null){
			plugins_Autoloader::register();
			$list = '<ul class="plugin-list">';
				foreach($dir as $d){
					if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
						$pluginPath = $this->directory_plugins().$d;
						if($makefiles->scanDir($pluginPath) != null){
							//Nom de la classe pour le test de la méthode
							$class = 'plugins_'.$d.'_admin';
							//Si la méthode run existe on ajoute le plugin dans le menu
							if(method_exists($class,'run')){
								$access = $this->allow_access_config($d);
								$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
								//Si on demande un debug
								if($debug){
									$firebug = new magixcjquery_debug_magixfire();
									$firebug->magixFireLog($d.': '.$access);
								}
								//Si le fichier d'accès est disponible, on retourne les permissions
								if($access != null OR $access != ''){
									if($access >= $perms['perms']){
										$list .= '<li>'.$this->icon_plugin($d);
										$list .='<a href="/admin/plugins.php?name='.$d.'">';
										$list .= magixcjquery_string_convert::ucFirst($d).'</a></li>';
									}elseif($access == '*'){
										$list .= '<li>'.$this->icon_plugin($d);
										$list .='<a href="/admin/plugins.php?name='.$d.'">';
										$list .= magixcjquery_string_convert::ucFirst($d).'</a></li>';
									}
								}else{
									$list .= '<li>'.$this->icon_plugin($d);
									$list .='<a href="/admin/plugins.php?name='.$d.'">';
									$list .=magixcjquery_string_convert::ucFirst($d).'</a></li>';
								}
							}
						}
					}
				}
			$list .= '</ul>';
		}
		return $list;
	}
	/**
	 * Construction de la navigation pour les plugins utilisateurs
	 * @access public
	 * @return void
	 */
	public function constructNavigation(){
		return $this->listing_plugin();
	}
	/**
	 * Chargement d'un plugin dans l'administration
	 * @access private
	 */
	private function load_plugin($debug=false){
		try{
			plugins_Autoloader::register();
			//Si le fichier admin.php existe dans le plugin
			if(file_exists($this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR.'admin.php')){
				//Si la classe exist on recherche la fonction run()
				if(class_exists('plugins_'.$this->getplugin().'_admin')){
					$load = $this->execute_plugins('plugins_'.$this->getplugin().'_admin');
					//Si la méthode existe on ajoute le plugin dans le register et execute la fonction run()
					if(method_exists($load,'run')){
						$access = $this->allow_access_config($this->getplugin());
						$perms = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
						if($debug){
							$firebug = new magixcjquery_debug_magixfire();
							$firebug->magixFireLog($this->getplugin().': '.$access);
						}
						if($access != null OR $access != ''){
							if($access >= $perms['perms']){
								$load->run();
							}elseif($access == '*'){
								$load->run();
							}else{
								exit();
							}
						}else{
							$load->run();
						}
					}
				}else{
					throw new Exception ('Class '.$this->getplugin().' is not found');
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}

	/**
	 * Retourne le nom du plugin
	 * @access public
	 * @static
	 * pluginName
	 */
	public function pluginName(){
		return $this->getplugin();
	}

	/**
	 * Retourne l'url du plugin
	 * @access public
	 * @static
	 * pluginUrl
	 */
	public function pluginUrl(){
		return '/'.PATHADMIN.'/plugins.php?name='.$this->pluginName();
	}

    /**
     * Retourne le chemin du dossier du plugin courant
     * @param null $plugin_folder
     * @return string
     */
    public function pluginDir($plugin_folder=null){
		if($plugin_folder == null){
			return $this->directory_plugins().$this->getplugin().DIRECTORY_SEPARATOR;
		}else{
			return $this->directory_plugins().$plugin_folder.DIRECTORY_SEPARATOR;
		}
	}

	/**
	 * Retourne le chemin du dossier du plugin courant
	 */
	public function pluginPath(){
		return self::PATHPLUGINS.'/'.$this->getplugin();
	}

	/**
	 * Retourne la langue courante
	 * @return string
	 * @access public 
	 * @static
	 */
	public function sessionLanguage(){
		if(isset($_SESSION['mc_adminlanguage'])){
			if(!empty($_SESSION['mc_adminlanguage'])){
				return magixcjquery_filter_join::getCleanAlpha($_SESSION['mc_adminlanguage'],3);
			}
		}
	}

	/**
	 * Chargement du fichier de configuration suivant la langue.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile){
		try {
			return $this->path_dir_i18n().$configfile.$this->sessionLanguage.'.conf';
		} catch (Exception $e) {
			magixglobal_model_system::magixlog("Error path config", $e);
		}
    }

    /**
     * @param $template_dir
     */
    public static function addTemplateDir($template_dir){
        backend_model_smarty::getInstance()->addTemplateDir($template_dir);
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
        self::addTemplateDir(self::directory_plugins().self::getplugin().'/skin/admin/');
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
        self::addTemplateDir(self::directory_plugins().self::getplugin().'/skin/admin/');
        if(!self::isCached($template, $cache_id, $compile_id, $parent)){
            return backend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }else{
            return backend_model_smarty::getInstance()->fetch($template, $cache_id, $compile_id, $parent, $display, $merge_tpl_vars, $no_output_filter);
        }
    }
    /**
     * @deprecated
     * Assign une variable pour smarty
     * @param $assign
     * @param $fetch
     * @throws Exception
     * @return
     * @internal param void $page
     */
    public function append_assign($assign,$fetch){
        if($assign){
            return backend_config_smarty::getInstance()->assign($assign,$fetch);
        }else{
            throw new Exception('Unable to assign a variable in template');
        }
    }

    /**
     * @deprecated
     * Affiche le template du plugin
     * @param void $page
     * @param null $cache_id
     * @param null $compile_id
     * @return
     */
    public function append_display($page,$cache_id = null,$compile_id = null){
        backend_config_smarty::getInstance()->addTemplateDir($this->directory_plugins().$this->getplugin().'/skin/admin/');
        return backend_config_smarty::getInstance()->display($page,$cache_id,$compile_id);
    }

    /**
     * @deprecated
     * Retourne le résultat du template plugin
     * @param void $page
     * @param null $cache_id
     * @param null $compile_id
     * @return
     */
    public function append_fetch($page,$cache_id = null,$compile_id = null){
        backend_config_smarty::getInstance()->addTemplateDir($this->directory_plugins().$this->getplugin().'/skin/admin/');
        return backend_config_smarty::getInstance()->fetch($page,$cache_id,$compile_id);
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
     * Charge le fichier de configuration associer à la langue
     * @param bool|string $sections (optionnel) :la section à charger
     */
	public static function configLoad($sections = false){
		backend_config_smarty::getInstance()->configLoad(
			self::pathConfigLoad(self::$ConfigFile), $sections
		);
	}

    /**
     * Charge le fichier de configuration pour les mails associer à la langue
     * @param bool|string $sections (optionnel) :la section à charger
     */
	public static function configLoadMail($sections = false){
		backend_config_smarty::getInstance()->configLoad(
            self::pathConfigLoad(self::$MailConfigFile), $sections
		);
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
	 * @access public
	 * Active le système de debug de smarty 3
	 */
	public function getDebugging(){
		return backend_model_smarty::getInstance()->getDebugging();
	}
	/**
	 * @access public
	 * Active le test de l'installation de smarty 3
	 */
	public function testInstall(){
		return backend_model_smarty::getInstance()->testInstall();
	}
	/**
	 * @access public
	 * Affiche la page index du plugin et execute la fonction run (obligatoire)
	 */
	private function display_plugins(){
		if($this->getplugin()){
			try{
				backend_config_smarty::getInstance()->assign('pluginName',$this->pluginName());
				backend_config_smarty::getInstance()->assign('pluginUrl',$this->pluginUrl());
				backend_config_smarty::getInstance()->assign('pluginPath',$this->pluginPath());
				backend_config_smarty::getInstance()->assign('pluginInfo',$this->load_config_info());
				$this->load_plugin();
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	public function run(){
		$this->display_plugins();
	}
//####### INSTALL TABLE ######
	/**
	 * @access private
	 * load sql file
	 */
	private function load_sql_file($filename,$plugin_folder=null){
		return backend_controller_plugins::pluginDir($plugin_folder).'sql'.DIRECTORY_SEPARATOR.$filename;
	}
	/**
	 * @access public
	 * @static
	 * Installation des tables mysql du plugin
	 */
	public function db_install_table($filename,$fetchFile,$plugin_folder=null){
		try{
			if(file_exists($this->load_sql_file($filename))){
				if(magixglobal_model_db::create_new_sqltable($this->load_sql_file($filename,$plugin_folder))){
					$this->append_assign('refresh_plugins','<meta http-equiv="refresh" content="3";URL="'.$this->pluginUrl().'">');
					$fetch = $this->append_fetch($fetchFile);
					$this->append_assign('install_db',$fetch);
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('Error install table '.$this->pluginName().':',$e);
		}
	}
}
?>