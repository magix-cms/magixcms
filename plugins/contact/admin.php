<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
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
 * @category   contact 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name contact
 * Administration du module contact de base
 *
 */
class plugins_contact_admin extends database_plugins_contact{
	/**
	 * 
	 * @var idadmin
	 */
	public $idadmin;
	/**
	 * 
	 * @var idlang
	 */
	public $idlang;
	/**
	 * Les variables globales
	 */
	public $action,$getlang;

    /**
     * Les variables du plugin contact
     */
    public $delete_contact,$mail_contact;
    /**
	 * Construct class
	 */
	public function __construct(){
        if(magixcjquery_filter_request::isPost('mail_contact')){
            $this->mail_contact = magixcjquery_form_helpersforms::inputClean($_POST['mail_contact']);
        }
		if(magixcjquery_filter_request::isPost('delete_contact')){
			$this->delete_contact = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['delete_contact']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
        }
	}

	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table($create){
		if(parent::c_show_table() == 0){
			$create->db_install_table('db.sql', 'request/install.phtml');
		}else{
			$magixfire = new magixcjquery_debug_magixfire();
			$magixfire->magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
			return true;
		}
	}

    /**
     * @access private
     * Insertion d'un contact pour le formulaire
     * @param $create
     */
    private function add($create){
		if(isset($this->mail_contact)){
			if(empty($this->mail_contact)){
				$create->display('request/empty.phtml');
			}else {
				parent::i_contact($this->getlang,$this->mail_contact);
                $create->display('request/success_add.phtml');
			}
		}
	}

    /**
     * Suppression d'un contact
     */
    private function remove(){
        if(isset($this->delete_contact)){
            parent::d_contact($this->delete_contact);
        }
    }

    /**
     * Retourne les statistiques des contacts au format JSON
     */
    private function json_graph(){
        if(parent::s_stats_contact() != null){
            foreach (parent::s_stats_contact() as $key){
                $stat[]= array(
                    'x'=>magixcjquery_string_convert::upTextCase($key['iso']),
                    'y'=>$key['CONTACT']
                );
            }
            print json_encode($stat);
        }
    }

    /**
     * Retourne la liste des contacts au format JSON
     */
    private function json_list_contact(){
        if(parent::s_contact($this->getlang) != null){
            foreach (parent::s_contact($this->getlang) as $key){
                $json[]= '{"idcontact":'.json_encode($key['idcontact']).',"mail_contact":'.json_encode($key['mail_contact']).'}';
            }
            print '['.implode(',',$json).']';
        }
    }

	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
        $header= new magixglobal_model_header();
        $create = new backend_controller_plugins();
        if(self::install_table($create) == true){
            if(magixcjquery_filter_request::isGet('getlang')){
                if(isset($this->action)){
                    if($this->action == 'list'){
                        if(magixcjquery_filter_request::isGet('json_list_contact')){
                            $header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
                            $header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
                            $header->pragma();
                            $header->cache_control("nocache");
                            $header->getStatus('200');
                            $header->json_header("UTF-8");
                            $this->json_list_contact();
                        }else{
                            $create->display('list.phtml');
                        }
                    }elseif($this->action == 'add'){
                        $this->add($create);
                    }elseif($this->action == 'remove'){
                        if(isset($this->delete_contact)){
                            $this->remove();
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
                }else{
                    $create->display('index.phtml');
                }
            }
        }
	}
    /**
     * @access public
     * Options de reecriture des métas
     */
    public function seo_options(){
        return $options_string = array(
            'plugins'=>true
        );
    }

    /**
     * Set Configuration pour le menu
     * @return array
     */
    public function setConfig(){
        return array(
            'url'=> array(
                'lang'=>'list',
                'action'=>'list'
            )
        );
    }
	//SITEMAP
	private function lastmod_dateFormat(){
		$dateformat = new magixglobal_model_dateformat();
		return $dateformat->sitemap_lastmod_dateFormat();
	}
	/**
	 * @access public
	 * Options de reecriture des sitemaps NEWS
	 */
	public function sitemap_rewrite_options(){
		return $options_string = array(
			'index'=>true,
			'level1'=>false,
			'level2'=>false,
			'records'=>false
		);
	}

    /**
     * URL index du module suivant la langue
     * @param $idlang
     */
	public function sitemap_uri_index($idlang){
		$sitemap = new magixcjquery_xml_sitemap();
        // Table des langues
        $lang = new backend_db_block_lang();
        // Retourne le code ISO
        $db = $lang->s_data_iso($idlang);
       	if($db != null){
           $sitemap->writeMakeNode(
               magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_plugins_root_url(
                   $db['iso'],
                   'contact',
                   true)
               ,
               $this->lastmod_dateFormat(),
               'always',
               0.7
           );
       	}
	}
}
class database_plugins_contact{
	/**
	 * Vérifie si les tables du plugin sont installé
	 * @access protected
	 * return integer
	 */
	protected function c_show_table(){
		$table = 'mc_plugins_contact';
		return magixglobal_model_db::layerDB()->showTable($table);
	}
    /*######################## Statistiques ##############################*/
    /**
     * @return array
     */
    protected function s_stats_contact(){
        $sql = 'SELECT lang.iso, IF( c.contact_count >0, c.contact_count, 0 ) AS CONTACT
        FROM mc_lang AS lang
        LEFT OUTER JOIN (
            SELECT lang.idlang, lang.iso, count( c.idcontact ) AS contact_count
            FROM mc_plugins_contact AS c
            JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
            GROUP BY c.idlang
            )c ON ( c.idlang = lang.idlang )
        GROUP BY lang.idlang';
        return magixglobal_model_db::layerDB()->select($sql);
    }
	/**
	 * @access protected
	 * Retourne les contacts enregistrés pour le formulaire
	 */

    protected function s_contact($getlang){
        $sql = 'SELECT c.*
        FROM mc_plugins_contact AS c
        JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
        WHERE c.idlang = :getlang';
        return magixglobal_model_db::layerDB()->select($sql,array(
            ':getlang'=>$getlang
        ));
    }

    /**
     * @access protected
     * Insertion d'un nouveau contact de l'administration
     * @param $idlang
     * @param $mail_contact
     */
	protected function i_contact($idlang,$mail_contact){
		$sql = 'INSERT INTO mc_plugins_contact (idlang,mail_contact)
		VALUE(:idlang,:mail_contact)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idlang'	=>	$idlang,
            ':mail_contact'=>$mail_contact
		));
	}
	/**
	 * @access protected
	 * @param integer $edit
	 */
	protected function d_contact($edit){
		$sql = 'DELETE FROM mc_plugins_contact WHERE idcontact = :edit';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':edit'	=>	$edit
		)); 
	}
}