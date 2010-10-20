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
 * @version    5.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name rss
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
	/**
	 * Retourne le dossier racine de l'installation de magix cms pour l'écriture du fichier XML
	 * @access private
	 **/
	private function dir_XML_FILE(){
		try {
			return magixglobal_model_system::base_path().DIRECTORY_SEPARATOR;
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function createXMLFile(){
		/*On demande de vérifier si le fichier existe et si pas on le crée*/
		self::xmlRssInstance()->createRSS(self::dir_XML_FILE(),'rss.xml');
		/*On ouvre le fichier*/
		self::xmlRssInstance()->openFileRSS(self::dir_XML_FILE(),'rss.xml');
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
		   foreach(backend_db_sitemap::adminDbSitemap()->s_news_rss() as $data){
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