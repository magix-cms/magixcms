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
 * @version    4.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name CMS
 *
 */
class backend_controller_cms{
	/**
	 * 
	 * @var string
	 */
	public $category;
	/**
	 * 
	 * @var string
	 */
	public $pathcategory;
	/**
	 * 
	 * @var intégrer
	 */
	public $idcategory;
	/**
	 * 
	 * @var intégrer
	 */
	public $idlang;
	/**
	 * 
	 * @var string
	 */
	public $pathpage;
	/**
	 * 
	 * @var string
	 */
	public $subjectpage;
	/**
	 * 
	 * @var string
	 */
	public $contentpage;
	/**
	 * 
	 * @var string
	 */
	public $metatitle;
	/**
	 * 
	 * @var string
	 */
	public $metadescription;
	/**
	 * 
	 * @var integer
	 */
	public $idpage;
	/**
	 * 
	 * @var integer
	 */
	public $viewpage;
	/**
	 * modifie l'ordre des pages
	 * @var orderpage
	 * integer
	 */
	public $orderpage;
	/**
	 * 
	 * @var editcms
	 * integer
	 */
	public $editcms;
	/**
	* @var delpage
	 * integer
	 */
	public $delpage;
	/**
	 * ucategory
	 * @var intéger
	 */
	public $ucategory;
	/**
	 * Mise à jour d'une catégorie (cms)
	 * @var update_category
	 * string
	 */
	public $update_category;
	/**
	 * Mise à jour du lien d'une catégorie (cms)
	 * @var update_pathcategory
	 * string
	 */
	public $update_pathcategory;
	/**
	 * Suppression d'une catégorie dans le CMS
	 * string
	 * @var dcmscat
	 */
	public $dcmscat;
	public $post_search;
	public $get_search_page;
	public $selidlang;
	/**
	 * déplacement d'une page
	 * @var movepage
	 */
	public $movepage;
	/**
	 * function construct class
	 */
	function __construct(){
		/***
		 * POST une catégorie avec le lien bien formé
		 */
		if(isset($_POST['category'])){
			$this->category = magixcjquery_form_helpersforms::inputClean($_POST['category']);
			$this->pathcategory = magixcjquery_url_clean::rplMagixString($_POST['category'],true);
		}
		if(isset($_POST['update_category'])){
			$this->update_category = magixcjquery_form_helpersforms::inputClean($_POST['update_category']);
			$this->update_pathcategory = magixcjquery_url_clean::rplMagixString($_POST['update_category'],true);
		}
		if(isset($_POST['subjectpage'])){
			$this->subjectpage = magixcjquery_form_helpersforms::inputClean($_POST['subjectpage']);
			$this->pathpage = magixcjquery_url_clean::rplMagixString($_POST['subjectpage'],true);
		}
		if(isset($_POST['contentpage'])){
			$this->contentpage = (string) ($_POST['contentpage']);
		}
		if(isset($_POST['idlang'])){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(isset($_POST['idcategory'])){
			$this->idcategory = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idcategory']);
		}
	   if(magixcjquery_filter_request::isGet('page')) {
				// si numéric
		      if(is_numeric($_GET['page'])){
		          $this->getpage = intval($_GET['page']);
		      }else{
		      	// Sinon retourne la première page
		          $this->getpage = 1;        
		           }
		 }else {
		    $this->getpage = 1;
		}
		if(isset($_SESSION['useradmin'])){
			$this->useradmin = $_SESSION['useradmin'];
		}
		if(isset($_POST['metatitle'])){
			$this->metatitle = magixcjquery_form_helpersforms::inputTagClean($_POST['metatitle']);
		}
		if(isset($_POST['metadescription'])){
			$this->metadescription = magixcjquery_form_helpersforms::inputTagClean($_POST['metadescription']);
		}
		if(isset($_POST['viewpage'])){
			$this->viewpage = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['viewpage']);
		}
		if(isset($_POST['orderpage'])){
			$this->orderpage = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['orderpage']);
		}
		if(isset($_POST['idpage'])){
			$this->idpage = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idpage']);
		}
		if(isset($_GET['editcms'])){
			$this->editcms = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['editcms']);
		}
		if(isset($_GET['delpage'])){
			$this->delpage = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delpage']);
		}
		/**
		 * Requête get pour la modification d'une catégorie
		 */
		if(isset($_GET['ucategory'])){
			$this->ucategory = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['ucategory']);
		}
		/**
		 * Requête get pour la suppression d'une catégorie
		 */
		if(isset($_GET['dcmscat'])){
			$this->dcmscat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dcmscat']);
		}
		if(isset($_POST['post_search'])){
			$this->post_search = magixcjquery_form_helpersforms::inputClean($_POST['post_search']);
		}
		if(isset($_GET['get_search_page'])){
			$this->get_search_page = magixcjquery_form_helpersforms::inputClean($_GET['get_search_page']);
		}
		if(magixcjquery_filter_request::isGet('idlang')){
			$this->selidlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['idlang']);
		}
		if(magixcjquery_filter_request::isGet('movepage')){
			$this->movepage = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['movepage']);
		}
	}
	/**
	 * Voir les catégories disponible
	 */
	private function view_category(){
		$category = null;
		foreach(backend_db_cms::adminDbCms()->s_block_category() as $block){
			if($block['codelang'] != null){
				$langspan = '<span class="lfloat">'.$block['codelang'].'</span>';
			}else{
				$langspan = '<span class="lfloat ui-icon ui-icon-flag"></span>';
			}
			$category .= '<li class="ui-state-default" id="ordercategory_'.$block['idcategory'].'">';
			$category .= '<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>';
			$category .= '<div class="sortdivfloat">'.$block['category'].'</div>';
			$category .= '<div style="float:right;">'.$langspan.'<a style="float:left;" class="ucms-category" href="#" title="'.$block['idcategory'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
			$category .= '<a class="aspanfloat dcmscat" href="#" title="'.$block['idcategory'].'"><span class="ui-icon ui-icon-close"></span></a>';
			$category .= '</div>';
			$category .= '</li>';
		}
		return $category;
	}
	/**
	 * Insérer une nouvelle catégorie
	 */
	private function insertion_category(){
		if(isset($this->category)){
			if(empty($this->category)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
				backend_db_cms::adminDbCms()->i_category($this->category,$this->pathcategory,$this->idlang);
				backend_config_smarty::getInstance()->display('request/scategory.phtml');
			}
		}
	}
	/**
	 * Affiche les statistique des catégories
	 */
	private function statistic_category(){
		$states = '<table class="clear">
						<thead>
							<tr>
							<th>Nbr catégories</th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_cms::adminDbCms()->s_count_category() as $cp){
			$states .= '<tr class="line">';
		 	$states .= '<td class="nowrap">'.$cp['countcat'].'</td>';
		 	$states .= '<td class="nowrap">'.$cp['codelang'].'</td>';
		 	$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * Affiche les statistiques des pages par catégorie
	 */
	private function block_statistique(){
		$states = '<table class="clear">
						<thead>
							<tr>
							<th>Nbr pages</th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_cms::adminDbCms()->statistic_category_page() as $cp){
			$states .= '<tr class="line">';
		 	$states .= '<td class="nowrap">'.$cp['cat'].'</td>';
		 	$states .= '<td class="nowrap">'.$cp['codelang'].'</td>';
		 	$states .= '</tr>';
		}
		$states .= '</tbody></table>';
		return $states;
	}
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	public function cms_offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * pagination for CMS
	 * @param $max
	 */
	public function cms_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = backend_db_cms::adminDbCms()->s_count_cms_pager_max();
		return $pagination->pagerData(
			$request,'total',
			$max,
			$this->getpage,
			'/admin/cms.php?',
			false,
			false,
			'page'
		);
	}
	/**
	 * Construction du select pour les catégories
	 */
	private function select_category(){
		//SELECT ordonnées pour detecter le changement de section
		$admindb = backend_db_cms::adminDbCms()->s_block_category();
		$lang = '';
		$category = '<select id="idcategory" name="idcategory" class="select">';
		$category .='<option value="0">Aucune catégorie</option>';
		foreach ($admindb as $row){
			//si codelang pas = à $lang
			if ($row['codelang'] != $lang) {
			       if ($lang != '') { $category .= "</optgroup>\n"; }
			       $category .= '<optgroup label="'.$row['codelang'].'">';
			}
			$category .= '<option value="'.$row['idcategory'].'">'.$row['category'].'</option>';
			$lang = $row['codelang'];
		}
		if ($lang != '') { $category .= "</optgroup>\n"; }
		$category .='</select>';
		return $category;
	}
	/**
	 * insertion d'une nouvelle page
	 * @access private
	 */
	private function insert_new_page(){
		// Verifier que le module exist
		$modexist = backend_db_config::adminDbConfig()->s_limited_module_exist();
		// Sélectionne le nombre de limitation de page par module
		$module = backend_db_config::adminDbConfig()->s_config_number_module();
		if(isset($this->subjectpage) AND isset($this->contentpage)){
			if(empty($this->subjectpage) OR empty($this->contentpage)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}elseif($modexist['idconfig'] != null){
				// Si le module existe
				// Si le nombre est plus grand que zero
				if($module['number'] != 0){
					$cpage = backend_db_cms::adminDbCms()->s_count_cms_max();
					if($cpage['total'] >= $module['number']){
						//Si le nombre maximal de page est atteint
						backend_config_smarty::getInstance()->display('request/maxpage.phtml');
					}else{
						backend_db_cms::adminDbCms()->i_news_page(
							$this->subjectpage,
							$this->pathpage,
							$this->contentpage,
							$this->idcategory,
							$this->idlang,
							backend_model_member::s_idadmin(),
							$this->metatitle,
							$this->metadescription
						);
						backend_config_smarty::getInstance()->display('request/success.phtml');
					}
				}else{
					// Sinon on insére
					backend_db_cms::adminDbCms()->i_news_page(
						$this->subjectpage,
						$this->pathpage,
						$this->contentpage,
						$this->idcategory,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->metatitle,
						$this->metadescription
					);
					backend_config_smarty::getInstance()->display('request/success.phtml');
				}
			}
		}
	}
	/**
	 * Construction du menu avec les éléments choisi
	 * @access private
	 */
	private function navigation_construct(){
		$form = '';
		foreach(backend_db_cms::adminDbCms()->s_cms_form_navigation() as $nav){
			$active = $nav['viewpage'] == 1 ? 'checked="checked"': null;
			$noactive = $nav['viewpage'] == 0 ? 'checked="checked"': null;
			$form .= '<form class="forms-cms-navigation" id="forms-cms-navigation_'.$nav['orderpage'].'" method="post" action="">
				<fieldset>
					<table>
						<tr>
							<td style="width:60%;">'.$nav['subjectpage'].'</td>
							<td style="width:100px;">
								<input type="hidden" name="idpage" value="'.$nav['idpage'].'" />
								Activer <input type="radio" name="viewpage" '.$active.' value="1" />
							</td>
							<td style="width:100px;">
								Désactiver <input type="radio" name="viewpage" '.$noactive.' value="0" />
							</td>
						</tr>
					</table>
				</fieldset>
			</form>';
		}
		return $form;
	}
	/**
	 * Affiche le menu "sortable" avec les éléments de pages
	 * @access private
	 */
	private function navigation_order(){
		$page = null;
		foreach(backend_db_cms::adminDbCms()->s_cms_navigation() as $nav){
			$page .= '<li class="ui-state-default" id="orderpage_'.$nav['idpage'].'"><span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'.$nav['subjectpage'].'<div style="float:right;">'.$nav['codelang'].'</div>'.'</li>';
		}
		return $page;
	}
	/**
	 * Mise à jour de l'élément afficher/cacher une page du menu
	 * @access private
	 */
	private function update_viewpage(){
		if(isset($this->viewpage)){
			backend_db_cms::adminDbCms()->u_viewpage($this->viewpage,$this->idpage);
		}
	}
	/**
	 * Execute Update AJAX FOR order category
	 * @access private
	 *
	 */
	private function executeOrderCategory(){
		if(isset($_POST['ordercategory'])){
			$p = $_POST['ordercategory'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_cms::adminDbCms()->u_ordercategory($i,$p[$i]);
			}
		}
	}
	/**
	 * Execute Update AJAX FOR order page
	 * Modifie l'ordre des pages
	 * @access private
	 *
	 */
	private function executeOrderPage(){
		if(isset($_POST['orderpage'])){
			$p = $_POST['orderpage'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_cms::adminDbCms()->u_orderpage($i,$p[$i]);
			}
		}
	}
	/**
	 * Charge les données à mettre à jour dans le formulaire
	 * @access private
	 */
	private function load_data_cms_forms(){
		$data = backend_db_cms::adminDbCms()->s_data_forms($this->editcms);
		backend_config_smarty::getInstance()->assign('subjectpage',$data['subjectpage']);
		backend_config_smarty::getInstance()->assign('contentpage',$data['contentpage']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('idcategory',$data['idcategory']);
		backend_config_smarty::getInstance()->assign('category',$data['category']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		backend_config_smarty::getInstance()->assign('metatitle',$data['metatitle']);
		backend_config_smarty::getInstance()->assign('metadescription',$data['metadescription']);
		$uri = magixglobal_model_rewrite::filter_cms_url($data['codelang'],$data['idcategory'],$data['pathcategory'],$data['idpage'],$data['pathpage'],true);
		backend_config_smarty::getInstance()->assign('view',$uri);
	}
	private function load_data_cms_move(){
		$data = backend_db_cms::adminDbCms()->s_data_forms($this->movepage);
		backend_config_smarty::getInstance()->assign('idpage',$data['idpage']);
		backend_config_smarty::getInstance()->assign('subjectpage',$data['subjectpage']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('idcategory',$data['idcategory']);
		backend_config_smarty::getInstance()->assign('category',$data['category']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
	}
	/**
	 * mise à jour d'une page
	 * @access private
	 */
	private function update_page(){
		if(isset($this->subjectpage) AND isset($this->contentpage)){
			if(empty($this->subjectpage) OR empty($this->contentpage)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
				backend_db_cms::adminDbCms()->u_cms_page(
						$this->subjectpage,
						$this->pathpage,
						$this->contentpage,
						$this->idcategory,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->metatitle,
						$this->metadescription,
						$this->editcms
					);
				backend_config_smarty::getInstance()->display('request/success.phtml');
			}
		}
	}
	/**
	 * effectue la requête d'édition de la catégorie
	 * @access private
	 */
	private function update_category_cms(){
		if(isset($this->ucategory)){
			if(isset($this->update_category)){
				backend_db_cms::adminDbCms()->u_cms_category($this->update_category,$this->update_pathcategory,$this->ucategory);
				backend_config_smarty::getInstance()->display('request/update-category.phtml');
			}
		}
	}
	/**
	 * Affiche la pop-pup pour l'édition d'une catégorie cms
	 * @access private
	 */
	private function edit_category_cms(){
		if(isset($this->ucategory)){
			$category = backend_db_cms::adminDbCms()->s_cms_category_id($this->ucategory);
			backend_config_smarty::getInstance()->assign('category',$category['category']);
		}
		backend_config_smarty::getInstance()->display('cms/editcategory.phtml');
	}
	/**
	 * Supprime une catégorie CMS
	 * @access private
	 */
	private function delete_category_cms(){
		if(isset($this->dcmscat)){
			backend_db_cms::adminDbCms()->d_cms_category($this->dcmscat);
		}
	}
	/**
	 * Suppression d'une page CMS
	 * @access private
	 */
	private function delete_page_cms(){
		if(isset($this->delpage)){
			backend_db_cms::adminDbCms()->d_cms_page($this->delpage);
		}
	}
	/**
	 * 
	 * Rechercher une page CMS dans les titres
	 */
	private function search_title_page(){
		if($this->post_search != ''){
			if(backend_db_cms::adminDbCms()->r_search_cms_title($this->post_search) != null){
				foreach (backend_db_cms::adminDbCms()->r_search_cms_title($this->post_search) as $s){
					$uricms = magixglobal_model_rewrite::filter_cms_url(
						$s['codelang'], 
						$s['idcategory'], 
						$s['pathcategory'], 
						$s['idpage'], 
						$s['pathpage'],
						true
					);
					$search[]= '{"idpage":'.json_encode($s['idpage']).',"subjectpage":'.json_encode($s['subjectpage']).
					',"idcategory":'.json_encode($s['idcategory']).',"codelang":'.json_encode($s['codelang']).
					',"uricms":'.json_encode($uricms).',"category":'.json_encode($s['category']).
					',"metatitle":'.json_encode($s['metatitle']).',"metadescription":'.json_encode($s['metadescription']).
					',"pseudo":'.json_encode($s['pseudo']).'}';
				}
				print '['.implode(',',$search).']';
			}
		}
	}
	/**
	 * @category json request
	 * @access private
	 * Requête json pour le chargement des catégories associé à une langue
	 */
	private function json_category(){
		if(backend_db_cms::adminDbCms()->s_json_category($this->selidlang) != null){
			foreach (backend_db_cms::adminDbCms()->s_json_category($this->selidlang) as $list){
				//if($list['idlang'] != 0){
					$subcat[]= json_encode($list['idcategory']).':'.json_encode($list['category']);
				/*}else{
					$subcat[] = json_encode("0").':'.json_encode("Aucune catégorie");
				}*/
			}
			print '{'.implode(',',$subcat).'}';
		}else{
			print '{"0":"Aucune catégorie"}';
		}
	}
	/**
	 * Déplace d'une page CMS
	 */
	private function move_specific_page(){
		if(isset($this->movepage)){
				backend_db_cms::adminDbCms()->u_cms_page_move(
					$this->idlang,
					$this->idcategory,
					backend_model_member::s_idadmin(),
					$this->movepage
				);
			backend_config_smarty::getInstance()->display('request/move.phtml');
		}
	}
	/**
	 * Affiche l'edition d'une page CMS
	 * @access private
	 */
	private function display_edit_page(){
		self::load_data_cms_forms();
		//self::update_page();
		backend_config_smarty::getInstance()->display('cms/editpage.phtml');
	}
	/**
	 * Affiche la page de modification de menu
	 * @access private
	 */
	private function display_navigation(){
		self::update_viewpage();
		backend_config_smarty::getInstance()->assign('navorder',self::navigation_order());
		backend_config_smarty::getInstance()->assign('navconstruct',self::navigation_construct());
		backend_config_smarty::getInstance()->display('cms/navigation.phtml');
	}
	/**
	 * Affiche la page d'insertion d'une page
	 * @access private
	 */
	private function display_page(){
		backend_config_smarty::getInstance()->assign('selectcategory',self::select_category());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('cms/add.phtml');
	}
	/**
	 * Affiche le déplacement d'une page CMS
	 * @access public
	 */
	private function display_move_page(){
		self::load_data_cms_move();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('cms/movepage.phtml');
	}
	/**
	 * Affiche la page des catégories et statistiques
	 * @access private
	 */
	private function display_category(){
		backend_config_smarty::getInstance()->assign('states_category',self::statistic_category());
		backend_config_smarty::getInstance()->assign('block_cms_statistic',self::block_statistique());
		backend_config_smarty::getInstance()->assign('block_category',self::view_category());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('cms/category.phtml');
	}
	/**
	 * Affiche la page de vue global
	 * @access public
	 */
	private function display_view(){
		backend_config_smarty::getInstance()->display('cms/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('add')){
			if(magixcjquery_filter_request::isGet('post')){
				self::insert_new_page();
			}elseif(magixcjquery_filter_request::isGet('json')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				self::json_category();
			}else{
				self::display_page();
			}
		}elseif(magixcjquery_filter_request::isGet('editcms')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_page();
			}else{
				self::display_edit_page();
			}
		}elseif(magixcjquery_filter_request::isGet('movepage')){
			if(magixcjquery_filter_request::isGet('postmovepage')){
				self::move_specific_page();
			}else{
				self::display_move_page();
			}
		}elseif(magixcjquery_filter_request::isGet('navigation')){
			self::display_navigation();
		}elseif(magixcjquery_filter_request::isGet('delpage')){
			self::delete_page_cms();
		}elseif(magixcjquery_filter_request::isGet('orderajax')){
			self::executeOrderCategory();
			self::executeOrderPage();
		}elseif(magixcjquery_filter_request::isGet('category')){
			if(magixcjquery_filter_request::isGet('post')){
				self::insertion_category();
			}else{
				self::display_category();
			}
		}elseif(magixcjquery_filter_request::isGet('ucategory')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_category_cms();
			}else{
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->html_header("UTF-8");
				self::edit_category_cms();
			}
		}elseif(magixcjquery_filter_request::isGet('dcmscat')){
			self::delete_category_cms();
		}elseif(magixcjquery_filter_request::isGet('get_search_page')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			self::search_title_page();
		}else{
			self::display_view();
		}
	}
}