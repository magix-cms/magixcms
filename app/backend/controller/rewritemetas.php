<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien@magix-cms.com>
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
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name rewritemetas
 *
 */
class backend_controller_rewritemetas extends backend_db_rewritemetas{
	/**
	 * 
	 * @var intéger
	 */
	public $idmetas;
	/**
	 * 
	 * @var intéger
	 */
	public $idlang;
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
	 * @var drmetas
	 */
	public $drmetas;
	public function __construct(){
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
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
		if(magixcjquery_filter_request::isPost('drmetas')){
			$this->drmetas = magixcjquery_filter_isVar::isPostNumeric($_POST['drmetas']);
		}
	}
	/**
	 * Affiche la réécriture des métas trié par langue
	 * @access private
	 */
	private function json_list_metas(){
		if(parent::s_rewrite_meta() != null){
			foreach (parent::s_rewrite_meta() as $s){
				$title[]= '{"idrewrite":'.json_encode($s['idrewrite']).',"attribute":'.json_encode($s['attribute']).
				',"idmetas":'.json_encode($s['idmetas']).',"strrewrite":'.json_encode($s['strrewrite']).
				',"level":'.json_encode($s['level']).',"iso":'.json_encode($s['iso']).'}';
			}
			print '['.implode(',',$title).']';
		}
	}
	/**
	 * insertion de la réécriture des métas
	 * @access private
	 */
	private function insertion_rewrite(){
		if(isset($this->strrewrite)){
			if(empty($this->attribute) OR empty($this->idmetas)){
				backend_controller_template::display('request/empty.phtml');
			}elseif(parent::s_rewrite_v_lang($this->attribute,$this->idlang,$this->idmetas,$this->level) == null){
				parent::i_rewrite_metas(
					$this->attribute,
					$this->idlang,
					$this->strrewrite,
					$this->idmetas,
					$this->level
				);
				backend_controller_template::display('config/request/add_seo.phtml');
			}else{
				backend_controller_template::display('request/element-exist.phtml');
			}
		}
	}
	/**
	 * Mise à jour de la réécriture suivant l'identifiant
	 * @access private
	 */
	private function update_rewrite(){
		if(isset($this->edit)){
			if(isset($this->strrewrite)){
				if(empty($this->attribute) OR empty($this->idmetas)){
					backend_controller_template::display('request/empty.phtml');
				}else{
					parent::u_rewrite_metas($this->attribute,$this->idlang,$this->strrewrite,$this->idmetas,$this->level,$this->edit);
					backend_controller_template::display('config/request/update_seo.phtml');
				}
			}
		}
	}
	/**
	 * Supprime la réécriture suivant l'identifiant
	 * @access public
	 */
	private function d_rewrite(){
		if(isset($this->drmetas)){
			parent::d_rewrite_metas($this->drmetas);
		}
	}
	/**
	 * Charge les données dans le formulaire d'édition
	 * @access private
	 */
	private function load_rewrite_for_edit(){
		if(isset($this->edit)){
			$load = parent::s_rewrite_for_edit($this->edit);
			backend_controller_template::assign('strrewrite',$load['strrewrite']);
			backend_controller_template::assign('idlang',$load['idlang']);
			backend_controller_template::assign('iso',$load['iso']);
			backend_controller_template::assign('attribute',$load['attribute']);
			backend_controller_template::assign('level',$load['level']);
			backend_controller_template::assign('idmetas',$load['idmetas']);
		}
	}
	/**
	 * Affiche le fomulaire de modification ainsi que la liste des réécritures disponible
	 * @access public
	 */
	private function display_seo_edit(){
		self::load_rewrite_for_edit();
		backend_controller_template::display('config/editseo.phtml');
	}
	/**
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
	 * Récupération des options pour la génération
	 * @param string $module
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
							//$list[$options_mod[0]]='plugins_'.$d;
							/*if($options_mod['plugins'] == true){
								$ini[]='plugins_'.$d;
							}*/
						}
					}
				}
			}
		}
		return $list;
	}
	/**
	 * Affiche le formulaire et une liste des réécritures disponible
	 * @access public
	 */
	private function display(){
		$this->insertion_rewrite();
		backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
		$tabsModule = array_merge(array('News'=>'news','Catalogue'=>'catalog'),$this->load_listing_plugin());
		$iniModules = new backend_model_modules($tabsModule);
		backend_controller_template::assign('select_module', $iniModules->select_menu_module());
		backend_controller_template::display('config/seo.phtml');
	}
	/**
	 * 
	 * Execute la fonction run
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('add')){
			self::insertion_rewrite();
		}elseif(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isPost('strrewrite')){
				self::update_rewrite();
			}else{
				self::display_seo_edit();
			}
		}elseif(magixcjquery_filter_request::isGet('load_metas')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			self::json_list_metas();
		}elseif(magixcjquery_filter_request::isPost('drmetas')){
			self::d_rewrite();
		}else{
			self::display();
		}
	}
}