<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
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
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name CMS
 *
 */
class backend_controller_cms extends backend_db_cms{
	public 
	$idpage,
	$idlang,
	$idcat_p,
	$idlang_p,
	$title_page,
	$uri_page,
	$content_page,
	$seo_title_page,
	$seo_desc_page,
	$pageorderp,
	$sidebar_page,
	$rel_title_page;
	public $getlang,$get_page_p,$edit;
	public $post_search,$get_search_page,$title_p_lang,$title_p_move,$callback;
	public $cat_p_lang;
	public $del_relang_p,$delpage,$movepage;
	/**
	 * function construct class
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('idcat_p')){
			$this->idcat_p = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idcat_p']);
		}
		if(magixcjquery_filter_request::isPost('idlang_p')){
			$this->idlang_p = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang_p']);
		}
		if(magixcjquery_filter_request::isPost('title_page')){
			$this->title_page = magixcjquery_form_helpersforms::inputClean($_POST['title_page']);
		}
		if(magixcjquery_filter_request::isPost('uri_page')){
			$this->uri_page = magixcjquery_url_clean::rplMagixString($_POST['uri_page'],true);
		}
		if(magixcjquery_filter_request::isPost('content_page')){
			$this->content_page = magixcjquery_form_helpersforms::inputCleanQuote($_POST['content_page']);
		}
		if(magixcjquery_filter_request::isPost('seo_title_page')){
			$this->seo_title_page = magixcjquery_form_helpersforms::inputClean($_POST['seo_title_page']);
		}
		if(magixcjquery_filter_request::isPost('seo_desc_page')){
			$this->seo_desc_page = magixcjquery_form_helpersforms::inputClean($_POST['seo_desc_page']);
		}
		if(magixcjquery_filter_request::isPost('pageorderp')){
			$this->pageorderp = magixcjquery_form_helpersforms::arrayClean($_POST['pageorderp']);
		}
		if(magixcjquery_filter_request::isPost('sidebar_page')){
			$this->sidebar_page = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['sidebar_page']);
		}
		if(magixcjquery_filter_request::isGet('getlang')){
			$this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
		}
		if(magixcjquery_filter_request::isGet('get_page_p')){
			$this->get_page_p = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['get_page_p']);
		}
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('idpage')){
			$this->idpage = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idpage']);
		}
		if(magixcjquery_filter_request::isPost('post_search')){
			$this->post_search = magixcjquery_form_helpersforms::inputClean($_POST['post_search']);
		}
		if(magixcjquery_filter_request::isGet('get_search_page')){
			$this->get_search_page = magixcjquery_form_helpersforms::inputClean($_GET['get_search_page']);
		}
		if(magixcjquery_filter_request::isPost('delpage')){
			$this->delpage = magixcjquery_filter_isVar::isPostNumeric($_POST['delpage']);
		}
		//Page relative dans une autre langue
		if(magixcjquery_filter_request::isPost('rel_title_page')){
			$this->rel_title_page = magixcjquery_form_helpersforms::inputClean($_POST['rel_title_page']);
		}
		if(magixcjquery_filter_request::isGet('title_p_lang')){
			$this->title_p_lang = magixcjquery_form_helpersforms::inputClean($_GET['title_p_lang']);
		}
		if(magixcjquery_filter_request::isPost('cat_p_lang')){
			$this->cat_p_lang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['cat_p_lang']);
		}
		if(magixcjquery_filter_request::isPost('del_relang_p')){
			$this->del_relang_p = magixcjquery_filter_isVar::isPostNumeric($_POST['del_relang_p']);
		}
		//MOVE
		if(magixcjquery_filter_request::isGet('movepage')){
			$this->movepage = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['movepage']);
		}
		if(magixcjquery_filter_request::isGet('title_p_move')){
			$this->title_p_move = magixcjquery_form_helpersforms::inputClean($_GET['title_p_move']);
		}
		//JQUERY CALLBACK
		if(magixcjquery_filter_request::isGet('callback')){
			$this->callback = (string) magixcjquery_form_helpersforms::inputClean($_GET['callback']);
		}
	}
	/**
	 * @access private
	 * Requête JSON suivant la langue sélectionner pour retourner les pages parente
	 */
	private function json_parent_p(){
		if(parent::s_parent_p($this->getlang) != null){
			foreach (parent::s_parent_p($this->getlang) as $s){
				$json[]= '{"idpage":'.json_encode($s['idpage']).',"title_page":'.json_encode($s['title_page']).',"sidebar_page":'.json_encode($s['sidebar_page']).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	/**
	 * @access private
	 * Requête JSON suivant la langue sélectionner pour retourner les pages enfants
	 */
	private function json_child_page(){
		if(parent::s_child_page($this->get_page_p) != null){
			foreach (parent::s_child_page($this->get_page_p) as $s){
				$json[]= '{"idpage":'.json_encode($s['idpage']).',"title_page":'.json_encode($s['title_page']).',"sidebar_page":'.json_encode($s['sidebar_page']).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	/**
	 * @access private
	 * retourne les langues pour administrer les pages parents ainsi que leurs enfants
	 */
	/*private function listing_index_language(){
		if(backend_db_block_lang::s_data_lang() != null){
			$list = '<ul>';
			foreach(backend_db_block_lang::s_data_lang() as $slang){
				$list .= '<li>';
				$list .= '<a href="/admin/cms.php?getlang='.$slang['idlang'].'">';
				$list .= '<img src="/upload/iso_lang/'.$slang['iso'].'.png" alt="'.$slang['iso'].'" /> ';
				$list .= '<span>'.magixcjquery_string_convert::ucFirst($slang['language']).'</span>';
				$list .= '</a></li>';
			}
			$list .= '</ul>';
			return $list;
		}
	}*/
	/**
	 * @access private
	 * Retourne l'image et la langue suivant l'identifiant
	 * @param integer $idlang
	 */
	private function parent_language($idlang){
		$db = backend_db_block_lang::s_data_iso($idlang);
		return '<img src="/upload/iso_lang/'.$db['iso'].'.png" alt="'.$db['iso'].'" /> '.magixcjquery_string_convert::ucFirst($db['language']);
	}
	/**
	 * @access private
	 * Retourne le nom de la page parente
	 * @param integer $get_page_p
	 */
	private function parent_page($get_page_p){
		if(isset($get_page_p)){
			$db = parent::s_current_page_p($get_page_p);
			return $db['title_page'];
		}
	}
	/**
	 * @access private
	 * Insertion d'une nouvelle page parent
	 * @param string $title_page
	 * @param integer $idlang
	 */
	private function insert_new_page_p($title_page,$idlang){
		if(isset($title_page) AND isset($idlang)){
			// Verifier que le module exist
			$numbermod = $config = backend_model_setting::tabs_load_config('cms');
			/*$firebug = new magixcjquery_debug_magixfire();
			$firebug->magixFireLog($numbermod['setting_value']);*/
			if(empty($title_page) OR empty($idlang)){
				backend_controller_template::display('request/empty.phtml');
			}elseif($numbermod['max_record'] != 0){
					$cpage = parent::s_count_page_max_by_language($idlang);
					if($cpage['total'] >= $numbermod['max_record']){
						//Si le nombre maximal de page est atteint
						backend_controller_template::display('request/maxpage.phtml');
					}else{
						$uri_page = magixcjquery_url_clean::rplMagixString($title_page,false);
						parent::i_new_parent_page(
							backend_model_member::s_idadmin(), 
							$this->idlang, 
							$this->title_page, 
							$uri_page, 
							$this->content_page, 
							$this->seo_title_page, 
							$this->seo_desc_page
						);
						backend_controller_template::display('request/success.phtml');
					}
			}else{
				$uri_page = magixcjquery_url_clean::rplMagixString($title_page,false);
				parent::i_new_parent_page(
					backend_model_member::s_idadmin(), 
					$this->idlang, 
					$this->title_page, 
					$uri_page, 
					$this->content_page, 
					$this->seo_title_page, 
					$this->seo_desc_page
				);
				backend_controller_template::display('request/success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Insertion d'une page enfant
	 * @param string $title_page
	 * @param integer $idlang
	 */
	private function insert_new_child_page($title_page,$idlang){
		if(isset($title_page) AND isset($idlang)){
			if(empty($title_page) OR empty($idlang)){
				backend_controller_template::display('request/empty.phtml');
			}else{
				$uri_page = magixcjquery_url_clean::rplMagixString($title_page,false);
				parent::i_new_child_page(
					backend_model_member::s_idadmin(), 
					$this->idlang,
					$this->idcat_p,
					$this->title_page, 
					$uri_page, 
					$this->content_page, 
					$this->seo_title_page, 
					$this->seo_desc_page
				);
				backend_controller_template::display('request/success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Chargement des données pour édition
	 * @param integer $edit
	 */
	private function load_edit_page($edit){
		if(isset($edit)){
			$db = parent::s_edit_page($edit);
			backend_controller_template::assign('idpage', $db['idpage']);
			backend_controller_template::assign('title_page', $db['title_page']);
			backend_controller_template::assign('iso', $db['iso']);
			backend_controller_template::assign('uri_page', $db['uri_page']);
			backend_controller_template::assign('content_page', magixcjquery_form_helpersforms::inputClean($db['content_page']));
			backend_controller_template::assign('seo_title_page', $db['seo_title_page']);
			backend_controller_template::assign('seo_desc_page', $db['seo_desc_page']);
			backend_controller_template::assign('selectexcludelang',backend_model_blockDom::select_other_lang($db['idlang']));
		}
	}
	/**
	 * @access private
	 * Chargement JSON des données URL pour information
	 */
	private function load_json_uri_cms($edit){
		$db = parent::s_edit_page($edit);
		if($db['idpage'] != null){
			$parent_page = parent::s_data_parent_page($db['idcat_p']);
			if($db['idcat_p'] != '0'){
				$uri = magixglobal_model_rewrite::filter_cms_url(
					$db['iso'], 
					$parent_page['idpage'], 
					$parent_page['uri_page'], 
					$db['idpage'], 
					$db['uri_page'],
					true
				);
			}else{
				$uri = magixglobal_model_rewrite::filter_cms_url(
					$db['iso'], 
					null, 
					null, 
					$db['idpage'], 
					$db['uri_page'],
					true
				);
			}
			$cmsinput= '{"cmsuri":'.json_encode(magixcjquery_url_clean::rplMagixString($uri)).'}';
			print $cmsinput;
		}
	}
	/**
	 * @access private
	 * Procédure de mise à jour de la page en édition
	 * @param string $title_page
	 */
	private function update_page($title_page){
		if(isset($title_page)){
			if(empty($title_page)){
				backend_controller_template::display('request/empty.phtml');
			}else{
				if(!empty($this->uri_page)){
					$uri_page = $this->uri_page;
				}else{
					$uri_page = magixcjquery_url_clean::rplMagixString($this->title_page);
				}
				parent::u_page(
					backend_model_member::s_idadmin(),
					$this->title_page, 
					$uri_page, 
					$this->content_page, 
					$this->seo_title_page, 
					$this->seo_desc_page,
					$this->edit
				);
				backend_controller_template::display('request/success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Retourne les pages dans les autres langues de la page courante
	 * @param integer $edit
	 */
	private function json_other_language_page($edit){
		if(parent::s_child_lang_current_page($edit) != null){
				foreach (parent::s_child_lang_current_page($edit) as $s){
				switch($s['seo_title_page']){
						case null:
							$metatitle = 0;
						break;
						case !null:
							$metatitle = 1;
						break;
					}
					switch($s['seo_desc_page']){
						case null:
							$metadescription = 0;
						break;
						case !null:
							$metadescription = 1;
						break;
					}
					if($s['idcat_p'] != 0){
						$uricms = magixglobal_model_rewrite::filter_cms_url(
							$s['iso'], 
							$s['idcat_p'], 
							$s['uri_category'], 
							$s['idpage'], 
							$s['uri_page'],
							true
						);
					}else{
						$uricms = magixglobal_model_rewrite::filter_cms_url(
							$s['iso'], 
							null, 
							null, 
							$s['idpage'], 
							$s['uri_page'],
							true
						);
					}
					$search[]= '{"idrel_lang":'.json_encode($s['idrel_lang']).',"idpage":'.json_encode($s['idpage']).',"title_page":'.json_encode($s['title_page']).
					',"idcat_p":'.json_encode($s['idcat_p']).',"iso":'.json_encode($s['iso']).
					',"uricms":'.json_encode($uricms).',"uri_category":'.json_encode($s['uri_category']).
					',"seo_title_page":'.$metatitle.',"seo_desc_page":'.$metadescription.
					',"pseudo":'.json_encode($s['pseudo']).'}';
				}
				print '['.implode(',',$search).']';
			}
	}
	/**
	 * @access private
	 * Autocomplete des pages dans la langue sélectionnée
	 */
	private function json_cat_p_lang(){
		if(parent::s_cat_p_lang($this->title_p_lang,$this->getlang) != null){
			foreach(parent::s_cat_p_lang($this->title_p_lang,$this->getlang) as $value){
				$j[]= '{"id":'.json_encode($value['idpage']).',"value":'.json_encode($value['title_page']).'}';
			}
			print $this->callback.'(['.implode(',',$j).'])';
		}else{
			print $this->callback.'([{"id":"0","value":"Aucune valeur"}])';
		}
	}
	/**
	 * @access private
	 * Insertion d'une relation linguistique
	 * @param integer $idlang_p
	 */
	private function insert_new_rel_lang_p($idlang_p){
		if(isset($idlang_p)){
			$verify = parent::verify_rel_lang($this->edit, $idlang_p);
			if(empty($idlang_p)){
				backend_controller_template::display('request/empty.phtml');
			}elseif($verify['rel_lang_count'] == '1'){
				backend_controller_template::display('request/element-exist.phtml');
			}else{
				
				parent::i_new_rel_lang(
					$this->edit, 
					$idlang_p
				);
				backend_controller_template::display('request/success_conf.phtml');
			}
		}
	}
	/**
	 * Suppression d'une relation de langue
	 * @access private
	 */
	private function delete_related_lang(){
		if(isset($this->del_relang_p)){
			parent::d_rel_lang_p($this->del_relang_p);
		}
	}
	/**
	 * Suppression d'une relation de langue
	 * @access private
	 */
	private function delete_page(){
		if(isset($this->delpage)){
			$verify = parent::verify_idcat_p($this->delpage);
			if($verify['childpages'] == 0){
				parent::d_page($this->delpage);
			}else{
				backend_controller_template::display('cms/request/element-child-exist.phtml');
			}
		}
	}
	/**
	 * Execute Update AJAX FOR order
	 * @access private
	 *
	 */
	private function update_order_page(){
		if(isset($this->pageorderp)){
			$p = $this->pageorderp;
			for ($i = 0; $i < count($p); $i++) {
				parent::u_orderpage($i,$p[$i]);
			}
		}
	}
	/**
	 * @access private
	 * Modification du status d'une page CMS dans la sidebar
	 */
	private function update_sidebar_status(){
		if(isset($this->idpage) AND isset($this->sidebar_page)){
			parent::u_status_sidebar_page($this->sidebar_page, $this->idpage);
		}
	}
	/**
	 * @access private
	 * Retourne les pages CMS suivant la langue pour l'autocomplete
	 */
	private function json_parent_cat_p(){
		if(parent::s_parent_cat_p($this->title_p_move,$this->getlang) != null){
			foreach(parent::s_parent_cat_p($this->title_p_move,$this->getlang) as $value){
				$j[]= '{"id":'.json_encode($value['idpage']).',"value":'.json_encode($value['title_page']).'}';
			}
			print $this->callback.'(['.implode(',',$j).'])';
		}else{
			print $this->callback.'([{"id":"0","value":"Aucune valeur"}])';
		}
	}
	/**
	 * @access private
	 * Rechercher une page CMS via les titres et retourne sous forme JSON
	 */
	private function search_title_page(){
		if($this->post_search != ''){
			if(parent::r_search_cms_title($this->post_search) != null){
				foreach (parent::r_search_cms_title($this->post_search) as $s){
					switch($s['seo_title_page']){
						case null:
							$metatitle = 0;
						break;
						case !null:
							$metatitle = 1;
						break;
					}
					switch($s['seo_desc_page']){
						case null:
							$metadescription = 0;
						break;
						case !null:
							$metadescription = 1;
						break;
					}
					if($s['idcat_p'] != 0){
						$uricms = magixglobal_model_rewrite::filter_cms_url(
							$s['iso'], 
							$s['idcat_p'], 
							$s['uri_category'], 
							$s['idpage'], 
							$s['uri_page'],
							true
						);
					}else{
						$uricms = magixglobal_model_rewrite::filter_cms_url(
							$s['iso'], 
							null, 
							null, 
							$s['idpage'], 
							$s['uri_page'],
							true
						);
					}
					$search[]= '{"idpage":'.json_encode($s['idpage']).',"title_page":'.json_encode($s['title_page']).
					',"idcat_p":'.json_encode($s['idcat_p']).',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($s['iso'])).
					',"uricms":'.json_encode($uricms).',"uri_category":'.json_encode($s['uri_category']).
					',"seo_title_page":'.$metatitle.',"seo_desc_page":'.$metadescription.
					',"pseudo":'.json_encode($s['pseudo']).'}';
				}
				print '['.implode(',',$search).']';
			}
		}
	}
	/**
	 * @access private
	 * Requête JSON pour les statistiques du CMS
	 */
	private function json_google_chart(){
		if(parent::count_lang_parent_p() != null){
			foreach (parent::count_lang_parent_p() as $s){
				$rowParent[]= $s['parent_p_count'];
			}
		}else{
			$rowParent = array(0);
		}
		if(parent::count_lang_child_p() != null){
			foreach (parent::count_lang_child_p() as $s){
				$rowChild[]= $s['child_p_count'];
			}
		}else{
			$rowChild = array(0);
		}
		if(parent::s_iso_lang() != null){
			foreach (parent::s_iso_lang() as $s){
				$rowLang[]= json_encode(magixcjquery_string_convert::upTextCase($s['iso']));
			}
		}else{
			$rowLang = array(0);
		}
		if(parent::count_related_lang() != null){
			foreach (parent::count_related_lang() as $s){
				$relatedLang[]= $s['rel_lang_child'];
			}
		}else{
			$relatedLang = array(0);
		}
		print '{"parent_p_count":['.implode(',',$rowParent).'],"child_p_count":['.implode(',',$rowChild).'],"rel_lang_child":['.implode(',',$relatedLang).'],"lang":['.implode(',',$rowLang).']}';
	}
	/**
	 * @access private
	 * Charge les données pour le déplacement d'une page CMS
	 * @param integer $movepage
	 */
	protected function load_data_move_page($movepage){
		$db = parent::s_edit_page($movepage);
			backend_controller_template::assign('idpage', $db['idpage']);
			backend_controller_template::assign('title_page', $db['title_page']);
			backend_controller_template::assign('iso', $db['iso']);
			backend_controller_template::assign('uri_page', $db['uri_page']);
			backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
	}
	/**
	 * @access private
	 * Modifie l'emplacement d'une page CMS
	 */
	protected function update_move_page(){
		if(isset($this->idlang) AND isset($this->movepage)){
			$verify = parent::verify_idcat_p($this->movepage);
			if($verify['childpages'] == '0'){
				if($this->idcat_p != null){
				$idcat_p = $this->idcat_p;
				}else{
					$idcat_p = 0;
				}
				parent::u_move_page($this->idlang, $idcat_p, $this->movepage);
				backend_controller_template::display('request/success_conf.phtml');
			}else{
				backend_controller_template::display('cms/request/element-child-exist.phtml');
			}
		}
	}
	/**
	 * execute la fonction run pour l'administration CMS
	 * @access public 
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('getlang')){
			if(magixcjquery_filter_request::isGet('json_page_p')){
				$this->json_parent_p();
			}elseif(magixcjquery_filter_request::isGet('title_p_lang')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_cat_p_lang();
			}elseif(magixcjquery_filter_request::isGet('title_p_move')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_parent_cat_p();
			}elseif(magixcjquery_filter_request::isGet('get_page_p')){
				if(magixcjquery_filter_request::isGet('json_child_p')){
					$this->json_child_page();
				}elseif(magixcjquery_filter_request::isPost('idcat_p')){
					$this->insert_new_child_page($this->title_page,$this->idlang);
				}else{
					backend_controller_template::assign('parent_page',$this->parent_page($this->get_page_p));
					backend_controller_template::assign('language', $this->parent_language($this->getlang));
					backend_controller_template::display('cms/child_page.phtml');	
				}
			}else{
				backend_controller_template::assign('selectlang',null);
				backend_controller_template::assign('language', $this->parent_language($this->getlang));
				backend_controller_template::display('cms/parent_page.phtml');
			}
		}elseif(magixcjquery_filter_request::isGet('add_parent_p')){
			$this->insert_new_page_p($this->title_page,$this->idlang);
		}elseif(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isPost('idlang_p')){
				$this->insert_new_rel_lang_p($this->idlang_p);
			}elseif(magixcjquery_filter_request::isPost('title_page')){
				$this->update_page($this->title_page);
			}elseif(magixcjquery_filter_request::isPost('del_relang_p')){
				$this->delete_related_lang();
			}elseif(magixcjquery_filter_request::isGet('load_json_uri_cms')){
				$this->load_json_uri_cms($this->edit);
			}elseif(magixcjquery_filter_request::isGet('json_child_lang_page')){
				$this->json_other_language_page($this->edit);
			}else{
				$this->load_edit_page($this->edit);
				backend_controller_template::display('cms/edit.phtml');
			}
		}elseif(magixcjquery_filter_request::isGet('movepage')){
			if(magixcjquery_filter_request::isPost('idlang')){
				$this->update_move_page();
			}else{
				$this->load_data_move_page($this->movepage);
				backend_controller_template::display('cms/movepage.phtml');
			}
		}elseif(magixcjquery_filter_request::isGet('get_search_page')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			self::search_title_page();
		}elseif(magixcjquery_filter_request::isPost('delpage')){
			$this->delete_page();
		}elseif(magixcjquery_filter_request::isPost('idpage')){
			$this->update_sidebar_status();
		}elseif(magixcjquery_filter_request::isGet('order_page')){
			$this->update_order_page();
		}else{
			if(magixcjquery_filter_request::isGet('json_google_chart_pages')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_google_chart();
			}else{
				backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
				backend_controller_template::display('cms/index.phtml');
			}
		}
	}
}