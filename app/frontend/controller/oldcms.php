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
 * @version    1.4
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name cms
 *
 */
class frontend_controller_cms extends frontend_db_cms{
	/**
	 * Langue
	 * @var string
	 */
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	/**
	 * Identifiant de la catégorie
	 * @var $getidcategory (integer)
	 */
	public $getidcategory;
	/**
	 * URL de la catégorie
	 * @var $getcat
	 */
	public $getcat;
	/**
	 * Url de la page
	 * @var $getpurl (integer)
	 */
	public $getpurl;
	/**
	 * Identifiant de la page
	 * @var $getidpage (integer)
	 */
	public $getidpage;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['getcat'])){
			$this->getcat = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getcat']);
		}
		if(isset($_GET['getpurl'])){
			$this->getpurl = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getpurl']);
		}
		if(isset($_GET['getidcategory'])){
			$this->getidcategory = magixcjquery_filter_isVar::isPostNumeric($_GET['getidcategory']);
		}
		if(isset($_GET['getidpage'])){
			$this->getidpage = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage']);
		}
	}
	/**
	 * Charge le contenu de la page courante si existe
	 * @access public
	 */
	private function load_cms_content_page(){
		$cms = parent::s_cms_page($this->getidpage);
		frontend_model_template::assign('date_page',$cms['date_page']);
		frontend_model_template::assign('subjectpage',magixcjquery_string_convert::ucFirst($cms['subjectpage']));
		frontend_model_template::assign('contentpage',$cms['contentpage']);
	}
	public function run(){
		if(isset($this->getpurl)){
			$this->load_cms_content_page();
			frontend_model_template::display('cms/index.phtml');
		}
	}
}