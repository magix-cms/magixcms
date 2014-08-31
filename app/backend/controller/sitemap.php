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
 * @version    6.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name sitemap
 *
 */
class backend_controller_sitemap extends backend_db_sitemap{
    protected $message;
	/**
	 * Constante PATHPLUGINS
	 * Défini le chemin vers le dossier des plugins
	 * @var string
	 */
	const PATHPLUGINS = 'plugins';

	public $tools_type,
        $idlang,
        $xml_type;
	/**
	 * @access public
	 * Constructor
	 */
	public function  __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(magixcjquery_filter_request::isPost('xml_type')) {
            $this->xml_type = magixcjquery_form_helpersforms::inputClean($_POST['xml_type']);
        }

		if(magixcjquery_filter_request::isPost('tools_type')) {
			$this->tools_type = magixcjquery_form_helpersforms::inputClean($_POST['tools_type']);
		}

        if(magixcjquery_filter_request::isPost('idlang')){
            $this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
        }
	}

    /**
     * Construction du menu select
     * @param $create
     * @return string
     */
    private function lang_select($create){
        $create->configLoad('local_'.backend_model_language::current_Language().'.conf');
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
                'attr_name'     =>  'idlang',
                'attr_id'       =>  'idlang',
                'default_value' =>  '',
                'empty_value'   =>  $create->getConfigVars('select_language'),
                'class'         =>  'form-control',
                'upper_case'    =>  true
            )
        );
        return $select;
    }
	//SITEMAP
	private function lastmod_dateFormat(){
		$dateformat = new magixglobal_model_dateformat();
		return $dateformat->date_w3c();
	}
	/**
	 * Retourne le dossier racine de l'installation de magix cms pour l'écriture du fichier XML
	 * @access private
	 **/
	private function dir_XML_FILE(){
	//		$system = new magixglobal_model_system();
		try {
			return magixglobal_model_system::base_path().DIRECTORY_SEPARATOR;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLFile($idlang){
		try{
            // Table des langues
            $lang = new backend_db_block_lang();
            // Retourne le code ISO
            $db = $lang->s_data_iso($idlang);
            if($db != null){
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML($this->dir_XML_FILE(),$db['iso'].'-sitemap-url.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile($this->dir_XML_FILE(),$db['iso'].'-sitemap-url.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemap("UTF-8");
	        /*Ecrit les éléments*/
	    	$sitemap->writeMakeNode(
	    		magixcjquery_html_helpersHtml::getUrl(),
	    		$this->lastmod_dateFormat(),
	    		'always',
	    		0.8
	    	);
           $sitemap->writeMakeNode(
               magixcjquery_html_helpersHtml::getUrl().'/'.$db['iso'].'/',
               $this->lastmod_dateFormat(),
               'always',
               0.8
           );
	       	}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLImgFile($idlang){
		try{
            // Table des langues
            $lang = new backend_db_block_lang();
            // Retourne le code ISO
            $db = $lang->s_data_iso($idlang);
            if($db != null){
                /*instance la classe*/
                $sitemap = new magixcjquery_xml_sitemap();
                /*Crée le fichier xml s'il n'existe pas*/
                $sitemap->createXML($this->dir_XML_FILE(),$db['iso'].'-sitemap-images.xml');
                /*Ouvre le fichier xml s'il existe*/
                $sitemap->openFile($this->dir_XML_FILE(),$db['iso'].'-sitemap-images.xml');
                /*indente les lignes (optionnel)*/
                $sitemap->indentXML(true);
                /*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
                $sitemap->headSitemapImage("UTF-8");
            }
	        /*Ecrit les éléments*/
	    	//$sitemap->writeMakeNode(magixcjquery_html_helpersHtml::getUrl(),date('d-m-Y'),'always',0.8);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Création du fichier sitemap.xml ainsi que l'entête sitemapindex 
	 */
	private function createXMLIndexFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML($this->dir_XML_FILE(),'sitemap.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile($this->dir_XML_FILE(),'sitemap.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemapIndex("UTF-8");
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ecriture dans le sitemapindex 
	 */
	private function writeIndex(){
        // Table des langues
        $lang = new backend_db_block_lang();
        // Retourne le code ISO
        //$db = $lang->s_data_iso($idlang);
        $db = backend_db_block_lang::s_data_lang(true);
        $attr_name = parent::s_config_named_data('catalog');
		// instance la classe
        $sitemap = new magixcjquery_xml_sitemap();
        foreach($db as $data){
            $sitemap->writeMakeNodeIndex(
                magixcjquery_html_helpersHtml::getUrl().'/'.$data['iso'].'-sitemap-url.xml',
                $this->lastmod_dateFormat()
            );
            if($attr_name['status'] == 1){
                $sitemap->writeMakeNodeIndex(
                    magixcjquery_html_helpersHtml::getUrl().'/'.$data['iso'].'-sitemap-images.xml',
                    $this->lastmod_dateFormat()
                );
            }
        }
	}
	/**
	 * @access private
	 * Si les NEWS sont activé, on inscrit les URLs dans le sitemap
	 */
	private function writeNews($idlang){
        // Table des langues
        $lang = new backend_db_block_lang();
        // Retourne le code ISO
        $db = $lang->s_data_iso($idlang);
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $attr_name = parent::s_config_named_data('news');
		if($attr_name['status'] == 1){
			/**
			 * La racine des news par langue
			 */
            $sitemap->writeMakeNode(
                magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_root_url($db['iso'],true),
                $this->lastmod_dateFormat(),
                'always',
                0.7
            );
	        /**
	         * Les news par langue
	         */
	        foreach(parent::s_news_sitemap($idlang) as $data){
	        	$curl = new magixglobal_model_dateformat();
	        	 $sitemap->writeMakeNode(
	        	 	 magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_url(
	        	 	 	$data['iso'],
	        	 	 	$curl->date_europeen_format($data['date_register']),
	        	 	 	$data['n_uri'],
	        	 	 	$data['keynews'],
	        	 	 	true
	        	 	 ),
		        	 $this->lastmod_dateFormat(),
		        	 'always',
		        	 0.8
	        	 );
	        }
		}
	}
	/**
	 * Si le CMS est activé, on inscrit les URLs dans le sitemap
	 * @access private
	 */
	private function writeCms($idlang){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $attr_name = parent::s_config_named_data('cms');
		if($attr_name['status'] == 1){
	        foreach(parent::s_cms_sitemap($idlang) as $data){
	        	/*if($data['date_register'] == '0000-00-00 00:00:00'){
	        		$date_page = date('d-m-Y');
	        	}else{
	        		$date_page = $data['date_register'];
	        	}*/
	        	if($data['idcat_p'] != 0 AND $data['uri_category'] != null){
					$uricms = magixglobal_model_rewrite::filter_cms_url(
						$data['iso'], 
						$data['idcat_p'], 
						$data['uri_category'], 
						$data['idpage'], 
						$data['uri_page'],
						true
					);
				}else{
					$uricms = magixglobal_model_rewrite::filter_cms_url(
						$data['iso'], 
						null, 
						null, 
						$data['idpage'], 
						$data['uri_page'],
						true
					);
				}
		       	$sitemap->writeMakeNode(
				    magixcjquery_html_helpersHtml::getUrl().$uricms,
				    $this->lastmod_dateFormat(),
				    'always',
				     0.9
		        );
	        }
		}
	}
	/**
	 * Si le catalogue est activé, on inscrit les URLs dans le sitemap
	 * @access private
	 */
	private function writeCatalog($idlang){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $attr_name = parent::s_config_named_data('catalog');
		if($attr_name['status'] == 1){
            // Table des langues
            $lang = new backend_db_block_lang();
            // Retourne le code ISO
            $db = $lang->s_data_iso($idlang);
            $sitemap->writeMakeNode(
                magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_root_url($db['iso'],true),
                $this->lastmod_dateFormat(),
                'always',
                0.7
            );
			foreach(parent::s_catalog_category($idlang) as $data){
		       	$sitemap->writeMakeNode(
			       	 magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url(
						$data['iso'], 
						$data['pathclibelle'], 
						$data['idclc'], 
						true
					),
					$this->lastmod_dateFormat(),
				    'always',
				     0.8
		        );
	        }
		    foreach(parent::s_catalog_subcategory_sitemap($idlang) as $data){
		       	$sitemap->writeMakeNode(
			       	  magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_subcategory_url(
						$data['iso'], 
						$data['pathclibelle'], 
						$data['idclc'],
						$data['pathslibelle'], 
						$data['idcls'], 
						true
					),
					$this->lastmod_dateFormat(),
				    'always',
				     0.8
		        );
	        }
	        foreach(parent::s_catalog_sitemap($idlang) as $data){
	        	$uri = magixglobal_model_rewrite::filter_catalog_product_url(
	        		$data['iso'], 
	        		$data['pathclibelle'], 
	        		$data['idclc'],
	        		$data['pathslibelle'], 
	        		$data['idcls'], 
	        		$data['urlcatalog'], 
	        		$data['idproduct'],
	        		true
	        	);
		       	$sitemap->writeMakeNode(
		       		magixcjquery_html_helpersHtml::getUrl().$uri,
			       	$this->lastmod_dateFormat(),
				    'always',
				     0.9
		        );
	        }
		}
	}
	/**
	 * @access private
	 * Ecrit les urls des images du catalogue (Google Image sitemap)
	 */
	private function writeImagesCatalog($idlang){
		// instance la classe
        $sitemap = new magixcjquery_xml_sitemap();
		// Les images des catégories du catalogue sur la racine de celui-ci

		foreach(parent::c_catalog_category($idlang) as $data){
			if($data['catimg'] != 0){
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_root_url(
                        $data['iso'],
                        true
                    ),
					'img_c',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/category/',
					parent::s_catalog_category($data['idlang'])
				);
			}
		}
		//Les images des sous catégories du catalogue de chaque catégorie
		foreach(parent::s_catalog_category($idlang) as $data){
			$count = parent::c_catalog_subcategory($data['idclc']);
			if($count['subcatimg'] != 0){
				$uri_cat = magixglobal_model_rewrite::filter_catalog_category_url(
                    $data['iso'],
                    $data['pathclibelle'],
                    $data['idclc'],
                    true
                );
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().$uri_cat,
					'img_s',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/subcategory/',
					parent::s_catalog_subcategory_images_by_lang($data['idclc'])
				);
			}
		}
		// Les images des produits du catalogue
		foreach(parent::s_catalog_sitemap($idlang) as $data){
			$uri = magixglobal_model_rewrite::filter_catalog_product_url(
        		$data['iso'], 
        		$data['pathclibelle'], 
        		$data['idclc'],
        		$data['pathslibelle'], 
        		$data['idcls'], 
        		$data['urlcatalog'], 
        		$data['idproduct'],
        		true
	        );
            if($data['imgcatalog'] != null){
                $sitemap->writeMakeNodeImage(
                    magixcjquery_html_helpersHtml::getUrl().$uri,
                    $data['imgcatalog'],
                    magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/product/'
                );
            }
		}
	}

    /**
     * execute ou instance la class du plugin
     * @param $module
     * @throws Exception
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
     * @throws Exception
     * @return array
     */
	private function ini_options_mod($module){
		if(method_exists($this->get_call_class($module),'sitemap_rewrite_options')){
			// Appelle la  fonction utilisateur sitemap_rewrite_options contenue dans le module
			$call_options = call_user_func(
				array($this->get_call_class($module),'sitemap_rewrite_options')
			);
			if(is_array($call_options)){
				return $call_options;
			}else{
				throw new Exception('ini_options_mod '.$module.' is not array');
			}
		}
	}
	/**
	 * @access private
	 * return string
	 */
	private function directory_plugins(){
		return $this->dir_XML_FILE().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}

    /**
     * @access private
     * Création/Ecriture dans le fichier sitemap correspondant
     * @param $class
     * @param $idlang
     */
	private function loadConfigPlugins($class,$idlang){
		$options_mod = $this->ini_options_mod($class);
        // On appelle la fonction associé à la demande avec le paramètres de langue
		// Génération de l'index
		switch($options_mod['index']){
			case 0:
				null;
			break;
			case 1:
                call_user_func_array(array($this->get_call_class($class),'sitemap_uri_index'),array($idlang));
			break;
		}
		// Génération du niveau 1
		switch($options_mod['level1']){
			case 0:
				null;
			break;
			case 1:
                call_user_func_array(array($this->get_call_class($class),'sitemap_uri_category'),array($idlang));
			break;
		}
		// Génération du niveau 2
		switch($options_mod['level2']){
			case 0:
				null;
			break;
			case 1:
                call_user_func_array(array($this->get_call_class($class),'sitemap_uri_subcategory'),array($idlang));
			break;
		}
		// Génération du dernier niveau
		switch($options_mod['records']){
			case 0:
				null;
			break;
			case 1:
                call_user_func_array(array($this->get_call_class($class),'sitemap_uri_record'),array($idlang));
			break;
		}
	}
	/**
	 * Scanne les plugins et vérifie si la fonction createSitemap 
	 * exist afin de l'intégrer dans le sitemap
	 * @access private
	 */
	private function writeplugin($idlang){
		try{
			plugins_Autoloader::register();
			// Si le dossier est accessible en lecture
			if(!is_readable($this->directory_plugins())){
				throw new exception('Error in writeplugin: Plugin is not minimal permission');
			}
			$makefiles = new magixcjquery_files_makefiles();
			$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
			if($dir != null){
				foreach($dir as $d){
					if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
						$pluginPath = $this->directory_plugins().$d;
						if($makefiles->scanDir($pluginPath) != null){
							if(class_exists('plugins_'.$d.'_admin')){
								$this->loadConfigPlugins('plugins_'.$d.'_admin',$idlang);
							}
						}
					}
				}
			}
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Fin de l'écriture du XML + fermeture balise
	 */
	private function endXMLWriter(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		/*Termine les noeuds*/
        $sitemap->endWrite();
	}

	/**
	 * Compression GZ du fichier XML
	 */
	private function compressed(){
		$sitemap = new magixcjquery_xml_sitemap();
		/*Compression GZ souhaitée*/
        $sitemap->setGZCompressionLevel(9);
		/*Création du fichier GZ à partir de l'XML*/
        $sitemap->createGZ($this->dir_XML_FILE(),'sitemap.xml.gz','sitemap.xml');
	}
	/**
	 * Pinguer Google
	 */
	private function googlePing($create){
		$sitemap = new magixcjquery_xml_sitemap();
		$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
        $this->message->getNotify('pinguer');
	}
	/**
	 * Compression GZ + ping Google
	 */
	private function compressedGooglePing($create){
		$sitemap = new magixcjquery_xml_sitemap();
		if(!extension_loaded('zlib')) {
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
		}else{
			$this->compressed();
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml.gz');
		}
        $this->message->getNotify('pinguer');
	}
	/**
	 * @access private
	 * Execution de la création du fichier index
	 */
	private function index($create){
		$this->createXMLIndexFile();
		$this->writeIndex();
		$this->endXMLWriter();
        $this->message->getNotify('add');
	}
	/**
	 * @access private
	 * Execute l'écriture dans le fichier XML
	 */
	private function module($create,$idlang){
        $this->createXMLFile($idlang);
        $this->writeNews($idlang);
        $this->writeCms($idlang);
        $this->writeCatalog($idlang);
        $this->writeplugin($idlang);
        $this->endXMLWriter();
        $this->message->getNotify('add');
	}
	/**
	 * @access private
	 * Execution de la création du sitemap des images
	 */
	private function images($create,$idlang){
        $attr_name = parent::s_config_named_data('catalog');
        if($attr_name['status'] == 1){
			$this->createXMLImgFile($idlang);
			$this->writeImagesCatalog($idlang);
			$this->endXMLWriter();
            $this->message->getNotify('add');
		}else{
            $this->message->getNotify('no_images');
		}
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_template();
        $create->addConfigFile(array(
                'sitemap'
            ),array('sitemap_'),false
        );
        if(isset($this->xml_type)){
            if($this->xml_type == 'index'){
                $this->index($create);
            }elseif($this->xml_type == 'url'){
                $this->module($create,$this->idlang);
            }elseif($this->xml_type == 'images'){
                $this->images($create,$this->idlang);
            }
        }elseif(isset($this->tools_type)){
            if($this->tools_type == 'pinguer'){
                $this->googlePing($create);
            }elseif($this->tools_type == 'compressed'){
                $this->compressedGooglePing($create);
            }
        }else{
            $create->assign('select_lang',$this->lang_select($create));
            $create->display('sitemap/index.tpl');
        }
	}
}