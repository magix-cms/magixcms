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
 * @version    3.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name home
 *
 */
class backend_controller_home extends backend_db_home{
	/**
	 * gethome
	 * @var getedit (get edit)
	 */
	public $edit;
	/**
	 * string
	 * @var subject
	 */
	public $subject;
	/**
	 * string
	 * @var content
	 */
	public $content;
	/**
	 * string
	 * @var metatitle
	 */
	public $metatitle;
	/**
	 * string
	 * @var metadescription
	 */
	public $metadescription;
	/**
	 * integer
	 * @var delhome
	 */
	public $del_home;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('edit')){
			$this->edit = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('subject')){
			$this->subject = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
		}
		if(magixcjquery_filter_request::isPost('content')){
			$this->content = ($_POST['content']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('metatitle')){
			$this->metatitle = magixcjquery_form_helpersforms::inputTagClean($_POST['metatitle']);
		}
		if(magixcjquery_filter_request::isPost('metadescription')){
			$this->metadescription = magixcjquery_form_helpersforms::inputTagClean($_POST['metadescription']);
		}
		if(magixcjquery_filter_request::isPost('del_home')){
			$this->del_home = magixcjquery_filter_isVar::isPostNumeric($_POST['del_home']);
		}
	}
	/**
	 * @access private
	 * Requête JSON pour retourner la liste des langues
	 */
	private function json_listing_home_page(){
		if(parent::s_listing_home_page() != null){
			foreach (parent::s_listing_home_page() as $s){
				if ($s['metatitle'] != null){
					$metatitle = 1;
				}else{
					$metatitle = 0;
				}
				if ($s['metadescription'] != null){
					$metadescription = 1;
				}else{
					$metadescription = 0;
				}
				$uri = magixcjquery_html_helpersHtml::getUrl().'/'.$s['iso'].'/';
				$json[]= '{"idhome":'.json_encode($s['idhome']).',"iso":'.json_encode(magixcjquery_string_convert::upTextCase($s['iso']))
				.',"subject":'.json_encode($s['subject']).',"pseudo":'.json_encode($s['pseudo']).',"uri_home":'.json_encode($uri).',"metatitle":'.json_encode($metatitle).
				',"metadescription":'.json_encode($metadescription).'}';
			}
			print '['.implode(',',$json).']';
		}
	}
	private function load_data_forms(){
		$data = parent::s_home_page_record($this->edit);
		backend_controller_template::assign('subject',$data['subject']);
		backend_controller_template::assign('content',$data['content']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
		backend_controller_template::assign('metatitle',$data['metatitle']);
		backend_controller_template::assign('metadescription',$data['metadescription']);
	}
	private function insert_data_forms(){
		if(isset($this->subject)){
			if(empty($this->subject)){
				backend_controller_template::display('request/empty.phtml');
			}else{
				if(parent::s_home_page_b_lang($this->idlang) == null){
					parent::i_new_home_page(
						$this->subject,
						$this->content,
						$this->metatitle,
						$this->metadescription,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					backend_controller_template::display('request/success.phtml');
				}else{
					backend_controller_template::display('request/element-exist.phtml');
				}
			}
		}
	}
	private function update_data_forms(){
		if(isset($this->subject)){
			if(empty($this->subject)){
				backend_controller_template::display('request/empty.phtml');
			}else{
					parent::u_home_page(
						$this->subject,
						$this->content,
						$this->metatitle,
						$this->metadescription,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->edit
					);
					backend_controller_template::display('request/success.phtml');
			}
		}
	}
	/**
	 * Supprime une page home
	 * @access private
	 */
	private function delete_home_page(){
		if(isset($this->del_home)){
			parent::d_home($this->del_home);
		}
	}
	
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isPost('subject')){
				$this->update_data_forms();
			}else{
				$this->load_data_forms();
				backend_controller_template::display('home/edit.phtml');
			}
		}elseif(magixcjquery_filter_request::isPost('subject')){
			$this->insert_data_forms();
		}elseif(magixcjquery_filter_request::isGet('json_list_home_page')){
			$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
			$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
			$header->pragma();
			$header->cache_control("nocache");
			$header->getStatus('200');
			$header->json_header("UTF-8");
			$this->json_listing_home_page();
		}elseif(magixcjquery_filter_request::isPost('del_home')){
			$this->delete_home_page();
		}else{
			backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
			backend_controller_template::display('home/index.phtml');
		}
	}
}
?>