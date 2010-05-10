<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name RSS
 * @version 5.0
 *
 */
class backend_controller_rss{
	/**
	 * singleton 
	 * @access public
	 * @var void
	 */
	public static $instance;
	/**
	 * singleton 
	 * @access protected
	 * @var void
	 */
	protected static $xmlRssInstance;
	/**
	 * 
	 */
	public static function instance(){
        if (!isset(self::$instance)){
         	self::$instance = new backend_controller_rss();
        }
    	return self::$instance;
    }
    /**
     * protected function instance xml_rss in magixcjquery
     * @access protected
     * 
     */
    private static function xmlRssInstance(){
    	if (!isset(self::$xmlRssInstance)){
         	self::$xmlRssInstance = new magixcjquery_xml_rss();
        }
    	return self::$xmlRssInstance;
    }
	/*
	 * Ouverture du fichier XML pour ecriture de l'entête
	 */
	private function createXMLFile(){
		/*On demande de vérifier si le fichier existe et si pas on le crée*/
		self::xmlRssInstance()->createRSS('rss.xml');
		/*On ouvre le fichier*/
		self::xmlRssInstance()->openFileRSS('rss.xml');
		/*On demande une indentation automatique (optionnelle)*/
		self::xmlRssInstance()->indentRSS(true);
		/*On écrit l'entête avec l'encodage souhaité*/
		self::xmlRssInstance()->startWriteAtom('utf-8','fr');
	}
	/**
	 * Création d'un noeud dans le fichier XML
	 */
	private function CreateNodeXML(){
		$config = backend_db_config::adminDbConfig()->s_config_named('news');
		if($config['status'] == 1){
		   foreach(backend_db_sitemap::adminDbSitemap()->s_news_sitemap() as $data){
		   		$islang = $data['codelang'] ? $data['codelang'].magixcjquery_html_helpersHtml::unixSeparator(): '';
		        $curl = date_create($data['date_sent']);
		        self::xmlRssInstance()->elementWriteAtom(
			        $data['subject'],
			        $data['date_sent'],
			        $islang.'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$data['rewritelink'],
			        '.html',
			        $data['content']
		        );
		    }
		}
	}
	/**
	 * Fin de l'écriture du XML + fermeture balise
	 */
	private function endNodeXML(){
		/*On ferme les noeuds*/
		self::xmlRssInstance()->endWriteRSS();
	}
	/**
	 * Exécution de la création du fichier RSS
	 */
	public function exec(){
		self::createXMLFile();
		self::CreateNodeXML();
		self::endNodeXML();
	}
}