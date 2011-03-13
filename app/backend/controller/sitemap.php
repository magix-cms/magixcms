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
 * @version    5.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name sitemap
 *
 */
class backend_controller_sitemap{
	/**
	 * Constante PATHPLUGINS
	 * Défini le chemin vers le dossier des plugins
	 * @var string
	 */
	const PATHPLUGINS = 'plugins';
	/**
	 * Creation du fichier xml index (get)
	 * @var void
	 **/
	public $create_xml_index;
	/**
	 * Creation du fichier xml url (get)
	 * @var void
	 **/
	public $create_xml_url;
	/**
	 * Creation du fichier xml images (get)
	 * @var void
	 **/
	public $create_xml_images;
	/**
	 * Ping Google (get)
	 * @var void
	 **/
	public $googleping;
	/**
	 * @access public
	 * Constructor
	 */
	public function  __construct(){
		if(magixcjquery_filter_request::isGet('create_xml_index')) {
			$this->create_xml_index = $_GET['create_xml_index'];
		}
		if(magixcjquery_filter_request::isGet('create_xml_url')) {
			$this->create_xml_url = $_GET['create_xml_url'];
		}
		if(magixcjquery_filter_request::isGet('create_xml_images')) {
			$this->create_xml_images = $_GET['create_xml_images'];
		}
		if(magixcjquery_filter_request::isGet('googleping')) {
			$this->googleping = $_GET['googleping'];
		}
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
	private function createXMLFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML(self::dir_XML_FILE(),'sitemap-url.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile(self::dir_XML_FILE(),'sitemap-url.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemap("UTF-8");
	        /*Ecrit les éléments*/
	    	$sitemap->writeMakeNode(magixcjquery_html_helpersHtml::getUrl(),date('d-m-Y'),'always',0.8);
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * @access private
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLImgFile(){
		try{
			/*instance la classe*/
	        $sitemap = new magixcjquery_xml_sitemap();
			/*Crée le fichier xml s'il n'existe pas*/
	        $sitemap->createXML(self::dir_XML_FILE(),'sitemap-images.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile(self::dir_XML_FILE(),'sitemap-images.xml');
			/*indente les lignes (optionnel)*/
	        $sitemap->indentXML(true);
			/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
	    	$sitemap->headSitemapImage("UTF-8");
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
	        $sitemap->createXML(self::dir_XML_FILE(),'sitemap.xml');
			/*Ouvre le fichier xml s'il existe*/
	        $sitemap->openFile(self::dir_XML_FILE(),'sitemap.xml');
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
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $sitemap->writeMakeNodeIndex(
        	magixcjquery_html_helpersHtml::getUrl().'/sitemap-url.xml',
        	date('d-m-Y')
        );
        ///magixcjquery_debug_magixfire::magixFireLog(magixcjquery_html_helpersHtml::getUrl().'/sitemap-url.xml');
        $config = backend_db_config::adminDbConfig()->s_config_named('catalog');
		if($config['status'] == 1){
        	$sitemap->writeMakeNodeIndex(
        		magixcjquery_html_helpersHtml::getUrl().'/sitemap-images.xml',
        		date('d-m-Y')
        	);
		}
	}
	/**
	 * @access private
	 * Si les NEWS sont activé, on inscrit les URLs dans le sitemap
	 */
	private function writeNews(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('news');
		if($config['status'] == 1){
			/**
			 * La racine des news par langue
			 */
			foreach(backend_db_sitemap::adminDbSitemap()->s_root_news_sitemap() as $data){
	        	$islang = $data['codelang'] ? $data['codelang']: '';
	        	$curl = date_create($data['date_sent']);
	        	 $sitemap->writeMakeNode(
	        	 	magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_root_url($islang,true),
		        	 $data['date_sent'],
		        	 'always',
		        	 0.8
	        	 );
	        }
	        /**
	         * Les news par langue
	         */
	        foreach(backend_db_sitemap::adminDbSitemap()->s_news_sitemap() as $data){
	        	$islang = $data['codelang'] ? $data['codelang']: '';
	        	$curl = date_create($data['date_sent']);
	        	 $sitemap->writeMakeNode(
	        	 	magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_news_url($islang,date_format($curl,'Y/m/d'),$data['rewritelink'],true),
		        	 $data['date_sent'],
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
	private function writeCms(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('cms');
		if($config['status'] == 1){
	        foreach(backend_db_sitemap::adminDbSitemap()->s_cms_sitemap() as $data){
	        	if($data['date_page'] == '0000-00-00 00:00:00'){
	        		$date_page = date('d-m-Y');
	        	}else{
	        		$date_page = $data['date_page'];
	        	}
		       	$sitemap->writeMakeNode(
				     magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_cms_url(
				    	$data['codelang'],
				    	$data['idcategory'],
				    	$data['pathcategory'],
				    	$data['idpage'],
				    	$data['pathpage'],
				    	true
				    ),
				    $date_page,
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
	private function writeCatalog(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('catalog');
		if($config['status'] == 1){
			foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_category_sitemap() as $data){
		       	$sitemap->writeMakeNode(
			       	 magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url(
						$data['codelang'], 
						$data['pathclibelle'], 
						$data['idclc'], 
						true
					),date('d-m-Y'),
				    'always',
				     0.8
		        );
	        }
		foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_subcategory_sitemap() as $data){
		       	$sitemap->writeMakeNode(
			       	  magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_subcategory_url(
						$data['codelang'], 
						$data['pathclibelle'], 
						$data['idclc'],
						$data['pathslibelle'], 
						$data['idcls'], 
						true
					),date('d-m-Y'),
				    'always',
				     0.8
		        );
	        }
	        foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_sitemap() as $data){
		       	$sitemap->writeMakeNode(
			       	  magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_product_url(
						$data['codelang'], 
						$data['pathclibelle'], 
						$data['idclc'], 
						$data['urlcatalog'], 
						$data['idproduct'],
						true
					),date('d-m-Y'),
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
	private function writeImagesCatalog(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		/**
		 * Les images des catégories du catalogue sur la racine de celui-ci
		 */
		foreach(backend_db_sitemap::adminDbSitemap()->count_catalog_category_sitemap_by_lang() as $data){
			if($data['catimg'] != 0){
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_root_url($data['codelang'],true),
					'img_c',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/category/',
					backend_db_sitemap::adminDbSitemap()->s_catalog_category_images_by_lang($data['idlang'])
				);
			}
		}
		/*
		 * Les images des sous catégories du catalogue de chaque catégorie
		 */
		foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_category_sitemap() as $data){
			$count = backend_db_sitemap::adminDbSitemap()->count_catalog_subcategory_sitemap($data['idclc']);
			//magixcjquery_debug_magixfire::magixFireLog($count['subcatimg']);
			if($count['subcatimg'] != 0){
				$sitemap->writeMakeNodeImage(
					magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_category_url($data['codelang'],$data['pathclibelle'],$data['idclc'],true),
					'img_s',
					magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/subcategory/',
					backend_db_sitemap::adminDbSitemap()->s_catalog_subcategory_images_by_lang($data['idclc'])
				);
			}
		}
		/**
		 * Les images des produits du catalogue
		 */
		foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_product_images() as $data){
			$sitemap->writeMakeNodeImage(
				magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_catalog_product_url($data['codelang'],$data['pathclibelle'],$data['idclc'],$data['urlcatalog'],$data['idproduct'],true),
				$data['imgcatalog'],
				magixcjquery_html_helpersHtml::getUrl().'/upload/catalogimg/product/'
			);
		}
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
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
	 */
	private function ini_options_mod($module){
		if(method_exists($this->get_call_class($module),'sitemap_rewrite_options')){
			/* Appelle la  fonction utilisateur sitemap_rewrite_options contenue dans le module */
			$call_options = call_user_func(
				array($this->get_call_class($module),'sitemap_rewrite_options')
			);
			if(is_array($call_options)){
				return $call_options;
			}else{
				throw new Exception('ini_options_mod '.$module.' is not array');
			}
		}else{
			throw new Exception('Method "sitemap_rewrite_options" does not exist');
		}
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return self::dir_XML_FILE().self::PATHPLUGINS.DIRECTORY_SEPARATOR;
	}
	/**
	 * 
	 * Création/Ecriture dans le fichier sitemap correspondant
	 * @param string $lang
	 * @param string $module
	 */
	private function writeFile($lang,$module){
		$options_mod = $this->ini_options_mod($module);
		// Génération de l'index
		switch($options_mod['index']){
			case 0:
				null;
			break;
			case 1:
				call_user_func_array(
					array($this->get_call_class($module),'sitemap_uri_index'), 
					array($lang)
				);
			break;
		}
		// Génération du niveau 1
		switch($options_mod['level1']){
			case 0:
				null;
			break;
			case 1:
				call_user_func_array(
					array($this->get_call_class($module),'sitemap_uri_category'), 
					array($lang)
				);
			break;
		}
		// Génération du niveau 2
		switch($options_mod['level2']){
			case 0:
				null;
			break;
			case 1:
				call_user_func_array(
					array($this->get_call_class($module),'sitemap_uri_subcategory'), 
					array($lang)
				);
			break;
		}
		// Génération du dernier niveau
		switch($options_mod['records']){
			case 0:
				null;
			break;
			case 1:
				call_user_func_array(
					array($this->get_call_class($module),'sitemap_uri_record'), 
					array($lang)
				);
			break;
		}
	}
	/**
	 * Scanne les plugins et vérifie si la fonction createSitemap 
	 * exist afin de l'intégrer dans le sitemap
	 * @access private
	 */
	private function writeplugin(){
		plugins_Autoloader::register();
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable(self::directory_plugins())){
			throw new exception('Error in writeplugin: Plugin is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir(self::directory_plugins());
		if($dir != null){
			foreach($dir as $d){
				if(file_exists(self::directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
					$pluginPath = self::directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						if(class_exists('plugins_'.$d.'_admin')){
							$create = self::get_call_class('plugins_'.$d.'_admin');
							//Si la méthode existe on execute la fonction createSitemap du plugin
							if(method_exists($create,'createSitemap')){
								$create->createSitemap();
							}
						}
					}
				}
			}
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
	 * Construction des plugins enregistré dans l'autoload et qui comporte un sitemap
	 */
	private function register_plugins(){
		$register = null;
		/**
		 * Appel les plugins enregistré dans l'autoload
		 */
		plugins_Autoloader::register();
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable(self::directory_plugins())){
			throw new exception('Error in register plugin: Plugin is not minimal permission');
		}
		/**
		 * Appel de la classe makeFiles dans magixcjquery
		 * @var void
		 */
		$makefiles = new magixcjquery_files_makefiles();
		/**
		 * scanne les dossiers du dossier plugins
		 * @var array()
		 */
		$dir = $makefiles->scanRecursiveDir($this->directory_plugins());
		if($dir != null){
			foreach($dir as $d){
				/**
				 * Si le fichier exist on continue
				 */
				if(file_exists($this->directory_plugins().$d.DIRECTORY_SEPARATOR.'admin.php')){
					/**
					 * Retourne le dossier ou chemin vers le dossier du plugin
					 * @var string
					 */
					$pluginPath = $this->directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						//Si la classe exist on recherche la fonction createSitemap
						if(class_exists('plugins_'.$d.'_admin')){
							$create = $this->get_call_class('plugins_'.$d.'_admin');
							//Si la méthode existe on ajoute le plugin dans le sitemap
							if(method_exists($create,'createSitemap')){
								$register .= '<tr class="line">
								<td class="maximal">'.magixcjquery_string_convert::ucFirst($d).'</td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-calculator"></span></td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-check"></span></td>
							</tr>';
							}
						}
					}
				}
			}
		}
		return $register;
	}
	/**
	 * Affiche la page d'administration des sitemaps
	 */
	private function display(){
		$statnews = backend_db_news::adminDbNews()->s_count_news_max();
		$statcms = backend_db_cms::adminDbCms()->s_count_cms_max();
		$statcatalog = backend_db_catalog::adminDbCatalog()->s_count_catalog_max();
		$confignews = backend_db_config::adminDbConfig()->s_config_named('news');
		/**
		 * Statistique des news
		 * @var $statnews void
		 */
		if($confignews['status'] == 1){
			backend_config_smarty::getInstance()->assign('statnews',$statnews['total']);
		}
		/**
		 * Statistique du CMS
		 * @var $statcms void
		 */
		$configcms = backend_db_config::adminDbConfig()->s_config_named('cms');
		if($configcms['status'] == 1){
			backend_config_smarty::getInstance()->assign('statcms',$statcms['total']);
		}
		/**
		 * Statistique du catalogue
		 * @var $statcatalog void
		 */
		$configcatalog = backend_db_config::adminDbConfig()->s_config_named('catalog');
		if($configcatalog['status'] == 1){
			backend_config_smarty::getInstance()->assign('statcatalog',$statcatalog['total']);
		}
		backend_config_smarty::getInstance()->assign('statplugins',self::register_plugins());
		backend_config_smarty::getInstance()->display('sitemap/index.phtml');
	}
	/**
	 * Compression GZ du fichier XML
	 */
	private function execute_compression(){
		$sitemap = new magixcjquery_xml_sitemap();
		/*Compression GZ souhaitée*/
        $sitemap->setGZCompressionLevel(9);
		/*Création du fichier GZ à partir de l'XML*/
        $sitemap->createGZ(self::dir_XML_FILE(),'sitemap.xml.gz','sitemap.xml');
	}
	/**
	 * Pinguer Google
	 */
	private function execPing(){
		$sitemap = new magixcjquery_xml_sitemap();
		backend_config_smarty::getInstance()->assign('sitemap','sitemap.xml');
		$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
		backend_config_smarty::getInstance()->display('sitemap/request/ping.phtml');
	}
	/**
	 * Compression GZ + ping Google
	 */
	private function execCompressionPing(){
		$sitemap = new magixcjquery_xml_sitemap();
		if(!extension_loaded('zlib')) {
			backend_config_smarty::getInstance()->assign('sitemap','sitemap.xml');
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml');
		}else{
			self::execute_compression();
			backend_config_smarty::getInstance()->assign('sitemap','sitemap.xml.gz');
			$sitemap->sendSitemapGoogle(substr(magixcjquery_html_helpersHtml::getUrl(),7),'sitemap.xml.gz');
		}
		backend_config_smarty::getInstance()->display('sitemap/request/ping.phtml');
	}
	/**
	 * @access private
	 * Execution de la création du fichier index
	 */
	private function execIndex(){
		self::createXMLIndexFile();
		self::writeIndex();
		self::endXMLWriter();
		backend_config_smarty::getInstance()->display('sitemap/request/success.phtml');
	}
	/**
	 * @access private
	 * Execute l'écriture dans le fichier XML
	 */
	private function exec(){
			self::createXMLFile();
			self::writeNews();
			self::writeCms();
			self::writeCatalog();
			self::writeplugin();
			self::endXMLWriter();
			backend_config_smarty::getInstance()->display('sitemap/request/success.phtml');
	}
	/**
	 * @access private
	 * Execution de la création du sitemap des images
	 */
	private function execImages(){
		$config = backend_db_config::adminDbConfig()->s_config_named('catalog');
		if($config['status'] == 1){
			self::createXMLImgFile();
			self::writeImagesCatalog();
			self::endXMLWriter();
			backend_config_smarty::getInstance()->display('sitemap/request/success.phtml');
		}else{
			backend_config_smarty::getInstance()->display('sitemap/request/noimages.phtml');
		}
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('create_xml_index')){
			self::execIndex();
		}elseif(magixcjquery_filter_request::isGet('create_xml_url')){
			self::exec();
		}elseif(magixcjquery_filter_request::isGet('create_xml_images')){
			self::execImages();
		}elseif(magixcjquery_filter_request::isGet('googleping')){
			self::execPing();
		}elseif(magixcjquery_filter_request::isGet('compressionping')){
			self::execCompressionPing();
		}else{
			self::display();
		}
	}
}