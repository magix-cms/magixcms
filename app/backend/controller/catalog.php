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
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    3.1
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name catalog
 *
 */
class backend_controller_catalog extends backend_db_catalog{
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
     * @deprecated
	 */
	public $corder;
    /**
     * Modification de l'ordre des éléments
     * @var $order_pages
     */
    public $order_pages;
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
    public $delete_image;
    /**
     * Les variables globales
     */
    public $edit,$section,$getlang,$action,$tab,$idadmin;
	/**
	 * @access public
	 * Constructor
	 */
	public function __construct(){
        //Catégories
		if(magixcjquery_filter_request::isPost('clibelle')){
			$this->clibelle = magixcjquery_form_helpersforms::inputClean($_POST['clibelle']);
		}
        if(magixcjquery_filter_request::isPost('pathclibelle')){
            $this->pathclibelle = magixcjquery_form_helpersforms::inputClean($_POST['pathclibelle']);
        }
        if(magixcjquery_filter_request::isPost('c_content')){
            $this->c_content = magixcjquery_form_helpersforms::inputCleanQuote($_POST['c_content']);
        }
        //Sous catégories
        if(magixcjquery_filter_request::isPost('slibelle')){
            $this->slibelle = magixcjquery_form_helpersforms::inputClean($_POST['slibelle']);

        }
        if(magixcjquery_filter_request::isPost('pathslibelle')){
            $this->pathslibelle = magixcjquery_url_clean::rplMagixString($_POST['slibelle'],array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
        }
        if(magixcjquery_filter_request::isPost('order_pages')){
            $this->order_pages = magixcjquery_form_helpersforms::arrayClean($_POST['order_pages']);
        }


		if(magixcjquery_filter_request::isPost('update_category')){
			$this->update_category = (string) magixcjquery_form_helpersforms::inputClean($_POST['update_category']);
			$this->update_pathclibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['update_category'],true);
		}

		if(magixcjquery_filter_request::isPost('update_subcategory')){
			$this->update_subcategory = (string) magixcjquery_form_helpersforms::inputClean($_POST['update_subcategory']);
			$this->update_pathslibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['update_subcategory'],true);
		}

