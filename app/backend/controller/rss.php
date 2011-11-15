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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.3
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name rss
 *
 */
class backend_controller_rss extends backend_db_rss{
	/**
	 * @access private
	 * variable d'instance la class magixcjquery_xml_rss
	 * @var $rss
	 */
	private $rss;
	/**
	 * 
	 * Constructor
	 */
	public function __construct(){
		$this->rss = new magixcjquery_xml_rss();
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
	private function news_CreateXMLFile(){
		/*On demande de vérifier si le fichier existe et si pas on le crée*/
		$this->rss->createRSS($this->dir_XML_FILE(),'rss.xml');
		/*On ouvre le fichier*/
		$this->rss->openFileRSS($this->dir_XML_FILE(),'rss.xml');
		/*On demande une indentation automatique (optionnelle)*/
		$this->rss->indentRSS(true);
		/*On écrit l'entête avec l'encodage souhaité*/
		$this->rss->startWriteAtom('utf-8','fr',null,null,null,"/rss.xml");
	}
	/**
	 * Ouverture du fichier XML pour ecriture de l'entête
	 **/
	private function plugins_CreateXMLFile($name){
		/*On demande de vérifier si le fichier existe et si pas on le crée*/
		$this->rss->createRSS($this->dir_XML_FILE(),$name.'_rss.xml');
		/*On ouvre le fichier*/
		$this->rss->openFileRSS($this->dir_XML_FILE(),'_rss.xml');
		/*On demande une indentation automatique (optionnelle)*/
		$this->rss->indentRSS(true);
		/*On écrit l'entête avec l'encodage souhaité*/
		$this->rss->startWriteAtom('utf-8','fr',null,null,null,"/'.$name.'_rss.xml");
	}
	/**
	 * Création d'un noeud dans le fichier XML
	 */
	private function news_CreateNodeXML(){
		$setting = new backend_model_setting();
		$attr_name = $setting->tabs_load_config('news');
		if($attr_name['status'] == 1){
		   foreach(parent::s_news_rss() as $data){
		   		$dateformat = new magixglobal_model_dateformat($data['date_register']);
		   		$uri = magixglobal_model_rewrite::filter_news_url(
					$data['iso'], 
					$dateformat->date_europeen_format(), 
					$data['n_uri'], 
					$data['keynews'],
					true
				);
		        $this->rss->elementWriteAtom(
			        $data['n_title'],
			        $data['date_register'],
			        $uri,
			        null,
			        $data['n_content']
		        );
		    }
		}
	}
	/**
	 * Fin de l'écriture du XML + fermeture balise
	 */
	private function endNodeXML(){
		/*On ferme les noeuds*/
		$this->rss->endWriteRSS();
	}
	private function news_rss(){
		$this->news_CreateXMLFile();
		$this->news_CreateNodeXML();
		$this->endNodeXML();
	}
	public function plugins_rss($CreateNodeXML){
		$plugins = new backend_controller_plugins();
		$this->plugins_CreateXMLFile($plugins->pluginName());
		$CreateNodeXML;
		$this->endNodeXML();
	}
	/**
	 * Exécution de la création du fichier RSS
	 */
	public function run($module){
		switch ($module){
			case 'news':
				$this->news_rss();
			break;
		}
	}
}