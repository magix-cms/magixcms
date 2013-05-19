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
	private function create_xml_file_news($iso){
        // On demande de vérifier si le fichier existe et si pas on le crée
		$this->rss->createRSS(
            $this->dir_XML_FILE(),
            'news_'.$iso.'_rss.xml'
        );
        // On ouvre le fichier
		$this->rss->openFileRSS(
            $this->dir_XML_FILE(),
            'news_'.$iso.'_rss.xml'
        );
        // On demande une indentation automatique (optionnelle)
		$this->rss->indentRSS(true);
        // On écrit l'entête avec l'encodage souhaité
		$this->rss->startWriteAtom(
            'utf-8',
            $iso,
            null,
            null,
            null,
            '/'.'news_'.$iso.'_rss.xml'
        );
	}

    /**
     * Création d'un noeud dans le fichier XML
     * @param $idlang
     * @param $iso
     */
    private function create_node_xml_news($idlang,$iso){
		$attr_name = parent::s_config_named_data('news');
		if($attr_name['status'] == 1){
		   foreach(parent::s_news($idlang) as $data){
		   		$dateformat = new magixglobal_model_dateformat();
		   		$uri = magixglobal_model_rewrite::filter_news_url(
					$data['iso'], 
					$dateformat->date_europeen_format($data['date_register']), 
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
     * Création du fichier XML pour les news
     * @param $idlang
     * @param $iso
     */
    private function xml_news($idlang,$iso){
		$this->create_xml_file_news($iso);
		$this->create_node_xml_news($idlang,$iso);
		$this->endNodeXML();
	}

    /**
     * Ouverture du fichier XML pour ecriture de l'entête
     * @param $iso
     * @param $name
     */
    private function create_xml_file_plugin($iso,$name){
        // On demande de vérifier si le fichier existe et si pas on le crée
        $this->rss->createRSS($this->dir_XML_FILE(),$name.'_'.$iso.'_rss.xml');
        // On ouvre le fichier*/
        $this->rss->openFileRSS($this->dir_XML_FILE(),'_rss.xml');
        // On demande une indentation automatique (optionnelle)
        $this->rss->indentRSS(true);
        // On écrit l'entête avec l'encodage souhaité
        $this->rss->startWriteAtom('utf-8',$iso,null,null,null,'/'.$name.'_'.$iso.'_rss.xml');
    }

    /**
     * @param $iso
     * @param $createNodeXML
     */
    public function xml_plugin($iso,$createNodeXML){
		$plugins = new backend_controller_plugins();
		$this->create_xml_file_plugin($iso,$plugins->pluginName());
        $createNodeXML;
		$this->endNodeXML();
	}

    /**
     * Fin de l'écriture du XML + fermeture balise
     */
    private function endNodeXML(){
        /*On ferme les noeuds*/
        $this->rss->endWriteRSS();
    }

	/**
	 * Exécution de la création du fichier RSS
	 */
	public function run($module,$array_params,$createNodeXML=false){
		switch ($module){
			case 'news':
                $idlang = $array_params['idlang'];
                $iso = $array_params['iso'];
				$this->xml_news($idlang,$iso);
			break;
            case 'plugins':
                $iso = $array_params['iso'];
                $this->xml_plugin($iso,$createNodeXML);
		}
	}
}