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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name lang
 *
 */
class backend_controller_lang extends backend_db_lang{
    protected $message;
	/**
	 * string
	 * @var iso
	 */
	public $idadmin,$iso;
	/**
	 * string
	 * @var language
	 */
	public $language;
	/**
	 * 
	 * @var intéger
	 */
	public $default_lang,$active_lang,$idlang;
	/**
	 * 
	 * Edition et suppression
	 * @var $edit
	 * @var $delete_lang
	 */
	public $edit,$delete_lang,$action;
	/**
	 * Constructor
	 */
	function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isSession('keyuniqid_admin')){
            $this->idadmin = magixcjquery_filter_isVar::isPostNumeric($_SESSION['keyuniqid_admin']);
        }
		if(magixcjquery_filter_request::isPost('iso')){
			$this->iso = magixcjquery_form_helpersforms::inputCleanStrolower($_POST['iso']);
		}
		if(magixcjquery_filter_request::isPost('language')){
			$this->language = magixcjquery_form_helpersforms::inputClean($_POST['language']);
		}
		if(magixcjquery_filter_request::isPost('default_lang')){
			$this->default_lang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['default_lang']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('active_lang')){
			$this->active_lang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['active_lang']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
		//DELETE
		if(magixcjquery_filter_request::isPost('delete_lang')){
			$this->delete_lang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['delete_lang']);
		}
		//EDIT
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
	}
	/**
	 * @access private
	 * Requête JSON pour retourner la liste des langues
	 */
	private function json_listing_language(){
		if(parent::s_lang() != null){
			foreach (parent::s_lang() as $key){
				$json[]= '{"idlang":'.json_encode($key['idlang']).',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($key['iso']))
				.',"language":'.json_encode($key['language']).',"default_lang":'.json_encode($key['default_lang']).
				',"active_lang":'.json_encode($key['active_lang']).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	/**
	 * insertion d'une nouvelle langue avec système de controle
	 * @access private
	 */
	private function insert_new_lang($create){
		if(isset($this->iso) AND isset($this->language)){
			$verify_lang = parent::s_verif_lang($this->iso);
			$verify_default = parent::count_default_language();
			if(empty($this->iso) OR empty($this->language)){
                $create->display('lang/request/empty.tpl');
			}elseif($verify_lang['numlang'] == '0'){
				if($this->default_lang == null){
					$langdefault = '0';
					parent::i_new_lang($this->iso,$this->language,$langdefault);
                    $this->message->getNotify('add');
				}else{
					if($verify_default['deflanguage'] == '1'){
                        $this->message->getNotify('lang_default');
					}else{
						$langdefault = $this->default_lang;
						parent::i_new_lang($this->iso,$this->language,$langdefault);
                        $this->message->getNotify('add');
					}
				}
			}else{
                $this->message->getNotify('lang_exist');
			}
		}
	}
	/**
	 * @access private
	 * Charge les données pour l'édition d'une langue
	 */
	private function load_data_language($create){
		$db = parent::s_lang_edit($this->edit);
        $create->assign('idlang', $db['idlang']);
		$iso = backend_model_forms::code_iso("iso",$db['iso']);
        $create->assign('iso', $iso);
        $create->assign('language', $db['language']);
        $create->assign('default_lang', $db['default_lang']);
	}

	/**
	 * Suppression d'une lang via une requête ajax
	 * @access public
	 */
	private function delete_lang_record($create){
		if(isset($this->delete_lang)){
			$count = parent::count_idlang_by_module($this->delete_lang);
			if($count['ctotal'] != 0){
                $this->message->getNotify('lang_exist');
			}else{
				parent::d_lang($this->delete_lang);
			}
		}
	}
	/**
	 * @access private
	 * Edition d'une langue
	 */
	private function edit_lang(){
		if(isset($this->edit)){
			$verify_default = parent::count_default_language();
			if($this->default_lang == null){
				$langdefault = '0';
			}else{
				$langdefault = $this->default_lang;
			}
			if($this->default_lang != null){
				if($verify_default['deflanguage'] == '1'){
                    $this->message->getNotify('lang_default');
				}else{
					parent::u_lang($this->iso,$this->language,$langdefault,$this->edit);
                    $this->message->getNotify('update');
				}
			}else{
				parent::u_lang($this->iso,$this->language,$langdefault,$this->edit);
                $this->message->getNotify('update');
			}
		}
	}
	/**
	 * @access private
	 * Modifie le status d'une langue
	 */
	private function update_activate_lang(){
		if(isset($this->active_lang)){
			parent::u_activate_lang_status($this->active_lang, $this->idlang);
		}
	}

    /**
     * @access private
     * Requête JSON pour les statistiques des langues
     */
    private function json_graph(){
        if(parent::s_stats_lang() != null){
            foreach (parent::s_stats_lang() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['HOME'],
                    'z'=>$key['NEWS'],
                    'a'=>$key['PAGES'],
                    'b'=>$key['PRODUCT']
                );
            }
            print json_encode($stat);
        }
    }
	/**
	 * @access public
	 * Execution de la structure
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'language'
            ),array('language_'),false
        );
        if(isset($this->action)){
            if($this->action == 'list'){
                if(magixcjquery_filter_request::isGet('json_list_lang')){
                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                    $header->pragma();
                    $header->cache_control("nocache");
                    $header->getStatus('200');
                    $header->json_header("UTF-8");
                    $this->json_listing_language();
                }else{
                    $iso = backend_model_forms::code_iso("iso");
                    $create->assign('iso', $iso);
                    $create->display('lang/list.tpl');
                }
            }elseif($this->action == 'add'){
                if(isset($this->iso)){
                    $this->insert_new_lang($create);
                }
            }elseif($this->action == 'edit'){
                if(magixcjquery_filter_request::isGet('edit')){
                    if(isset($this->iso)){
                        $this->edit_lang();
                    }else{
                        $this->load_data_language($create);
                        backend_controller_template::display('lang/edit.tpl');
                    }
                }else{
                    if(isset($this->active_lang)){
                        $this->update_activate_lang();
                    }
                }
            }elseif($this->action == 'remove'){
                if(magixcjquery_filter_request::isPost('delete_lang')){
                    $this->delete_lang_record($create);
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
				$iso = backend_model_forms::code_iso("iso");
				backend_controller_template::assign('iso', $iso);
				backend_controller_template::display('lang/index.tpl');
			}
		}
	}
}