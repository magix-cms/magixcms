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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 * @name news
 *
 */
class frontend_controller_news extends frontend_db_news{
	/**
	 * parametre GET de la langue
	 * @var string
	 */
	public $getlang;
	/**
	 * variable de sessions deslangues
	 * @var string
	 */
	public $slang;
	/**
	 * 
	 * @var parametre identifiant la news
	 */
	public $getnews;
	/**
	 * Parametre de date dans url
	 * @var string
	 */
	public $getdate;
	/**
	 * 
	 * URL de la news
	 * @var $uri_get_news
	 */
	public $uri_get_news,$tag;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
		if(magixcjquery_filter_request::isGet('getnews')){
			$this->getnews = magixcjquery_filter_var::clean($_GET['getnews']);
		}
		if(magixcjquery_filter_request::isGet('getdate')){
			$this->getdate = ($_GET['getdate']);
		}
		if(magixcjquery_filter_request::isGet('uri_get_news')){
			$this->uri_get_news = magixcjquery_url_clean::rplMagixString($_GET['uri_get_news']);
		}
		if(magixcjquery_filter_request::isGet('page')) {
				// si numéric
		      if(is_numeric($_GET['page'])){
		          $this->getpage = intval($_GET['page']);
		      }else{
		      	// Sinon retourne la première page
		          $this->getpage = 1;        
		           }
		 }else {
		    $this->getpage = 1;
		}
		if(magixcjquery_filter_request::isGet('tag')){
			$this->tag = magixcjquery_url_clean::make2tagString($_GET['tag']);
		}
	}
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	public function news_offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * Appel la pagination pour les articles (news)
	 * @param $max
	 * @access public
	 */
	private function news_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = frontend_db_block_news::s_count_news($this->getlang);
		$rewrite = new magixglobal_model_rewrite();
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/'.$this->getlang.$rewrite->mod_news_lang($this->getlang),false,true,'page');
	}
	/**
	 * Retourne la pagination des news
	 * @param $max
	 * @access public
	 */
	public function news_pagination($max,$pagination_class){
		if($pagination_class != null){
			$class_container = $pagination_class;
		}else{
			$class_container = 'pagination';
		}
		return '<div class="'.$class_container.'">'.self::news_pager($max).'</div>';
	}
	/**
	 * Retourne la page de la news courante
	 * @access public
	 */
	private function display_getnews($getnews,$date_register){
		if(isset($getnews) AND isset($date_register)){
			$plitdate = explode('/', $this->getdate);
			$page = parent::s_specific_news($getnews,$date_register);
			if($page['idnews'] != null){
				if($page['n_image'] != null){
					$img = '/upload/news/'.$page['n_image'];
				}else{
					$img = '/skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png';
				}
				frontend_model_template::assign('date_publish',$page['date_publish']);
				frontend_model_template::assign('n_title',$page['n_title']);
				frontend_model_template::assign('n_content',$page['n_content']);
				frontend_model_template::assign('n_image',$img);
			}else{
				
			}
		}
	}
	/**
	 * 
	 * fonction run
	 */
	public function run(){
		if(isset($this->getnews)){
			$this->display_getnews($this->getnews,$this->getdate);
			frontend_model_template::display('news/record.phtml');
		}elseif(magixcjquery_filter_request::isGet('tag')){
			frontend_model_template::assign('current_name_tag', urldecode($this->tag));
			frontend_model_template::display('news/tag.phtml');
		}else{
			frontend_model_template::display('news/index.phtml');
		}
	}
}
?>