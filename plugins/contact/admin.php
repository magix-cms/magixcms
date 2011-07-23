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
 * @category   contact 
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
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
	 * GET pour la suppression de contact
	 * @var $dcontact (integer)
	 */
	public $dcontact;
	/**
	 * Construct class
	 */
	public function __construct(){
		if(magixcjquery_filter_request::isPost('idadmin')){
			$this->idadmin = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idadmin']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isGet('dcontact')){
			$this->dcontact = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dcontact']);
		}
	}
	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			backend_controller_plugins::create()->db_install_table('db.sql', 'request/install.phtml');
		}else{
			$magixfire = new magixcjquery_debug_magixfire();
			$magixfire->magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
			return true;
		}
	}
	/**
	 * @access private
	 * Liste les membres de l'administration
	 */
	private function list_member(){
		$m = '<table class="clear" style="width:60%">
					<thead>
						<tr>
							<th>ID</th>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span class="magix-icon magix-icon-perms" style="float: left;"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-mail-closed"></span></th>
						</tr>
					</thead>
					<tbody>';
		foreach(backend_db_admin::adminDbMember()->view_list_members() as $list){
			switch($list['perms']){
				case 1:
					$perms = 'Seo Agency';
					break;
				case 2:
					$perms = 'Web Agency';
					break;
				case 3:
					$perms = 'User admin';
					break;
				case 4:
					$perms = 'User';
					break;
			}
			$m .='<tr class="line">';
			$m .='<td class="minimal">'.$list['idadmin'].'</td>';
			$m .='<td class="nowrap">'.$list['pseudo'].'</td>';
			$m .='<td class="nowrap">'.$perms.'</td>';
			$m .='<td class="maximal">'.$list['email'].'</td>';
			$m .='</tr>';
		}
		$m .= '</tbody></table>';
		return $m;
	}
	/**
	 * @access private
	 * Liste les membres pour le formulaire de contact
	 */
	private function list_member_contact(){
		$m = '<table class="clear" style="width:60%">
				<thead>
					<tr>
						<th>ID</th>
						<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-mail-closed"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
					</tr>
				</thead>
				<tbody>';
		$lang = '';
		foreach(parent::s_register_contact() as $list){
			switch($list['idlang']){
				case 0:
					$iso = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$iso = $list['iso'];
				break;
			}
			if ($list['iso'] != $lang) {
				//if ($lang != '') { $m .= "</tr>\n"; }
			       $m .= '<tr class="ui-widget-content"><td>&nbsp;</td><td>&nbsp;</td><td style="text-align:center;text-transform:uppercase;"><span style="font-weight:bold;">'.$list['iso'].'</span></td><td>&nbsp;</td></tr>';
			}
			$lang = $list['iso'];
			$m .='<tr class="line">';
			$m .='<td class="minimal">'.$list['idadmin'].'</td>';
			$m .='<td class="minimal">'.$iso.'</td>';
			$m .='<td class="nowrap">'.$list['pseudo'].'</td>';
			$m .='<td class="maximal">'.$list['email'].'</td>';
			$m .='<td class="minimal"><a href="#" title="'.$list['idcontact'].'" class="d-plugins-contact"><span style="float:left" class="ui-icon ui-icon-close"></span></a></td>';
			$m .='</tr>';
		}
		$m .= '</tbody></table>';
		return $m;
	}
	private function delete_contact(){
		if(isset($this->dcontact)){
			parent::d_contact($this->dcontact);
			backend_controller_plugins::create()->append_display('delete.phtml');
		}
	}
	/**
	 * @access private
	 * Assign les listes
	 */
	private function display_list(){
		backend_controller_plugins::create()->append_assign('list_member_admin',self::list_member());
		backend_controller_plugins::create()->append_assign('list_member_contact',self::list_member_contact());
	}
	/**
	 * @access private
	 * Insertion d'un contact pour le formulaire
	 */
	private function insert_contact(){
		if(isset($this->idadmin)){
			if(empty($this->idadmin) AND empty($this->idlang)){
				backend_controller_plugins::create()->append_display('request/empty.phtml');
			}else {
				parent::i_contact($this->idadmin,$this->idlang);
				backend_controller_plugins::create()->append_display('request/success.phtml');
			}
		}
	}
	/**
	 * Fonction pour la création des urls dans le sitemap
	 * !!! createSitemap obligatoire pour l'ajout dans le sitemap
	 */
	/*public function createSitemap(){
		/*instance la classe*/
        /*$sitemap = new magixcjquery_xml_sitemap();
        $dblang = backend_db_lang::dblang()->s_full_lang();
	    $sitemap->writeMakeNode(
			magixcjquery_html_helpersHtml::getUrl().'/magixmod/contact/',
			date('d-m-Y'),
			'always',
			0.7
	    );
		if($dblang != null){
	        foreach ($dblang as $l){
	        	$sitemap->writeMakeNode(
					magixcjquery_html_helpersHtml::getUrl().'/'.$l['iso'].'/magixmod/contact/',
					date('d-m-Y'),
					'always',
					0.7
		   		);
	        }
        }
	}*/
	/**
	 * @access public
	 * Options de reecriture des sitemaps NEWS
	 */
	public function seo_options(){
		return $options_string = array(
			'plugins'=>true
		);
	}
	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
		if(isset($_GET['add'])){
			$this->insert_contact();
		}elseif(isset($_GET['dcontact'])){
			$this->delete_contact();
		}else{
			//Installation des tables mysql
			if(self::install_table() == true){
				$this->display_list();
				backend_controller_plugins::create()->append_assign('selectlang',backend_model_blockDom::select_language());
				backend_controller_plugins::create()->append_assign('selectusers',backend_model_blockDom::select_users());
			}
			// Retourne la page index.phtml
			backend_controller_plugins::create()->append_display('index.phtml');
		}
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
	 * @param string $lang
	 */
	public function sitemap_uri_index(){
		$sitemap = new magixcjquery_xml_sitemap();
       	$db = backend_db_block_lang::s_data_lang();
       	if($db != null){
       		foreach($db as $data){
	        	 $sitemap->writeMakeNode(
	        	 	magixcjquery_html_helpersHtml::getUrl().magixglobal_model_rewrite::filter_plugins_root_url($data['iso'], 'contact',true),
		        	$this->lastmod_dateFormat(),
		        	'always',
		        	0.7
	        	 );
	        }
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
	/**
	 * @access protected
	 * Retourne les contacts enregistrés pour le formulaire
	 */
	protected function s_register_contact(){
		$sql = 'SELECT c.idcontact,c.idadmin,c.idlang,lang.iso,m.pseudo,m.email FROM mc_plugins_contact c
		LEFT JOIN mc_lang AS lang ON ( c.idlang = lang.idlang )
		LEFT JOIN mc_admin_member as m ON ( c.idadmin = m.idadmin )
		ORDER BY lang.idlang';
		return magixglobal_model_db::layerDB()->select($sql);
	}
	/**
	 * @access protected
	 * Insertion d'un nouveau contact de l'administration
	 * @param integer $idadmin
	 * @param integer $idlang
	 */
	protected function i_contact($idadmin,$idlang){
		$sql = 'INSERT INTO mc_plugins_contact (idadmin,idlang) VALUE(:idadmin,:idlang)';
		magixglobal_model_db::layerDB()->insert($sql,
		array(
			':idadmin'	=>	$idadmin,
			':idlang'	=>	$idlang
		));
	}
	/**
	 * @access protected
	 * @param integer $idcontact
	 */
	protected function d_contact($idcontact){
		$sql = 'DELETE FROM mc_plugins_contact WHERE idcontact = :idcontact';
		magixglobal_model_db::layerDB()->delete($sql,array(
			':idcontact'	=>	$idcontact
		)); 
	}
}