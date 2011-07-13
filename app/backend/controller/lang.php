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
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name lang
 *
 */
class backend_controller_lang extends backend_db_lang{
	/**
	 * string
	 * @var iso
	 */
	public $iso;
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
	 * @var $dellang
	 */
	public $edit,$dellang;
	/**
	 * Constructor
	 */
	function __construct(){
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
		//DELETE
		if(magixcjquery_filter_request::isPost('dellang')){
			$this->dellang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['dellang']);
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
			foreach (parent::s_lang() as $s){
				$json[]= '{"idlang":'.json_encode($s['idlang']).',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($s['iso']))
				.',"language":'.json_encode($s['language']).',"default_lang":'.json_encode($s['default_lang']).
				',"active_lang":'.json_encode($s['active_lang']).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	/**
	 * insertion d'une nouvelle langue avec système de controle
	 * @access private
	 */
	private function insert_new_lang(){
		if(isset($this->iso) AND isset($this->language)){
			$verify_lang = parent::s_verif_lang($this->iso);
			$verify_default = parent::count_default_language();
			if(empty($this->iso) OR empty($this->language)){
				backend_controller_template::display('request/empty.phtml');
			}elseif($verify_default['deflanguage'] == '1'){
				backend_controller_template::display('lang/request/default_exist.phtml');
			}elseif($verify_lang['numlang'] == '0'){
				if($this->default_lang == null){
					$langdefault = '0';
				}else{
					$langdefault = $this->default_lang;
				}
				parent::i_new_lang($this->iso,$this->language,$langdefault);
				backend_controller_template::display('lang/success.phtml');
			}else{
				backend_controller_template::display('lang/request/element-exist.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Charge les données pour l'édition d'une langue
	 */
	private function load_data_language(){
		$db = parent::s_lang_edit($this->edit);
		backend_controller_template::assign('idlang', $db['idlang']);
		backend_controller_template::assign('iso', $db['iso']);
		backend_controller_template::assign('language', $db['language']);
		backend_controller_template::assign('default_lang', $db['default_lang']);
	}
	/**
	 * Suppression d'une lang via une requête ajax
	 * @access public
	 */
	private function delete_lang_record(){
		if(isset($this->dellang)){
			$count = parent::count_idlang_by_module($this->dellang);
			if($count['ctotal'] != 0){
				backend_controller_template::display('lang/request/element-exist.phtml');
			}else{
				parent::d_lang($this->dellang);
				backend_controller_template::display('lang/request/delete.phtml');
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
					backend_controller_template::display('lang/request/default_exist.phtml');
				}else{
					parent::u_lang($this->iso,$this->language,$langdefault,$this->edit);
					backend_controller_template::display('lang/request/update-success.phtml');
				}
			}else{
				parent::u_lang($this->iso,$this->language,$langdefault,$this->edit);
				backend_controller_template::display('lang/request/update-success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Modifie le status d'une langue
	 */
	private function post_activate_lang(){
		if(isset($this->active_lang)){
			parent::u_activate_lang_status($this->active_lang, $this->idlang);
		}
	}
	/**
	 * @access private
	 * Requête JSON pour les statistiques du CMS
	 */
	private function json_language_chart(){
		if(parent::count_lang_pages() != null){
			foreach (parent::count_lang_pages() as $s){
				$rowCms[]= $s['countpages'];
			}
		}else{
			$rowCms = array(0);
		}
		if(parent::count_lang_news() != null){
			foreach (parent::count_lang_news() as $s){
				$rowNews[]= $s['countnews'];
			}
		}else{
			$rowNews = array(0);
		}
		if(parent::count_lang_product() != null){
			foreach (parent::count_lang_product() as $s){
				$rowProduct[]= $s['countproduct'];
			}
		}else{
			$rowProduct = array(0);
		}
		if(parent::s_lang() != null){
			foreach (parent::s_lang() as $s){
				$rowLang[]= json_encode(magixcjquery_string_convert::upTextCase($s['iso']));
			}
		}else{
			$rowLang = array(0);
		}
		print '{"cms_pages_count":['.implode(',',$rowCms).'],"product_count":['.implode(',',$rowProduct).'],"news_count":['.implode(',',$rowNews).'],"lang":['.implode(',',$rowLang).']}';
	}
	/**
	 * @access public
	 * Execution de la structure
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isPost('iso')){
				$this->edit_lang();
			}else{
				$this->load_data_language();
				backend_controller_template::display('lang/edit.phtml');
			}
		}elseif(magixcjquery_filter_request::isGet('json_list_lang')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			$this->json_listing_language();
		}elseif(magixcjquery_filter_request::isPost('dellang')){
			$this->delete_lang_record();
		}elseif(magixcjquery_filter_request::isPost('active_lang')){
			$this->post_activate_lang();
		}else{
			if(magixcjquery_filter_request::isPost('iso')){
				$this->insert_new_lang();
			}elseif(magixcjquery_filter_request::isGet('json_google_chart_lang')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_language_chart();
			}else{
				backend_controller_template::display('lang/index.phtml');
			}
		}
	}
}