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
 * @name rewritemetas
 *
 */
class backend_controller_seo extends backend_db_seo{
    protected $message;
	/**
	 * 
	 * @var intéger
	 */
	public $idmetas;
	/**
	 * Identifiant de la configuration
	 * @var integer
	 */
	public $attribute;
	/**
	 * Phrase pour la réécriture des métas
	 * @var string
	 */
	public $strrewrite;
	/**
	 * Niveau de la réécriture des métas
	 * @var integer
	 */
	public $level;
	/**
	 * Edition d'une réécriture des métas
	 * @var integer
	 */
	public $edit;
	/**
	 * Supprime une réécriture via l'identifiant
	 * @var delete_metas
	 */
	public $delete_metas;
    public $action,$tab,$getlang;
	public function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
		if(magixcjquery_filter_request::isPost('attribute')){
			$this->attribute = magixcjquery_form_helpersforms::inputClean($_POST['attribute']);
		}
		if(magixcjquery_filter_request::isPost('idmetas')){
			$this->idmetas = magixcjquery_filter_isVar::isPostNumeric($_POST['idmetas']);
		}
		if(magixcjquery_filter_request::isPost('strrewrite')){
			$this->strrewrite = magixcjquery_form_helpersforms::inputClean($_POST['strrewrite']);
		}
		if(magixcjquery_filter_request::isPost('level')){
			$this->level = magixcjquery_filter_isVar::isPostNumeric($_POST['level']);
		}
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('delete_metas')){
			$this->delete_metas = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_metas']);
		}
        //Global
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
        }
	}

    /**
     * Affiche la réécriture des métas suivant la langue
     * @access private
     */
    private function json_list_metas(){
		if(parent::s_rewrite_meta($this->getlang) != null){
			foreach (parent::s_rewrite_meta($this->getlang) as $key){
				$json[]= '{"idrewrite":'.json_encode($key['idrewrite']).',"attribute":'.json_encode($key['attribute']).
				',"idmetas":'.json_encode($key['idmetas']).',"strrewrite":'.json_encode($key['strrewrite']).
				',"level":'.json_encode($key['level']).'}';
			}
			print '['.implode(',',$json).']';
		}else{
            print '{}';
        }
	}

    /**
     * Selection de l'attribut
     * @param $create
     * @param null $update
     */
    private function select_attribute($create,$update=null){
        $create->configLoad('local_'.backend_model_language::current_Language().'.conf');
        $tabsModule = array_merge(
            array(
                'news'      =>  $create->getConfigVars('news'),
                'catalog'   =>  $create->getConfigVars('catalog')
            ),
            $this->load_listing_plugin()
        );
        $iniModules = new backend_model_modules($tabsModule);
        $create->assign('select_attribute', $iniModules->select_menu_module($update));
    }

    /**
     * Selection du niveau
     * @param $create
     * @param null $update
     */
    private function select_level($create,$update=null){
        $create->configLoad('local_'.backend_model_language::current_Language().'.conf');
        if($update != null){
            $default = array($update=> 'level '.$update);
        }
        $select = backend_model_forms::select_static_row(
            array(
                '0'=>'Level 0',
                '1'=>'Level 1',
                '2'=>'Level 2',
                '3'=>'Level 3'
            ),
            array(
                'attr_name'     =>  'level',
                'attr_id'       =>'level',
                'default_value' =>$default,
                'empty_value'   =>$create->getConfigVars('select_level'),
                'class'         =>  'form-control',
                'upper_case'    =>false
            )
        );
        $create->assign('select_level', $select);
    }

    /**
     * selection du type
     * @param $create
     * @param null $update
     */
    private function select_metas($create,$update=null){
        $create->configLoad('local_'.backend_model_language::current_Language().'.conf');
        if($update != null){
            if($update == 1){
                $default = array($update=>'title');
            }elseif($update == 2){
                $default = array($update=>'description');
            }

        }
        $select = backend_model_forms::select_static_row(
            array(
                '1'=>'Title',
                '2'=>'Description'
            ),
            array(
                'attr_name'     =>  'idmetas',
                'attr_id'       =>  'idmetas',
                'default_value' =>  $default,
                'empty_value'   =>  $create->getConfigVars('select_type'),
                'class'         =>  'form-control',
                'upper_case'    =>  false
            )
        );
        $create->assign('select_metas', $select);
    }

	/**
	 * insertion de la réécriture des métas
	 * @access private
	 */
	private function add(){
		if(isset($this->strrewrite)){
			if(empty($this->attribute) OR empty($this->idmetas)){
                $this->message->getNotify('empty');
			}elseif(parent::v_rewrite_meta(
                $this->getlang,
                $this->attribute,
                $this->idmetas,
                $this->level
            ) == null){
				parent::i_rewrite_metas(
                    $this->getlang,
					$this->attribute,
					$this->strrewrite,
					$this->idmetas,
					$this->level
				);
                $this->message->getNotify('add');
			}else{
                $this->message->getNotify('lang_exist');
			}
		}
	}

	/**
	 * Mise à jour de la réécriture suivant l'identifiant
	 * @access private
	 */
	private function update(){
		if(isset($this->edit)){
			if(isset($this->strrewrite)){
				if(empty($this->attribute) OR empty($this->idmetas)){
                    $this->message->getNotify('empty');
				}else{
					parent::u_rewrite_metas(
                        $this->getlang,
                        $this->attribute,
                        $this->strrewrite,
                        $this->idmetas,
                        $this->level,
                        $this->edit
                    );
                    $this->message->getNotify('update');
				}
			}
		}
	}
	/**
	 * Supprime la réécriture suivant l'identifiant
	 * @access public
	 */
	private function remove_rewrite(){
		if(isset($this->delete_metas)){
			parent::d_rewrite_metas($this->delete_metas);
		}
	}
	/**
	 * Charge les données dans le formulaire d'édition
	 * @access private
	 */
	private function load_rewrite($create,$data){
		if(isset($this->edit)){
            $assign_exclude = array(
                'iso','idlang'
            );
            foreach($data as $key => $value){
                if(!(array_search($key,$assign_exclude))){
                    $create->assign($key,$value);
                }
            }
		}
	}

    /**
     * execute ou instance la class du plugin
     * @param $module
     * @return
     * @internal param void $className
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
     * Récupération des options pour la génération
     * @param string $module
     * @throws Exception
     * @return array
     */
	private function ini_options_mod($module){
		if(method_exists($this->get_call_class('plugins_'.$module.'_admin'),'seo_options')){
			/* Appelle la  fonction utilisateur sitemap_rewrite_options contenue dans le module */
			$call_options = call_user_func(
				array($this->get_call_class('plugins_'.$module.'_admin'),'seo_options')
			);
			if(is_array($call_options)){
				return $call_options;
			}else{
				throw new Exception('ini_options_mod '.$module.' is not array');
			}
		}else{
			throw new Exception('Method "seo_options" does not exist');
		}
	}

	/**
	 * @access private
	 * listing plugin
	 */
	private function load_listing_plugin(){
		$pathplugins = new backend_controller_plugins();
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable($pathplugins->directory_plugins())){
			throw new exception('Plugin dir is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir($pathplugins->directory_plugins());
		if($dir != null){
			plugins_Autoloader::register();
			$list = '';
			foreach($dir as $d){
				if(file_exists($pathplugins->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
					$pluginPath = $pathplugins->directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						//Nom de la classe pour le test de la méthode
						$class = 'plugins_'.$d.'_admin';
						//Si la méthode run existe on ajoute le plugin dans le menu
						if(method_exists($class,'seo_options')){
							$options_mod = $this->ini_options_mod($d);
							if($options_mod['plugins'] == true){
								$list['plugins:'.$d]='plugins:'.$d;
							}
						}
					}
				}
			}
		}
		return $list;
	}

    /**
     * @access private
     * Requête JSON pour les statistiques du CMS
     */
    private function json_graph(){
        if(parent::s_stats_rewrite() != null){
            foreach (parent::s_stats_rewrite() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['REWRITE']
                );
            }
            print json_encode($stat);
        }
    }

	/**
	 * 
	 * Execute la fonction run
	 */
	public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'seo'
            ),array('seo_'),false
        );
        if(magixcjquery_filter_request::isGet('getlang')){
            if(isset($this->action)){
                if($this->action == 'list'){
                    if(magixcjquery_filter_request::isGet('json_list_seo')){
                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                        $header->pragma();
                        $header->cache_control("nocache");
                        $header->getStatus('200');
                        $header->json_header("UTF-8");
                        $this->json_list_metas();
                    }else{
                        $this->select_attribute($create);
                        $this->select_level($create);
                        $this->select_metas($create);
                        $create->display('seo/list.tpl');
                    }
                }elseif($this->action == 'add'){
                    if(isset($this->strrewrite)){
                        $this->add();
                    }
                }elseif($this->action == 'edit'){
                    if(isset($this->edit)){
                        $data = parent::s_rewrite_data($this->edit);
                        if(isset($this->strrewrite)){
                            $this->update();
                        }else{
                            $this->load_rewrite($create,$data);
                            $this->select_attribute($create,$data['attribute']);
                            $this->select_level($create,$data['level']);
                            $this->select_metas($create,$data['idmetas']);
                            $create->display('seo/edit.tpl');
                        }
                    }
                }elseif($this->action == 'remove'){
                    if(isset($this->delete_metas)){
                        $this->remove_rewrite();
                    }
                }
            }
        }else{
            if(magixcjquery_filter_request::isGet('json_graph')){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_graph();
            }else{
                $create->display('seo/index.tpl');
            }
        }
	}
}