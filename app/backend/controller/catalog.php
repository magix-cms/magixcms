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
 * @version    4.0
 * Update 19/05/2013
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name catalog
 *
 */
class backend_controller_catalog extends backend_db_catalog{
    protected $model_access,$message;
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
	 * Image d'une catégorie
	 * @var img_c
	 */
	public $img_c;
	/**
	 * Image d'une sous catégorie
	 * @var img_c
	 */
	public $img_s;

	/**
	 * 
	 * POST l'identifiant du produit
	 * @var idproduct
	 */
	public $idproduct;

	/**
	 * GET pour la suppression d'un produit lié
	 * @var d_in_product
	 */
	public $d_rel_product;
	public $product_search,$name_product,$name_category,$img_order;
	public $get_search_page;
    public $delete_catalog,$delete_image,$delete_product,$delete_galery,$delete_category,$delete_subcategory;
    /**
     * Les variables globales
     */
    public $edit,$section,$getlang,$action,$tab,$idadmin,$callback,$title_search,$copy,$move,$plugin;

	/**
	 * @access public
	 * Constructor
	 */
	public function __construct(){
        if(class_exists('backend_model_access')){
            $this->model_access = new backend_model_access();
        }
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isSession('keyuniqid_admin')){
            $this->idadmin = magixcjquery_filter_isVar::isPostNumeric($_SESSION['id_admin']);
        }
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
			$this->price = magixcjquery_form_helpersforms::inputClean($_POST['price']);
		}
        // Remove
        if(magixcjquery_filter_request::isPost('delete_catalog')){
            $this->delete_catalog = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_catalog']);
        }
        if(magixcjquery_filter_request::isPost('delete_image')){
            $this->delete_image = magixcjquery_form_helpersforms::inputClean($_POST['delete_image']);
        }
        if(magixcjquery_filter_request::isPost('delete_product')){
            $this->delete_product = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_product']);
        }
        if(magixcjquery_filter_request::isPost('delete_galery')){
            $this->delete_galery = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_galery']);
        }
        if(magixcjquery_filter_request::isPost('delete_category')){
            $this->delete_category = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_category']);
        }
        if(magixcjquery_filter_request::isPost('delete_subcategory')){
            $this->delete_subcategory = magixcjquery_filter_isVar::isPostNumeric($_POST['delete_subcategory']);
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
		if(isset($_FILES['imgcatalog']["name"])){
			$this->imgcatalog = magixcjquery_url_clean::rplMagixString($_FILES['imgcatalog']["name"]);
		}
		if(isset($_FILES['img_c']["name"])){
			$this->img_c = magixcjquery_url_clean::rplMagixString($_FILES['img_c']["name"]);
		}
		if(isset($_FILES['img_s']["name"])){
			$this->img_s = magixcjquery_url_clean::rplMagixString($_FILES['img_s']["name"]);
		}
        if(magixcjquery_filter_request::isGet('idclc')){
            $this->getidclc = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['idclc']);
        }
		if(magixcjquery_filter_request::isPost('idproduct')){
			$this->idproduct = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idproduct']);
		}


		/**
		 * Recherche de fiche catalogue
		 */
		if(isset($_POST['product_search'])){
			$this->product_search = magixcjquery_form_helpersforms::inputClean($_POST['product_search']);
		}
        if(magixcjquery_filter_request::isGet('name_product')){
            $this->name_product = magixcjquery_form_helpersforms::inputClean($_GET['name_product']);
        }
        if(magixcjquery_filter_request::isGet('name_category')){
            $this->name_category = magixcjquery_form_helpersforms::inputClean($_GET['name_category']);
        }
        // galery
        if(magixcjquery_filter_request::isPost('img_order')){
            $this->img_order = magixcjquery_form_helpersforms::arrayClean($_POST['img_order']);
        }
        //Global
        if(magixcjquery_filter_request::isGet('section')){
            $this->section = magixcjquery_form_helpersforms::inputClean($_GET['section']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('plugin')){
            $this->plugin = magixcjquery_form_helpersforms::inputClean($_GET['plugin']);
        }

        //JQUERY CALLBACK
        if(magixcjquery_filter_request::isGet('callback')){
            $this->callback = (string) magixcjquery_form_helpersforms::inputClean($_GET['callback']);
        }
        if(magixcjquery_filter_request::isGet('title_search')){
            $this->title_search = magixcjquery_form_helpersforms::inputClean($_GET['title_search']);
        }
        //Copy
        if(magixcjquery_filter_request::isPost('copy')){
            $this->copy = magixcjquery_filter_isVar::isPostNumeric($_POST['copy']);
        }
        if(magixcjquery_filter_request::isPost('move')){
            $this->move = magixcjquery_filter_isVar::isPostNumeric($_POST['move']);
        }
	}

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
        }else{
            print '{}';
        }
    }

    /**
     * Retourne la liste des catégories sous forme de tableau
     * @return array
     */
    private function array_list_category(){
        if(parent::s_catalog_list_category_data($this->getlang) != null){
            foreach (parent::s_catalog_list_category_data($this->getlang) as $key){
                $id[]=$key['idclc'];
                $clibelle[]=$key['clibelle'];
            }
            return array_combine($id,$clibelle);
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
                $this->message->getNotify('add');
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
                $this->message->getNotify('update');
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
     * @param $create
     * @param $img_c
     */
    private function ajax_category_image($create,$img_c){
        if(file_exists($create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf')){
            $create->configLoad(
                $create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf',
                ''
            );
        }
        if($img_c != null){
            if(file_exists(self::dirImgCategory().$img_c)){
                $img = '<p><img src="/upload/catalogimg/category/'.$img_c.'" class="img-thumbnail" alt="" /></p>';
                $img .= '<p><a href="#" data-delete="'.$img_c.'" class="btn btn-danger delete-image">';
                $img .= '<span class="icon-trash"></span> '.$create->getConfigVars("remove").'</a></p>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-thumbnail" /></p>';
            }
        }else{
            $img = '<p><img data-src="holder.js/140x140/text:Thumnails" class="ajax-image img-thumbnail" /></p>';
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
     * Retourne la liste des catégories/et sous catégories dans lequel se trouve le catalogue courant
     */
    private function json_listing_category_product(){
        if(parent::s_catalog_category_product($this->edit) != null){
            foreach (parent::s_catalog_category_product($this->edit) as $key){
                $product[]= '{"idproduct":'.json_encode($key['idproduct']).',"idcatalog":'.json_encode($key['idcatalog']).
                    ',"idclc":'.json_encode($key['idclc']).',"titlecatalog":'.json_encode($key['titlecatalog']).'}';
            }
            print '['.implode(',',$product).']';
        }else{
            print '{}';
        }
    }
    /**
     * Execute Update AJAX FOR order
     * @access private
     *
     */
    private function update_order_category_product(){
        if(isset($this->order_pages)){
            $p = $this->order_pages;
            for ($i = 0; $i < count($p); $i++) {
                parent::u_order_category_product($i,$p[$i]);
            }
        }
    }

    /**
     * Suppression de la catégorie
     * @param $create
     */
    private function remove_category($create){
        if(isset($this->delete_category)){
            $verify = parent::v_catalog_subcategory($this->delete_category);
            if($verify['COUNT_SUB_CAT'] != 0){
                $this->message->getNotify('child_exist');
            }else{
                parent::d_category($this->delete_category);
            }
        }
    }
    //SOUS CATEGORIE
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
        }else{
            print '{}';
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
                $this->message->getNotify('add');
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
                $this->message->getNotify('update');
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
     * @param $create
     * @param $img_s
     */
    private function ajax_subcategory_image($create,$img_s){
        if(file_exists($create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf')){
            $create->configLoad(
                $create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf',
                ''
            );
        }
        if($img_s != null){
            if(file_exists(self::dirImgSubCategory().$img_s)){
                $img = '<p><img src="/upload/catalogimg/subcategory/'.$img_s.'" class="img-thumbnail" alt="" /></p>';
                $img .= '<p><a href="#" data-delete="'.$img_s.'" class="btn btn-danger delete-image">';
                $img .= '<span class="icon-trash"></span> '.$create->getConfigVars("remove").'</a></p>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumbnails" class="ajax-image img-thumbnail" /></p>';
            }
        }else{
            $img = '<p><img data-src="holder.js/140x140/text:Thumbnails" class="ajax-image img-thumbnail" /></p>';
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
                false
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
    /**
     * @category json request
     * @access private
     * Requête json pour le chargement des sous catégories associé à une catégorie dans le menu déroulant
     */
    private function json_idcls(){
        if(parent::s_catalog_subcategory($this->getidclc) != null){
            foreach (parent::s_catalog_subcategory($this->getidclc) as $key){
                if($key['idcls'] != 0){
                    $subcat[]= json_encode($key['idcls']).':'.json_encode($key['slibelle']);
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
     * Retourne la liste des produits dans la sous catégorie
     */
    private function json_listing_subcategory_product(){
        if(parent::s_catalog_subcategory_product($this->edit) != null){
            foreach (parent::s_catalog_subcategory_product($this->edit) as $key){
                $product[]= '{"idproduct":'.json_encode($key['idproduct']).',"idcatalog":'.json_encode($key['idcatalog']).
                    ',"titlecatalog":'.json_encode($key['titlecatalog']).'}';
            }
            print '['.implode(',',$product).']';
        }else{
            print '{}';
        }
    }
    /**
     * Execute Update AJAX FOR order
     * @access private
     *
     */
    private function update_order_subcategory_product(){
        if(isset($this->order_pages)){
            $p = $this->order_pages;
            for ($i = 0; $i < count($p); $i++) {
                parent::u_order_category_product($i,$p[$i]);
            }
        }
    }

    /**
     * Suppression de la catégorie
     */
    private function remove_subcategory(){
        if(isset($this->delete_subcategory)){
            parent::d_subcategory($this->delete_subcategory);
        }
    }
    // ####### SECTION PRODUITS
    /**
     * Ajoute un nouveau produit
     * @param $create
     */
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
                $this->message->getNotify('add');
            }
        }
    }

    /**
     * Mise à jour du produit
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
                    $price = number_format(str_replace(",",".",$this->price),2,'.','');
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
                $this->message->getNotify('update');
            }
        }
    }

    /**
     * @param $file
     * @param $newfile
     * @return mixed
     */
    private function copyImage($dir, $file, $newfile){
        if (copy($dir.$file, $dir.$newfile)) {
            return $newfile;
        }
    }
    /**
     * Copie un produit
     */
    private function copy_product(){
        $initImg = new backend_model_image();
        if(isset($this->copy)){
            $data = parent::s_catalog_data($this->copy);
            if($data['imgcatalog'] != null){
                $fileextends = $initImg->image_analyze(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR.$data['imgcatalog']);
                $imgcatalog = $this->copyImage(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR,$data['imgcatalog'],magixglobal_model_cryptrsa::random_generic_ui().$fileextends);
                $this->copyImage(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR,$data['imgcatalog'],$imgcatalog);
                $this->copyImage(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR,$data['imgcatalog'],$imgcatalog);
            }else{
                $imgcatalog = null;
            }
            // Insertion de la copie du produit
            parent::i_catalog_product_copy(
                $data['idlang'],
                $data['idadmin'],
                $data['titlecatalog'],
                $data['urlcatalog'],
                $data['desccatalog'],
                $data['price'],
                $imgcatalog
            );
            //Récupère l'identifiant du produit dupliqué
            $lastidcatalog = parent::s_catalog_last_insert();
            if($lastidcatalog){
                $dataGalery = parent::s_product_galery($this->copy);
                if($dataGalery != null){
                    foreach($dataGalery as $item){
                        $fileextends = $initImg->image_analyze(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR.$item['imgcatalog']);
                        $imggalery = $this->copyImage(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR,$item['imgcatalog'],magixglobal_model_cryptrsa::random_generic_ui().$fileextends);
                        $this->copyImage(self::dirImgProductGalery().'mini'.DIRECTORY_SEPARATOR,$item['imgcatalog'],$imggalery);
                        $this->i_product_galery($imggalery,$lastidcatalog['idcatalog']);
                    }
                }
            }
        }
    }

    /**
     *
     */
    private function move_product(){
        if(isset($this->move) AND isset($this->idlang)){
            parent::u_move_product($this->move,$this->idlang);
        }
    }

    /**
     * Suppression d'un produit avec les liaisons
     */
    private function remove_product(){
        if(isset($this->delete_catalog)){
            parent::d_product($this->delete_catalog);
        }
    }

    /**
     * Construction du menu select
     * @return string
     */
    private function lang_select(){
        $idlang = '';
        $iso = '';
        foreach(backend_db_block_lang::s_data_lang() as $key){
            $idlang[]=$key['idlang'];
            $iso[]=$key['iso'];
        }
        $lang_conb = array_combine($idlang,$iso);
        $select = backend_model_forms::select_static_row(
            $lang_conb
            ,
            array(
                'attr_name'=>'idlang',
                'attr_id'=>'idlang',
                'default_value'=>'',
                'empty_value'=>'',
                'class'=>'form-control',
                'upper_case'=>true
            )
        );
        return $select;
    }

    /**
     * Retourne au format JSON la liste des produits
     * @param $limit
     */
    private function json_listing_product($limit){
        $pager = new magixglobal_model_pager();
        $max = $limit;
        $offset= $pager->setPaginationOffset($limit,$this->getpage);
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
                    $price = number_format($key['price'],2,',','.');
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
                    ',"pseudo":'.json_encode($key['pseudo_admin']).'}';
            }
            print '['.implode(',',$json_data).']';
        }else{
            print '{}';
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
            $dataPager = magixglobal_model_pager::setPaginationData(
                $total,
                $limit,
                $basePath,
                $this->getpage,
                '='
            );
            $pagination = null;
            if ($dataPager != null) {
                $pagination = '<ul class="pagination">';
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
                'price'         =>  $data['price'],
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
     * Insertion d'une image à un produit
     * @param $img
     * @param $urlimg
     * @param null $imgcatalog
     * @param bool $debug
     * @return null|string
     * @throws Exception
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
                false
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
     * @param $create
     * @param $imgcatalog
     */
    private function ajax_product_image($create,$imgcatalog){
        if(file_exists($create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf')){
            $create->configLoad(
                $create->basePathConfig('section').'local_'.backend_model_language::current_Language().'.conf',
                ''
            );
        }
        $img = '';
        if($imgcatalog != null){
            if(file_exists(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog)){
                $small = getimagesize(self::dirImgProduct().'mini'.DIRECTORY_SEPARATOR.$imgcatalog);
                $medium = getimagesize(self::dirImgProduct().'medium'.DIRECTORY_SEPARATOR.$imgcatalog);
                $product = getimagesize(self::dirImgProduct().'product'.DIRECTORY_SEPARATOR.$imgcatalog);
                $img .= '<p>';
                $img .= '<a href="#" data-delete="'.$imgcatalog.'" class="btn btn-danger btn-block delete-image">';
                $img .= '<span class="icon-trash"></span> '.$create->getConfigVars("remove").'</a>';
                $img .= '</p>';
                $img .= '<div class="col-lg-2 col-sm-3">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/mini/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="list-unstyled">';
                            $img .= '<li>width:'.$small[0].'</li>';
                            $img .= '<li>height:'.$small[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</div>';
                $img .= '<div class="col-lg-3 col-sm-4">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/medium/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="list-unstyled">';
                            $img .= '<li>width:'.$medium[0].'</li>';
                            $img .= '<li>height:'.$medium[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</div>';
                $img .= '<div class="col-lg-5 col-sm-5">';
                    $img .= '<div class="thumbnail">';
                        $img .= '<img src="/upload/catalogimg/product/'.$imgcatalog.'" alt="" />';
                        $img .= '<div class="caption">';
                            $img .= '<ul class="list-unstyled">';
                            $img .= '<li>width:'.$product[0].'</li>';
                            $img .= '<li>height:'.$product[1].'</li>';
                            $img .= '</ul>';
                        $img .= '</div>';
                    $img .= '</div>';
                $img .= '</div>';
            }else{
                $img = '<p><img data-src="holder.js/140x140/text:Thumbnails" class="ajax-image img-thumbnail" /></p>';
            }
        }else{
            $img .= '<p><img data-src="holder.js/140x140/text:Thumbnails" class="ajax-image img-thumbnail" /></p>';
        }
        print $img;
    }

    /**
     * Retourne la liste des catégories/et sous catégories dans lequel se trouve le catalogue courant
     */
    private function json_listing_product_category(){
        if(parent::s_catalog_product_category($this->edit) != null){
            foreach (parent::s_catalog_product_category($this->edit) as $key){
                $product[]= '{"idproduct":'.json_encode($key['idproduct']).',"idcatalog":'.json_encode($key['idcatalog']).
                ',"clibelle":'.json_encode($key['clibelle']).',"slibelle":'.json_encode($key['slibelle']).'}';
            }
            print '['.implode(',',$product).']';
        }else{
            print '{}';
        }
    }

    /**
     * Ajoute un produit dans une catégorie/ou sous catégorie
     */
    private function add_product_category(){
        if(isset($this->idclc)){
            if(!empty($this->idclc)){
                parent::i_catalog_product_category($this->edit,$this->idclc,$this->idcls);
            }
        }
    }

    /**
     * Suppression de la catégorie dans le produit
     */
    private function remove_product_category(){
        if(isset($this->delete_product)){
            parent::d_product_category($this->delete_product);
        }
    }

    //Galery
    /**
     * @access private
     * Retourne le dossier des images de galerie de produit
     * @return string
     */
    private function dirImgProductGalery(){
        try{
            return self::imgBasePath("upload".DIRECTORY_SEPARATOR."catalogimg".DIRECTORY_SEPARATOR.'galery'.DIRECTORY_SEPARATOR);
        }catch (Exception $e){
            magixglobal_model_system::magixlog('An error has occured :',$e);
        }
    }

    /**
     * Insertion d'une image dans la galerie spécifique à un produit
     * @param $img
     * @param $imgcatalog
     * @param bool $debug
     * @return string
     * @throws Exception
     */
    private function insert_image_galery($img,$imgcatalog,$debug=false){
        if(isset($this->$img)){
            try{
                //Supprime le fichier original pour gagner en espace
                $makeFiles = new magixcjquery_files_makefiles();
                // Charge la classe de traitement des images
                $initImg = new backend_model_image();
                /**
                 * Envoi une image dans le dossier "racine" catalogimg
                 */
                $initImg->upload_img(
                    'imgcatalog',
                    'upload'.DIRECTORY_SEPARATOR.'catalogimg'.DIRECTORY_SEPARATOR.'galery'.DIRECTORY_SEPARATOR,
                    $debug
                );
                /**
                 * Analyze l'extension du fichier en traitement
                 * @var $fileextends
                 */
                $fileextends = $initImg->image_analyze(self::dirImgProductGalery().$this->$img);

                if ($initImg->imgSizeMin(self::dirImgProductGalery().$this->$img,25,25)){

                    // Charge la classe pour renommer le fichier
                    $makeFiles = new magixcjquery_files_makefiles();
                    /*
                     * Renomme le fichier
                     */
                    $makeFiles->renameFiles(
                        self::dirImgProductGalery(),
                        self::dirImgProductGalery().$this->$img,
                        self::dirImgProductGalery().$imgcatalog.$fileextends
                    );

                    /**
                     * Initialisation de la classe phpthumb
                     * @var void
                     */
                    $thumb = PhpThumbFactory::create(self::dirImgProductGalery().$imgcatalog.$fileextends);
                    //Charge la taille des images des galeries du catalogue
                    $firebug = new magixcjquery_debug_magixfire();
                    /**
                     * Création des images et miniatures utile.
                     * 2 tailles !!!
                     */

                    $imgsizelarge = $initImg->dataImgSize('catalog','galery','large');
                    $imgsizesmall = $initImg->dataImgSize('catalog','galery','small');
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
                            $thumb->resize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR.$imgcatalog.$fileextends);
                            break;
                        case 'adaptive':
                            if($debug){
                                $firebug->magixFireGroup($imgsizelarge['config_size_attr'].' => '.$imgsizelarge['type']);
                                $firebug->magixFireLog($imgsizelarge['img_resizing'],'Type');
                                $firebug->magixFireLog($imgsizelarge['width'],'Width');
                                $firebug->magixFireLog($imgsizelarge['height'],'Height');
                                $firebug->magixFireGroupEnd();
                            }
                            $thumb->adaptiveResize($imgsizelarge['width'],$imgsizelarge['height'])->save(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR.$imgcatalog.$fileextends);
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
                            $thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dirImgProductGalery().'mini'.DIRECTORY_SEPARATOR.$imgcatalog.$fileextends);
                            break;
                        case 'adaptive':
                            if($debug){
                                $firebug->magixFireGroup($imgsizesmall['config_size_attr'].' => '.$imgsizesmall['type']);
                                $firebug->magixFireLog($imgsizesmall['img_resizing'],'Type');
                                $firebug->magixFireLog($imgsizesmall['width'],'Width');
                                $firebug->magixFireLog($imgsizesmall['height'],'Height');
                                $firebug->magixFireGroupEnd();
                            }
                            $thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dirImgProductGalery().'mini'.DIRECTORY_SEPARATOR.$imgcatalog.$fileextends);
                            break;
                    }
                    if($debug){
                        $firebug->magixFireGroupEnd();
                    }
                    if(file_exists(self::dirImgProductGalery().$imgcatalog.$fileextends)){
                        $makeFiles->removeFile(self::dirImgProductGalery(),$imgcatalog.$fileextends);
                    }
                    return $imgcatalog.$fileextends;
                }else{
                    if(file_exists(self::dirImgProductGalery().$this->$img)){
                        $makeFiles->removeFile(self::dirImgProductGalery(),$this->$img);
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
     * Ajoute une image dans la galerie
     */
    private function add_galery_image(){
        if(isset($this->imgcatalog)){
            $imgp = self::insert_image_galery(
                'imgcatalog',
                magixglobal_model_cryptrsa::random_generic_ui(),
                false
            );
            parent::i_product_galery($imgp,$this->edit);
        }
    }

    /**
     * Retourne les images (micro galerie) d'un produit spécifique dans une requête JSON
     * @access private
     */
    private function json_list_galery(){
        if(isset($this->edit)){
            if(parent::s_product_galery($this->edit) != null){
                foreach (parent::s_product_galery($this->edit) as $list){
                    $json[]= '{"idmicro":'.json_encode($list['idmicro']).',"imgcatalog":'.json_encode($list['imgcatalog']).'}';
                }
                print '['.implode(',',$json).']';
            }else{
                print '{}';
            }
        }
    }
    /**
     * Execute Update AJAX FOR order image
     * @access private
     *
     */
    private function update_order_galery(){
        if(isset($this->img_order)){
            $p = $this->img_order;
            for ($i = 0; $i < count($p); $i++) {
                parent::u_order_galery($i,$p[$i]);
            }
        }
    }
    /**
     * @access private
     * Suppression des images de galerie produit
     */
    private function remove_product_galery(){
        if(isset($this->delete_galery)){
            $makeFiles = new magixcjquery_files_makefiles();
            $data = parent::s_product_galery_data($this->delete_galery);
            if(file_exists(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR.$data['imgcatalog'])){
                $makeFiles->removeFile(self::dirImgProductGalery().'maxi'.DIRECTORY_SEPARATOR,$data['imgcatalog']);
                $makeFiles->removeFile(self::dirImgProductGalery().'mini'.DIRECTORY_SEPARATOR,$data['imgcatalog']);
                parent::d_product_galery($this->delete_galery);
            }

        }
    }

    /**
     * @access private
     * Retourne la liste des produits pour l'autocompletion des produits relatifs
     */
    private function json_list_product(){
        if(isset($this->title_search)){
            if(parent::s_product($this->title_search) != null){
                foreach (parent::s_product($this->title_search) as $key){
                    $json[]= '{"idproduct":'.json_encode($key['idproduct']).
                    ',"titlecatalog":'.json_encode($key['titlecatalog']).
                    ',"clibelle":'.json_encode($key['clibelle']).
                    ',"slibelle":'.json_encode($key['slibelle']).
                    '}';
                }
                print $this->callback.'(['.implode(',',$json).'])';
            }else{
                print $this->callback.'([{"idproduct":"0","titlecatalog":"Aucune valeur","clibelle":"Aucune valeur","slibelle":"Aucune valeur"}])';
            }
        }
    }

    /**
     * @access private
     * Ajouter un produit relatif au produit courant
     * @param $create
     */
    private function addProductRel($create){
        if(isset($this->idproduct)){
            if(!empty($this->idproduct)){
                parent::i_product_rel(
                    $this->edit,
                    $this->idproduct
                );
                $this->message->getNotify('add');
            }
        }
    }

    /**
     * @access private
     * Retourne la liste des produits relatif du produit courant
     */
    private function json_listing_product_rel(){
        if(parent::s_product_rel($this->edit) != null){
            foreach (parent::s_product_rel($this->edit) as $key){
                $product[]= '{"idrelproduct":'.json_encode($key['idrelproduct']).',"idproduct":'.json_encode($key['idproduct']).
                    ',"idcatalog":'.json_encode($key['idcatalog']).',"titlecatalog":'.json_encode($key['titlecatalog']).
                    ',"idclc":'.json_encode($key['idclc']).',"clibelle":'.json_encode($key['clibelle']).
                    ',"idcls":'.json_encode($key['idcls']).',"slibelle":'.json_encode($key['slibelle']).'}';
            }
            print '['.implode(',',$product).']';
        }else{
            print '{}';
        }
    }

    /**
     * Suppression des produits relatifs dans le produit
     */
    private function remove_product_rel(){
        if(isset($this->delete_product)){
            parent::d_product_rel($this->delete_product);
        }
    }
    //Autocomplete
    /**
     * Retourne au format JSON le nom des catégories recherchés
     */
    private function json_autocomplete_category(){
        if(isset($this->name_category)){
            if(parent::s_catalog_category_list($this->getlang,$this->name_category) != null){
                foreach (parent::s_catalog_category_list($this->getlang,$this->name_category) as $key){
                    $json[]= '{"idclc":'.json_encode($key['idclc']).
                        ',"clibelle":'.json_encode($key['clibelle']).'}';
                }
                print $this->callback.'(['.implode(',',$json).'])';
            }else{
                print $this->callback.'([{"idclc":"0","clibelle":"Aucune valeur"}])';
            }
        }
    }
    /**
     * Retourne au format JSON le nom des produits recherchés
     */
    private function json_autocomplete_product(){
        if(isset($this->name_product)){
            if(parent::s_catalog_list($this->getlang,$this->name_product) != null){
                foreach (parent::s_catalog_list($this->getlang,$this->name_product) as $key){
                    $json[]= '{"idcatalog":'.json_encode($key['idcatalog']).
                        ',"titlecatalog":'.json_encode($key['titlecatalog']).'}';
                }
                print $this->callback.'(['.implode(',',$json).'])';
            }else{
                print $this->callback.'([{"idcatalog":"0","titlecatalog":"Aucune valeur"}])';
            }
        }
    }

    //TINYMCE
    /**
     * Retourne les produits du catalogue dans l'éditeur
     * @access private
     *
     */
    private function json_url_product(){
        if($this->product_search != ''){
            if(parent::s_product_url($this->product_search) != null){
                foreach(parent::s_product_url($this->product_search) as $key){
                    $url_product = magixglobal_model_rewrite::filter_catalog_product_url(
                        $key['iso'],
                        $key['pathclibelle'],
                        $key['idclc'],
                        $key['pathslibelle'],
                        $key['idcls'],
                        $key['urlcatalog'],
                        $key['idproduct'],
                        true
                    );
                    $json[]= '{"idproduct":'.json_encode($key['idproduct']).',"titlecatalog":'.json_encode($key['titlecatalog']).
                        ',"category":'.json_encode($key['clibelle']).',"subcategory":'.json_encode($key['slibelle']).
                        ',"uriproduct":'.json_encode($url_product).',"iso":'.json_encode($key['iso']).'}';
                }
                print '['.implode(',',$json).']';
            }
        }else{
            print '{}';
        }
    }
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $plugin = new backend_controller_plugins();
        $create->addConfigFile(array(
                'catalog'
            ),array('catalog_'),false
        );
        $access = $this->model_access->module_access("backend_controller_catalog");
        $create->assign('access',$access);
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
                            }elseif(isset($this->name_category)){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_autocomplete_category();
                            }
                        }elseif($this->action === 'add'){
                            if(isset($this->clibelle)){
                                $this->addCategory($create);
                            }
                        }elseif($this->action === 'edit'){
                            if(isset($this->edit)){
                                $data = parent::s_catalog_category_data($this->edit);
                                $create->assign('plugin',$plugin->menu_item_plugin('catalog_category'));
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
                                                $this->ajax_category_image($create,$data['img_c']);
                                            }else{
                                                $this->load_category_edit_data($create,$data);
                                                $create->display('catalog/category/edit.tpl');
                                            }
                                        }elseif($this->tab === 'subcat'){
                                            if(isset($this->slibelle)){
                                                $this->addSubCategory($create);
                                            }elseif(isset($this->order_pages)){
                                                $this->update_order_subcategory();
                                            }elseif(isset($this->delete_subcategory)){
                                                $this->remove_subcategory();
                                            }else{
                                                $this->load_category_edit_data($create,$data);
                                                $create->display('catalog/category/edit.tpl');
                                            }
                                        }elseif($this->tab === 'product'){
                                            if(isset($this->order_pages)){
                                                $this->update_order_category_product();
                                            }elseif(magixcjquery_filter_request::isGet('json_category_product')){
                                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                                $header->pragma();
                                                $header->cache_control("nocache");
                                                $header->getStatus('200');
                                                $header->json_header("UTF-8");
                                                $this->json_listing_category_product();
                                            }elseif(isset($this->delete_product)){
                                                $this->remove_product_category();
                                            }else{
                                                $this->load_category_edit_data($create,$data);
                                                $create->display('catalog/category/edit.tpl');
                                            }
                                        }
                                    }elseif(isset($this->plugin)){
                                        // Chargement du plugin dans le produit du catalogue (edition)
                                        $this->load_category_edit_data($create,$data);
                                        $param_arr = array($this->plugin,$this->getlang,$this->edit);
                                        $plugin->extend_module($this->plugin,'catalog_category',$param_arr);
                                    }else{
                                        if(isset($this->clibelle)){
                                            $this->update_category($create);
                                        }elseif(isset($this->delete_image)){
                                            $this->remove_category_image();
                                        }else{
                                            $this->load_category_edit_data($create,$data);
                                            $create->display('catalog/category/edit.tpl');
                                        }
                                    }
                                }
                            }else{
                                if(isset($this->order_pages)){
                                    $this->update_order_category();
                                }
                            }
                        }elseif($this->action === 'remove'){
                            $this->remove_category($create);
                        }
                    }else{
                        $create->display('catalog/category/list.tpl');
                    }
                }
            }elseif($this->section === 'subcategory'){
                if(isset($this->getlang)){
                    if(isset($this->action)){
                        if($this->action === 'add'){

                        }elseif($this->action === 'edit'){
                            if(isset($this->edit)){
                                $data = parent::s_catalog_subcategory_data($this->edit);
                                $create->assign('plugin',$plugin->menu_item_plugin('catalog_subcategory'));
                                if(isset($this->tab)){
                                    if($this->tab === 'image'){
                                        if(magixcjquery_filter_request::isGet('ajax_subcategory_image')){
                                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                            $header->pragma();
                                            $header->cache_control("nocache");
                                            $header->getStatus('200');
                                            $header->html_header("UTF-8");
                                            $this->ajax_subcategory_image($create,$data['img_s']);
                                        }elseif(isset($this->img_s)){
                                            $this->update_subcategory_image($data);
                                        }else{
                                            $this->load_subcategory_edit_data($create,$data);
                                            $create->display('catalog/subcategory/edit.tpl');
                                        }
                                    }elseif($this->tab === 'product'){
                                        if(isset($this->order_pages)){
                                            $this->update_order_subcategory_product();
                                        }elseif(magixcjquery_filter_request::isGet('json_subcategory_product')){
                                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                            $header->pragma();
                                            $header->cache_control("nocache");
                                            $header->getStatus('200');
                                            $header->json_header("UTF-8");
                                            $this->json_listing_subcategory_product();
                                        }elseif(isset($this->delete_product)){
                                            $this->remove_product_category();
                                        }else{
                                            $this->load_subcategory_edit_data($create,$data);
                                            $create->display('catalog/subcategory/edit.tpl');
                                        }
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
                                    }elseif(isset($this->plugin)){
                                        // Chargement du plugin dans le produit du catalogue (edition)
                                        $this->load_subcategory_edit_data($create,$data);
                                        $param_arr = array($this->plugin,$this->getlang,$this->edit);
                                        $plugin->extend_module($this->plugin,'catalog_subcategory',$param_arr);
                                    }else{
                                        $this->load_subcategory_edit_data($create,$data);
                                        $create->display('catalog/subcategory/edit.tpl');
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
                            }elseif(magixcjquery_filter_request::isGet('idclc')){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_idcls($this->getidclc);
                            }elseif(isset($this->title_search)){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_list_product();
                            }elseif(isset($this->name_product)){
                                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                $header->pragma();
                                $header->cache_control("nocache");
                                $header->getStatus('200');
                                $header->json_header("UTF-8");
                                $this->json_autocomplete_product();
                            }
                        }elseif($this->action === 'add'){
                            if(isset($this->titlecatalog)){
                                $this->addProduct($create);
                            }
                        }elseif($this->action === 'edit'){
                            $data = parent::s_catalog_data($this->edit);
                            $create->assign('plugin',$plugin->menu_item_plugin('catalog_product'));
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
                                        $this->ajax_product_image($create,$data['imgcatalog']);
                                    }else{
                                        $this->load_product_edit_data($create,$data);
                                        $create->display('catalog/product/edit.tpl');
                                    }
                                }elseif($this->tab === 'category'){
                                    if(magixcjquery_filter_request::isGet('json_product_category')){
                                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                        $header->pragma();
                                        $header->cache_control("nocache");
                                        $header->getStatus('200');
                                        $header->json_header("UTF-8");
                                        $this->json_listing_product_category();
                                    }elseif(isset($this->idclc)){
                                        $this->add_product_category();
                                    }elseif(isset($this->delete_product)){
                                        $this->remove_product_category();
                                    }else{
                                        $this->load_product_edit_data($create,$data);
                                        $create->assign('array_list_category',$this->array_list_category());
                                        $create->display('catalog/product/edit.tpl');
                                    }
                                }elseif($this->tab === 'product'){
                                    if(isset($this->idproduct)){
                                        $this->addProductRel($create);
                                    }elseif(magixcjquery_filter_request::isGet('json_product_rel')){
                                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                        $header->pragma();
                                        $header->cache_control("nocache");
                                        $header->getStatus('200');
                                        $header->json_header("UTF-8");
                                        $this->json_listing_product_rel();
                                    }elseif(isset($this->delete_product)){
                                        $this->remove_product_rel();
                                    }else{
                                        $this->load_product_edit_data($create,$data);
                                        $create->display('catalog/product/edit.tpl');
                                    }
                                }elseif($this->tab === 'galery'){
                                    if(magixcjquery_filter_request::isGet('json_list_galery')){
                                        $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                                        $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                                        $header->pragma();
                                        $header->cache_control("nocache");
                                        $header->getStatus('200');
                                        $header->json_header("UTF-8");
                                        $this->json_list_galery();
                                    }elseif(isset($this->img_order)){
                                        $this->update_order_galery();
                                    }elseif(isset($this->imgcatalog)){
                                        $this->add_galery_image();
                                    }elseif(isset($this->delete_galery)){
                                        $this->remove_product_galery();
                                    }else{
                                        $this->load_product_edit_data($create,$data);
                                        $create->display('catalog/product/edit.tpl');
                                    }
                                }
                            }else{
                                if(isset($this->delete_image)){
                                    $this->remove_product_image();
                                }if(isset($this->titlecatalog)){
                                    $this->update_product($create);
                                }elseif(isset($this->plugin)){
                                    // Chargement du plugin dans le produit du catalogue (edition)
                                    $this->load_product_edit_data($create,$data);
                                    $param_arr = array($this->plugin,$this->getlang,$this->edit);
                                    $plugin->extend_module($this->plugin,'catalog_product',$param_arr);
                                }else{
                                    $this->load_product_edit_data($create,$data);
                                    $create->display('catalog/product/edit.tpl');
                                }
                            }
                        }elseif($this->action === 'remove'){
                            $this->remove_product();
                        }elseif($this->action === 'copy'){
                            if(isset($this->copy)){
                                $this->copy_product();
                            }
                        }elseif($this->action === 'move'){
                            if(isset($this->move)){
                                $this->move_product();
                            }
                        }
                    }else{
                        $create->assign('select_lang',$this->lang_select());
                        $create->assign('pagination',$this->product_pagination(20));
                        $create->display('catalog/product/list.tpl');
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
            }elseif(isset($this->product_search)){
                $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                $header->pragma();
                $header->cache_control("nocache");
                $header->getStatus('200');
                $header->json_header("UTF-8");
                $this->json_url_product();
            }else{
                $create->display('catalog/index.tpl');
            }
        }
	}
}
?>