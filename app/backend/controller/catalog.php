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
 * @version    3.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name catalog
 *
 */
class backend_controller_catalog extends analyzer_catalog{
	/**
	 * ####### Categorie et sous categorie ########
	 */
	/**
	 * libelle de la catégorie
	 * @var clibelle
	 */
	public $clibelle;
	/**
	 * Url sur base du libelle de la catégorie
	 * @var pathclibelle
	 */
	public $pathclibelle;
	/**
	 * Modification de l'ordre des catégories
	 * @var corder
	 */
	public $corder;
	/**
	 * 
	 * Contenu texte de la catégorie
	 * @var $c_content
	 */
	public $c_content;
	/**
	 * libelle de la sous catégorie
	 * @var slibelle
	 */
	public $slibelle;
	/**
	 * Url sur base du libelle de la sous catégorie
	 * @var pathslibelle
	 */
	public $pathslibelle;
	/**
	 * 
	 * Contenu texte de la catégorie
	 * @var $c_content
	 */
	public $s_content;
	/**
	 * Modification de l'ordre des sous catégories
	 * @var sorder
	 */
	public $sorder;
	/**
	 * get pour la requête json des sous catégories d'une catégorie
	 * @var string
	 */
	public $getidclc;
	/**
	 * get pour la requête json des produits d'une catégorie
	 * @var string
	 */
	public $prodcorder;
	/**
	 * get pour la requête json des produits d'une sous catégorie
	 * @var string
	 */
	public $prodsorder;
	/*
	 * ####### Fiche produit ########
	 */
	/**
	 * identifiant de la langue
	 * @var lang
	 */
	public $idlang;
	/**
	 * URL du produit
	 * @var urlcatalog
	 */
	public $urlcatalog;
	/**
	 * titre ou nom du produit
	 * @var titlecatalog
	 */
	public $titlecatalog;
	/**
	 * description du produit
	 * @var desccatalog
	 */
	public $desccatalog;
	/**
	 * prix du produit
	 * @var prix
	 */
	public $price;
	/**
	 * iddentifiant de l'ordre des produits
	 * @var ordercatalog
	 */
	public $ordercatalog;
	/**
	 * edition d'un produit
	 * @var editproduct
	 */
	public $editproduct;
	/**
	 * déplacement d'un produit
	 * @var moveproduct
	 */
	public $moveproduct;
	/**
	 * copie d'un produit
	 * @var copyproduct
	 */
	public $copyproduct;
	/**
	 * edition d'une catégorie
	 * @var editclc
	 */
	public $editclc;
	/**
	 * edition d'une sous catégorie
	 * @var editcls
	 */
	public $editcls;
	// Liaison de produit aux catégories
	/**
	 * identifiant de la catégorie
	 * @var $idclc
	 */
	public $idclc;
	/**
	 * identifiant de la sous catégorie
	 * @var $idclc
	 */
	public $idcls;
	/**
	 * ############## Envoi de l'image lié au produit #############
	 */
	/**
	 * post identifiant du catalog
	 * @var idcatalog
	 */
	public $idcatalog;
	/**
	 * image du produit
	 * @var imgcatalog
	 */
	public $imgcatalog;
	/**
	 * image due la galerie
	 * @var $imggalery
	 */
	public $imggalery;
	/**
	 * Image d'une catégorie
	 * @var img_c
	 */
	public $img_c;
	/**
	 * Modification d!une Image catégorie
	 * @var $update_img_c
	 */
	public $update_img_c;
	/**
	 * Image d'une sous catégorie
	 * @var img_c
	 */
	public $img_s;
	/**
	 * Modification d!une Image sous catégorie
	 * @var $update_img_c
	 */
	public $update_img_s;
	/**
	 * intéger
	 * @var 
	 */
	public $getimg;
	/**
	 * intéger
	 * @var 
	 */
	public $getgalery;
	/**
	 * pagination 
	 * @var getpage
	 */
	public $getpage;
	/**
	 * get product delete
	 * @var intéger
	 */
	public $delproduct;
	/**
	 * get sub category delete
	 * @var intéger
	 */
	public $dels;
	/**
	 * get category delete
	 * @var intéger
	 */
	public $delc;
	/**
	 * delete microgalery
	 * @var intéger
	 */
	public $delmicro;
	/**
	 * récupération de l'indentifiant d'une catégorie pour l'édition
	 * @var upcat
	 */
	public $upcat;
	/**
	 * post le changement de nom d'une catégorie
	 * @var string
	 */
	public $update_category;
	/**
	 * post le changement de l'url d'une catégorie
	 * @var string
	 */
	public $update_pathclibelle;
	/**
	 * récupération de l'indentifiant d'une sous catégorie pour l'édition
	 * @var upcat
	 */
	public $upsubcat;
	/**
	 * post le changement de nom d'une sous catégorie
	 * @var string
	 */
	public $update_subcategory;
	/**
	 * post le changement de l'url d'une sous catégorie
	 * @var string
	 */
	public $update_pathslibelle;
	/**
	 * 
	 * GET vers l'identifiant des catégories
	 * @var selidclc
	 */
	public $selidclc;
	/**
	 * 
	 * GT vers le résultat des produits html
	 * @var gethtmlprod
	 */
	public $gethtmlprod;
	/**
	 * 
	 * GET vers le résultat json des produits
	 * @var getjsonprod
	 */
	public $getjsonprod;
	/**
	 * 
	 * POST l'identifiant du produit
	 * @var idproduct
	 */
	public $idproduct;
	/**
	 * 
	 * GET vers l'identifiant du catalogue pour 
	 * récupérer l'url des produits de cette fiche
	 * @var geturicat
	 */
	public $geturicat;
	/**
	 * 
	 * GET vers l'identifiant du catalogue pour 
	 * récupérer l'url des produits de liaison de cette fiche
	 * @var getreluri
	 */
	public $getreluri;
	/**
	 * GET pour la suppression d'un produit
	 * @var d_in_product
	 */
	public $d_in_product;
	/**
	 * GET pour la suppression d'un produit lié
	 * @var d_in_product
	 */
	public $d_rel_product;
	public $post_search;
	public $get_search_page;
	/**
	 * @access public
	 * Constructor
	 */
	public function __construct(){
		if(magixcjquery_filter_request::isPost('clibelle')){
			$this->clibelle = (string) magixcjquery_form_helpersforms::inputClean($_POST['clibelle']);
			$this->pathclibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['clibelle'],true);
		}
		if(magixcjquery_filter_request::isPost('update_category')){
			$this->update_category = (string) magixcjquery_form_helpersforms::inputClean($_POST['update_category']);
			$this->update_pathclibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['update_category'],true);
		}
		if(magixcjquery_filter_request::isPost('slibelle')){
			$this->slibelle = (string) magixcjquery_form_helpersforms::inputClean($_POST['slibelle']);
			$this->pathslibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['slibelle'],true);
		}
		if(magixcjquery_filter_request::isPost('update_subcategory')){
			$this->update_subcategory = (string) magixcjquery_form_helpersforms::inputClean($_POST['update_subcategory']);
			$this->update_pathslibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['update_subcategory'],true);
		}
		if(magixcjquery_filter_request::isPost('c_content')){
			$this->c_content =(string) magixcjquery_form_helpersforms::inputCleanQuote($_POST['c_content']);
		}
		if(magixcjquery_filter_request::isPost('s_content')){
			$this->s_content =(string) magixcjquery_form_helpersforms::inputCleanQuote($_POST['s_content']);
		}
		if(magixcjquery_filter_request::isPost('idclc')){
			$this->idclc = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idclc']);
		}
		if(magixcjquery_filter_request::isPost('idcls')){
			$this->idcls = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idcls']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('titlecatalog')){
			$this->titlecatalog = (string) magixcjquery_form_helpersforms::inputClean($_POST['titlecatalog']);
			$this->urlcatalog = (string) magixcjquery_url_clean::rplMagixString($_POST['titlecatalog'],true);
		}
		if(magixcjquery_filter_request::isPost('desccatalog')){
			$this->desccatalog = (string) magixcjquery_form_helpersforms::inputCleanQuote($_POST['desccatalog']);
		}
		if(magixcjquery_filter_request::isPost('price')){
			$this->price = (integer) magixcjquery_filter_isVar::isPostFloat($_POST['price']);
		}
		if(magixcjquery_filter_request::isPost('ordercatalog')){
			$this->ordercatalog = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['ordercatalog']);
		}
		if(magixcjquery_filter_request::isGet('page')) {
				// si numéric
			if(magixcjquery_filter_isVar::isPostNumeric($_GET['page'])){
		    	$this->getpage =(integer) intval($_GET['page']);
		    }else{
		      	// Sinon retourne la première page
		        $this->getpage = 1;        
		        }
		}else {
		    $this->getpage = 1;
		}
		/*if(magixcjquery_filter_request::isGet('getidclc')) {
			$this->getidclc = (integer) magixcjquery_filter_isVar::isPostFloat($_GET['getidclc']);
		}*/
		/**
		 * Identifiant pour la suppression d'un catalogue !!!!
		 */
		if(magixcjquery_filter_request::isGet('delproduct')){
			$this->delproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delproduct']);
		}
		/**
		 * identifiant pour la suppression d'une sous catégorie
		 */
		if(magixcjquery_filter_request::isGet('dels')){
			$this->dels = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dels']);
		}
		/**
		 * identifiant pour la suppression d'une sous catégorie
		 */
		if(magixcjquery_filter_request::isGet('delc')){
			$this->delc = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delc']);
		}
		/**
		 * identifiant pour la suppression d'une image dans une galerie catalogue
		 */
		if(magixcjquery_filter_request::isGet('delmicro')){
			$this->delmicro = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delmicro']);
		}
		if(magixcjquery_filter_request::isGet('editproduct')){
			$this->editproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['editproduct']);
		}
		if(magixcjquery_filter_request::isGet('moveproduct')){
			$this->moveproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['moveproduct']);
		}
		if(magixcjquery_filter_request::isGet('copyproduct')){
			$this->copyproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['copyproduct']);
		}
		if(magixcjquery_filter_request::isGet('getimg')){
			$this->getimg = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getimg']);
		}
		if(magixcjquery_filter_request::isGet('getgalery')){
			$this->getgalery = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getgalery']);
		}
		if(isset($_FILES['imgcatalog']["name"])){
			$this->imgcatalog = magixcjquery_url_clean::rplMagixString($_FILES['imgcatalog']["name"]);
		}
		if(isset($_FILES['imggalery']["name"])){
			$this->imggalery = magixcjquery_url_clean::rplMagixString($_FILES['imggalery']["name"]);
		}
		if(isset($_FILES['img_c']["name"])){
			$this->img_c = magixcjquery_url_clean::rplMagixString($_FILES['img_c']["name"]);
		}
		if(isset($_FILES['update_img_c']["name"])){
			$this->update_img_c = magixcjquery_url_clean::rplMagixString($_FILES['update_img_c']["name"]);
		}
		if(isset($_FILES['img_s']["name"])){
			$this->img_s = magixcjquery_url_clean::rplMagixString($_FILES['img_s']["name"]);
		}
		if(isset($_FILES['update_img_s']["name"])){
			$this->update_img_s = magixcjquery_url_clean::rplMagixString($_FILES['update_img_s']["name"]);
		}
		/**
		 * URL pour édition d'une catégorie
		 */
		if(magixcjquery_filter_request::isGet('upcat')){
			$this->upcat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['upcat']);
		}
		/**
		 * URL pour édition d'une sous catégorie
		 */
		if(magixcjquery_filter_request::isGet('upsubcat')){
			$this->upsubcat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['upsubcat']);
		}
		if(magixcjquery_filter_request::isGet('idclc')){
			$this->selidclc = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
		}
		if(magixcjquery_filter_request::isGet('gethtmlprod')){
			$this->gethtmlprod = (string) magixcjquery_form_helpersforms::inputClean($_GET['gethtmlprod']);
		}
		if(magixcjquery_filter_request::isGet('getjsonprod')){
			$this->getjsonprod = (string) magixcjquery_form_helpersforms::inputClean($_GET['getjsonprod']);
		}
		if(magixcjquery_filter_request::isPost('idproduct')){
			$this->idproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idproduct']);
		}
		/**
		 * Identifiant de catalogue pour la construction de la fenêtre des URL produits (modal URL produits)
		 */
		if(magixcjquery_filter_request::isGet('geturicat')){
			$this->geturicat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['geturicat']);
		}
		/**
		 * Identifiant de catalogue pour la construction de la fenêtre des URL produits liées (modal URL produits liées)
		 */
		if(magixcjquery_filter_request::isGet('getreluri')){
			$this->getreluri = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getreluri']);
		}
		if(magixcjquery_filter_request::isGet('d_in_product')){
			$this->d_in_product = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['d_in_product']);
		}
		if(magixcjquery_filter_request::isGet('d_rel_product')){
			$this->d_rel_product = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['d_rel_product']);
		}
		/**
		 * Recherche de fiche catalogue
		 */
		if(isset($_POST['post_search'])){
			$this->post_search = magixcjquery_form_helpersforms::inputClean($_POST['post_search']);
		}
		if(isset($_GET['get_search_page'])){
			$this->get_search_page = magixcjquery_form_helpersforms::inputClean($_GET['get_search_page']);
		}
	}
	private function def_dirimg_frontend($pathupload){
		return magixglobal_model_system::base_path().$pathupload;
	}
	/**
	 * catalog_category_order
	 * Affiche le menu "sortable" avec les éléments de catégorie
	 * @access private
	 * @return string
	 */
	private function catalog_category_order(){
		$category = null;
		if(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder() != null){
			$category = '<ul id="sortcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder() as $cat){
				if($cat['codelang'] != null){
					$langspan = '<span class="lfloat">'.$cat['codelang'].'</span>';
				}else{
					$langspan = '<span class="lfloat ui-icon ui-icon-flag"></span>';
				}
				$category .= '<li class="ui-state-default" id="corder_'.$cat['idclc'].'">';
				$category .= '<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$category .= '<div class="sortdivfloat">'.$cat['clibelle'].'</div>';
				$category .= '<div style="float:right;">'.$langspan.'<a style="float:left;" href="/admin/catalog.php?upcat='.$cat['idclc'].'" title="'.$cat['idclc'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
				$category .= '<a class="aspanfloat delc" href="#" title="'.$cat['idclc'].'"><span class="ui-icon ui-icon-close"></span></a>';
				$category .= '</div>';
				$category .= '</li>';
			}
			$category .= '</ul>';
		}
		return $category;
	}
	/**
	 * @access private
	 * Construction du select pour les catégories
	 * @return string
	 */
	private function catalog_select_category(){
		//SELECT ordonnées pour detecter le changement de section
		$admindb = backend_db_catalog::adminDbCatalog()->s_catalog_category_select_construct();
		$lang = '';
		$category = '<select id="idclc" name="idclc" class="select">';
		$category .='<option value="0">Aucune catégorie</option>';
		foreach ($admindb as $row){
			//si codelang pas = à $lang
			if ($row['codelang'] != $lang) {
				if ($lang != '') { $category .= "</optgroup>\n"; }
			       $category .= '<optgroup label="'.$row['codelang'].'">';
			}
			$category .= '<option value="'.$row['idclc'].'">'.$row['clibelle'].'</option>';
			$lang = $row['codelang'];
		}
		if ($lang != '') { $category .= "</optgroup>\n"; }
		$category .='</select>';
		return $category;
	}
	/**
	 * @access private
	 * @return string
	 * Construction du menu select suivant la langue
	 */
	private function construct_select_category_lang(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->editproduct);
		$admindb =  backend_db_catalog::adminDbCatalog()->s_catalog_getlang_category_select($data['idlang']);
		$category = '<select id="idclc" name="idclc">';
		$category .='<option value="0">Aucune catégorie</option>';
		foreach ($admindb as $row){
			$category .= '<option value="'.$row['idclc'].'">'.$row['clibelle'].'</option>';
		}
		$category .='</select>';
		return $category;
	}
	/**
	 * @access private
	 * Execute Update AJAX FOR order category
	 * Post la requête ajax pour la modification de l'ordre des catégories
	 */
	private function executeOrderCategory(){
		if(isset($_POST['corder'])){
			$p = $_POST['corder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_catalog_category($i,$p[$i]);
			}
		}
	}
	/**
	 * product_in_category_order
	 * Affiche le menu "sortable" avec les produits de la catégorie
	 * @access private
	 * @return string
	 */
	private function product_in_category_order($upcat){
		$product = null;
		if(backend_db_catalog::adminDbCatalog()->s_product_in_category($upcat) != null){
			$product = '<ul id="sortproduct">';
			foreach(backend_db_catalog::adminDbCatalog()->s_product_in_category($upcat) as $cat){
				$product .= '<li class="ui-state-default" id="prodcorder_'.$cat['idproduct'].'">';
				$product .= '<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$product .= '<div class="sortdivfloat">'.$cat['titlecatalog'].'</div>';
				$product .= '<div style="float:right;">';
				$product .= '</div>';
				$product .= '</li>';
			}
			$product .= '</ul>';
		}
		return $product;
	}
	/**
	 * @access private
	 * Affiche le menu "sortable" avec les éléments des sous catégorie
	 */
	/*private function catalog_sub_category_order(){
		$category = null;
		if(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() != null){
			$category = '<ul id="sortsubcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() as $cat){
				if($cat['codelang'] != null){
					$lang = $cat['codelang'];
					$langspan = '<span class="lfloat">'.$cat['codelang'].'</span>';
				}else{
					$lang = 'default';
					$langspan = '<span class="lfloat ui-icon ui-icon-flag"></span>';
				}
				$category .= '<li title="'.$lang.'" class="ui-state-default" id="sorder_'.$cat['idcls'].'">';
				$category .= '<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$category .= '<div class="sortdivfloat">'.$cat['slibelle'].'</div>';
				$category .= '<span style="float:left;" class="ui-icon ui-icon-arrowthick-1-e"></span>';
				$category .= '<span style="font-style:italic;">'.$cat['clibelle'].'</span>';
				$category .= '<div style="float:right;">'.$langspan;
				$category .= '<a style="float:left;" href="/admin/catalog.php?upsubcat='.$cat['idcls'].'" title="'.$cat['idcls'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
				$category .= '<a class="aspanfloat dels" href="#" title="'.$cat['idcls'].'"><span class="ui-icon ui-icon-close"></span></a>';
				$category .= '</div></li>';
			}
			$category .= '</ul>';
		}
		return $category;
	}*/
	private function json_list_idcls($idclc){
		if(backend_db_catalog::adminDbCatalog()->s_json_subcategory($idclc) != null){
			foreach (backend_db_catalog::adminDbCatalog()->s_json_subcategory($idclc) as $list){
				$subcat[]= '{"idcls":'.json_encode($list['idcls']).',"slibelle":'.json_encode($list['slibelle']).'}';
			}
			print '['.implode(',',$subcat).']';
		}
	}
	/**
	 * Execute Update AJAX FOR order sub category
	 * Post la requête ajax pour la modification de l'ordre des sous catégories
	 *
	 */
	private function executeOrderSubCategory(){
		if(isset($_POST['sorder'])){
			$p = $_POST['sorder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_catalog_subcategory($i,$p[$i]);
			}
		}
	}
	/**
	 * @access private
	 * retourne le dossier des images catalogue des catégories
	 * @return string
	 */
	private function dir_img_category(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."category".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Insertion d'une image por la catégorie du catalogue
	 * @access private
	 * @return string
	 */
	private function insert_image_category($img,$pathclibelle,$img_c=null){
		if(isset($this->$img)){
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img($img,'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."category");
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				$fileextends = backend_model_image::image_analyze(self::dir_img_category().$this->$img);
				// Charge la classe pour renommer le fichier
				$makeFiles = new magixcjquery_files_makefiles();
				if (backend_model_image::imgSizeMin(self::dir_img_category().$this->$img,50,50)){
					if(file_exists(self::dir_img_category().$pathclibelle.$fileextends)){
						$makeFiles->removeFile(self::dir_img_category(),$img_c);
					}
					$makeFiles->renameFiles(self::dir_img_category(),self::dir_img_category().$this->$img,self::dir_img_category().$pathclibelle.$fileextends);
					/**
					 * Initialisation de la classe phpthumb 
					 * @var void
					 */
					$thumb = PhpThumbFactory::create(self::dir_img_category().$pathclibelle.$fileextends);
					$thumb->resize(120,100)->save(self::dir_img_category().$pathclibelle.$fileextends);
					return $pathclibelle.$fileextends;
				}else{
					if(file_exists(self::dir_img_category().$this->$img)){
						$makeFiles->removeFile(self::dir_img_category().$this->$img);
					}else{
						throw new Exception('file: '.$this->$img.' is not found');
					}
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * insert une nouvelle catégorie dans le catalogue
	 * @access public
	 */
	private function insert_new_category(){
		if(isset($this->clibelle)){
			try{
				if(empty($this->clibelle)){
					backend_config_smarty::getInstance()->display('catalog/request/empty.phtml');
				}else{
					$imgc = null;
					if($this->img_c != null){
						$imgc = self::insert_image_category('img_c',$this->pathclibelle.'_'.magixglobal_model_cryptrsa::random_generic_ui(),null);
					}
					backend_db_catalog::adminDbCatalog()->i_catalog_category($this->clibelle,$this->pathclibelle,$imgc,$this->idlang);
					backend_config_smarty::getInstance()->display('catalog/request/success-cat.phtml');
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * Suppression d'une categorie
	 * @access public
	 */
	private function delete_catalog_category(){
		if(isset($this->delc)){
			backend_db_catalog::adminDbCatalog()->d_catalog_category($this->delc);
			backend_config_smarty::getInstance()->display('catalog/request/s-cat-delete.phtml');
		}
	}
	/**
	 * @access private
	 * Mise à jour d'un catégorie
	 */
	private function update_category(){
		if(isset($this->upcat)){
			if(isset($this->update_category)){
				backend_db_catalog::adminDbCatalog()->u_catalog_category($this->update_category,$this->update_pathclibelle,$this->c_content,$this->upcat);
				backend_config_smarty::getInstance()->display('request/update-category.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Mise à jour de l'image d'une catégorie
	 */
	private function update_category_image(){
		if(isset($this->upcat)){
			if(isset($this->update_img_c)){
				$clibelle = backend_db_catalog::adminDbCatalog()->s_catalog_category_id($this->upcat);
				$imgc = self::insert_image_category(
					'update_img_c',
					$clibelle['pathclibelle'].'_'.magixglobal_model_cryptrsa::random_generic_ui(),
					$clibelle['img_c']
				);
				backend_db_catalog::adminDbCatalog()->u_catalog_category_image($imgc,$this->upcat);
				backend_config_smarty::getInstance()->display('request/update-image.phtml');
			}
		}
	}
	/**
	 * Post la requête ajax pour la modification de l'ordre des produuits dans la catégorie
	 *
	 */
	private function execute_order_product_category(){
		if(isset($_POST['prodcorder'])){
			$p = $_POST['prodcorder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_product_category($i,$p[$i]);
			}
		}
	}
	/**
	 * @access private
	 * json_img_category
	 * Retourne l'image de la catégorie avec json
	 */
	private function json_img_category(){
		$clibelle = backend_db_catalog::adminDbCatalog()->s_catalog_category_id($this->upcat);
		if($clibelle['img_c'] != null){
			$img = '[{"img_c":'.json_encode($clibelle['img_c']).'}]';
			print $img;
		}
	}
	/**
	 * Affiche la pop-up pour l'édition de la catégorie
	 * @access public
	 */
	private function display_edit_category(){
		if(isset($this->upcat)){
			$clibelle = backend_db_catalog::adminDbCatalog()->s_catalog_category_id($this->upcat);
			backend_config_smarty::getInstance()->assign('clibelle',$clibelle['clibelle']);
			backend_config_smarty::getInstance()->assign('c_content',$clibelle['c_content']);
			backend_config_smarty::getInstance()->assign('product_category_order',self::product_in_category_order($this->upcat));
		}
		backend_config_smarty::getInstance()->display('catalog/editcategory.phtml');
	}
	/**
	 * @access private
	 * retourne le dossier des images catalogue des catégories
	 * @return string
	 */
	private function dir_img_subcategory(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."subcategory".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Insertion d'une image por la catégorie du catalogue
	 * @access private
	 * @return string
	 */
	private function insert_image_subcategory($img,$pathslibelle){
		if(isset($this->$img)){
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img($img,'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."subcategory");
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				// Charge la classe pour renommer le fichier
				$makeFiles = new magixcjquery_files_makefiles();
				$fileextends = backend_model_image::image_analyze(self::dir_img_subcategory().$this->$img);
				if (backend_model_image::imgSizeMin(self::dir_img_subcategory().$this->$img,50,50)){
					if(file_exists(self::dir_img_subcategory().$pathslibelle.$fileextends)){
						$makeFiles->removeFile(self::dir_img_subcategory(),$pathslibelle.$fileextends);
					}
					$makeFiles->renameFiles(self::dir_img_subcategory(),self::dir_img_subcategory().$this->$img,self::dir_img_subcategory().$pathslibelle.$fileextends);
					/**
					 * Initialisation de la classe phpthumb 
					 * @var void
					 */
					$thumb = PhpThumbFactory::create(self::dir_img_subcategory().$pathslibelle.$fileextends);
					$thumb->resize(120,100)->save(self::dir_img_subcategory().$pathslibelle.$fileextends);
					return $pathslibelle.$fileextends;
				}else{
					if(file_exists(self::dir_img_subcategory().$this->$img)){
						$makeFiles->removeFile(self::dir_img_subcategory(),$this->$img);
					}else{
						throw new Exception('file: '.$this->$img.' is not found');
					}
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * @access private
	 * insert une nouvelle sous catégorie dans le catalogue
	 */
	private function insert_new_subcategory(){
		if(isset($this->slibelle)){
			try{
				if(empty($this->slibelle)){
					backend_config_smarty::getInstance()->display('catalog/request/empty.phtml');
				}elseif(empty($this->idclc)){
					backend_config_smarty::getInstance()->display('catalog/request/nocategory.phtml');
				}else{
					$imgs = null;
					if($this->img_s != null){
						$imgs = self::insert_image_subcategory('img_s',$this->pathslibelle);
					}
					backend_db_catalog::adminDbCatalog()->i_catalog_subcategory($this->slibelle,$this->pathslibelle,$imgs,$this->idclc);
					backend_config_smarty::getInstance()->display('catalog/request/success-subcat.phtml');
				}
			} catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * @access private
	 * Suppression d'une sous catégorie
	 */
	private function delete_catalog_subcategory(){
		if(isset($this->dels)){
			backend_db_catalog::adminDbCatalog()->d_catalog_subcategory($this->dels);
			backend_config_smarty::getInstance()->display('catalog/request/s-subcat-delete.phtml');
		}
	}
	/**
	 * @access private
	 * Mise à jour d'une sous catégorie
	 */
	private function update_subcategory(){
		if(isset($this->upsubcat)){
			if(isset($this->update_subcategory)){
				backend_db_catalog::adminDbCatalog()->u_catalog_subcategory($this->update_subcategory,$this->update_pathslibelle,$this->s_content,$this->upsubcat);
				backend_config_smarty::getInstance()->display('request/update-subcategory.phtml');
			}
		}
	}
	/**
	 * @access private 
	 * Mise à jour de l'image d'une sous catégorie
	 */
	private function update_subcategory_image(){
		if(isset($this->upsubcat)){
			if(isset($this->update_img_s)){
				$imgs = self::insert_image_subcategory('update_img_s',$this->update_pathslibelle);
				backend_db_catalog::adminDbCatalog()->u_catalog_subcategory_image($imgs,$this->upsubcat);
				backend_config_smarty::getInstance()->display('request/update-image.phtml');
			}
		}
	}
	/**
	 * product_in_subcategory_order
	 * Affiche le menu "sortable" avec les produits de la sous catégorie
	 * @access private
	 * @return string
	 */
	private function product_in_subcategory_order($upsubcat){
		$product = null;
		if(backend_db_catalog::adminDbCatalog()->s_product_in_subcategory($upsubcat) != null){
			$product = '<ul id="sortproduct">';
			foreach(backend_db_catalog::adminDbCatalog()->s_product_in_subcategory($upsubcat) as $cat){
				$product .= '<li class="ui-state-default" id="prodsorder_'.$cat['idproduct'].'">';
				$product .= '<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$product .= '<div class="sortdivfloat">'.$cat['titlecatalog'].'</div>';
				$product .= '<div style="float:right;">';
				$product .= '</div>';
				$product .= '</li>';
			}
			$product .= '</ul>';
		}
		return $product;
	}
	/**
	 * Post la requête ajax pour la modification de l'ordre des produuits dans la sous catégorie
	 *
	 */
	private function execute_order_product_subcategory(){
		if(isset($_POST['prodsorder'])){
			$p = $_POST['prodsorder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_product_subcategory($i,$p[$i]);
			}
		}
	}
	/**
	 * Affiche la pop-up pour l'édition de la sous catégorie
	 * @access public
	 */
	private function display_edit_subcategory(){
		if(isset($this->upsubcat)){
			$slibelle = backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_id($this->upsubcat);
			backend_config_smarty::getInstance()->assign('slibelle',$slibelle['slibelle']);
			backend_config_smarty::getInstance()->assign('img_s',$slibelle['img_s']);
			backend_config_smarty::getInstance()->assign('s_content',$slibelle['s_content']);
			backend_config_smarty::getInstance()->assign('product_subcategory_order',self::product_in_subcategory_order($this->upsubcat));
		}
		backend_config_smarty::getInstance()->display('catalog/editsubcategory.phtml');
	}
	/**
	 * Requete ajax json pour le chargement du menu select des sous-catégories correspondante à une catégorie
	 */
	/*public function get_select_json_construct(){
		if($this->getidclc){
			try {
				$select = '';
				foreach(backend_db_catalog::adminDbCatalog()->s_json_subcategory($this->getidclc) as $sel){
					$select  []= '{"optionValue": '.$sel["idcls"].', "optionDisplay": "'.$sel['slibelle'].'"}';
				}
				if($select != 0){
					print '['.implode(',',$select).']';
				}else{
					print '[{"optionValue":0 , "optionDisplay": "Aucune sous catégorie"}]';
				}
			} catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}*/
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	public function catalog_offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * pagination for Catalog
	 * @param $max
	 */
	public function catalog_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = backend_db_catalog::adminDbCatalog()->s_count_catalog_pager_max();
		return $pagination->pagerData(
			$request,
			'total',
			$max,
			$this->getpage,
			'/admin/catalog.php?',
			false,
			false,
			'page'
		);
	}
	/**
	 * 
	 * Rechercher un catalogue dans les titres
	 */
	private function search_title_page(){
		if($this->post_search != ''){
			if(backend_db_catalog::adminDbCatalog()->r_search_catalog_title($this->post_search) != null){
				foreach (backend_db_catalog::adminDbCatalog()->r_search_catalog_title($this->post_search) as $s){
					$search[]= '{"idcatalog":'.json_encode($s['idcatalog']).',"imgcatalog":'.json_encode($s['imgcatalog']).
					',"pseudo":'.json_encode($s['pseudo']).',"titlecatalog":'.json_encode($s['titlecatalog']).',"codelang":'.json_encode($s['codelang']).'}';
				}
				print '['.implode(',',$search).']';
			}
		}
	}
	/**
	 * 
	 * Rechercher un catalogue dans les titres
	 */
	private function search_catalog_ref(){
		if($this->post_search != ''){
			if(backend_db_catalog::adminDbCatalog()->r_search_complete_product($this->post_search) != null){
				foreach (backend_db_catalog::adminDbCatalog()->r_search_complete_product($this->post_search) as $catalog){
					$url = magixglobal_model_rewrite::filter_catalog_product_url(
						$catalog['codelang'], 
						$catalog['pathclibelle'], 
						$catalog['idclc'], 
						$catalog['urlcatalog'], 
						$catalog['idproduct'],
						true
					);
					$search[]= '{"idproduct":'.json_encode($catalog['idproduct']).',"titlecatalog":'.json_encode($catalog['titlecatalog']).
					',"category":'.json_encode($catalog['clibelle']).',"subcategory":'.json_encode($catalog['slibelle']).',"uriproduct":'.json_encode($url).',"codelang":'.json_encode($catalog['codelang']).'}';
				}
				print '['.implode(',',$search).']';
			}
		}
	}
	/**
	 * @access private
	 * Insertion d'un nouveau produit dans la table mc_catalog
	 */
	private function insert_new_card_product(){
		if(isset($this->titlecatalog)){
			if(empty($this->titlecatalog)){
				backend_config_smarty::getInstance()->display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_card_product(
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->urlcatalog,
					$this->titlecatalog,
					$this->desccatalog,
					$this->price
				);
				backend_config_smarty::getInstance()->display('catalog/request/success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Insertion d'un produit dans la table mc_catalog_product pour la liaison produit=>categorie
	 */
	private function insert_new_product(){
		if(isset($this->idclc)){
			if(empty($this->idclc)){
				backend_config_smarty::getInstance()->display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_product(
					$this->editproduct,
					$this->idclc,
					$this->idcls
				);
				backend_config_smarty::getInstance()->display('catalog/request/success-cat-product.phtml');
			}
		}
	}
	/**
	 * @access private
	 * @return string
	 * Retourne la liste des catégories/et sous catégories dans lequel se trouve le catalogue courant
	 */
	private function list_category_in_product(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_product($this->editproduct) != null){
			foreach (backend_db_catalog::adminDbCatalog()->s_catalog_product($this->editproduct) as $list){
				$product[]= '{"idproduct":'.json_encode($list['idproduct']).',"clibelle":'.json_encode($list['clibelle']).
				',"slibelle":'.json_encode($list['slibelle']).'}';
			}
			print '['.implode(',',$product).']';
		}
	}
	/**
	 * @access private
	 * Suppression d'un produit
	 */
	private function delete_in_product(){
		if(isset($this->d_in_product)){
			backend_db_catalog::adminDbCatalog()->d_in_product($this->d_in_product);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * @access private
	 * Retourne la liste des urls d'un produit défini
	 */
	private function uri_catalog_product(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_product($this->geturicat) != null){
			$product = '<ul style="margin:0;">';
			//foreach(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->geturicat) as $prod){
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_product($this->geturicat) as $prod){
				$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($prod['idproduct']);
				$product .= '<li style="list-style: none;margin:0;padding:0;">'.
				magixglobal_model_rewrite::filter_catalog_product_url(
					$prod['codelang'], 
					$prod['pathclibelle'], 
					$prod['idclc'], 
					$prod['urlcatalog'], 
					$prod['idproduct'],
					true
				).'</li>';
			}
			$product .= '</ul>';
		}else{
			$product = 'Ce produit ne contient aucun lien';
		}
		backend_config_smarty::getInstance()->assign('uri_catalog',$product);
		backend_config_smarty::getInstance()->display('catalog/window/uricatalog.phtml');
	}
	/**
	 * @access private
	 * @return string
	 * Retourne un menu select des produits groupés par sous catégorie de la catégorie
	 */
	private function construct_select_product(){
		$admindb =  backend_db_catalog::adminDbCatalog()->s_catalog_product_for_lang($this->selidclc);
		$category ='';
		$idcls = '';
		$idclc = '';
	      if ($admindb != null) {
	      	/*Boucle pour retourner la catégorie courante*/
	      	foreach($admindb as $cat){
      		 if ($cat['clibelle'] != $idclc) {
			     $category .= '<optgroup label="Categorie:'.$cat['clibelle'].'">';
			     /* Boucle selection des produits de la categorie START */
			     foreach ($admindb as $row){
			       if ($row['idcls'] == 0) {
			         $category .= '<option value="'.$row['idproduct'].'">'.$row['titlecatalog'].'</option>';
			       }
			     }
			     /* Boucle selection des produits de la categorie END */
			     $category .= "</optgroup>\n";
      		}
      		$idclc = $cat['clibelle'];
      		/*Fin de la boucle des catégories courante*/
	      	}
	      }
		/* Boucle selection des sous-catégories et leurs produits START */    
		foreach ($admindb as $row){
	      if ($row['slibelle'] != $idcls) {
	        if ($idcls != '') { 
	        	$category .= "</optgroup>\n"; 
	        }
	        $category .= '<optgroup label="Sous catégorie:'.$row['slibelle'].'">';
	      }
	        if ($row['idcls'] != 0) {
	          $category .= '<option value="'.$row['idproduct'].'">'.$row['titlecatalog'].'</option>';
	        }
	        if ($idcls != '') {
	              $category .= "</optgroup>\n"; 
	        }
	      $idcls = $row['slibelle'];
	    }
		/* Boucle selection des sous-catégories et leurs produits END */
		if ($idcls == '') { $category .= "</optgroup>\n"; }
		print $category;
	}
	/**
	 * @category json request
	 * @access private
	 * Requête json pour le chargement des sous catégories associé à une catégorie dans le menu déroulant
	 */
	private function json_idcls($idclc){
		if(backend_db_catalog::adminDbCatalog()->s_json_subcategory($idclc) != null){
			//print_r(backend_db_catalog::adminDbCatalog()->s_json_subcategory(2));
			foreach (backend_db_catalog::adminDbCatalog()->s_json_subcategory($idclc) as $list){
				if($list['idcls'] != 0){
					$subcat[]= json_encode($list['idcls']).':'.json_encode($list['slibelle']);
				}else{
					$subcat[] = json_encode("0").':'.json_encode("Aucune sous catégorie");
				}
			}
			print '{'.implode(',',$subcat).'}';
		}
	}
	/**
	 * @access private
	 * Insertion d'un produit lié avec le catalogue courant
	 */
	private function insert_rel_product(){
		if(isset($this->idproduct)){
			if(empty($this->idproduct)){
				backend_config_smarty::getInstance()->display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_rel_product(
					$this->editproduct,
					$this->idproduct
				);
				backend_config_smarty::getInstance()->display('catalog/request/success-cat-product.phtml');
			}
		}
	}
	/**
	 * @access private
	 * La liste des produits lié à une fiche
	 */
	private function list_rel_product(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->editproduct) != null){
			foreach (backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->editproduct) as $list){
				$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($list['idproduct']);
				$product[]= '{"idrelproduct":'.json_encode($list['idrelproduct']).',"clibelle":'.json_encode($info['clibelle']).
				',"slibelle":'.json_encode($info['slibelle']).',"titlecatalog":'.json_encode($info['titlecatalog']).'}';
			}
			print '['.implode(',',$product).']';
		}
	}
	/**
	 * @access private
	 * Retourne la liste des urls de liaison d'un produit défini
	 */
	private function uri_rel_product(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->getreluri) != null){
			$product = '<ul style="margin:0;">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->getreluri) as $prod){
				$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($prod['idproduct']);
				$product .= '<li style="list-style: none;margin:0;padding:0;">'
				.magixglobal_model_rewrite::filter_catalog_product_url(
					$info['codelang'], 
					$info['pathclibelle'], 
					$info['idclc'], 
					$info['urlcatalog'], 
					$info['idproduct'],
					true
				).'</li>';
			}
			$product .= '</ul>';
		}else{
			$product = 'Ce produit ne contient aucun lien';
		}
		backend_config_smarty::getInstance()->assign('rel_uri_catalog',$product);
		backend_config_smarty::getInstance()->display('catalog/window/rel-uricatalog.phtml');
	}
	/**
	 * Supprime un produit de liaison à une fiche catalogue
	 * @access private
	 */
	private function delete_rel_product(){
		if(isset($this->d_rel_product)){
			backend_db_catalog::adminDbCatalog()->d_rel_product($this->d_rel_product);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * @access private
	 * chargement des données d'un produit pour le formulaire
	 */
	private function load_data_product_forms(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->editproduct);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('desccatalog',$data['desccatalog']);
		backend_config_smarty::getInstance()->assign('price',$data['price']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
	}
	/**
	 * chargement des données d'un produit pour le déplacement de catégorie
	 */
	private function load_data_move_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->moveproduct);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
	}
	/**
	 * chargement des données d'un produit pour la copie d'un produit dans plusieurs catégorie
	 */
	private function load_data_copy_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->copyproduct);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('desccatalog',$data['desccatalog']);
		backend_config_smarty::getInstance()->assign('price',$data['price']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
	}
	/**
	 * Chargement des données d'un produit pour l'insertion d'une image
	 */
	private function load_data_image_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->getimg);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('desccatalog',$data['desccatalog']);
		backend_config_smarty::getInstance()->assign('price',$data['price']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
	}
	/**
	 * Mise à jour d'un produit
	 */
	private function update_specific_product(){
		if(isset($this->titlecatalog)){
			if(empty($this->titlecatalog)){
				backend_config_smarty::getInstance()->display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->u_catalog_product(
					backend_model_member::s_idadmin(),
					$this->titlecatalog,
					$this->urlcatalog,
					$this->desccatalog,
					$this->price,
					$this->editproduct
				);
				backend_config_smarty::getInstance()->display('catalog/request/success.phtml');
			}
		}
	}
	/**
	 * Déplace un produit
	 */
	private function move_specific_product(){
		if(isset($this->moveproduct)){
				backend_db_catalog::adminDbCatalog()->u_catalog_product_move(
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->moveproduct
				);
			backend_config_smarty::getInstance()->display('catalog/request/success.phtml');
		}
	}
	/**
	 * Suppression d'un produit
	 */
	private function delete_catalog_product(){
		if(isset($this->delproduct)){
			backend_db_catalog::adminDbCatalog()->d_catalog_product($this->delproduct);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * Copie un produit dans la table mc_catalog
	 */
	private function copy_product(){
		if(isset($this->copyproduct)){
			if(empty($this->copyproduct)){
				backend_config_smarty::getInstance()->display('catalog/request/empty.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->copy_catalog_product(
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->copyproduct
				);
				backend_config_smarty::getInstance()->display('catalog/request/copy.phtml');
			}
		}
	}
	/**
	 * @access private
	 * retourne le dossier des images catalogue
	 * @return string
	 */
	private function dir_img_product(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Insertion d'une image à un produit spécifique
	 */
	private function insert_image_product(){
		if(isset($this->imgcatalog)){
			//Supprime le fichier original pour gagner en espace
			$makeFiles = new magixcjquery_files_makefiles();
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img('imgcatalog','upload'.DIRECTORY_SEPARATOR.'catalogimg');
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				$fileextends = backend_model_image::image_analyze(self::dir_img_product().$this->imgcatalog);
				$random_id = magixglobal_model_cryptrsa::random_generic_ui();
				if (backend_model_image::imgSizeMin(self::dir_img_product().$this->imgcatalog,40,40)){
					// Sélectionne et retourne le nom du produit
					$simg = backend_db_catalog::adminDbCatalog()->s_uniq_url_catalog($this->getimg);
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
					$makeFiles->renameFiles(self::dir_img_product(),self::dir_img_product().$this->imgcatalog,self::dir_img_product().$simg['urlcatalog'].'_'.$random_id.$fileextends);
					/**
					 * Vérifie si le produit contient déjà une image 
					 * @var intéger
					 */
					$count = backend_db_catalog::adminDbCatalog()->count_image_product($this->getimg);
					if($count['cimage'] == 0){
						backend_db_catalog::adminDbCatalog()->i_image_catalog($this->getimg,$simg['urlcatalog'].'_'.$random_id.$fileextends);
					}else{
						backend_db_catalog::adminDbCatalog()->u_image_catalog($this->getimg,$simg['urlcatalog'].'_'.$random_id.$fileextends);
					}
					/**
					 * Selectionne l'image et retourne le nom
					 * @var string
					 */
					$getimg = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
					/**
					 * Initialisation de la classe phpthumb 
					 * @var void
					 */
					$thumb = PhpThumbFactory::create(self::dir_img_product().$getimg['imgcatalog']);
					/**
					 * Création des images et miniatures utile.
					 * 3 tailles !!!
					 */
					$thumb->resize(700)->save(self::dir_img_product().'product'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
					$thumb->resize(350,250)->save(self::dir_img_product().'medium'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
					$thumb->resize(120,100)->save(self::dir_img_product().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
					if(file_exists(self::dir_img_product().$getimg['imgcatalog'])){
						$makeFiles->removeFile(self::dir_img_product(),$getimg['imgcatalog']);
					}else{
						throw new Exception('file: '.$getimg['imgcatalog'].' is not found');
					}
				}else{
					if(file_exists(self::dir_img_product().$this->imgcatalog)){
						$makeFiles->removeFile(self::dir_img_product(),$this->imgcatalog);
					}else{
						throw new Exception('file: '.$this->imgcatalog.' is not found');
					}
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * @access private
	 * retourne le dossier des micros galeries
	 * @return string
	 */
	private function dir_micro_galery(){
		return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."galery".DIRECTORY_SEPARATOR);
	}
	/**
	 * Insertion d'une image dans la galerie spécifique à un produit
	 */
	private function insert_image_galery(){
		if(isset($this->imggalery)){
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img('imggalery','upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR.'galery');
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				$fileextends = backend_model_image::image_analyze(self::dir_micro_galery().$this->imggalery);
				$random_id = magixglobal_model_cryptrsa::random_generic_ui();
				if (backend_model_image::imgSizeMin(self::dir_micro_galery().$this->imggalery,40,40)){
					// Sélectionne et retourne le nom du produit
					$simg = backend_db_catalog::adminDbCatalog()->s_uniq_url_catalog($this->getimg);
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
					$makeFiles->renameFiles(self::dir_micro_galery(),self::dir_micro_galery().$this->imggalery,self::dir_micro_galery().$simg['urlcatalog'].'-'.$this->getimg.'_'.$random_id.$fileextends);
					/**
					 * Insére l'image dans la base de donnée
					 */
					backend_db_catalog::adminDbCatalog()->i_galery_image_catalog($this->getimg,$simg['urlcatalog'].'-'.$this->getimg.'_'.$random_id.$fileextends);
					/**
					 * Selectionne l'image et retourne le nom
					 * @var string
					 */
					$getimg = backend_db_catalog::adminDbCatalog()->s_galery_image_product();
					/**
					 * Initialisation de la classe phpthumb 
					 * @var void
					 */
					$thumb = PhpThumbFactory::create(self::dir_micro_galery().$getimg['imgcatalog']);
					/**
					 * Création des images et miniatures utile.
					 * 2 tailles !!!
					 */
					$thumb->resize(700)->save(self::dir_micro_galery().'maxi'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
					$thumb->resize(120,100)->save(self::dir_micro_galery().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
					$makeFiles = new magixcjquery_files_makefiles();
					if(file_exists(self::dir_micro_galery().$getimg['imgcatalog'])){
						$makeFiles->removeFile(self::dir_micro_galery(),$getimg['imgcatalog']);
					}
				}else{
					if(file_exists(self::dir_micro_galery().$this->imggalery)){
						$makeFiles->removeFile(self::dir_micro_galery(),$this->imggalery);
					}
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * Suppression d'une image dans une micro galerie
	 * @access public
	 */
	private function delete_image_microgalery(){
		if(isset($this->delmicro)){
			try{
				$dfile = backend_db_catalog::adminDbCatalog()->s_galery_image_micro($this->delmicro);
				$makeFiles = new magixcjquery_files_makefiles();
				if(file_exists(self::dir_micro_galery().'maxi/'.$dfile['imgcatalog'])){
					$makeFiles->removeFile(self::dir_micro_galery().'maxi'.DIRECTORY_SEPARATOR,$dfile['imgcatalog']);
					$makeFiles->removeFile(self::dir_micro_galery().'mini'.DIRECTORY_SEPARATOR,$dfile['imgcatalog']);
				}
				backend_db_catalog::adminDbCatalog()->d_galery_image_catalog($this->delmicro);
				backend_config_smarty::getInstance()->display('catalog/request/success-delete-mg.phtml');
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * Retourne les images (micro galerie) d'un produit spécifique dans une requête JSON
	 * @access private
	 */
	private function json_micro_galery(){
		if(isset($this->getimg)){
			if(backend_db_catalog::adminDbCatalog()->s_image_in_galery_product($this->getimg) != null){
				foreach (backend_db_catalog::adminDbCatalog()->s_image_in_galery_product($this->getimg) as $list){
					$img[]= '{"idmicro":'.json_encode($list['idmicro']).',"imgcatalog":'.json_encode($list['imgcatalog']).'}';
				}
				print '['.implode(',',$img).']';
			}
		}
	}
	/**
	 * Affiche l'edition d'un produit
	 * @access public
	 */
	private function display_edit_product(){
		self::load_data_product_forms();
		backend_config_smarty::getInstance()->assign('selectcategory',self::construct_select_category_lang());
		backend_config_smarty::getInstance()->display('catalog/editproduct.phtml');
	}
	/**
	 * Affiche le déplacement d'un produit
	 * @access public
	 */
	private function display_move_product(){
		self::load_data_move_product();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/moveproduct.phtml');
	}
	/**
	 * Affiche la copie d'un produit
	 * @access public
	 */
	private function display_copy_product(){
		self::load_data_copy_product();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/copyproduct.phtml');
	}
	/**
	 * Ajoute une catégorie (method post)
	 */
	private function post_category(){
		self::insert_new_category();
		self::insert_new_subcategory();
	}
	/**
	 * Affiche la page des sous catégories
	 * @access public
	 */
	private function display_category(){
		backend_config_smarty::getInstance()->assign('category_order',self::catalog_category_order());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	/**
	 * Affiche la page des produits ou insertion d'un produit
	 * @access public
	 */
	private function display_product(){
		backend_config_smarty::getInstance()->assign('global_product',parent::statistic_global_product('product'));
		backend_config_smarty::getInstance()->assign('global_product_subfolder',parent::statistic_global_product('subfolder'));
		backend_config_smarty::getInstance()->assign('global_folder',parent::statistic_global_folder_product());
		backend_config_smarty::getInstance()->assign('global_subfolder',parent::statistic_global_subfolder_product());
		backend_config_smarty::getInstance()->assign('global_rel_product',parent::statistic_global_rel_product());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/product.phtml');
	}
	private function json_img_product(){
		$getimg = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
		if($getimg['imgcatalog'] != null){
			if(file_exists(self::def_dirimg_frontend('upload/catalogimg').DIRECTORY_SEPARATOR.'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog'])){
				$gsize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').DIRECTORY_SEPARATOR.'product'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
				$psize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').DIRECTORY_SEPARATOR.'medium'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
				$ssize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').DIRECTORY_SEPARATOR.'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
				$img = '[{"imgcatalog":'.json_encode($getimg['imgcatalog']);
				$img .=',"gwidth":'.json_encode($gsize[0]);
				$img .=',"gheight":'.json_encode($gsize[1]);
				$img .=',"pwidth":'.json_encode($psize[0]);
				$img .=',"pheight":'.json_encode($psize[1]);
				$img .=',"swidth":'.json_encode($ssize[0]);
				$img .=',"sheight":'.json_encode($ssize[1]);
				$img .= '}]';
				print $img;
			}
		}
	}
	/**
	 * affiche la page d'insertion d'une image
	 * @access public
	 */
	private function display_product_image(){
		self::load_data_image_product();
		backend_config_smarty::getInstance()->display('catalog/image.phtml');
	}
	/**
	 * affiche la page pour la liste des articles
	 * @access public
	 */
	private function display(){
		backend_config_smarty::getInstance()->display('catalog/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('category')){
			if(magixcjquery_filter_request::isGet('delc')){
				self::delete_catalog_category();
			}elseif(magixcjquery_filter_request::isGet('dels')){
				self::delete_catalog_subcategory();
			}elseif(magixcjquery_filter_request::isGet('post')){
				self::post_category();
			}else{
				self::display_category();
			}
		}elseif(magixcjquery_filter_request::isGet('upcat')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_category();
			}elseif(magixcjquery_filter_request::isGet('imgcat')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				self::json_img_category();
			}elseif(magixcjquery_filter_request::isGet('postimg')){
				self::update_category_image();
			}else{
				if(magixcjquery_filter_request::isGet('json_sub_cat')){
					$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
					$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
					$header->pragma();
					$header->cache_control("nocache");
					$header->getStatus('200');
					$header->json_header("UTF-8");
					self::json_list_idcls($this->upcat);
				}else{
					self::display_edit_category();	
				}
			}
		}elseif(magixcjquery_filter_request::isGet('upsubcat')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_subcategory();
			}elseif(magixcjquery_filter_request::isGet('postimg')){
				self::update_subcategory_image();
			}else{
				self::display_edit_subcategory();
			}
		}elseif(magixcjquery_filter_request::isGet('product')){
			if(magixcjquery_filter_request::isGet('add_card_product')){
				self::insert_new_card_product();
			}elseif(magixcjquery_filter_request::isGet('editproduct')){
				if(magixcjquery_filter_request::isGet('add_product')){
					self::insert_new_product();
				}elseif(magixcjquery_filter_request::isGet('updateproduct')){
					self::update_specific_product();
				}elseif(magixcjquery_filter_request::isGet('json_cat_product')){
					$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
					$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
					$header->pragma();
					$header->cache_control("nocache");
					$header->getStatus('200');
					$header->json_header("UTF-8");
					self::list_category_in_product();
				}elseif(magixcjquery_filter_request::isGet('json_rel_product')){
					$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
					$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
					$header->pragma();
					$header->cache_control("nocache");
					$header->getStatus('200');
					$header->json_header("UTF-8");
					self::list_rel_product();
				}elseif(magixcjquery_filter_request::isGet('gethtmlprod')){
					if(magixcjquery_filter_request::isGet('idclc')){
						$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
						$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
						$header->pragma();
						$header->cache_control("nocache");
						$header->getStatus('200');
						$header->html_header("UTF-8");
						self::construct_select_product();
					}
				}elseif(magixcjquery_filter_request::isGet('getjsonprod')){
					if(magixcjquery_filter_request::isGet('idclc')){
						$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
						$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
						$header->pragma();
						$header->cache_control("nocache");
						$header->getStatus('200');
						$header->json_header("UTF-8");
						self::json_idcls($this->selidclc);
					}
				}elseif(magixcjquery_filter_request::isGet('post_rel_product')){
					self::insert_rel_product();
				}elseif(magixcjquery_filter_request::isGet('d_in_product')){
					self::delete_in_product();
				}elseif(magixcjquery_filter_request::isGet('d_rel_product')){
					self::delete_rel_product();
				}else{
					self::display_edit_product();
				}
			}elseif(magixcjquery_filter_request::isGet('moveproduct')){
				if(magixcjquery_filter_request::isGet('postmoveproduct')){
					self::move_specific_product();
				}else{
					self::display_move_product();
				}
			}elseif(magixcjquery_filter_request::isGet('copyproduct')){
				if(magixcjquery_filter_request::isGet('postcopyproduct')){
					self::copy_product();
				}else{
					self::display_copy_product();
				}
			}elseif(magixcjquery_filter_request::isGet('getimg')){
				if(magixcjquery_filter_request::isGet('postimgproduct')){
					self::insert_image_product();
				}elseif(magixcjquery_filter_request::isGet('postimggalery')){
					self::insert_image_galery();
				}elseif(magixcjquery_filter_request::isGet('jsonimgproduct')){
					$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
					$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
					$header->pragma();
					$header->cache_control("nocache");
					$header->getStatus('200');
					$header->json_header("UTF-8");
					self::json_img_product();
				}elseif(magixcjquery_filter_request::isGet('json_micro_galery')){
					$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
					$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
					$header->pragma();
					$header->cache_control("nocache");
					$header->getStatus('200');
					$header->json_header("UTF-8");
					self::json_micro_galery();
				}elseif(magixcjquery_filter_request::isGet('delmicro')){
					self::delete_image_microgalery();
				}else{
					self::display_product_image();
				}
			}elseif(magixcjquery_filter_request::isGet('delproduct')){
				self::delete_catalog_product();
			}else{
				self::display_product();
			}
		}elseif(magixcjquery_filter_request::isGet('get_search_page')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			self::search_title_page();
		}elseif(magixcjquery_filter_request::isGet('get_search_product')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			self::search_catalog_ref();
		}elseif(magixcjquery_filter_request::isGet('order')){
			self::executeOrderCategory();
			self::executeOrderSubCategory();
			self::execute_order_product_category();
			self::execute_order_product_subcategory();
		}elseif(magixcjquery_filter_request::isGet('geturicat')){
			self::uri_catalog_product();
		}elseif(magixcjquery_filter_request::isGet('getreluri')){
			self::uri_rel_product();
		}else{
			self::display();
		}
	}
}
/**
 * Class pour les statistiques du catalogue
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 *
 */
class analyzer_catalog{
	protected function statistic_global_product($info){
		$count = backend_db_catalog::adminDbCatalog()->count_global_product();
		$subfolder = backend_db_catalog::adminDbCatalog()->count_global_subfolder_product();
		switch($info){
			case 'subfolder':
				return $subfolder['subfolder'];
				break;
			case 'product':
				return $count['globalproduct'];
				break;
		}
	}
	protected function statistic_global_rel_product(){
		$count = backend_db_catalog::adminDbCatalog()->count_global_rel_product();
		return $count['relproduct'];
	}
	protected function statistic_global_folder_product(){
		$count = backend_db_catalog::adminDbCatalog()->count_global_folder();
		return $count['folder'];
	}
	protected function statistic_global_subfolder_product(){
		$count = backend_db_catalog::adminDbCatalog()->count_global_subfolder();
		return $count['subfolder'];
	}
}
?>