		if(magixcjquery_filter_request::isPost('s_content')){
			$this->s_content = magixcjquery_form_helpersforms::inputCleanQuote($_POST['s_content']);
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
		if(magixcjquery_filter_request::isGet('getlang')){
			$this->getlang = magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
		}
        if(magixcjquery_filter_request::isGet('edit')){
            $this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
        }
		if(magixcjquery_filter_request::isPost('titlecatalog')){
			$this->titlecatalog = (string) magixcjquery_form_helpersforms::inputClean($_POST['titlecatalog']);
		}
        if(magixcjquery_filter_request::isPost('urlcatalog')){
            $this->urlcatalog = magixcjquery_form_helpersforms::inputClean($_POST['urlcatalog']);
        }
		if(magixcjquery_filter_request::isPost('desccatalog')){
			$this->desccatalog = (string) magixcjquery_form_helpersforms::inputCleanQuote($_POST['desccatalog']);
		}
		if(magixcjquery_filter_request::isPost('price')){
			$this->price = magixcjquery_filter_isVar::isPostFloat($_POST['price']);
		}
		if(magixcjquery_filter_request::isPost('ordercatalog')){
			$this->ordercatalog = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['ordercatalog']);
		}
        if(magixcjquery_filter_request::isPost('delete_image')){
            $this->delete_image = magixcjquery_form_helpersforms::inputClean($_POST['delete_image']);
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
		if(magixcjquery_filter_request::isPost('delproduct')){
			$this->delproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['delproduct']);
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
        if(magixcjquery_filter_request::isGet('section')){
            $this->section = magixcjquery_form_helpersforms::inputClean($_GET['section']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isSession('useridadmin')){
            $this->idadmin = magixcjquery_filter_isVar::isPostNumeric($_SESSION['useridadmin']);
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
				$list .= '<a href="/admin/catalog.php?category=true&amp;getlang='.$slang['idlang'].'">';
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
		if(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder($this->getlang) != null){
			$category = '<ul id="sortcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder($this->getlang) as $cat){
				if($cat['iso'] != null){
					$langspan = '<span class="lfloat">'.$cat['iso'].'</span>';
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
	private function json_list_category(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder($this->getlang) != null){
			foreach (backend_db_catalog::adminDbCatalog()->s_catalog_category_corder($this->getlang) as $list){
				$cat[]= '{"idclc":'.json_encode($list['idclc']).',"clibelle":'.json_encode($list['clibelle']).
				',"iso":'.json_encode($list['iso']).'}';
			}
			print '['.implode(',',$cat).']';
		}
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
			//si iso pas = à $lang
			if ($row['iso'] != $lang) {
				if ($lang != '') { $category .= "</optgroup>\n"; }
			       $category .= '<optgroup label="'.$row['iso'].'">';
			}
			$category .= '<option value="'.$row['idclc'].'">'.$row['clibelle'].'</option>';
			$lang = $row['iso'];
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
				if($cat['iso'] != null){
					$lang = $cat['iso'];
					$langspan = '<span class="lfloat">'.$cat['iso'].'</span>';
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
	/*private function dir_img_category(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."category".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}*/
	/**
	 * Insertion d'une image por la catégorie du catalogue
	 * @access private
	 * @return string
	 */
	/*private function insert_image_category($img,$pathclibelle,$img_c=null){
		if(isset($this->$img)){
			try{
				// Charge la classe pour le traitement du fichier
				$makeFiles = new magixcjquery_files_makefiles();
				if(!empty($this->$img)){
					/**
					 * Envoi une image dans le dossier "racine" catalogimg
					 */
					//backend_model_image::upload_img($img,'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."category");
					/**
					 * Analyze l'extension du fichier en traitement
					 * @var $fileextends
					 */
					/*$fileextends = backend_model_image::image_analyze(self::dir_img_category().$this->$img);
					if (backend_model_image::imgSizeMin(self::dir_img_category().$this->$img,50,50)){
						if(file_exists(self::dir_img_category().$pathclibelle.$fileextends)){
							$makeFiles->removeFile(self::dir_img_category(),$img_c);
						}
						$makeFiles->renameFiles(self::dir_img_category(),self::dir_img_category().$this->$img,self::dir_img_category().$pathclibelle.$fileextends);
						/**
						 * Initialisation de la classe phpthumb 
						 * @var void
						 */
						/*try{
							$thumb = PhpThumbFactory::create(self::dir_img_category().$pathclibelle.$fileextends);
						}catch (Exception $e)
						{
						     magixglobal_model_system::magixlog('An error has occured :',$e);
						}
						/**
						 * 
						 * Charge la taille des images des sous catégories du catalogue
						 */
						/*$imgsetting = new backend_model_setting();
						//$resizing = $imgsetting->select_uniq_setting('img_resizing');
						foreach($imgsetting->data_img_size('catalog','category') as $row){
							switch($row['img_resizing']){
								case 'basic':
									$thumb->resize($row['width'],$row['height'])->save(self::dir_img_category().$pathclibelle.$fileextends);
								break;
								case 'adaptive':
									$thumb->adaptiveResize($row['width'],$row['height'])->save(self::dir_img_category().$pathclibelle.$fileextends);
								break;
							}
						}
						return $pathclibelle.$fileextends;
					}else{
						if(file_exists(self::dir_img_category().$this->$img)){
							$makeFiles->removeFile(self::dir_img_category(),$this->$img);
						}else{
							throw new Exception('file: '.$this->$img.' is not found');
						}
					}
				}else{
					if(!empty($img_c)){
						if(file_exists(self::dir_img_category().$img_c)){
							$makeFiles->removeFile(self::dir_img_category(),$img_c);
						}
					}
					return null;
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}*/
	/**
	 * insert une nouvelle catégorie dans le catalogue
	 * @access public
	 */
	private function insert_new_category(){
		if(isset($this->clibelle)){
			try{
				if(empty($this->clibelle)){
					backend_controller_template::display('catalog/request/empty.phtml');
				}else{
					$imgc = null;
					if($this->img_c != null){
						$imgc = self::insert_image_category('img_c',$this->pathclibelle.'_'.magixglobal_model_cryptrsa::random_generic_ui(),null);
					}
					backend_db_catalog::adminDbCatalog()->i_catalog_category($this->clibelle,$this->pathclibelle,$imgc,$this->idlang);
					backend_controller_template::display('catalog/request/success-cat.phtml');
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
			$cproduct = backend_db_catalog::adminDbCatalog()->s_count_product_in_category($this->delc);
			$csubcat = backend_db_catalog::adminDbCatalog()->s_count_catalog_subcategory_in_category($this->delc);
			if($csubcat['csubcat']!= 0 OR $cproduct['cproduct']!= 0){
				backend_controller_template::display('catalog/request/verify_category.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->d_catalog_category($this->delc);
				backend_controller_template::display('catalog/request/s-cat-delete.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Mise à jour d'un catégorie
	 */
	/*private function update_category(){
		if(isset($this->upcat)){
			if(isset($this->update_category)){
				backend_db_catalog::adminDbCatalog()->u_catalog_category($this->update_category,$this->update_pathclibelle,$this->c_content,$this->upcat);
				backend_controller_template::display('request/update-category.phtml');
			}
		}
	}*/
	/**
	 * @access private
	 * Mise à jour de l'image d'une catégorie
	 */
	/*private function update_category_image(){
		if(isset($this->upcat)){
			if(isset($this->update_img_c)){
				$clibelle = backend_db_catalog::adminDbCatalog()->s_catalog_category_id($this->upcat);
				$imgc = self::insert_image_category(
					'update_img_c',
					$clibelle['pathclibelle'].'_'.magixglobal_model_cryptrsa::random_generic_ui(),
					$clibelle['img_c']
				);
				backend_db_catalog::adminDbCatalog()->u_catalog_category_image($imgc,$this->upcat);
				backend_controller_template::display('request/update-image.phtml');
			}
		}
	}*/
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
			backend_controller_template::assign('clibelle',$clibelle['clibelle']);
			backend_controller_template::assign('c_content',$clibelle['c_content']);
			backend_controller_template::assign('product_category_order',self::product_in_category_order($this->upcat));
		}
		backend_controller_template::display('catalog/editcategory.phtml');
	}
	/**
	 * @access private
	 * retourne le dossier des images catalogue des catégories
	 * @return string
	 */
	/*private function dir_img_subcategory(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."subcategory".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}*/
	/**
	 * Insertion d'une image por la catégorie du catalogue
	 * @access private
	 * @return string
	 */
	/*private function insert_image_subcategory($img,$pathslibelle,$img_s=null){
		if(isset($this->$img)){
			try{
				// Charge la classe pour le traitement du fichier
				$makeFiles = new magixcjquery_files_makefiles();
				if(!empty($this->$img)){
					/**
					 * Envoi une image dans le dossier "racine" catalogimg
					 */
					/*backend_model_image::upload_img($img,'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."subcategory");
					/**
					 * Analyze l'extension du fichier en traitement
					 * @var $fileextends
					 */
					/*$fileextends = backend_model_image::image_analyze(self::dir_img_subcategory().$this->$img);
					if (backend_model_image::imgSizeMin(self::dir_img_subcategory().$this->$img,50,50)){
						if(file_exists(self::dir_img_subcategory().$pathslibelle.$fileextends)){
							$makeFiles->removeFile(self::dir_img_subcategory(),$img_s);
						}
						$makeFiles->renameFiles(self::dir_img_subcategory(),self::dir_img_subcategory().$this->$img,self::dir_img_subcategory().$pathslibelle.$fileextends);
						/**
						 * Initialisation de la classe phpthumb 
						 * @var void
						 */
						/*$thumb = PhpThumbFactory::create(self::dir_img_subcategory().$pathslibelle.$fileextends);
						/**
						 * 
						 * Charge la taille des images des sous catégories du catalogue
						 */
						/*$imgsetting = new backend_model_setting();
						foreach($imgsetting->data_img_size('catalog','subcategory') as $row){
							/*switch($row['type']){
								case 'small':
									$thumb->resize($row['width'],$row['height'])->save(self::dir_img_subcategory().$pathslibelle.$fileextends);
								break;
							}*/
							/*switch($row['img_resizing']){
								case 'basic':
									$thumb->resize($row['width'],$row['height'])->save(self::dir_img_subcategory().$pathslibelle.$fileextends);
								break;
								case 'adaptive':
									$thumb->adaptiveResize($row['width'],$row['height'])->save(self::dir_img_subcategory().$pathslibelle.$fileextends);
								break;
							}
						}
						return $pathslibelle.$fileextends;
					}else{
						if(file_exists(self::dir_img_subcategory().$this->$img)){
							$makeFiles->removeFile(self::dir_img_subcategory(),$this->$img);
						}else{
							throw new Exception('file: '.$this->$img.' is not found');
						}
					}
				}else{
					if(!empty($img_s)){
						if(file_exists(self::dir_img_subcategory().$img_s)){
							$makeFiles->removeFile(self::dir_img_subcategory(),$img_s);
						}
					}
					return null;
				}
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}*/
	/**
	 * @access private
	 * insert une nouvelle sous catégorie dans le catalogue
	 */
	private function insert_new_subcategory(){
		if(isset($this->slibelle)){
			try{
				if(empty($this->slibelle)){
					backend_controller_template::display('catalog/request/empty.phtml');
				}elseif(empty($this->idclc)){
					backend_controller_template::display('catalog/request/nocategory.phtml');
				}else{
					$imgs = null;
					if($this->img_s != null){
						//$imgs = self::insert_image_subcategory('img_s',$this->pathslibelle);
						$imgs = self::insert_image_subcategory('img_s',$this->pathslibelle.'_'.magixglobal_model_cryptrsa::random_generic_ui(),null);
					}
					backend_db_catalog::adminDbCatalog()->i_catalog_subcategory($this->slibelle,$this->pathslibelle,$imgs,$this->idclc);
					backend_controller_template::display('catalog/request/success-subcat.phtml');
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
			backend_controller_template::display('catalog/request/s-subcat-delete.phtml');
		}
	}
	/**
	 * @access private
	 * Mise à jour d'une sous catégorie
	 */
	/*private function update_subcategory(){
		if(isset($this->upsubcat)){
			if(isset($this->update_subcategory)){
				backend_db_catalog::adminDbCatalog()->u_catalog_subcategory($this->update_subcategory,$this->update_pathslibelle,$this->s_content,$this->upsubcat);
				backend_controller_template::display('request/update-subcategory.phtml');
			}
		}
	}*/
	/**
	 * @access private
	 * json_img_subcategory
	 * Retourne l'image de la sous catégorie avec json
	 */
	private function json_img_subcategory(){
		$clibelle = backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_id($this->upsubcat);
		if($clibelle['img_s'] != null){
			$img = '[{"img_s":'.json_encode($clibelle['img_s']).'}]';
			print $img;
		}
	}
	/**
	 * @access private 
	 * Mise à jour de l'image d'une sous catégorie
	 */
	/*private function update_subcategory_image(){
		if(isset($this->upsubcat)){
			if(isset($this->update_img_s)){
				$slibelle = backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_id($this->upsubcat);
				$imgs = self::insert_image_subcategory(
					'update_img_s',
					$slibelle['pathslibelle'].'_'.magixglobal_model_cryptrsa::random_generic_ui(),
					$slibelle['img_s']
				);
				backend_db_catalog::adminDbCatalog()->u_catalog_subcategory_image($imgs,$this->upsubcat);
				backend_controller_template::display('request/update-image.phtml');
			}
		}
	}*/
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
			backend_controller_template::assign('slibelle',$slibelle['slibelle']);
			backend_controller_template::assign('img_s',$slibelle['img_s']);
			backend_controller_template::assign('s_content',$slibelle['s_content']);
			backend_controller_template::assign('product_subcategory_order',self::product_in_subcategory_order($this->upsubcat));
		}
		backend_controller_template::display('catalog/editsubcategory.phtml');
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
					',"pseudo":'.json_encode($s['pseudo']).',"titlecatalog":'.json_encode($s['titlecatalog']).',"iso":'.json_encode($s['iso']).'}';
				}
				print '['.implode(',',$search).']';
			}
		}
	}
	/**
	 * @access private
	 * Rechercher un catalogue dans les titres
	 */
	private function search_catalog_ref(){
		if($this->post_search != ''){
			if(backend_db_catalog::adminDbCatalog()->r_search_complete_product($this->post_search) != null){
				foreach (backend_db_catalog::adminDbCatalog()->r_search_complete_product($this->post_search) as $catalog){
					$url = magixglobal_model_rewrite::filter_catalog_product_url(
						$catalog['iso'],
						$catalog['pathclibelle'],
						$catalog['idclc'],
						$catalog['pathslibelle'],
						$catalog['idcls'],
						$catalog['urlcatalog'], 
						$catalog['idproduct'],
						true);
					$search[]= '{"idproduct":'.json_encode($catalog['idproduct']).',"titlecatalog":'.json_encode($catalog['titlecatalog']).
					',"category":'.json_encode($catalog['clibelle']).',"subcategory":'.json_encode($catalog['slibelle']).',"uriproduct":'.json_encode($url).',"iso":'.json_encode($catalog['iso']).'}';
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
				backend_controller_template::display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_card_product(
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->urlcatalog,
					$this->titlecatalog,
					$this->desccatalog,
					$this->price
				);
				backend_controller_template::display('catalog/request/success.phtml');
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
				backend_controller_template::display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_product(
					$this->editproduct,
					$this->idclc,
					$this->idcls
				);
				backend_controller_template::display('catalog/request/success-cat-product.phtml');
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
			backend_controller_template::display('catalog/request/success-delete.phtml');
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
					$prod['iso'], 
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
		backend_controller_template::assign('uri_catalog',$product);
		backend_controller_template::display('catalog/window/uricatalog.phtml');
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
		}else{
			print '{"0":"Aucune sous catégorie"}';
		}
	}
	/**
	 * @access private
	 * Insertion d'un produit lié avec le catalogue courant
	 */
	private function insert_rel_product(){
		if(isset($this->idproduct)){
			if(empty($this->idproduct)){
				backend_controller_template::display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_rel_product(
					$this->editproduct,
					$this->idproduct
				);
				backend_controller_template::display('catalog/request/success-cat-product.phtml');
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
					$info['iso'], 
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
		backend_controller_template::assign('rel_uri_catalog',$product);
		backend_controller_template::display('catalog/window/rel-uricatalog.phtml');
	}
	/**
	 * Supprime un produit de liaison à une fiche catalogue
	 * @access private
	 */
	private function delete_rel_product(){
		if(isset($this->d_rel_product)){
			backend_db_catalog::adminDbCatalog()->d_rel_product($this->d_rel_product);
			backend_controller_template::display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * @access private
	 * chargement des données d'un produit pour le formulaire
	 */
	private function load_data_product_forms(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->editproduct);
		backend_controller_template::assign('titlecatalog',$data['titlecatalog']);
		backend_controller_template::assign('desccatalog',magixcjquery_form_helpersforms::inputClean($data['desccatalog']));
		backend_controller_template::assign('price',$data['price']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
	}
	/**
	 * chargement des données d'un produit pour le déplacement de catégorie
	 */
	private function load_data_move_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->moveproduct);
		backend_controller_template::assign('idproduct',$data['idcatalog']);
		backend_controller_template::assign('titlecatalog',$data['titlecatalog']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
	}
	/**
	 * chargement des données d'un produit pour la copie d'un produit dans plusieurs catégorie
	 */
	private function load_data_copy_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->copyproduct);
		backend_controller_template::assign('idproduct',$data['idcatalog']);
		backend_controller_template::assign('titlecatalog',$data['titlecatalog']);
		backend_controller_template::assign('desccatalog',$data['desccatalog']);
		backend_controller_template::assign('price',$data['price']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
	}
	/**
	 * Chargement des données d'un produit pour l'insertion d'une image
	 */
	private function load_data_image_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->getimg);
		backend_controller_template::assign('idproduct',$data['idcatalog']);
		backend_controller_template::assign('titlecatalog',$data['titlecatalog']);
		backend_controller_template::assign('desccatalog',$data['desccatalog']);
		backend_controller_template::assign('price',$data['price']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
	}
	/**
	 * Mise à jour d'un produit
	 */
	private function update_specific_product(){
		if(isset($this->titlecatalog)){
			if(empty($this->titlecatalog)){
				backend_controller_template::display('catalog/request/empty-product.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->u_catalog_product(
					backend_model_member::s_idadmin(),
					$this->titlecatalog,
					$this->urlcatalog,
					$this->desccatalog,
					$this->price,
					$this->editproduct
				);
				backend_controller_template::display('catalog/request/success.phtml');
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
			backend_controller_template::display('catalog/request/success.phtml');
		}
	}
	/**
	 * Suppression d'un produit
	 */
	private function delete_catalog_product(){
		if(isset($this->delproduct)){
			backend_db_catalog::adminDbCatalog()->d_catalog_product($this->delproduct);
			backend_controller_template::display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * Copie un produit dans la table mc_catalog
	 */
	private function copy_product(){
		if(isset($this->copyproduct)){
			if(empty($this->copyproduct)){
				backend_controller_template::display('catalog/request/empty.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->copy_catalog_product(
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->copyproduct
				);
				backend_controller_template::display('catalog/request/copy.phtml');
			}
		}
	}
	/**
	 * @access private
	 * retourne le dossier des images catalogue
	 * @return string
	 */
	/*private function dirImgProduct(){
		try{
			return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}*/
	/**
	 * Insertion d'une image à un produit spécifique
	 */
	/*private function insert_image_product($debug=false){
		if(isset($this->imgcatalog)){
			//Supprime le fichier original pour gagner en espace
			$makeFiles = new magixcjquery_files_makefiles();
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				/*backend_model_image::upload_img('imgcatalog','upload'.DIRECTORY_SEPARATOR.'catalogimg');
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				/*$fileextends = backend_model_image::image_analyze(self::dir_img_product().$this->imgcatalog);
				$random_id = magixglobal_model_cryptrsa::random_generic_ui();
				if (backend_model_image::imgSizeMin(self::().$this->imgcatalog,40,40)){
					// Sélectionne et retourne le nom du produit
					$simg = backend_db_catalog::adminDbCatalog()->s_uniq_url_catalog($this->getimg);
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
					$makeFiles->renameFiles(self::dir_img_product(),self::dir_img_product().$this->imgcatalog,self::dir_img_product().$simg['urlcatalog'].'_'.$random_id.$fileextends);
					/**
					 * Vérifie si le produit contient déjà une image 
					 * @var intéger
					 */
					/*$count = backend_db_catalog::adminDbCatalog()->count_image_product($this->getimg);
					if($count['cimage'] == 0){
						backend_db_catalog::adminDbCatalog()->i_image_catalog($this->getimg,$simg['urlcatalog'].'_'.$random_id.$fileextends);
					}else{
						$old_img = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
						if(file_exists(self::dir_img_product().'product'.DIRECTORY_SEPARATOR.$old_img['imgcatalog'])){
							$makeFiles->removeFile(self::dir_img_product(),'product'.DIRECTORY_SEPARATOR.$old_img['imgcatalog']);
							$makeFiles->removeFile(self::dir_img_product(),'medium'.DIRECTORY_SEPARATOR.$old_img['imgcatalog']);
							$makeFiles->removeFile(self::dir_img_product(),'mini'.DIRECTORY_SEPARATOR.$old_img['imgcatalog']);
						}/*else{
							throw new Exception('file: '.$old_img['imgcatalog'].' is not found');
						}*/
						/*backend_db_catalog::adminDbCatalog()->u_image_catalog($this->getimg,$simg['urlcatalog'].'_'.$random_id.$fileextends);
					}
					/**
					 * Selectionne l'image et retourne le nom
					 * @var string
					 */
					/*$getimg = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
					/**
					 * Initialisation de la classe phpthumb 
					 * @var void
					 */
					/*$thumb = PhpThumbFactory::create(self::dir_img_product().$getimg['imgcatalog']);
					$firebug = new magixcjquery_debug_magixfire();
					/**
					 * Création des images et miniatures utile.
					 * 3 tailles !!!
					 */
					/*$imgsetting = new backend_model_setting();
					$imgsizelarge = $imgsetting->uniq_data_img_size('catalog','product','large');
					$imgsizemed = $imgsetting->uniq_data_img_size('catalog','product','medium');
					$imgsizesmall = $imgsetting->uniq_data_img_size('catalog','product','small');
					if($debug){
						$firebug->magixFireGroup('Setting image');
					}
					switch($imgsizelarge['img_resizing']){
						case 'basic':
							if($debug){
								$firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
								$firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizelarge['width'],'Width');
								$firebug->magixFireLog($imgsizelarge['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->resize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dir_img_product().'product'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
						case 'adaptive':
							if($debug){
								$firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
								$firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizelarge['width'],'Width');
								$firebug->magixFireLog($imgsizelarge['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->adaptiveResize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dir_img_product().'product'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
					}
					switch($imgsizemed['img_resizing']){
						case 'basic':
							if($debug){
								$firebug->magixFireGroup($imgsizemed['config_size_attr'].' => '.$imgsizemed['type']);
								$firebug->magixFireLog($imgsizemed['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizemed['width'],'Width');
								$firebug->magixFireLog($imgsizemed['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->resize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_product().'medium'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
						case 'adaptive':
							if($debug){
								$firebug->magixFireGroup($imgsizemed['config_size_attr'].' => '.$imgsizemed['type']);
								$firebug->magixFireLog($imgsizemed['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizemed['width'],'Width');
								$firebug->magixFireLog($imgsizemed['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->adaptiveResize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_product().'medium'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
					}
					switch($imgsizesmall['img_resizing']){
						case 'basic':
							if($debug){
								$firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
								$firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizesmall['width'],'Width');
								$firebug->magixFireLog($imgsizesmall['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_product().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
						case 'adaptive':
							if($debug){
								$firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
								$firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizesmall['width'],'Width');
								$firebug->magixFireLog($imgsizesmall['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_product().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
					}
					if($debug){
						$firebug->magixFireGroupEnd();
					}
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
	}*/
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
	private function insert_image_galery($debug=false){
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
					//Charge la taille des images des galeries du catalogue
					$firebug = new magixcjquery_debug_magixfire();
					/**
					 * Création des images et miniatures utile.
					 * 2 tailles !!!
					 */
					$imgsetting = new backend_model_setting();
					$imgsizelarge = $imgsetting->uniq_data_img_size('catalog','galery','large');
					$imgsizesmall = $imgsetting->uniq_data_img_size('catalog','galery','small');
					if($debug){
						$firebug->magixFireGroup('Setting image');
					}
					switch($imgsizelarge['img_resizing']){
						case 'basic':
							if($debug){
								$firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
								$firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizelarge['width'],'Width');
								$firebug->magixFireLog($imgsizelarge['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->resize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dir_micro_galery().'maxi'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
						case 'adaptive':
							if($debug){
								$firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
								$firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizelarge['width'],'Width');
								$firebug->magixFireLog($imgsizelarge['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->adaptiveResize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dir_micro_galery().'maxi'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
					}
					switch($imgsizesmall['img_resizing']){
						case 'basic':
							if($debug){
								$firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
								$firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizesmall['width'],'Width');
								$firebug->magixFireLog($imgsizesmall['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_micro_galery().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
						case 'adaptive':
							if($debug){
								$firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
								$firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
								$firebug->magixFireLog($imgsizesmall['width'],'Width');
								$firebug->magixFireLog($imgsizesmall['height'],'Height');
								$firebug->magixFireGroupEnd();
							}
							$thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_micro_galery().'mini'.DIRECTORY_SEPARATOR.$getimg['imgcatalog']);
						break;
					}
					if($debug){
						$firebug->magixFireGroupEnd();
					}
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
				backend_controller_template::display('catalog/request/success-delete-mg.phtml');
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
		backend_controller_template::assign('selectcategory',self::construct_select_category_lang());
		backend_controller_template::display('catalog/editproduct.phtml');
	}
	/**
	 * Affiche le déplacement d'un produit
	 * @access public
	 */
	private function display_move_product(){
		self::load_data_move_product();
		backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
		backend_controller_template::display('catalog/moveproduct.phtml');
	}
	/**
	 * Affiche la copie d'un produit
	 * @access public
	 */
	private function display_copy_product(){
		self::load_data_copy_product();
		backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
		backend_controller_template::display('catalog/copyproduct.phtml');
	}
	/**
	 * Ajoute une catégorie (method post)
	 */
	private function post_category(){
		self::insert_new_category();
		self::insert_new_subcategory();
	}
	/**
	 * Affiche la page des produits ou insertion d'un produit
	 * @access public
	 */
	private function display_product(){
		backend_controller_template::assign('global_product',parent::statistic_global_product('product'));
		backend_controller_template::assign('global_product_subfolder',parent::statistic_global_product('subfolder'));
		backend_controller_template::assign('global_folder',parent::statistic_global_folder_product());
		backend_controller_template::assign('global_subfolder',parent::statistic_global_subfolder_product());
		backend_controller_template::assign('global_rel_product',parent::statistic_global_rel_product());
		backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
		backend_controller_template::display('catalog/product.phtml');
	}
	/**
	 * 
	 * Enter description here ...
	 */
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
		backend_controller_template::display('catalog/image.phtml');
	}
	/**
     * @deprecated
	 * @access private
	 * Requête JSON pour les statistiques du CMS
	 */
	/*private function json_catalog_chart(){
		if(backend_db_block_catalog::chart_count_catalog() != null){
			foreach (backend_db_block_catalog::chart_count_catalog() as $s){
				$rowCatalog[]= $s['countcatalog'];
			}
		}else{
			$rowCatalog = array(0);
		}
		if(backend_db_block_catalog::chart_count_category() != null){
			foreach (backend_db_block_catalog::chart_count_category() as $s){
				$rowCatalogCat[]= $s['countcatalog_cat'];
			}
		}else{
			$rowCatalogCat = array(0);
		}
		if(backend_db_block_catalog::chart_count_subcategory() != null){
			foreach (backend_db_block_catalog::chart_count_subcategory() as $s){
				$rowCatalogSubCat[]= $s['countcatalog_subcat'];
			}
		}else{
			$rowCatalogSubCat = array(0);
		}
		if(backend_db_block_lang::s_data_lang() != null){
			foreach (backend_db_block_lang::s_data_lang() as $s){
				$rowLang[]= json_encode(magixcjquery_string_convert::upTextCase($s['iso']));
			}
		}else{
			$rowLang = array(0);
		}
		print '{"catalog_count":['.implode(',',$rowCatalog).'],"lang":['.implode(',',$rowLang).'],"catalog_category_count":['.implode(',',$rowCatalogCat).'],"catalog_subcategory_count":['.implode(',',$rowCatalogSubCat).']}';
	}*/
    /**
     * @access private
     * Requête JSON pour les statistiques du catalogue
     */
    private function json_graph(){
        if(parent::s_stats_catalog() != null){
            foreach (parent::s_stats_catalog() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['CATEGORY'],
                    'z'=>$key['SUBCATEGORY'],
                    'a'=>$key['CATALOG']
                );
            }
            print json_encode($stat);
        }
    }
    // ####### SECTION CATEGORIES
    /**
     * Retourne les catégories au format JSON
     */
    private function json_listing_category(){
        if(parent::s_catalog_category($this->getlang) != null){
            foreach (parent::s_catalog_category($this->getlang) as $key){
                if($key['c_content'] != null){
                    $content = 1;
                }else{
                    $content = 0;
                }
                if($key['img_c'] != null){
                    $img = 1;
                }else{
                    $img = 0;
                }
                $json_data[]= '{"idclc":'.json_encode($key['idclc']).
                    ',"clibelle":'.json_encode($key['clibelle']).
                    ',"c_content":'.json_encode($content).
                    ',"img":'.json_encode($img).
                    ',"iso":'.json_encode($key['iso']).'}';
            }
            print '['.implode(',',$json_data).']';
        }
    }

    /**
     * @access private
     * Insertion d'une catégorie
     */
    private function addCategory($create){
        if(isset($this->clibelle)){
            if(!empty($this->clibelle)){
                $pathclibelle = magixcjquery_url_clean::rplMagixString($this->clibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                parent::i_catalog_category(
                    $this->clibelle,
                    $pathclibelle,
                    $this->getlang
                );
                $create->display('catalog/request/success_add.phtml');
            }
        }
    }
    /**
     * Execute Update AJAX FOR order
     * @access private
     *
     */
    private function update_order_category(){
        if(isset($this->order_pages)){
            $p = $this->order_pages;
            for ($i = 0; $i < count($p); $i++) {
                parent::u_order_category($i,$p[$i]);
            }
        }
    }

    /**
     * Retourne les données d'édition de la catégorie
     * @param $create
     * @param $data
     */
    private function load_category_edit_data($create,$data){
        /**
         * Retourne un tableau des données
         * @var
         */
        $create->assign('idclc',$data['idclc'],true);
        $create->assign('clibelle',$data['clibelle'],true);
        $create->assign('pathclibelle',$data['pathclibelle'],true);
        $create->assign('c_content',$data['c_content'],true);
        $create->assign('iso',$data['iso'],true);
    }

    /**
     * Retourne l'url de la catégorie
     * @param $data
     */
    private function json_uri_category($data){
        if($data != null){
            $url = magixglobal_model_rewrite::filter_catalog_category_url(
                $data['iso'],
                $data['pathclibelle'],
                $data['idclc'],
                true
            );
            $categoryinput= '{"categorylink":'.json_encode(magixcjquery_url_clean::rplMagixString($url)).'}';
            print $categoryinput;
        }
    }

    /**
     * Mise à jour de la catégorie
     */
    private function update_category($create){
        if(isset($this->clibelle)){
            if(!empty($this->clibelle)){
                if(!empty($this->pathclibelle)){
                    $pathclibelle = magixcjquery_url_clean::rplMagixString($this->pathclibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }else{
                    $pathclibelle = magixcjquery_url_clean::rplMagixString($this->clibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }
                parent::u_catalog_category(
                    $this->clibelle,
                    $pathclibelle,
                    $this->c_content,
                    $this->edit
                );
                $create->display('catalog/request/success_update.phtml');
            }
        }
    }

    /**
     * Retourne le chemin depuis la racine
     * @param $pathupload
     * @return string
     */
    private function imgBasePath($pathupload){
        return magixglobal_model_system::base_path().$pathupload;
    }

    /**
     * @access private
     * retourne le dossier des images catalogue des catégories
     * @return string
     */
    private function dirImgCategory(){
        try{
            return self::imgBasePath("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."category".DIRECTORY_SEPARATOR);
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * Insertion d'une image por la catégorie du catalogue
     * @access private
     * @param $img
     * @param $pathclibelle
     * @param null $img_c
     * @param bool $debug
     * @throws Exception
     * @return string
     */
    private function insert_image_category($img,$pathclibelle,$img_c=null,$debug=false){
        if(isset($this->$img)){
            try{
                // Charge la classe pour le traitement du fichier
                $makeFiles = new magixcjquery_files_makefiles();
                if(!empty($this->$img)){
                    $initImg = new backend_model_image();
                    /**
                     * Envoi une image dans le dossier "racine" catalogimg
                     */
                    $initImg->upload_img(
                        $img,
                        'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."category".DIRECTORY_SEPARATOR,
                        $debug
                    );
                    /**
                     * Analyze l'extension du fichier en traitement
                     * @var $fileextends
                     */
                    $fileextends = $initImg->image_analyze(self::dirImgCategory().$this->$img);
                    if ($initImg->imgSizeMin(self::dirImgCategory().$this->$img,25,25)){
                        if(file_exists(self::dirImgCategory().$pathclibelle.$fileextends)){
                            $makeFiles->removeFile(self::dirImgCategory(),$img_c);
                        }
                        // Renomme le fichier
                        $makeFiles->renameFiles(
                            self::dirImgCategory(),
                            self::dirImgCategory().$this->$img,self::dirImgCategory().$pathclibelle.$fileextends
                        );
                        /**
                         * Initialisation de la classe phpthumb
                         * @var void
                         */
                        try{
                            $thumb = PhpThumbFactory::create(self::dirImgCategory().$pathclibelle.$fileextends);
                        }catch (Exception $e)
                        {
                            magixglobal_model_system::magixlog('An error has occured :',$e);
                        }
                        /**
                         *
                         * Charge la taille des images des sous catégories du catalogue
                         */

                        foreach($initImg->arrayImgSize('catalog','category') as $key){
                            switch($key['img_resizing']){
                                case 'basic':
                                    $thumb->resize($key['width'],$key['height'])->save(self::dirImgCategory().$pathclibelle.$fileextends);
                                    break;
                                case 'adaptive':
                                    $thumb->adaptiveResize($key['width'],$key['height'])->save(self::dirImgCategory().$pathclibelle.$fileextends);
                                    break;
                            }
                        }
                        // Supprime l'ancienne image
                        if(!empty($img_c)){
                            if(file_exists(self::dirImgCategory().$img_c)){
                                $makeFiles->removeFile(self::dirImgCategory(),$img_c);
                            }
                        }
                        return $pathclibelle.$fileextends;
                    }else{
                        if(file_exists(self::dirImgCategory().$this->$img)){
                            $makeFiles->removeFile(self::dirImgCategory(),$this->$img);
                        }else{
                            throw new Exception('file: '.$this->$img.' is not found');
                        }
                    }
                }else{
                    if(!empty($img_c)){
                        if(file_exists(self::dirImgCategory().$img_c)){
                            $makeFiles->removeFile(self::dirImgCategory(),$img_c);
                        }
                    }
                    return null;
                }
            }catch (Exception $e){
                magixglobal_model_system::magixlog('An error has occured :',$e);
            }
        }
    }

    /**
     * Mise à jour de l'image de la catégorie
     * @param $data
     */
    private function update_category_image($data){
        if(isset($this->img_c)){
            $imgc = self::insert_image_category(
                'img_c',
                $data['pathclibelle'].'_'.magixglobal_model_cryptrsa::random_generic_ui(),
                $data['img_c'],
                false
            );
            parent::u_catalog_category_image($imgc,$this->edit);
        }
    }

    /**
     * @access private
     * Retourne l'image de la catégorie
     * @param string $img_c
     */
    private function ajax_category_image($img_c){
        if($img_c != null){
            if(file_exists(self::dirImgCategory().$img_c)){
                $img = '<p><img src="/upload/catalogimg/category/'.$img_c.'" class="img-polaroid" alt="" /></p>';
                $img .= '<p><a href="#" data-delete="'.$img_c.'" class="btn delete-image"><span class="icon-trash"></span> Supprimer</a></p>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
            }
        }else{
            $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
        }
        print $img;
    }

    /**
     * Suppression de l'image de la catégorie
     */
    private function remove_category_image(){
        if(isset($this->delete_image)){
            $makeFiles = new magixcjquery_files_makefiles();
            if(file_exists(self::dirImgCategory().$this->delete_image)){
                $makeFiles->removeFile(self::dirImgCategory(),$this->delete_image);
            }
            parent::u_catalog_category_image(null,$this->edit);
        }
    }
    /**
     * Retourne la liste des sous catégories
     */
    private function json_listing_subcategory(){
        if(parent::s_catalog_subcategory($this->edit) != null){
            foreach (parent::s_catalog_subcategory($this->edit) as $key){
                if($key['s_content'] != null){
                    $content = 1;
                }else{
                    $content = 0;
                }
                if($key['img_s'] != null){
                    $img = 1;
                }else{
                    $img = 0;
                }
                $json_data[]= '{"idcls":'.json_encode($key['idcls']).
                    ',"idclc":'.json_encode($key['idclc']).
                    ',"slibelle":'.json_encode($key['slibelle']).
                    ',"s_content":'.json_encode($content).
                    ',"img":'.json_encode($img).
                    ',"iso":'.json_encode($key['iso']).'}';
            }
            print '['.implode(',',$json_data).']';
        }
    }

    /**
     * @access private
     * Insertion d'une catégorie
     */
    private function addSubCategory($create){
        if(isset($this->slibelle)){
            if(!empty($this->slibelle)){
                $pathslibelle = magixcjquery_url_clean::rplMagixString($this->slibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                parent::i_catalog_subcategory(
                    $this->slibelle,
                    $pathslibelle,
                    $this->edit
                );
                $create->display('catalog/request/success_add.phtml');
            }
        }
    }

    /**
     * Modification de l'ordre des sous catégories
     */
    private function update_order_subcategory(){
        if(isset($this->order_pages)){
            $p = $this->order_pages;
            for ($i = 0; $i < count($p); $i++) {
                parent::u_order_subcategory($i,$p[$i]);
            }
        }
    }
    // ####### SECTION SOUS CATEGORIES
    /**
     * Retourne les données pour l'édition de la sous catégorie
     * @param $create
     * @param $data
     */
    private function load_subcategory_edit_data($create,$data){
        /**
         * Retourne un tableau des données
         * @var
         */
        //Categorie
        $create->assign('idclc',$data['idclc'],true);
        $create->assign('clibelle',$data['clibelle'],true);
        //sous categorie
        $create->assign('idcls',$data['idcls'],true);
        $create->assign('slibelle',$data['slibelle'],true);
        $create->assign('pathslibelle',$data['pathslibelle'],true);
        $create->assign('s_content',$data['s_content'],true);
        $create->assign('iso',$data['iso'],true);
    }

    /**
     * Retourne l'URL de la sous catégorie
     * @param $data
     */
    private function json_uri_subcategory($data){
        if($data != null){
            $url = magixglobal_model_rewrite::filter_catalog_subcategory_url(
                $data['iso'],
                $data['pathclibelle'],
                $data['idclc'],
                $data['pathslibelle'],
                $data['idcls'],
                true
            );
            $categoryinput= '{"subcategorylink":'.json_encode(magixcjquery_url_clean::rplMagixString($url)).'}';
            print $categoryinput;
        }
    }
    /**
     * Mise à jour de la sous catégorie
     */
    private function update_subcategory($create){
        if(isset($this->slibelle)){
            if(!empty($this->slibelle)){
                if(!empty($this->pathslibelle)){
                    $pathslibelle = magixcjquery_url_clean::rplMagixString($this->pathslibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }else{
                    $pathslibelle = magixcjquery_url_clean::rplMagixString($this->slibelle,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }
                parent::u_catalog_subcategory(
                    $this->slibelle,
                    $pathslibelle,
                    $this->s_content,
                    $this->edit
                );
                $create->display('catalog/request/success_update.phtml');
            }
        }
    }
    /**
     * @access private
     * retourne le dossier des images catalogue des sous catégories
     * @return string
     */
    private function dirImgSubCategory(){
        try{
            return self::imgBasePath("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."subcategory".DIRECTORY_SEPARATOR);
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * Insertion d'une image pour la sous catégorie du catalogue
     * @access private
     * @param $img
     * @param $pathslibelle
     * @param null $img_s
     * @param bool $debug
     * @throws Exception
     * @return string
     */
    private function insert_image_subcategory($img,$pathslibelle,$img_s=null,$debug=false){
        if(isset($this->$img)){
            try{
                // Charge la classe pour le traitement du fichier
                $makeFiles = new magixcjquery_files_makefiles();
                if(!empty($this->$img)){
                    $initImg = new backend_model_image();
                    /**
                     * Envoi une image dans le dossier "racine" catalogimg
                     */
                    $initImg->upload_img(
                        $img,
                        'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR."subcategory".DIRECTORY_SEPARATOR,
                        $debug
                    );
                    /**
                     * Analyze l'extension du fichier en traitement
                     * @var $fileextends
                     */
                    $fileextends = $initImg->image_analyze(self::dirImgSubCategory().$this->$img);
                    if ($initImg->imgSizeMin(self::dirImgSubCategory().$this->$img,25,25)){
                        if(file_exists(self::dirImgSubCategory().$pathslibelle.$fileextends)){
                            $makeFiles->removeFile(self::dirImgSubCategory(),$img_s);
                        }
                        $makeFiles->renameFiles(
                            self::dirImgSubCategory(),
                            self::dirImgSubCategory().$this->$img,
                            self::dirImgSubCategory().$pathslibelle.$fileextends
                        );
                        /**
                         * Initialisation de la classe phpthumb
                         * @var void
                         */
                        $thumb = PhpThumbFactory::create(self::dirImgSubCategory().$pathslibelle.$fileextends);
                        /**
                         *
                         * Charge la taille des images des sous catégories du catalogue
                         */
                        foreach($initImg->arrayImgSize('catalog','subcategory') as $key){
                            switch($key['img_resizing']){
                                case 'basic':
                                    $thumb->resize($key['width'],$key['height'])->save(self::dirImgSubCategory().$pathslibelle.$fileextends);
                                    break;
                                case 'adaptive':
                                    $thumb->adaptiveResize($key['width'],$key['height'])->save(self::dirImgSubCategory().$pathslibelle.$fileextends);
                                    break;
                            }
                        }
                        // Supprime l'ancienne image
                        if(!empty($img_s)){
                            if(file_exists(self::dirImgSubCategory().$img_s)){
                                $makeFiles->removeFile(self::dirImgSubCategory(),$img_s);
                            }
                        }
                        return $pathslibelle.$fileextends;
                    }else{
                        if(file_exists(self::dirImgSubCategory().$this->$img)){
                            $makeFiles->removeFile(self::dirImgSubCategory(),$this->$img);
                        }else{
                            throw new Exception('file: '.$this->$img.' is not found');
                        }
                    }
                }else{
                    if(!empty($img_s)){
                        if(file_exists(self::dirImgSubCategory().$img_s)){
                            $makeFiles->removeFile(self::dirImgSubCategory(),$img_s);
                        }
                    }
                    return null;
                }
            }catch (Exception $e){
                magixglobal_model_system::magixlog('An error has occured :',$e);
            }
        }
    }
    /**
     * @access private
     * Retourne l'image de la sous catégorie
     * @param string $img_s
     */
    private function ajax_subcategory_image($img_s){
        if($img_s != null){
            if(file_exists(self::dirImgSubCategory().$img_s)){
                $img = '<p><img src="/upload/catalogimg/subcategory/'.$img_s.'" class="img-polaroid" alt="" /></p>';
                $img .= '<p><a href="#" data-delete="'.$img_s.'" class="btn delete-image"><span class="icon-trash"></span> Supprimer</a></p>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
            }
        }else{
            $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
        }
        print $img;
    }
    /**
     * Mise à jour de l'image de la catégorie
     * @param $data
     */
    private function update_subcategory_image($data){
        if(isset($this->img_s)){
            $imgs = self::insert_image_subcategory(
                'img_s',
                $data['pathslibelle'].'_'.magixglobal_model_cryptrsa::random_generic_ui(),
                $data['img_s'],
                true
            );
            parent::u_catalog_subcategory_image($imgs,$this->edit);
        }
    }
    /**
     * Suppression de l'image de la catégorie
     */
    private function remove_subcategory_image(){
        if(isset($this->delete_image)){
            $makeFiles = new magixcjquery_files_makefiles();
            if(file_exists(self::dirImgSubCategory().$this->delete_image)){
                $makeFiles->removeFile(self::dirImgSubCategory(),$this->delete_image);
            }
            parent::u_catalog_subcategory_image(null,$this->edit);
        }
    }

    // ####### SECTION PRODUITS
    private function addProduct($create){
        if(isset($this->titlecatalog)){
            if(!empty($this->titlecatalog)){
                $urlcatalog = magixcjquery_url_clean::rplMagixString($this->titlecatalog,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                parent::i_catalog_product(
                    $this->titlecatalog,
                    $urlcatalog,
                    $this->getlang,
                    $this->idadmin
                );
                $create->display('catalog/request/success_add.phtml');
            }
        }
    }

    /**
     * @param $create
     */
    private function update_product($create){
        if(isset($this->titlecatalog)){
            if(!empty($this->titlecatalog)){
                if(!empty($this->urlcatalog)){
                    $urlcatalog = magixcjquery_url_clean::rplMagixString($this->urlcatalog,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }else{
                    $urlcatalog = magixcjquery_url_clean::rplMagixString($this->titlecatalog,array('dot'=>false,'ampersand'=>'strict','cspec'=>'','rspec'=>''));
                }
                if(!empty($this->price)){
                    $price = number_format($this->price,0,'.',',');
                }else{
                    $price = null;
                }
                if(!empty($this->desccatalog)){
                    $desccatalog = $this->desccatalog;
                }else{
                    $desccatalog = null;
                }
                parent::u_catalog_product(
                    $this->titlecatalog,
                    $urlcatalog,
                    $desccatalog,
                    $price,
                    $this->edit,
                    $this->idadmin
                );
                $create->display('catalog/request/success_update.phtml');
            }
        }
    }
    /**
     * Retourne au format JSON la liste des produits
     * @param $limit
     */
    private function json_listing_product($limit){
        $pager = new magixglobal_model_pager();
        $max = $limit;
        $offset= $pager->set_pagination_offset($limit,$this->getpage);
        $role = new backend_model_role();
        $sort = 'idcatalog';
        if(parent::s_catalog($this->getlang,$role->sql_arg(),$limit,$max,$offset,$sort) != null){
            foreach (parent::s_catalog($this->getlang,$role->sql_arg(),$limit,$max,$offset,$sort) as $key){
                if($key['desccatalog'] != null){
                    $content = 1;
                }else{
                    $content = 0;
                }
                if($key['imgcatalog'] != null){
                    $img = 1;
                }else{
                    $img = 0;
                }
                if($key['price'] != null){
                    $price = number_format($key['price'],0,',','.');
                }else{
                    $price = 0;
                }
                $json_data[]= '{"idcatalog":'.json_encode($key['idcatalog']).
                    ',"urlcatalog":'.json_encode($key['urlcatalog']).
                    ',"titlecatalog":'.json_encode($key['titlecatalog']).
                    ',"content":'.json_encode($content).
                    ',"price":'.json_encode($price).
                    ',"img":'.json_encode($img).
                    ',"iso":'.json_encode($key['iso']).
                    ',"pseudo":'.json_encode($key['pseudo']).'}';
            }
            print '['.implode(',',$json_data).']';
        }
    }

    /**
     * Retourne la pagination pour les produits
     * @param $limit
     * @return null|string
     */
    private function product_pagination($limit){
        $dbcatalog = parent::s_catalog_count($this->getlang);
        $total = $dbcatalog['total'];
        // *** Set pagination
        $dataPager = null;
        if (isset($total) AND isset($limit)) {
            $lib_rewrite = new magixglobal_model_rewrite();
            $basePath = '/'.PATHADMIN.'/catalog.php?section=product&amp;getlang='.$this->getlang.'&amp;';
            $dataPager = magixglobal_model_pager::set_pagination_data(
                $total,
                $limit,
                $basePath,
                $this->getpage,
                '='
            );
            $pagination = null;
            if ($dataPager != null) {
                $pagination = '<div class="pagination">';
                $pagination .= '<ul>';
                foreach ($dataPager as $row) {
                    switch ($row['name']){
                        case 'first':
                            $name = '<<';
                            break;
                        case 'previous':
                            $name = '<';
                            break;
                        case 'next':
                            $name = '>';
                            break;
                        case 'last':
                            $name = '>>';
                            break;
                        default:
                            $name = $row['name'];
                    }
                    $classItem = ($name == $this->getpage) ? ' class="active"' : null;
                    $pagination .= '<li'.$classItem.'>';
                    $pagination .= '<a href="'.$row['url'].'" title="'.$name.'" >';
                    $pagination .= $name;
                    $pagination .= '</a>';
                    $pagination .= '</li>';
                }
                $pagination .= '</ul>';
                $pagination .= '</div>';
            }
            unset($total);
            unset($limit);
        }
        return $pagination;
    }

    /**
     * @param $create
     * @param $data
     */
    private function load_product_edit_data($create,$data){
        $create->assign(
            array(
                'idcatalog'     =>  $data['idcatalog'],
                'urlcatalog'    =>  $data['urlcatalog'],
                'titlecatalog'  =>  $data['titlecatalog'],
                'desccatalog'   =>  $data['desccatalog'],
                'iso'           =>  $data['iso']
            )
        );
    }
    /**
     * @access private
     * retourne le dossier des images catalogue des sous catégories
     * @return string
     */
    private function dirImgProduct(){
        try{
            return self::imgBasePath("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR);
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }
    /**
     * Insertion d'une image à un produit spécifique
     */
    private function insert_image_product($img,$urlimg,$imgcatalog=null,$debug=false){
        if(isset($this->$img)){
            //Supprime le fichier original pour gagner en espace
            $makeFiles = new magixcjquery_files_makefiles();
            // Charge la classe de traitement des images
            $initImg = new backend_model_image();
            try{
                if(!empty($this->$img)){
                    /**
                     * Envoi une image dans le dossier "racine" catalogimg
                     */
                    $initImg->upload_img(
                        'imgcatalog',
                        'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR,
                        $debug
                    );
                    /**
                     * Analyze l'extension du fichier en traitement
                     * @var $fileextends
                     */
                    $fileextends = $initImg->image_analyze(self::dirImgProduct().$this->$img);

                    if ($initImg->imgSizeMin(self::dirImgProduct().$this->$img,25,25)){
                        // Charge la classe pour renommer le fichier
                        if(file_exists(self::dirImgProduct().$urlimg.$fileextends)){
                            $makeFiles->removeFile(self::dirImgProduct(),$imgcatalog);
                        }
                        $makeFiles->renameFiles(
                            self::dirImgProduct(),
                            self::dirImgProduct().$this->$img,
                            self::dirImgProduct().$urlimg.$fileextends
                        );
                        /**
                         * Initialisation de la classe phpthumb
                         * @var void
                         */
                        $thumb = PhpThumbFactory::create(self::dirImgProduct().$urlimg.$fileextends);
                        $firebug = new magixcjquery_debug_magixfire();
                        /**
                         * Création des images et miniatures utile.
                         * 3 tailles !!!
                         */

                        $imgsizelarge = $initImg->dataImgSize('catalog','product','large');
                        $imgsizemed = $initImg->dataImgSize('catalog','product','medium');
                        $imgsizesmall = $initImg->dataImgSize('catalog','product','small');
                        if($debug){
                            $firebug->magixFireGroup('Setting image');
                        }
                        switch($imgsizelarge['img_resizing']){
                            case 'basic':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
                                    $firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizelarge['width'],'Width');
                                    $firebug->magixFireLog($imgsizelarge['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->resize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                            case 'adaptive':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
                                    $firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizelarge['width'],'Width');
                                    $firebug->magixFireLog($imgsizelarge['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->adaptiveResize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                        }
                        switch($imgsizemed['img_resizing']){
                            case 'basic':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizemed['config_size_attr'].' => '.$imgsizemed['type']);
                                    $firebug->magixFireLog($imgsizemed['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizemed['width'],'Width');
                                    $firebug->magixFireLog($imgsizemed['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->resize($imgsizemed['width'],$imgsizemed['height'])->save(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                            case 'adaptive':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizemed['config_size_attr'].' => '.$imgsizemed['type']);
                                    $firebug->magixFireLog($imgsizemed['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizemed['width'],'Width');
                                    $firebug->magixFireLog($imgsizemed['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->adaptiveResize($imgsizemed['width'],$imgsizemed['height'])->save(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                        }
                        switch($imgsizesmall['img_resizing']){
                            case 'basic':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
                                    $firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizesmall['width'],'Width');
                                    $firebug->magixFireLog($imgsizesmall['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                            case 'adaptive':
                                if($debug){
                                    $firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
                                    $firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
                                    $firebug->magixFireLog($imgsizesmall['width'],'Width');
                                    $firebug->magixFireLog($imgsizesmall['height'],'Height');
                                    $firebug->magixFireGroupEnd();
                                }
                                $thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR.$urlimg.$fileextends);
                                break;
                        }
                        if($debug){
                            $firebug->magixFireGroupEnd();
                        }
                        //Supprime l'image temporaire
                        if(file_exists(self::dirImgProduct().$urlimg.$fileextends)){
                            $makeFiles->removeFile(self::dirImgProduct(),$urlimg.$fileextends);
                        }
                        // Supprime l'ancienne image
                        if(!empty($imgcatalog)){
                            if(file_exists(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog)){
                                $makeFiles->removeFile(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR,$imgcatalog);
                                $makeFiles->removeFile(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR,$imgcatalog);
                                $makeFiles->removeFile(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR,$imgcatalog);
                            }
                        }
                        return $urlimg.$fileextends;
                    }else{
                        if(file_exists(self::dirImgProduct().$this->$img)){
                            $makeFiles->removeFile(self::dirImgProduct(),$this->$img);
                        }else{
                            throw new Exception('file: '.$this->$img.' is not found');
                        }
                    }
                }else{
                    if(!empty($imgcatalog)){
                        if(file_exists(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog)){
                            $makeFiles->removeFile(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR,$imgcatalog);
                            $makeFiles->removeFile(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR,$imgcatalog);
                            $makeFiles->removeFile(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR,$imgcatalog);
                        }
                    }
                    return null;
                }
            }catch (Exception $e){
                magixglobal_model_system::magixlog('An error has occured :',$e);
            }
        }
    }

    /**
     * Mise à jour de l'image du produit
     * @param $data
     */
    private function update_product_image($data){
        if(isset($this->imgcatalog)){
            $imgp = self::insert_image_product(
                'imgcatalog',
                magixglobal_model_cryptrsa::random_generic_ui(),
                $data['imgcatalog'],
                true
            );
            parent::u_catalog_product_image($imgp,$this->edit);
        }
    }
    /**
     * Suppression de l'image de la catégorie
     */
    private function remove_product_image(){
        if(isset($this->delete_image)){
            $makeFiles = new magixcjquery_files_makefiles();
            if(file_exists(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$this->delete_image)){
                $makeFiles->removeFile(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR,$this->delete_image);
                $makeFiles->removeFile(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR,$this->delete_image);
                $makeFiles->removeFile(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR,$this->delete_image);
            }
            parent::u_catalog_product_image(null,$this->edit);
        }
    }
    /**
     * @access private
     * Retourne l'image du produit
     * @param string $imgcatalog
     */
    private function ajax_product_image($imgcatalog){
        $img = '<div class="container-fluid">';
        if($imgcatalog != null){
            if(file_exists(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog)){
                $small = getimagesize(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR.$imgcatalog);
                $medium = getimagesize(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog);
                $product = getimagesize(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR.$imgcatalog);
                $img .= '<p>';
                $img .= '<a href="#" data-delete="'.$imgcatalog.'" class="btn btn-block delete-image"><span class="icon-trash"></span> Supprimer</a>';
                $img .= '</p>';
                $img .= '<ul class="thumbnails">';
                $img .= '<li class="span2">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/mini/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="unstyled">';
                            $img .= '<li>width:'.$small[0].'</li>';
                            $img .= '<li>height:'.$small[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</li>';
                $img .= '<li class="span3">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/medium/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="unstyled">';
                            $img .= '<li>width:'.$medium[0].'</li>';
                            $img .= '<li>height:'.$medium[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</li>';
                $img .= '<li class="span5">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/product/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="unstyled">';
                            $img .= '<li>width:'.$product[0].'</li>';
                            $img .= '<li>height:'.$product[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</li>';
                $img .= '</ul>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
            }
        }else{
            $img .= '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-polaroid" /></p>';
        }
        $img .= '</div>';
        print $img;
    }
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
		/*if(magixcjquery_filter_request::isGet('category')){
			if(magixcjquery_filter_request::isGet('delc')){
				self::delete_catalog_category();
			}elseif(magixcjquery_filter_request::isGet('dels')){
				self::delete_catalog_subcategory();
			}elseif(magixcjquery_filter_request::isGet('post')){
				self::post_category();
			}else{
				if(magixcjquery_filter_request::isGet('getlang')){
					if(magixcjquery_filter_request::isGet('json_cat')){
						$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
						$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
						$header->pragma();
						$header->cache_control("nocache");
						$header->getStatus('200');
						$header->json_header("UTF-8");
						self::json_list_category();
					}else{
						backend_controller_template::assign('language', $this->parent_language($this->getlang));
						backend_controller_template::display('catalog/category_language.phtml');
					}
				}else{
					backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
					backend_controller_template::display('catalog/category.phtml');
				}
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
			}elseif(magixcjquery_filter_request::isGet('imgsubcat')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				self::json_img_subcategory();
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
			}elseif(magixcjquery_filter_request::isPost('delproduct')){
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
			if(magixcjquery_filter_request::isGet('json_google_chart_catalog')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_catalog_chart();
			}else{
				backend_controller_template::display('catalog/index.phtml');
			}
		}*/
        if(isset($this->section)){
            if($this->section === 'category'){
                if(isset($this->getlang)){
                    if(isset($this->action)){
                        if($this->action === 'list'){
                            if(magixcjquery_filter_request::isGet('json_list_category')){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_listing_category();
                            }
                        }elseif($this->action === 'add'){
                            if(isset($this->clibelle)){
                                $this->addCategory($create);
                            }
                        }elseif($this->action === 'edit'){
                            if(isset($this->edit)){
                                $data = parent::s_catalog_category_data($this->edit);
                                if(magixcjquery_filter_request::isGet('json_uri_category')){
                                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                    $header->pragma();
                                    $header->cache_control("nocache");
                                    $header->getStatus('200');
                                    $header->json_header("UTF-8");
                                    $this->json_uri_category($data);
                                }elseif(magixcjquery_filter_request::isGet('json_list_subcategory')){
                                    $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                    $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                    $header->pragma();
                                    $header->cache_control("nocache");
                                    $header->getStatus('200');
                                    $header->json_header("UTF-8");
                                    $this->json_listing_subcategory();
                                }else{
                                    if(isset($this->tab)){
                                        if($this->tab === 'image'){
                                            if(isset($this->img_c)){
                                                $this->update_category_image($data);
                                            }elseif(magixcjquery_filter_request::isGet('ajax_category_image')){
                                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                                $header->pragma();
                                                $header->cache_control("nocache");
                                                $header->getStatus('200');
                                                $header->html_header("UTF-8");
                                                $this->ajax_category_image($data['img_c']);
                                            }else{
                                                $this->load_category_edit_data($create,$data);
                                                $create->display('catalog/category/edit.phtml');
                                            }
                                        }elseif($this->tab === 'subcat'){
                                            if(isset($this->slibelle)){
                                                $this->addSubCategory($create);
                                            }elseif(isset($this->order_pages)){
                                                $this->update_order_subcategory();
                                            }else{
                                                $this->load_category_edit_data($create,$data);
                                                $create->display('catalog/category/edit.phtml');
                                            }
                                        }elseif($this->tab === 'product'){
                                            $this->load_category_edit_data($create,$data);
                                            $create->display('catalog/category/edit.phtml');
                                        }
                                    }else{
                                        if(isset($this->clibelle)){
                                            $this->update_category($create);
                                        }elseif(isset($this->delete_image)){
                                            $this->remove_category_image();
                                        }else{
                                            $this->load_category_edit_data($create,$data);
                                            $create->display('catalog/category/edit.phtml');
                                        }
                                    }
                                }
                            }else{
                                if(isset($this->order_pages)){
                                    $this->update_order_category();
                                }
                            }
                        }elseif($this->action === 'remove'){

                        }
                    }else{
                        $create->display('catalog/category/list.phtml');
                    }
                }
            }elseif($this->section === 'subcategory'){
                if(isset($this->getlang)){
                    if(isset($this->action)){
                        if($this->action === 'add'){

                        }elseif($this->action === 'edit'){
                            if(isset($this->edit)){
                                $data = parent::s_catalog_subcategory_data($this->edit);
                                if(isset($this->tab)){
                                    if($this->tab === 'image'){
                                        if(magixcjquery_filter_request::isGet('ajax_subcategory_image')){
                                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                            $header->pragma();
                                            $header->cache_control("nocache");
                                            $header->getStatus('200');
                                            $header->html_header("UTF-8");
                                            $this->ajax_subcategory_image($data['img_s']);
                                        }elseif(isset($this->img_s)){
                                            $this->update_subcategory_image($data);
                                        }else{
                                            $this->load_subcategory_edit_data($create,$data);
                                            $create->display('catalog/subcategory/edit.phtml');
                                        }
                                    }elseif($this->tab === 'product'){
                                        $this->load_subcategory_edit_data($create,$data);
                                        $create->display('catalog/subcategory/edit.phtml');
                                    }
                                }else{
                                    if(magixcjquery_filter_request::isGet('json_uri_subcategory')){
                                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                        $header->pragma();
                                        $header->cache_control("nocache");
                                        $header->getStatus('200');
                                        $header->json_header("UTF-8");
                                        $this->json_uri_subcategory($data);
                                    }elseif(isset($this->slibelle)){
                                        $this->update_subcategory($create);
                                    }elseif(isset($this->delete_image)){
                                        $this->remove_subcategory_image();
                                    }else{
                                        $this->load_subcategory_edit_data($create,$data);
                                        $create->display('catalog/subcategory/edit.phtml');
                                    }
                                }
                            }
                        }
                    }
                }
            }elseif($this->section === 'product'){
                if(isset($this->getlang)){
                    if(isset($this->action)){
                        if($this->action === 'list'){
                            if(magixcjquery_filter_request::isGet('json_listing_product')){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_listing_product(20);
                            }
                        }elseif($this->action === 'add'){
                            if(isset($this->titlecatalog)){
                                $this->addProduct($create);
                            }
                        }elseif($this->action === 'edit'){
                            $data = parent::s_catalog_data($this->edit);
                            if(isset($this->tab)){
                                if($this->tab === 'image'){
                                    if(isset($this->imgcatalog)){
                                        $this->update_product_image($data);
                                    }elseif(magixcjquery_filter_request::isGet('ajax_product_image')){
                                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                        $header->pragma();
                                        $header->cache_control("nocache");
                                        $header->getStatus('200');
                                        $header->html_header("UTF-8");
                                        $this->ajax_product_image($data['imgcatalog']);
                                    }else{
                                        $this->load_product_edit_data($create,$data);
                                        $create->display('catalog/product/edit.phtml');
                                    }
                                }elseif($this->tab === 'category'){
                                    $this->load_product_edit_data($create,$data);
                                    $create->display('catalog/product/edit.phtml');
                                }elseif($this->tab === 'product'){
                                    $this->load_product_edit_data($create,$data);
                                    $create->display('catalog/product/edit.phtml');
                                }elseif($this->tab === 'galery'){
                                    $this->load_product_edit_data($create,$data);
                                    $create->display('catalog/product/edit.phtml');
                                }
                            }else{
                                if(isset($this->delete_image)){
                                    $this->remove_product_image();
                                }if(isset($this->titlecatalog)){
                                    $this->update_product($create);
                                }else{
                                    $this->load_product_edit_data($create,$data);
                                    $create->display('catalog/product/edit.phtml');
                                }
                            }
                        }
                    }else{
                        $create->assign('pagination',$this->product_pagination(20));
                        $create->display('catalog/product/list.phtml');
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
                $create->display('catalog/index.phtml');
            }
        }
	}
}
/**
 * Class pour les statistiques du catalogue
 * @author Gérits Aurélien <aurelien@magix-cms.com> | <gerits.aurelien@gmail.com>
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