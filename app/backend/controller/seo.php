<?php 
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien@magix-cms.com>
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
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name seo
 *
 */
class backend_controller_seo{
	public 
	/**
	 * @var $getmodule
	 * string
	 */
	$getmodule,
	/**
	 * @var $idlang
	 * integer
	 */
	$idlang,
	/**
	 * @var $strrewrite,$ustrrewrite
	 * string
	 */
	$strrewrite,$ustrrewrite,
	/**
	 * @var $idmetas
	 * integer
	 */
	$idmetas,
	/**
	 * @var $level
	 * integer
	 */
	$level,
	$editseo,
	$deleteseo;
	function __construct(){
		if(magixcjquery_filter_request::isPost('getmodule')){
			$this->getmodule = (string) magixcjquery_form_helpersforms::inputClean($_POST['getmodule']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
		}
		if(magixcjquery_filter_request::isPost('strrewrite')){
			$this->strrewrite = (string) magixcjquery_form_helpersforms::inputClean($_POST['strrewrite']);
		}
		if(magixcjquery_filter_request::isPost('ustrrewrite')){
			$this->ustrrewrite = (string) magixcjquery_form_helpersforms::inputClean($_POST['ustrrewrite']);
		}
		if(magixcjquery_filter_request::isPost('idmetas')){
			$this->idmetas = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['idmetas']);
		}
		if(magixcjquery_filter_request::isPost('level')){
			$this->level = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['level']);
		}
		if(magixcjquery_filter_request::isGet('editseo')){
			$this->editseo = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['editseo']);
		}
		if(magixcjquery_filter_request::isGet('deleteseo')){
			$this->deleteseo = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['deleteseo']);
		}
	}
	private function insert_new_seo(){
		if(isset($this->getmodule) AND isset($this->idlang)){
			if(empty($this->getmodule) AND empty($this->idlang)){
				backend_config_smarty::getInstance()->display('seo/empty.phtml');
			}else{
				parent::i_new_seo($this->getmodule, $this->idlang, $this->strrewrite, $this->idmetas, $this->level);
				backend_config_smarty::getInstance()->display('seo/success.phtml');	
			}
		}
	}
	private function load_seo_strrewrite(){
		if(isset($this->editseo)){
			$load = parent::s_uniq_rewrite($this->editseo);
			backend_config_smarty::getInstance()->assign('strrewrite',$load['strrewrite']);
			backend_config_smarty::getInstance()->display('seo/updateforms.phtml');
		}
	}
	private function update_seo(){
		if(isset($this->ustrrewrite)){
			if(empty($this->ustrrewrite)){
				backend_config_smarty::getInstance()->display('seo/empty.phtml');
			}else{
				parent::u_seo($this->editseo,$this->ustrrewrite);
				backend_config_smarty::getInstance()->display('seo/success.phtml');	
			}
		}
	}
	/**
	 * 
	 * requête JSON pour récupérer la liste des réécriture de metas
	 */
	private function json_list_rewrite(){
		$dbseo = parent::s_tab_rewrite();
		if($dbseo != null){
			foreach ($dbseo as $list){
				$seo[]= '{"idrewrite":'.json_encode($list['idrewrite']).',"attribute":'.json_encode($list['attribute'])
				.',"alias_lang":'.json_encode($list['alias_lang']).',"strrewrite":'.json_encode($list['strrewrite'])
				.',"idmetas":'.json_encode($list['idmetas']).',"level":'.json_encode($list['level']).'}';
			}
			print '['.implode(',',$seo).']';	
		}
	}
	private function delete_seo(){
		if(isset($this->deleteseo)){
			parent::d_seo($this->deleteseo);
		}
	}
}
?>