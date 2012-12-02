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
 * @category   Controller 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2011 -2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0 $Id$
 * @id $Rev$
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name cms
 *
 */
class frontend_controller_cms extends frontend_db_cms{
	/**
	 * Identifiant de la catégorie (page parente)
	 * @var $getidpage_p (integer)
	 */
	public $getidpage_p;
	/**
	 * URL de la catégorie (page parente)
	 * @var $geturi_page_p
	 */
	public $geturi_page_p;
	/**
	 * Identifiant de la page
	 * @var $getidpage (integer)
	 */
	public $getidpage;
	/**
	 * Url de la page
	 * @var $geturi_page (string)
	 */
	public $geturi_page;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('getidpage_p')){
			$this->getidpage_p = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['getidpage_p']);
		}
		if(magixcjquery_filter_request::isGet('geturi_page')){
			$this->geturi_page = magixcjquery_filter_isVar::isPostAlphaNumeric($_GET['geturi_page']);
		}
		if(magixcjquery_filter_request::isGet('getidpage_p')){
			$this->getidpage_p = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage_p']);
		}
		if(magixcjquery_filter_request::isGet('getidpage')){
			$this->getidpage = magixcjquery_filter_isVar::isPostNumeric($_GET['getidpage']);
		}
	}
	/**
	 * Charge le contenu de la page courante si existe
	 * @access public
	 */
	private function load_cms_content_page(){
		$cms = parent::s_data_current_page(frontend_model_template::getLanguage(),$this->getidpage);
		if(isset($this->getidpage_p)){
			$parent_page = parent::s_data_parent_page($cms['idcat_p']);
			$uri_page_p = magixglobal_model_rewrite::filter_cms_url(
				$parent_page['iso'], 
				null, 
				null, 
				$parent_page['idpage'], 
				$parent_page['uri_page'],
				true
			);
			$uri_page = magixglobal_model_rewrite::filter_cms_url(
				$cms['iso'], 
				$parent_page['idpage'], 
				$parent_page['uri_page'],
				$cms['idpage'], 
				$cms['uri_page'],
				true
			);
			$title_page_p = $parent_page['title_page'];
		}else{
			$uri_page_p = null;
			$title_page_p = null;
			$uri_page = magixglobal_model_rewrite::filter_cms_url(
				$cms['iso'], 
				null, 
				null,
				$cms['idpage'], 
				$cms['uri_page'],
				true
			);
		}
		frontend_model_template::assign('uri_page',$uri_page);
		frontend_model_template::assign('title_page_p',$title_page_p);
		frontend_model_template::assign('uri_page_p',$uri_page_p);
		frontend_model_template::assign('last_update',$cms['last_update']);
		frontend_model_template::assign('date_register',$cms['date_register']);
		frontend_model_template::assign('title_page',magixcjquery_string_convert::ucFirst($cms['title_page']));
		frontend_model_template::assign('content_page',$cms['content_page']);
		frontend_model_template::assign('seo_title_page',$cms['seo_title_page']);
		frontend_model_template::assign('seo_desc_page',$cms['seo_desc_page']);
	}
	/**
	 * 
	 * Fonction d'execution de la classe
	 */
	public function run(){
		if(isset($this->getidpage)){
			$this->load_cms_content_page();
			frontend_model_template::display('cms/index.phtml');
		}
	}
}