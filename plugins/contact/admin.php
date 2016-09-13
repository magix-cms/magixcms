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
class plugins_contact_admin extends DBContact{
	protected $template, $header,$message;
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
	public $action,$tab,$getlang;

    /**
     * Les variables du plugin contact
     */
    public $delete_contact,$mail_contact,$switch,$enable_address,$require_address,$enable_inliner;
    /**
	 * Construct class
	 */
	public function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        if(class_exists('magixglobal_model_header')){
            $this->header = new magixglobal_model_header();
        }
        if(class_exists('backend_controller_plugins')){
            $this->template = new backend_controller_plugins();
        }

        if(magixcjquery_filter_request::isPost('mail_contact')){
            $this->mail_contact = magixcjquery_form_helpersforms::inputClean($_POST['mail_contact']);
        }
		if(magixcjquery_filter_request::isPost('delete_contact')){
			$this->delete_contact = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['delete_contact']);
		}
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = magixcjquery_form_helpersforms::inputNumeric($_GET['getlang']);
        }

        // *** Config
        if(magixcjquery_filter_request::isPost('switch')) {
            $this->switch = magixcjquery_form_helpersforms::inputClean($_POST['switch']);
            if(magixcjquery_filter_request::isPost('enable_address')){
                $this->enable_address = magixcjquery_form_helpersforms::inputClean($_GET['enable_address']);
            }
            if(magixcjquery_filter_request::isPost('require_address')){
                $this->require_address = magixcjquery_form_helpersforms::inputClean($_GET['require_address']);
            }
			if(magixcjquery_filter_request::isPost('enable_inliner')){
				$this->enable_inliner = magixcjquery_form_helpersforms::inputClean($_GET['enable_inliner']);
			}
        }
	}

	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			$this->template->db_install_table('db.sql', 'request/install.tpl');
		}
		return true;
	}

    /**
     * @access private
     * Insertion d'un contact pour le formulaire
     */
    private function add(){
		if(isset($this->mail_contact)){
			if(empty($this->mail_contact)){
                $this->message->getNotify('empty');
			}else {
				parent::i_contact($this->getlang,$this->mail_contact);
                $this->message->getNotify('add');
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
        if(parent::select(array('type'=>'statistics')) != null){
            foreach (parent::select(array('type'=>'statistics')) as $key){
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
    private function jsonList(){
        if(parent::select(array('type'=>'list','getlang'=>$this->getlang)) != null){
            foreach (parent::select(array('type'=>'list','getlang'=>$this->getlang)) as $key){
                $json[]= '{"idcontact":'.json_encode($key['idcontact']).',"mail_contact":'.json_encode($key['mail_contact']).'}';
            }
            print '['.implode(',',$json).']';
        }else{
            print '{}';
        }
    }
	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run()
    {

        if (self::install_table() == true) {
            if (magixcjquery_filter_request::isGet('getlang')) {
                if (isset($this->action)) {
                    if ($this->action == 'json') {
						$this->header->set_json_headers();
                        $this->jsonList();
                    } elseif ($this->action == 'config') {
                        $this->template->assign('config',parent::getContactConfig());
                        $this->template->display('config.tpl');
                    } elseif ($this->action == 'list') {
                        $this->template->display('list.tpl');
                    } elseif ($this->action == 'add') {
                        $this->add();
                    } elseif ($this->action == 'remove') {
                        if (isset($this->delete_contact)) {
                            $this->remove();
                        }
                    }
                } elseif (isset($this->tab)) {
                    $this->template->display('about.tpl');
                }
            } else {
                if (magixcjquery_filter_request::isGet('json_graph')) {
					$this->header->set_json_headers();
                    $this->json_graph();
                } elseif (isset($this->action)) {
                    if ($this->action == 'switch' && isset($this->switch)) {
                        if($this->switch == 'enable') {
                            parent::u_config('address_enabled', array(':address_enabled' => (isset($this->enable_address)?1:0)));
                        }
                        if($this->switch == 'require') {
                            parent::u_config('address_required', array(':address_required' => (isset($this->require_address)?1:0)));
                        }
                        if($this->switch == 'inliner') {
                            parent::u_config('enable_inliner', array(':enable_inliner' => (isset($this->enable_inliner)?1:0)));
                        }
                        $this->message->getNotify('add');
                    }
                } else {
                    $this->template->display('index.tpl');
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
                'action'=>'list',
                'name'=>'Contact'
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
class DBContact{
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
	 * @access protected
	 * Retourne les contacts enregistrés pour le formulaire
	 */

    protected function select($data){
        if(is_array($data)){
            if($data['type'] === 'statistics'){
                $sql = 'SELECT lang.iso, IF( c.contact_count > 0, c.contact_count, 0 ) AS CONTACT
                FROM mc_lang AS lang
                LEFT OUTER JOIN (
                    SELECT lang.idlang, lang.iso, count( c.idcontact ) AS contact_count
                    FROM mc_plugins_contact AS c
                    JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
                    GROUP BY c.idlang
                    )c ON ( c.idlang = lang.idlang )
                GROUP BY lang.idlang';
                return magixglobal_model_db::layerDB()->select($sql);
            }elseif($data['type'] === 'list'){
                $sql = 'SELECT c.*
                FROM mc_plugins_contact AS c
                JOIN mc_lang AS lang ON(c.idlang = lang.idlang)
                WHERE c.idlang = :getlang';
                return magixglobal_model_db::layerDB()->select($sql,
                    array(
                        ':getlang'  =>  $data['getlang']
                    )
                );
            }
        }
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

    /**
     * @return array
     */
    protected function getContactConfig() {
        $sql = 'SELECT * FROM mc_plugins_contact_config';
        return magixglobal_model_db::layerDB()->selectOne($sql);
    }

    /**
     * @param $data
     */
    public function u_config($type,$data)
    {
        $sql = "UPDATE `mc_plugins_contact_config` SET `".$type."` = :".$type." WHERE `idcontact_config` = 1";
        magixglobal_model_db::layerDB()->update($sql,$data);
    }
}