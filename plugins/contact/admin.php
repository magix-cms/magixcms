<?php
/**
 * @category   Plugins 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2010 - 2011 (http://www.logiciel-referencement-professionnel.com/)
 * @license    Proprietary software
 * @version    1.0 03-06-2010
 * Update      1.1 11-06-2010
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name contact
 * @version 0.2
 *
 */
class plugins_contact_admin extends database_plugins_contact{
	/**
	 * @access private
	 * load sql file
	 */
	private function load_sql_file(){
		return backend_controller_plugins::pluginDir().'sql'.DIRECTORY_SEPARATOR.'db.sql';
	}
	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			if(file_exists(self::load_sql_file())){
				if(magixglobal_model_db::create_new_sqltable(self::load_sql_file())){
					backend_controller_plugins::append_assign('refresh_plugins','<meta http-equiv="refresh" content="3";URL="'.backend_controller_plugins::pluginUrl().'">');
					$fetch = backend_controller_plugins::append_fetch('request/install.phtml');
					backend_controller_plugins::append_assign('install_db',$fetch);
				}
			}
		}else{
			magixcjquery_debug_magixfire::magixFireInfo('Les tables mysql sont installés', 'Statut des tables mysql du plugin');
			return true;
		}
	}
	private function list_member(){
		$m = '<table class="clear" style="width:80%">
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
	private function display_list(){
		backend_controller_plugins::append_assign('list_member_admin',self::list_member());
	}
	/**
	 * Fonction pour la création des urls dans le sitemap
	 * !!! createSitemap obligatoire pour l'ajout dans le sitemap
	 */
	public function createSitemap(){
		/*instance la classe*/
        $sitemap = new magixcjquery_xml_sitemap();
		   $sitemap->writeMakeNode(
				magixcjquery_html_helpersHtml::getUrl().'/magixmod/contact/',
				date('d-m-Y'),
				'always',
				0.7
		   );
	}
	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
		if(isset($_GET['add'])){
			
		}else{
			//Installation des tables mysql
			if(self::install_table() == true){
				self::display_list();
				backend_controller_plugins::append_assign('selectlang',backend_model_blockDom::select_language());
				backend_controller_plugins::append_assign('selectusers',backend_model_blockDom::select_users());
			}
			// Retourne la page index.phtml
			backend_controller_plugins::append_display('index.phtml');
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
		return backend_db_plugins::layerPlugins()->showTable($table);
	}
}