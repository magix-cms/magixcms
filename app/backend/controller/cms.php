<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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
	}
	/**
	 * Voir les catégories disponible
	 */
	private function view_category(){
		$category = null;
		foreach(backend_db_cms::adminDbCms()->s_block_category() as $block){
			$category .= '<li class="ui-state-default" id="ordercategory_'.$block['idcategory'].'">';
			$category .= '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
			$category .= '<div class="sortdivfloat">'.$block['category'].'</div>';
			$category .= '<div style="float:right;"><a style="float:left;" class="ucms-category" href="#" title="'.$block['idcategory'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
			$category .= '<a class="aspanfloat dcmscat" href="#" title="'.$block['idcategory'].'"><span class="ui-icon ui-icon-close"></span></a>';
			$category .= '</div>';
			$category .= '</li>';
		}
		return $category;
	}
	/**
	 * Insérer une nouvelle catégorie
	 */
	public function insertion_category(){
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
			'/admin/index.php?dashboard&amp;cms&amp;',
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
	public function insert_new_page(){
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
		foreach(backend_db_cms::adminDbCms()->s_cms_navigation() as $nav){
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
			$page .= '<li class="ui-state-default" id="orderpage_'.$nav['idpage'].'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$nav['subjectpage'].'<div style="float:right;"><span class="ui-icon ui-icon-flag"></span>'.$nav['codelang'].'</div>'.'</li>';
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
	public function executeOrderCategory(){
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
	public function executeOrderPage(){
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
		/*$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
		switch($data['idcategory']){
				case 0:
					$catpath = null;
				break;
				default: 
					$catpath = 'getidcategory='.$data['idcategory'].'&amp;getcat='.$data['pathcategory'].'&amp;';
				break;
			}*/
		$uri = magixglobal_model_rewrite::filter_cms_url($data['codelang'],$data['idcategory'],$data['pathcategory'],$data['idpage'],$data['pathpage']);
		//magixcjquery_html_helpersHtml::getUrl().'/index.php?'.$islang.$catpath.'getidpage='.$data['idpage'].'&amp;'.'getpurl='.$data['pathpage']
		backend_config_smarty::getInstance()->assign('view',$uri);
	}
/**
	 * mise à jour d'une page
	 * @access private
	 */
	public function update_page(){
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
	 * Affiche la pop-pup pour l'édition d'une catégorie cms
	 * @access public
	 */
	public function edit_category_cms(){
		if(isset($this->ucategory)){
			$category = backend_db_cms::adminDbCms()->s_cms_category_id($this->ucategory);
			backend_config_smarty::getInstance()->assign('category',$category['category']);
			if(isset($this->update_category)){
				backend_db_cms::adminDbCms()->u_cms_category($this->update_category,$this->update_pathcategory,$this->ucategory);
			}
		}
		backend_config_smarty::getInstance()->display('cms/editcategory.phtml');
	}
	/**
	 * Supprime une catégorie CMS
	 * @access public
	 */
	public function delete_category_cms(){
		if(isset($this->dcmscat)){
			backend_db_cms::adminDbCms()->d_cms_category($this->dcmscat);
		}
	}
	/**
	 * Suppression d'une page CMS
	 * @access public
	 */
	public function delete_page_cms(){
		if(isset($this->delpage)){
			backend_db_cms::adminDbCms()->d_cms_page($this->delpage);
		}
	}
	/**
	 * Affiche l'edition d'une page CMS
	 * @access public
	 */
	public function display_edit_page(){
		self::load_data_cms_forms();
		//self::update_page();
		backend_config_smarty::getInstance()->display('cms/editpage.phtml');
	}
	/**
	 * Affiche la page de modification de menu
	 * @access public
	 */
	public function display_navigation(){
		self::update_viewpage();
		backend_config_smarty::getInstance()->assign('navorder',self::navigation_order());
		backend_config_smarty::getInstance()->assign('navconstruct',self::navigation_construct());
		backend_config_smarty::getInstance()->display('cms/navigation.phtml');
	}
	/**
	 * Affiche la page d'insertion d'une page
	 * @access public
	 */
	public function display_page(){
		backend_config_smarty::getInstance()->assign('selectcategory',self::select_category());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('cms/add.phtml');
	}
	/**
	 * Affiche la page des catégories et statistiques
	 * @access public
	 */
	public function display_category(){
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
	function display_view(){
		backend_config_smarty::getInstance()->display('cms/index.phtml');
	}
}