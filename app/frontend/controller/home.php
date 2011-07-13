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
class frontend_controller_home extends frontend_db_home{
	/**
	 * 
	 * Paramètre get des langues
	 * @var string
	 */
	public $getlang;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
	}
	/*
	 * Charge contenu de la page d'accueil courante
	 * @access public
	 */
	private function load_home_content(){
		if(isset($this->getlang)){
			$home = parent::s_get_home_page($this->getlang);
		}else{
			if(parent::s_get_home_page_default() != null){
				$home = parent::s_get_home_page_default();
			}elseif(magixcjquery_filter_request::isSession('strLangue')){
				$lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
				$home = parent::s_get_home_page($lang);
			}
		}
		frontend_model_template::assign('subject',magixcjquery_string_convert::ucFirst($home['subject']));
		frontend_model_template::assign('content',$home['content']);
		frontend_model_template::assign('title',$home['metatitle']);
		frontend_model_template::assign('description',$home['metadescription']);
	}
	/**
	 * Exec home script
	 */
	public function run(){
		$this->load_home_content();
		frontend_model_template::display('home/index.phtml');
	}
}
?>