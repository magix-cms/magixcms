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
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    5.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name CMS
 *
 */
class backend_controller_cms extends backend_db_cms{
	public 
	$idlang,
	$idcat_p,
	$idlang_p,
	$title_page,
	$uri_page,
	$content_page,
	$seo_title_page,
	$seo_desc_page,
	$order_page,
	$sidebar_page;
	public $getlang;
	/**
	 * function construct class
	 */
	function __construct(){
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('idcat_p')){
			$this->idcat_p = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idcat_p']);
		}
		if(magixcjquery_filter_request::isPost('idlang_p')){
			$this->idlang_p = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang_p']);
		}
		if(magixcjquery_filter_request::isPost('title_page')){
			$this->title_page = magixcjquery_form_helpersforms::inputClean($_POST['title_page']);
		}
		if(magixcjquery_filter_request::isPost('content_page')){
			$this->content_page = magixcjquery_form_helpersforms::inputCleanQuote($_POST['content_page']);
		}
		if(magixcjquery_filter_request::isPost('seo_title_page')){
			$this->seo_title_page = magixcjquery_form_helpersforms::inputClean($_POST['seo_title_page']);
		}
		if(magixcjquery_filter_request::isPost('seo_desc_page')){
			$this->seo_desc_page = magixcjquery_form_helpersforms::inputClean($_POST['seo_desc_page']);
		}
		if(magixcjquery_filter_request::isPost('order_page')){
			$this->order_page = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['order_page']);
		}
		if(magixcjquery_filter_request::isPost('sidebar_page')){
			$this->sidebar_page = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['sidebar_page']);
		}
		if(magixcjquery_filter_request::isGet('getlang')){
			$this->getlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['getlang']);
		}
	}
	/**
	 * @access private
	 * Requête JSON suivant la langue sélectionner pour retourner les pages parente
	 */
	private function json_parent_p(){
		if(parent::s_parent_p($this->getlang) != null){
			foreach (parent::s_parent_p($this->getlang) as $s){
				$json[]= '{"idpage":'.json_encode($s['idpage']).',"title_page":'.json_encode($s['title_page']).
				',"iso":'.json_encode($s['iso']).'}';
			}
			return $json;
		}
	}
	/**
	 * @access private
	 * retourne les langues pour administrer les pages parents ainsi que leurs enfants
	 */
	private function listing_index_language(){
		if(backend_db_lang::dblang()->s_full_lang() != null){
			$list = '<ul>';
			foreach(backend_db_lang::dblang()->s_full_lang() as $slang){
				$list .= '<li><a href="/admin/cms.php?getlang='.$slang['idlang'].'">'.$slang['iso'].'</a></li>';
			}
			$list .= '</ul>';
			return $list;
		}
	}
	private function current_language($idlang){
		$db = backend_db_lang::dblang()->s_language_data($idlang);
		return $db['language'];
	}
	/**
	 * execute la fonction run pour l'administration CMS
	 * @access public 
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('getlang')){
			backend_controller_template::assign('language', $this->current_language($this->getlang));
			backend_controller_template::display('cms/parent_page.phtml');
		}else{
			backend_controller_template::assign('list_language', $this->listing_index_language());
			backend_controller_template::display('cms/index.phtml');
		}
	}
}