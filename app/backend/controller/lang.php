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
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name lang
 *
 */
class backend_controller_lang{
	/**
	 * string
	 * @var codelang
	 */
	public $codelang;
	/**
	 * string
	 * @var codelang
	 */
	public $desclang;
	/**
	 * 
	 * @var intéger
	 */
	public $dellang;
	public $ulang;
	public $ucodelang;
	public $udesclang;
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_POST['codelang'])){
			$this->codelang = magixcjquery_form_helpersforms::inputCleanStrolower($_POST['codelang']);
		}
		if(isset($_POST['desclang'])){
			$this->desclang = magixcjquery_form_helpersforms::inputClean($_POST['desclang']);
		}
		if(isset($_GET['dellang'])){
			$this->dellang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['dellang']);
		}
		//Update
		if(isset($_GET['ulang'])){
			$this->ulang = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['ulang']);
		}
		if(isset($_POST['ucodelang'])){
			$this->ucodelang = magixcjquery_form_helpersforms::inputCleanStrolower($_POST['ucodelang']);
		}
		if(isset($_POST['udesclang'])){
			$this->udesclang = magixcjquery_form_helpersforms::inputClean($_POST['udesclang']);
		}
	}
	/**
	 * retourne les langues ajouté
	 * @access private
	 */
	private function full_language(){
		$lang = null;
		$lang .= '<table class="clear">
						<thead>
							<tr>
							<th>code Langue</th>
							<th>Langue</th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
		if(backend_db_lang::dblang()->s_full_lang_data() == null){
			$lang .= '<tr class="line">';
			$lang .='<td class="maximal"></td>';
			$lang .='<td class="nowrap"></td>';
			$lang .='<td class="nowrap"></td>';
			$lang .='<td class="nowrap"></td>';
			$lang .= '</tr>';
		}else{
			foreach(backend_db_lang::dblang()->s_full_lang_data() as $slang){
				 $lang .= '<tr class="line">';
				 $lang .=	'<td class="maximal">'.$slang['codelang'].'</td>';
				 $lang .=	'<td class="nowrap">'.$slang['desclang'].'</td>';
				 $lang .= 	'<td class="nowrap"><a class="edit-lang" title="'.$slang['idlang'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
				 $lang .= 	'<td class="nowrap"><a class="dellang" title="'.$slang['idlang'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
				 $lang .= '</tr>';
			}
		}
		$lang .= '</tbody></table>';
		return $lang;
	}
	/**
	 * insertion d'une nouvelle langue avec système de controle
	 * @access private
	 */
	private function insert_new_lang(){
		if(isset($this->codelang) AND isset($this->desclang)){
			if(empty($this->codelang) OR empty($this->desclang)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}elseif(backend_db_lang::dblang()->s_verif_lang($this->codelang) == null){
				backend_db_lang::dblang()->i_new_lang($this->codelang,$this->desclang);
				backend_config_smarty::getInstance()->display('lang/success.phtml');
			}else{
				backend_config_smarty::getInstance()->display('lang/element-exist.phtml');
			}
		}
	}
	/**
	 * Compte le nombre d'utilisation d'une langue
	 * @access private
	 * @name count_lang
	 * @return string
	 */
	private function count_lang(){
		$lang = null;
		$lang .= '<table class="clear">
						<thead>
							<tr>
								<th>Module</th>
								<th>code Langue</th>
								<th>Langue</th>
								<th>Nbr pages</th>
							</tr>
						</thead>
						<tbody>';
		//Compte les langues dans la page home
		foreach(backend_db_lang::dblang()->count_lang_home() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">Home</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		//Compte les langues dans le CMS
		foreach(backend_db_lang::dblang()->count_lang_pages() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">CMS</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		//Compte les langues dans les news
		foreach(backend_db_lang::dblang()->count_lang_news() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">News</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		//Compte le nombre de fiche catalogue par langue
		foreach(backend_db_lang::dblang()->count_lang_catalog() as $clang){
			$lang .= '<tr class="line">';
			$lang .=	'<td class="nowrap">Catalogue</td>';
			$lang .=	'<td class="nowrap">'.$clang['codelang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['desclang'].'</td>';
			$lang .=	'<td class="nowrap">'.$clang['countlang'].'</td>';
			$lang .= '</tr>';
		}
		$lang .= '</tbody></table>';
		return $lang;
	}
	/**
	 * Suppression d'une lang via une requête ajax
	 * @access public
	 */
	private function delete_lang_record(){
		if(isset($this->dellang)){
			$count = backend_db_lang::dblang()->global_count($this->dellang);
			if($count['ctotal'] != 0){
				backend_config_smarty::getInstance()->display('lang/element-exist.phtml');
			}else{
				backend_db_lang::dblang()->d_lang($this->dellang);
				backend_config_smarty::getInstance()->display('lang/delete.phtml');
			}
		}
	}
	private function update_lang(){
		if(isset($this->ulang)){
			backend_db_lang::dblang()->u_lang($this->ucodelang,$this->udesclang,$this->ulang);
			backend_config_smarty::getInstance()->display('lang/update-success.phtml');
		}
	}
	private function edit_lang(){
		if(isset($this->ulang)){
			$data = backend_db_lang::dblang()->s_lang_edit($this->ulang);
			backend_config_smarty::getInstance()->assign('ucodelang',$data['codelang']);
			backend_config_smarty::getInstance()->assign('udesclang',$data['desclang']);
			backend_config_smarty::getInstance()->display('lang/edit-lang.phtml');
		}
	}
	/**
	 * Affiche la page des langues
	 */
	private function display_index(){
		backend_config_smarty::getInstance()->assign('viewlang',self::full_language());
		backend_config_smarty::getInstance()->assign('countlang',self::count_lang());
		backend_config_smarty::getInstance()->display('lang/index.phtml');
	}
	public function run(){
		if(magixcjquery_filter_request::isGet('add')){
			self::insert_new_lang();
		}
		elseif(magixcjquery_filter_request::isGet('ulang')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_lang();
			}else{
				self::edit_lang();
			}
		}elseif(magixcjquery_filter_request::isGet('dellang')){
			self::delete_lang_record();
		}else{
			self::display_index();
		}
	}
}