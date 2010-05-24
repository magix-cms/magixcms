<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name SITEMAP
 * @version 5.0
 *
 */
class backend_controller_sitemap{
	/**
	 * Cosntante
	 * @var string
	 */
	const plugins = '/plugins/';
	/*
	 * Creation du fichier (get)
	 * @var void
	 */
	public $createxml;
	/*
	 * Ping Google (get)
	 * @var void
	 */
	public $googleping;
	function  __construct(){
		if(magixcjquery_filter_request::isGet('createxml')) {
			$this->createxml = $_GET['createxml'];
		}
		if(magixcjquery_filter_request::isGet('googleping')) {
			$this->googleping = $_GET['googleping'];
		}
	}
	/*
	 * Ouverture du fichier XML pour ecriture de l'entête
	 */
	private function createXMLFile(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		/*Crée le fichier xml s'il n'existe pas*/
        $sitemap->createXML('sitemap.xml');
		/*Ouvre le fichier xml s'il existe*/
        $sitemap->openFile('sitemap.xml');
		/*indente les lignes (optionnel)*/
        $sitemap->indentXML(true);
		/*Ecrit la DTD ainsi que l'entête complète suivi de l'encodage souhaité*/
    	$sitemap->headSitemap("UTF-8");
        /*Ecrit les éléments*/
    	$sitemap->writeMakeNode('',date('d-m-Y'),'always',0.8);
	}
	/**
	 * Si les NEWS sont activé, on inscrit les URLs dans le sitemap
	 */
	private function writeNews(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('news');
		if($config['status'] == 1){
	        foreach(backend_db_sitemap::adminDbSitemap()->s_news_sitemap() as $data){
	        	$islang = $data['codelang'] ? $data['codelang'].magixcjquery_html_helpersHtml::unixSeparator(): '';
	        	$curl = date_create($data['date_sent']);
	        	 $sitemap->writeMakeNode(
		        	 $islang.'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$data['rewritelink'].'.html',
		        	 $data['date_sent'],
		        	 'always',
		        	 0.8
	        	 );
	        }
		}
	}
	/**
	 * Si le CMS est activé, on inscrit les URLs dans le sitemap
	 */
	private function writeCms(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('cms');
		if($config['status'] == 1){
	        foreach(backend_db_sitemap::adminDbSitemap()->s_cms_sitemap() as $data){
		        switch($data['idlang']){
					case 0:
						$codelang = null;
					break;
					default: 
						$codelang = $data['codelang'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
				switch($data['idcategory']){
					case 0:
						$catpath = null;
					break;
					default: 
						$catpath = $data['idcategory'].'-'.$data['pathcategory'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
		       	$sitemap->writeMakeNode(
				    $codelang.$catpath.$data['idpage'].'-'.$data['pathpage'].'.html',
				    date('d-m-Y'),
				    'always',
				     0.8
		        );
	        }
		}
	}
	/**
	 * Si le catalogue est activé, on inscrit les URLs dans le sitemap
	 */
	private function writeCatalog(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
        $config = backend_db_config::adminDbConfig()->s_config_named('catalog');
		if($config['status'] == 1){
			$langsession = null;
	        foreach(backend_db_sitemap::adminDbSitemap()->s_catalog_sitemap() as $data){
	        switch($data['codelang']){
				case 'fr':
				$langsession = 'catalogue';
					break;
				case 'en':
				$langsession = 'catalog';
					break;	
				case 'de':
				$langsession = 'katalog';
					break;
				case 'nl':
				$langsession = 'catalog';
					break;	
				default:
				$langsession = 'catalogue';	
			}
		        switch($data['idlang']){
					case 0:
						$codelang = null;
					break;
					default: 
						$codelang = $data['codelang'].magixcjquery_html_helpersHtml::unixSeparator();
					break;
				}
		        switch($data['idcls']){
					case 0:
						$subcatpath = null;
					break;
					default: 
						$subcatpath = magixcjquery_html_helpersHtml::unixSeparator().$data['pathslibelle'].'-'.$data['idcls'];
					break;
				}
		       	$sitemap->writeMakeNode(
				    $codelang.$langsession.magixcjquery_html_helpersHtml::unixSeparator().$data['pathclibelle'].'-'.$data['idclc'].$subcatpath.magixcjquery_html_helpersHtml::unixSeparator().$data['urlcatalog'].'-'.$data['idcatalog'].'.html',
				    date('d-m-Y'),
				    'always',
				     0.8
		        );
	        }
		}
	}
	/**
	 * execute ou instance la class du plugin
	 * @param void $className
	 */
	private function execute_plugins($className){
		try{
			$class =  new $className;
		}catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        $log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        magixcjquery_debug_magixfire::magixFireError($e);
		}
		return $class;
	}
	/**
	 * @access private
	 * return void
	 */
	private function directory_plugins(){
		return $_SERVER['DOCUMENT_ROOT'].self::plugins;
	}
	/**
	 * Scanne les plugins et vérifie si la fonction createSitemap exist afin de l'intégrer dans le sitemap
	 */
	private function writeplugin(){
		/*if(backend_db_sitemap::adminDbSitemap()->s_plugin_sitemap() != null){
			foreach(backend_db_sitemap::adminDbSitemap()->s_plugin_sitemap() as $smap){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/app/backend/plugins/'.$smap['pname'].'.php')){
					if(class_exists('backend_plugins_'.$smap['pname'])){
						$create = self::execute_plugins('backend_plugins_'.$smap['pname']);
						if(method_exists($create,'createSitemap')){
							$create->createSitemap();
						}
					}
				}
			}
		}*/
		plugins_Autoloader::register();
		/**
		 * Si le dossier est accessible en lecture
		 */
		if(!is_readable(self::directory_plugins())){
			throw new exception('Plugin is not minimal permission');
		}
		$makefiles = new magixcjquery_files_makefiles();
		$dir = $makefiles->scanRecursiveDir(self::directory_plugins());
		if($dir != null){
			foreach($dir as $d){
				if(file_exists(self::directory_plugins().$d.'/'.'admin.php')){
					$pluginPath = self::directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						if(class_exists('plugins_'.$d.'_admin')){
							$create = self::execute_plugins('plugins_'.$d.'_admin');
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
			throw new exception('Plugin is not minimal permission');
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
		$dir = $makefiles->scanRecursiveDir(self::directory_plugins());
		if($dir != null){
			foreach($dir as $d){
				/**
				 * Si le fichier exist on continue
				 */
				if(file_exists(self::directory_plugins().$d.'/'.'admin.php')){
					/**
					 * Retourne le dossier ou chemin vers le dossier du plugin
					 * @var string
					 */
					$pluginPath = self::directory_plugins().$d;
					if($makefiles->scanDir($pluginPath) != null){
						//Si la classe exist on recherche la fonction createSitemap
						if(class_exists('plugins_'.$d.'_admin')){
							$create = self::execute_plugins('plugins_'.$d.'_admin');
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
	public function display(){
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
		/*if(backend_db_sitemap::adminDbSitemap()->s_plugin_sitemap() != null){
			foreach(backend_db_sitemap::adminDbSitemap()->s_plugin_sitemap() as $smap){
			$statplugins .= '<tr class="line">
								<td class="maximal">'.magixcjquery_string_convert::ucFirst($smap['pname']).'</td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-calculator"></span></td>
								<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-check"></span></td>
							</tr>';
			}
			
		}*/
		
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
        $sitemap->createGZ('sitemap.xml.gz','sitemap.xml');
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
	 * Execute l'écriture dans le fichier XML
	 */
	public function exec(){
			self::createXMLFile();
			self::writeNews();
			self::writeCms();
			self::writeCatalog();
			self::writeplugin();
			self::endXMLWriter();
			backend_config_smarty::getInstance()->display('request/success.phtml');
	}
}