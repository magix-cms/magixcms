<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    3.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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
	 * Modification de l'ordre des sous catégories
	 * @var sorder
	 */
	public $sorder;
	/**
	 * get pour la requête json des sous catégories d'une catégorie
	 * @var string
	 */
	public $getidclc;
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
	/**
	 * Constructor
	 */
	function __construct(){
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
		if(magixcjquery_filter_request::isGet('getidclc')) {
			$this->getidclc = (integer) magixcjquery_filter_isVar::isPostFloat($_GET['getidclc']);
		}
		if(magixcjquery_filter_request::isGet('delproduct')){
			$this->delproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delproduct']);
		}
		if(magixcjquery_filter_request::isGet('dels')){
			$this->dels = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dels']);
		}
		if(magixcjquery_filter_request::isGet('delc')){
			$this->delc = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delc']);
		}
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
		if(magixcjquery_filter_request::isGet('upcat')){
			$this->upcat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['upcat']);
		}
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
		if(magixcjquery_filter_request::isGet('geturicat')){
			$this->geturicat = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['geturicat']);
		}
		if(magixcjquery_filter_request::isGet('getreluri')){
			$this->getreluri = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getreluri']);
		}
		if(magixcjquery_filter_request::isGet('d_in_product')){
			$this->d_in_product = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['d_in_product']);
		}
		if(magixcjquery_filter_request::isGet('d_rel_product')){
			$this->d_rel_product = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['d_rel_product']);
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
				$category .= '<li class="ui-state-default ui-corner-all" id="corder_'.$cat['idclc'].'">';
				$category .= '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$category .= '<div class="sortdivfloat">'.$cat['clibelle'].'</div>';
				$category .= '<div style="float:right;"><a style="float:left;" class="ucategory" href="#" title="'.$cat['idclc'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
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
	 * @access private
	 * Affiche le menu "sortable" avec les éléments des sous catégorie
	 */
	private function catalog_sub_category_order(){
		$category = null;
		if(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() != null){
			$category = '<ul id="sortsubcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() as $cat){
				$category .= '<li class="ui-state-default ui-corner-all" id="sorder_'.$cat['idcls'].'">';
				$category .= '<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>';
				$category .= '<div class="sortdivfloat">'.$cat['slibelle'].'</div>';
				$category .= '<div style="float:left;" class="ui-icon ui-icon-arrowthick-1-e"></div>';
				$category .= $cat['clibelle'].'<div style="float:right;"><a style="float:left;" class="usubcategory" href="#" title="'.$cat['idcls'].'"><span class="ui-icon ui-icon-pencil"></span></a>';
				$category .= '<a class="aspanfloat dels" href="#" title="'.$cat['idcls'].'"><span class="ui-icon ui-icon-close"></span></a>';
				$category .= '</div></li>';
			}
			$category .= '</ul>';
		}
		return $category;
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
	private function insert_image_category($img,$pathclibelle){
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
				if (backend_model_image::imgSizeMin(self::dir_img_category().$this->$img,50,50)){
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
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
						$imgc = self::insert_image_category('img_c',$this->pathclibelle);
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
				$fileextends = backend_model_image::image_analyze(self::dir_img_subcategory().$this->$img);
				if (backend_model_image::imgSizeMin(self::dir_img_subcategory().$this->$img,50,50)){
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
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
						$makeFiles->removeFile(self::dir_img_subcategory().$this->$img);
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
		$product = <<<EOT
		<table class="clear" style="margin-left:2em;width:50%">
			<thead>
				<tr>
				<th>ID</th>
				<th><span style="float:left;" class="ui-icon ui-icon-folder-open"></span></th>
				<th><span style="float:left;" class="ui-icon ui-icon-folder-collapsed"></span></th>
				<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
				</tr>
			</thead>
			<tbody>
EOT;
		foreach(backend_db_catalog::adminDbCatalog()->s_catalog_product($this->editproduct) as $prod){
			$product .='
			<tr class="line">
				<td class="nowrap">'.$prod['idproduct'].'</td>	
				<td class="nowrap">'.$prod['clibelle'].'</td>
				<td class="nowrap">'.$prod['slibelle'].'</td>
				<td class="minimal"><a href="#" class="d-in-product" title="'.$prod['idproduct'].'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>
			</tr>';
		}
		$product .= <<<EOT
			</tbody>
		</table>
EOT;
	return $product;
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
			$product = '<ul style="margin-left:1em;">';
			//foreach(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->geturicat) as $prod){
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_product($this->geturicat) as $prod){
				$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($prod['idproduct']);
				$product .= '<li style="list-style-type: square;">
				<a href="'
				.magixglobal_model_rewrite::filter_catalog_product_url(
					$prod['codelang'], 
					$prod['pathclibelle'], 
					$prod['idclc'], 
					$prod['urlcatalog'], 
					$prod['idproduct'],
					true
				).'">'.magixglobal_model_rewrite::filter_catalog_product_url(
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
		/*$category = '<select id="idproduct" name="idproduct">';
		$category .='<option value="">Aucun produits</option>';*/
		$category ='';
		$idcls = '';
		foreach ($admindb as $row){
			if ($row['slibelle'] != $idcls) {
				if ($idcls != '') { $category .= "</optgroup>\n"; }
			       $category .= '<optgroup label="'.$row['slibelle'].'">';
			}
			if ($row['idcls'] != 0) {
				$category .= '<option value="'.$row['idproduct'].'">'.$row['titlecatalog'].'</option>';
			}
			$idcls = $row['slibelle'];
		}
		if ($idcls != '') { $category .= "</optgroup>\n"; }
		if ($idcls == '') {
			$category .= '<optgroup label="Pas de sous catégorie">';
			foreach ($admindb as $row){
				if ($row['idcls'] == 0) {
					$category .= '<option value="'.$row['idproduct'].'">'.$row['titlecatalog'].'</option>';
				}
			}
		}
		if ($idcls == '') { $category .= "</optgroup>\n"; }
		print  $category;
	}
	/**
	 * @category json request
	 * @access private
	 * Requête json pour le chargement des sous catégories associé à une catégorie
	 */
	private function json_idcls(){
		if(backend_db_catalog::adminDbCatalog()->s_json_subcategory($this->selidclc) != null){
			//print_r(backend_db_catalog::adminDbCatalog()->s_json_subcategory(2));
			foreach (backend_db_catalog::adminDbCatalog()->s_json_subcategory($this->selidclc) as $list){
				if($list['idcls'] != 0){
					$subcat[]= json_encode($list['idcls']).':'.json_encode($list['slibelle']);
				}else{
					$subcat[] = json_encode("0").':'.json_encode("Aucune sous catégorie");
				}
			}
			print '{'.implode(',',$subcat).'}';
		}
		/*}else{
			print '{"0":""}';
		}*/
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
	 * La liste des produit lié à une fiche
	 */
	private function list_rel_product(){
		$product = <<<EOT
		<table class="clear" style="margin-left:2em;width:50%">
			<thead>
				<tr>
				<th>ID</th>
				<th><span style="float:left;" class="ui-icon ui-icon-folder-open"></span></th>
				<th><span style="float:left;" class="ui-icon ui-icon-folder-collapsed"></span></th>
				<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
				<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
				</tr>
			</thead>
			<tbody>
EOT;
		foreach(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->editproduct) as $prod){
			$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($prod['idproduct']);
			$product .='
			<tr class="line">
				<td class="nowrap">'.$prod['idrelproduct'].'</td>
				<td class="nowrap">'.$info['clibelle'].'</td>
				<td class="nowrap">'.$info['slibelle'].'</td>
				<td class="nowrap">'.$info['titlecatalog'].'</td>
				<td class="minimal"><a href="#" class="d-rel-product" title="'.$prod['idrelproduct'].'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>
			</tr>';
		}
		$product .= <<<EOT
			</tbody>
		</table>
EOT;
	return $product;
	}
	/**
	 * @access private
	 * Retourne la liste des urls de liaison d'un produit défini
	 */
	private function uri_rel_product(){
		if(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->getreluri) != null){
			$product = '<ul style="margin-left:1em;">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_rel_product($this->getreluri) as $prod){
				$info = backend_db_catalog::adminDbCatalog()->s_catalog_product_info($prod['idproduct']);
				$product .= '<li style="list-style-type: square;"><a href="'
				.magixglobal_model_rewrite::filter_catalog_product_url(
					$info['codelang'], 
					$info['pathclibelle'], 
					$info['idclc'], 
					$info['urlcatalog'], 
					$info['idproduct'],
					true
				).'">'.magixglobal_model_rewrite::filter_catalog_product_url(
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
		backend_config_smarty::getInstance()->assign('list_category_in_product',self::list_category_in_product());
		backend_config_smarty::getInstance()->assign('list_rel_product',self::list_rel_product());
		//backend_config_smarty::getInstance()->assign('select_product',self::construct_select_product());
		//$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
	}
	/**
	 * chargement des données d'un produit pour le déplacement de catégorie
	 */
	private function load_data_move_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->moveproduct);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('clibelle',$data['clibelle']);
		backend_config_smarty::getInstance()->assign('idclc',$data['idclc']);
		backend_config_smarty::getInstance()->assign('slibelle',$data['slibelle']);
		backend_config_smarty::getInstance()->assign('idcls',$data['idcls']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		//$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
	}
	/**
	 * chargement des données d'un produit pour la copie d'un produit dans plusieurs catégorie
	 */
	private function load_data_copy_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->copyproduct);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('clibelle',$data['clibelle']);
		backend_config_smarty::getInstance()->assign('idclc',$data['idclc']);
		backend_config_smarty::getInstance()->assign('slibelle',$data['slibelle']);
		backend_config_smarty::getInstance()->assign('idcls',$data['idcls']);
		backend_config_smarty::getInstance()->assign('desccatalog',$data['desccatalog']);
		backend_config_smarty::getInstance()->assign('price',$data['price']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		//$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
	}
	/**
	 * Chargement des données d'un produit pour l'insertion d'une image
	 */
	private function load_data_image_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->getimg);
		backend_config_smarty::getInstance()->assign('idproduct',$data['idcatalog']);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
//		backend_config_smarty::getInstance()->assign('clibelle',$data['clibelle']);
//		backend_config_smarty::getInstance()->assign('idclc',$data['idclc']);
//		backend_config_smarty::getInstance()->assign('slibelle',$data['slibelle']);
//		backend_config_smarty::getInstance()->assign('idcls',$data['idcls']);
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
		if(isset($this->idclc)){
				backend_db_catalog::adminDbCatalog()->u_catalog_product_move(
					$this->idclc,
					$this->idcls,
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
		if(isset($this->idclc)){
			if(empty($this->idclc)){
				backend_config_smarty::getInstance()->display('catalog/request/empty.phtml');
			}elseif($this->idclc == 0){
				backend_config_smarty::getInstance()->display('catalog/request/nocategory.phtml');
			}else{
				backend_db_catalog::adminDbCatalog()->copy_catalog_product(
					$this->idclc,
					$this->idcls,
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
		//return $_SERVER['DOCUMENT_ROOT'].'/upload/catalogimg/';
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
				if (backend_model_image::imgSizeMin(self::dir_img_product().$this->imgcatalog,50,50)){
					// Sélectionne et retourne le nom du produit
					$simg = backend_db_catalog::adminDbCatalog()->s_uniq_url_catalog($this->getimg);
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
					$makeFiles->renameFiles(self::dir_img_product(),self::dir_img_product().$this->imgcatalog,self::dir_img_product().$simg['urlcatalog'].'-'.$this->getimg.$fileextends);
					/**
					 * Vérifie si le produit contient déjà une image 
					 * @var intéger
					 */
					$count = backend_db_catalog::adminDbCatalog()->count_image_product($this->getimg);
					if($count['cimage'] == 0){
						backend_db_catalog::adminDbCatalog()->i_image_catalog($this->getimg,$simg['urlcatalog'].'-'.$this->getimg.$fileextends);
					}else{
						backend_db_catalog::adminDbCatalog()->u_image_catalog($this->getimg,$simg['urlcatalog'].'-'.$this->getimg.$fileextends);
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
					//Supprime le fichier original pour gagner en espace
					$makeFiles = new magixcjquery_files_makefiles();
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
		//return $_SERVER['DOCUMENT_ROOT'].'/upload/catalogimg/galery/';
		return self::def_dirimg_frontend("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR."galery".DIRECTORY_SEPARATOR);
	}
	/**
	 * Insertion d'une image dans la galerie spéifique à un produit
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
				if (backend_model_image::imgSizeMin(self::dir_micro_galery().$this->imggalery,50,50)){
					// Sélectionne et retourne le nom du produit
					$simg = backend_db_catalog::adminDbCatalog()->s_uniq_url_catalog($this->getimg);
					// Compte le nombre d'image dans la galerie et incrémente de un
					$numbimg = backend_db_catalog::adminDbCatalog()->count_image_in_galery_product($this->getimg);
					$number = $numbimg['cimage']+1;
					// Charge la classe pour renommer le fichier
					$makeFiles = new magixcjquery_files_makefiles();
					$makeFiles->renameFiles(self::dir_micro_galery(),self::dir_micro_galery().$this->imggalery,self::dir_micro_galery().$simg['urlcatalog'].'-'.$this->getimg.'-'.$number.$fileextends);
					/**
					 * Insére l'image dans la base de donnée
					 */
					backend_db_catalog::adminDbCatalog()->i_galery_image_catalog($this->getimg,$simg['urlcatalog'].'-'.$this->getimg.'-'.$number.$fileextends);
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
					if(file_exists(self::dir_micro_galery().$this->getimg)){
						$makeFiles->removeFile(self::dir_micro_galery(),$this->getimg);
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
				}/*else{
					throw new Exception('file: '.$dfile['imgcatalog'].' is not found');
				}*/
				backend_db_catalog::adminDbCatalog()->d_galery_image_catalog($this->delmicro);
				backend_config_smarty::getInstance()->display('catalog/request/success-delete-mg.phtml');
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * Affiche les images de la galerie d'un produit spécifique
	 * @access public
	 */
	private function view_galery_in_product(){
		if(isset($this->getimg)){
			$count = backend_db_catalog::adminDbCatalog()->count_image_in_galery_product($this->getimg);
			$galery = null;
			if($count['cimage'] != 0){
			$galery .= '<div id="list-image-galery">';
			foreach(backend_db_catalog::adminDbCatalog()->s_image_in_galery_product($this->getimg) as $img){
				$galery .= '<div class="list-img">';
				$galery .= '<div class="title-galery-image ui-widget-header ui-corner-all"><div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div> <a href="#" class="delmicro" title="'.$img['idmicro'].'">Supprimer</a></div>';
				$galery .= '<div class="img-galery">'.'<img src="'.magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/galery/mini/'.$img['imgcatalog'].'" alt="'.$img['imgcatalog'].'" />'.'</div>';
				$galery .= '</div>';
			}
			$galery .= '<div style="clear:both;"></div></div>';
			}
			return $galery;
		}
	}
	/*function construct_select_product(){
		backend_db_catalog::adminDbCatalog()->s_idcatalog_product();
	}*/
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
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->display('catalog/moveproduct.phtml');
	}
	/**
	 * Affiche la copie d'un produit
	 * @access public
	 */
	private function display_copy_product(){
		self::load_data_copy_product();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
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
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->assign('category_order',self::catalog_category_order());
		backend_config_smarty::getInstance()->assign('subcategory_order',self::catalog_sub_category_order());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	/**
	 * @access private
	 * Mise à jour d'un catégorie
	 */
	private function update_category(){
		if(isset($this->upcat)){
			if(isset($this->update_category)){
				$imgc = null;
				if($this->update_img_c != null){
					$imgc = self::insert_image_category('update_img_c',$this->update_pathclibelle);
				}
				magixcjquery_debug_magixfire::magixFireLog($this->update_img_c,'Evoi image');
				backend_db_catalog::adminDbCatalog()->u_catalog_category($this->update_category,$this->update_pathclibelle,$imgc,$this->upcat);
				backend_config_smarty::getInstance()->display('request/update-category.phtml');
			}
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
			backend_config_smarty::getInstance()->assign('img_c',$clibelle['img_c']);
		}
		backend_config_smarty::getInstance()->display('catalog/editcategory.phtml');
	}
	/**
	 * @access private
	 * Mise à jour d'une sous catégorie
	 */
	private function update_subcategory(){
		if(isset($this->upsubcat)){
			if(isset($this->update_subcategory)){
				$imgs = null;
				if($this->update_img_s != null){
					$imgs = self::insert_image_subcategory('update_img_s',$this->update_pathslibelle);
				}
				backend_db_catalog::adminDbCatalog()->u_catalog_subcategory($this->update_subcategory,$this->update_pathslibelle,$imgs,$this->upsubcat);
				backend_config_smarty::getInstance()->display('request/update-subcategory.phtml');
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
		}
		backend_config_smarty::getInstance()->display('catalog/editsubcategory.phtml');
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
	/**
	 * affiche la page d'insertion d'une image
	 * @access public
	 */
	private function display_product_image(){
		self::load_data_image_product();
		$getimg = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
		if($getimg['imgcatalog'] != null){
			if(file_exists(self::dir_img_product().'product'.DIRECTORY_SEPARATOR.$getimg['imgcatalog'])){
				$gsize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').magixcjquery_html_helpersHtml::unixSeparator().'product'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
				$psize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').magixcjquery_html_helpersHtml::unixSeparator().'medium'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
				$ssize = getimagesize(self::def_dirimg_frontend('upload/catalogimg').magixcjquery_html_helpersHtml::unixSeparator().'mini'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
				backend_config_smarty::getInstance()->assign('gwidth',$gsize[0]);
				backend_config_smarty::getInstance()->assign('gheight',$gsize[1]);
				backend_config_smarty::getInstance()->assign('pwidth',$psize[0]);
				backend_config_smarty::getInstance()->assign('pheight',$psize[1]);
				backend_config_smarty::getInstance()->assign('swidth',$ssize[0]);
				backend_config_smarty::getInstance()->assign('sheight',$ssize[1]);
				backend_config_smarty::getInstance()->assign('imgcatalog',$getimg['imgcatalog']);
				
			}else{
				backend_config_smarty::getInstance()->assign('imgcatalog',null);
				if(M_FIREPHP == true){
					magixcjquery_debug_magixfire::magixFireError("Not file exist: ".$getimg['imgcatalog']);
				}
			}
		}
		backend_config_smarty::getInstance()->assign('galery',self::view_galery_in_product());
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
			}else{
				self::display_edit_category();
			}
		}elseif(magixcjquery_filter_request::isGet('upsubcat')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_subcategory();
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
				}elseif(magixcjquery_filter_request::isGet('gethtmlprod')){
					if(magixcjquery_filter_request::isGet('idclc')){
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
						header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
						header("Pragma: no-cache" ); 
						header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
						self::construct_select_product();
					}
				}elseif(magixcjquery_filter_request::isGet('getjsonprod')){
					if(magixcjquery_filter_request::isGet('idclc')){
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
						header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
						header("Pragma: no-cache" ); 
						header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
						self::json_idcls();
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
		}elseif(magixcjquery_filter_request::isGet('order')){
			self::executeOrderCategory();
			self::executeOrderSubCategory();
		}elseif(magixcjquery_filter_request::isGet('json')){
			self::get_select_json_construct();
		}elseif(magixcjquery_filter_request::isGet('geturicat')){
			self::uri_catalog_product();
		}elseif(magixcjquery_filter_request::isGet('getreluri')){
			self::uri_rel_product();
		}else{
			self::display();
		}
	}
}
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