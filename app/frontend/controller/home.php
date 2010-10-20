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
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name home
 *
 */
class frontend_controller_home{
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
	}
	/*
	 * Charge contenu de la page d'accueil courante
	 * @access public
	 */
	private function load_home_content(){
		$home = frontend_db_home::getHome()->s_home_page_construct($this->getlang);
		frontend_config_smarty::getInstance()->assign('subject',magixcjquery_string_convert::ucFirst($home['subject']));
		frontend_config_smarty::getInstance()->assign('content',$home['content']);
		frontend_config_smarty::getInstance()->assign('title',$home['metatitle']);
		frontend_config_smarty::getInstance()->assign('description',$home['metadescription']);
	}
	/**
	 * Retourne et affiche la page d'accueil courante
	 * @access public
	 */
	function display(){
		self::load_home_content();
		frontend_config_smarty::getInstance()->display('home/index.phtml');
	}
}
?>