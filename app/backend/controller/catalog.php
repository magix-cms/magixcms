<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    3.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name catalog
 *
 */
class backend_controller_catalog{
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
	 * Constructor
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('clibelle')){
			$this->clibelle = (string) magixcjquery_form_helpersforms::inputClean($_POST['clibelle']);
			$this->pathclibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['clibelle'],true);
		}
		if(magixcjquery_filter_request::isPost('slibelle')){
			$this->slibelle = (string) magixcjquery_form_helpersforms::inputClean($_POST['slibelle']);
			$this->pathslibelle = (string) magixcjquery_url_clean::rplMagixString($_POST['slibelle'],true);
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
		if(isset($_GET['delproduct'])){
			$this->delproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delproduct']);
		}
		if(isset($_GET['dels'])){
			$this->dels = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dels']);
		}
		if(isset($_GET['delc'])){
			$this->delc = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delc']);
		}
		if(isset($_GET['delmicro'])){
			$this->delmicro = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['delmicro']);
		}
		if(isset($_GET['editproduct'])){
			$this->editproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['editproduct']);
		}
		if(isset($_GET['moveproduct'])){
			$this->moveproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['moveproduct']);
		}
		if(isset($_GET['copyproduct'])){
			$this->copyproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['copyproduct']);
		}
		if(isset($_GET['getimg'])){
			$this->getimg = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getimg']);
		}
		if(isset($_GET['getgalery'])){
			$this->getgalery = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getgalery']);
		}
		if(isset($_FILES['imgcatalog']["name"])){
			$this->imgcatalog = magixcjquery_url_clean::rplMagixString($_FILES['imgcatalog']["name"]);
		}
		if(isset($_FILES['imggalery']["name"])){
			$this->imggalery = magixcjquery_url_clean::rplMagixString($_FILES['imggalery']["name"]);
		}
	}
	/**
	 * Affiche le menu "sortable" avec les éléments de catégorie
	 */
	function catalog_category_order(){
		$category = null;
		if(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder() != null){
			$category = '<ul id="sortcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_category_corder() as $cat){
				$category .= '<li class="ui-state-default ui-corner-all" id="corder_'.$cat['idclc'].'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>'.$cat['clibelle'].'<div style="float:right;"><a class="aspanfloat delc" href="#" title="'.$cat['idclc'].'"><span class="ui-icon ui-icon-close"></span></a></div>'.'</li>';
			}
			$category .= '</ul>';
		}
		return $category;
	}
	/**
	 * Construction du select pour les catégories
	 */
	function catalog_select_category(){
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
	 * Execute Update AJAX FOR order category
	 * Post la requête ajax pour la modification de l'ordre des catégories
	 *
	 */
	function executeOrderCategory(){
		if(isset($_POST['corder'])){
			$p = $_POST['corder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_catalog_category($i,$p[$i]);
			}
		}
	}
	/**
	 * Affiche le menu "sortable" avec les éléments des sous catégorie
	 */
	function catalog_sub_category_order(){
		$category = null;
		if(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() != null){
			$category = '<ul id="sortsubcat">';
			foreach(backend_db_catalog::adminDbCatalog()->s_catalog_subcategory_sorder() as $cat){
				$category .= '<li class="ui-state-default ui-corner-all" id="sorder_'.$cat['idcls'].'"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span><div class="sortdivfloat">'.$cat['slibelle'].'</div><div style="float:left;" class="ui-icon ui-icon-arrowthick-1-e"></div>'.$cat['clibelle'].'<div style="float:right;"><a style="float:left;" href="#"><span class="ui-icon ui-icon-pencil"></span></a><a class="aspanfloat dels" href="#" title="'.$cat['idcls'].'"><span class="ui-icon ui-icon-close"></span></a></div></li>';
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
	function executeOrderSubCategory(){
		if(isset($_POST['sorder'])){
			$p = $_POST['sorder'];
			for ($i = 0; $i < count($p); $i++) {
				backend_db_catalog::adminDbCatalog()->u_order_catalog_subcategory($i,$p[$i]);
			}
		}
	}
	/**
	 * insert une nouvelle catégorie dans le catalogue
	 */
	function insert_new_category(){
		if(isset($this->clibelle)){
			try{
				if(empty($this->clibelle)){
					$fetch = backend_config_smarty::getInstance()->fetch('request/empty.phtml');
					backend_config_smarty::getInstance()->assign('msgcat',$fetch);
				}else{
					backend_db_catalog::adminDbCatalog()->i_catalog_category($this->clibelle,$this->pathclibelle,$this->idlang);
				}
			} catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	/**
	 * Suppression d'une categroie
	 */
	function delete_catalog_category(){
		if(isset($this->delc)){
			backend_db_catalog::adminDbCatalog()->d_catalog_category($this->delc);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * insert une nouvelle sous catégorie dans le catalogue
	 */
	function insert_new_subcategory(){
		if(isset($this->slibelle)){
			try{
				if(empty($this->slibelle) OR empty($this->idclc)){
					$fetch = backend_config_smarty::getInstance()->fetch('request/empty.phtml');
					backend_config_smarty::getInstance()->assign('msgsubcat',$fetch);
				}else{
					backend_db_catalog::adminDbCatalog()->i_catalog_subcategory($this->slibelle,$this->pathslibelle,$this->idclc);
				}
			} catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	/**
	 * Suppression d'une sous categroie
	 */
	function delete_catalog_subcategory(){
		if(isset($this->dels)){
			backend_db_catalog::adminDbCatalog()->d_catalog_subcategory($this->dels);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * Requete ajax json pour le chargement du menu select des sous-catégories correspondante à une catégorie
	 */
	function get_select_json_construct(){
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
			} catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	function catalog_offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * pagination for Catalog
	 * @param $max
	 */
	function catalog_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = backend_db_catalog::adminDbCatalog()->s_count_catalog_pager_max();
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/admin/dashboard/catalog/',false,true,'page');
	}
	/**
	 * Insertion d'un nouveau produit dans la table mc_catalog
	 */
	function insert_new_product(){
		if(isset($this->titlecatalog) AND isset($this->desccatalog)){
			if(empty($this->titlecatalog) OR empty($this->desccatalog)){
				$fetch = backend_config_smarty::getInstance()->fetch('catalog/request/empty.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}elseif($this->idclc == 0){
				$fetch = backend_config_smarty::getInstance()->fetch('catalog/request/nocategory.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}else{
				backend_db_catalog::adminDbCatalog()->i_catalog_product(
					$this->idclc,
					$this->idcls,
					$this->idlang,
					backend_model_member::s_idadmin(),
					$this->urlcatalog,
					$this->titlecatalog,
					$this->desccatalog,
					$this->price
				);
				$fetch = backend_config_smarty::getInstance()->fetch('catalog/request/success.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}
		}
	}
	/**
	 * chargement des données d'un produit pour le formulaire
	 */
	protected function load_data_product_forms(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->editproduct);
		backend_config_smarty::getInstance()->assign('titlecatalog',$data['titlecatalog']);
		backend_config_smarty::getInstance()->assign('desccatalog',$data['desccatalog']);
		backend_config_smarty::getInstance()->assign('price',$data['price']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		//$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
	}
	/**
	 * chargement des données d'un produit pour le déplacement de catégorie
	 */
	protected function load_data_move_product(){
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
	protected function load_data_copy_product(){
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
	protected function load_data_image_product(){
		$data = backend_db_catalog::adminDbCatalog()->s_data_forms($this->getimg);
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
	}
	/**
	 * Mise à jour d'un produit
	 */
	function update_specific_product(){
		if(isset($this->titlecatalog) AND isset($this->desccatalog)){
			if(empty($this->titlecatalog) OR empty($this->desccatalog)){
				$fetch = backend_config_smarty::getInstance()->fetch('catalog/request/empty.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}else{
				backend_db_catalog::adminDbCatalog()->u_catalog_product(
					backend_model_member::s_idadmin(),
					$this->titlecatalog,
					$this->urlcatalog,
					$this->desccatalog,
					$this->price,
					$this->editproduct
				);
				$fetch = backend_config_smarty::getInstance()->fetch('catalog/request/success.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}
		}
	}
	/**
	 * Déplace un produit
	 */
	function move_specific_product(){
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
	function delete_catalog_product(){
		if(isset($this->delproduct)){
			backend_db_catalog::adminDbCatalog()->d_catalog_product($this->delproduct);
			backend_config_smarty::getInstance()->display('catalog/request/success-delete.phtml');
		}
	}
	/**
	 * Copie un produit dans la table mc_catalog
	 */
	function copy_product(){
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
		return $_SERVER['DOCUMENT_ROOT'].'/upload/catalogimg/';
	}
	/**
	 * Insertion d'une image à un produit spécifique
	 */
	function insert_image_product(){
		if(isset($this->imgcatalog)){
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img('imgcatalog','upload'.magixcjquery_html_helpersHtml::unixSeparator().'catalogimg');
				/**
				 * Vérifie si le produit contient déjà une image 
				 * @var intéger
				 */
				$count = backend_db_catalog::adminDbCatalog()->count_image_product($this->getimg);
				if($count['cimage'] == 0){
					backend_db_catalog::adminDbCatalog()->i_image_catalog($this->getimg,$this->imgcatalog);
				}else{
					backend_db_catalog::adminDbCatalog()->u_image_catalog($this->getimg,$this->imgcatalog);
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
			}catch (Exception $e){
				//Systeme de log + firephp
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
			if (backend_model_image::imgSizeMin(self::dir_img_product().$getimg['imgcatalog'],100,100)){
				/**
				 * Création des images et miniatures utile.
				 * 3 tailles !!!
				 */
				$thumb->resize(500)->save(self::dir_img_product().'product/'.$getimg['imgcatalog']);
				$thumb->resize(350)->save(self::dir_img_product().'medium/'.$getimg['imgcatalog']);
				$thumb->resize(120)->save(self::dir_img_product().'mini/'.$getimg['imgcatalog']);
			}
			//Supprime le fichier original pour gagner en espace
			$makeFiles = new magixcjquery_files_makefiles();
			if(file_exists(self::dir_img_product().$getimg['imgcatalog'])){
				$makeFiles->removeFile(self::dir_img_product(),$getimg['imgcatalog']);
			}else{
				throw new Exception('file: '.$getimg['imgcatalog'].' is not found');
			}
		}
	}
	/**
	 * @access private
	 * retourne le dossier des micros galeries
	 * @return string
	 */
	private function dir_micro_galery(){
		return $_SERVER['DOCUMENT_ROOT'].'/upload/catalogimg/galery/';
	}
	/**
	 * Insertion d'une image dans la galerie spéifique à un produit
	 */
	function insert_image_galery(){
		if(isset($this->imggalery)){
			try{
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img('imggalery','upload/catalogimg/galery');
				/**
				 * Insére l'image dans la base de donnée
				 */
				backend_db_catalog::adminDbCatalog()->i_galery_image_catalog($this->getimg,$this->imggalery);
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
			}catch (Exception $e){
				//Systeme de log + firephp
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
			if (backend_model_image::imgSizeMin(self::dir_micro_galery().$getimg['imgcatalog'],100,100)){
				/**
				 * Création des images et miniatures utile.
				 * 2 tailles !!!
				 */
				$thumb->resize(500)->save(self::dir_micro_galery().'maxi/'.$getimg['imgcatalog']);
				$thumb->resize(120)->save(self::dir_micro_galery().'mini/'.$getimg['imgcatalog']);
			}
			//Supprime le fichier original pour gagner en espace (si existe)
			$makeFiles = new magixcjquery_files_makefiles();
			if(file_exists(self::dir_micro_galery().$getimg['imgcatalog'])){
				$makeFiles->removeFile(self::dir_micro_galery(),$getimg['imgcatalog']);
			}/*else{
				throw new Exception('file: '.$getimg['imgcatalog'].' is not found');
			}*/
		}
	}
	/**
	 * Suppression d'une image dans une micro galerie
	 * @access public
	 */
	public function delete_image_microgalery(){
		if(isset($this->delmicro)){
			try{
				$dfile = backend_db_catalog::adminDbCatalog()->s_galery_image_micro($this->delmicro);
				$makeFiles = new magixcjquery_files_makefiles();
				if(file_exists(self::dir_micro_galery().'maxi/'.$dfile['imgcatalog'])){
					$makeFiles->removeFile(self::dir_micro_galery().'maxi/',$dfile['imgcatalog']);
					$makeFiles->removeFile(self::dir_micro_galery().'mini/',$dfile['imgcatalog']);
				}/*else{
					throw new Exception('file: '.$dfile['imgcatalog'].' is not found');
				}*/
				backend_db_catalog::adminDbCatalog()->d_galery_image_catalog($this->delmicro);
				backend_config_smarty::getInstance()->display('catalog/request/success-delete-mg.phtml');
			}catch (Exception $e){
				//Systeme de log + firephp
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	/**
	 * Affiche les images de la galerie d'un produit spécifique
	 * @access public
	 */
	public function view_galery_in_product(){
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
	 */
	function display_edit_product(){
		self::load_data_product_forms();
		backend_config_smarty::getInstance()->display('catalog/editproduct.phtml');
	}
	/**
	 * Affiche le déplacement d'un produit
	 */
	function display_move_product(){
		self::load_data_move_product();
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->display('catalog/moveproduct.phtml');
	}
	/**
	 * Affiche la copie d'un produit
	 */
	function display_copy_product(){
		self::load_data_copy_product();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->display('catalog/copyproduct.phtml');
	}
	/**
	 * Affiche la page des sous catégories
	 */
	function display_category(){
		self::insert_new_category();
		self::insert_new_subcategory();
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->assign('category_order',self::catalog_category_order());
		backend_config_smarty::getInstance()->assign('subcategory_order',self::catalog_sub_category_order());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/category.phtml');
	}
	/**
	 * Affiche la page des produits ou insertion d'un produit
	 */
	function display_product(){
		backend_config_smarty::getInstance()->assign('selectcategory',self::catalog_select_category());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('catalog/product.phtml');
	}
	/**
	 * affiche la page d'insertion d'une image
	 */
	function display_product_image(){
		self::load_data_image_product();
		$getimg = backend_db_catalog::adminDbCatalog()->s_image_product($this->getimg);
		if($getimg['imgcatalog'] != null){
			$gsize = getimagesize($_SERVER['DOCUMENT_ROOT'].magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg'.magixcjquery_html_helpersHtml::unixSeparator().'product'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
			$psize = getimagesize($_SERVER['DOCUMENT_ROOT'].magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg'.magixcjquery_html_helpersHtml::unixSeparator().'medium'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
			$ssize = getimagesize($_SERVER['DOCUMENT_ROOT'].magixcjquery_html_helpersHtml::unixSeparator().'upload/catalogimg'.magixcjquery_html_helpersHtml::unixSeparator().'mini'.magixcjquery_html_helpersHtml::unixSeparator().$getimg['imgcatalog']);
			backend_config_smarty::getInstance()->assign('gwidth',$gsize[0]);
			backend_config_smarty::getInstance()->assign('gheight',$gsize[1]);
			backend_config_smarty::getInstance()->assign('pwidth',$psize[0]);
			backend_config_smarty::getInstance()->assign('pheight',$psize[1]);
			backend_config_smarty::getInstance()->assign('swidth',$ssize[0]);
			backend_config_smarty::getInstance()->assign('sheight',$ssize[1]);
		}
		backend_config_smarty::getInstance()->assign('imgcatalog',$getimg['imgcatalog']);
		backend_config_smarty::getInstance()->assign('galery',self::view_galery_in_product());
		backend_config_smarty::getInstance()->display('catalog/image.phtml');
	}
	/**
	 * affiche la page pour la liste des articles
	 */
	function display(){
		backend_config_smarty::getInstance()->display('catalog/index.phtml');
	}
}
?>