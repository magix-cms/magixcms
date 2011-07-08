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
	public $uri_get_news;
	/**
	 * function construct
	 *
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			//$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
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
	}
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	private function news_offset_pager($max){
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
		$request = parent::s_count_news($this->getlang);
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/news/','/',false,'page');
	}
	/**
	 * Retourne la pagination des news
	 * @param $max
	 * @access public
	 */
	private function news_pagination($max){
		return '<div class="pagination"><div class="middle">'.self::news_pager($max).'</div></div>';
	}
	/**
	 * Affiche la liste des news avec la pagination
	 * @access public
	 */
	private function s_all_linknews(){
		$limit = 5;
		$max = 5;
		$news = '';
		$offset = self::news_offset_pager($max);
		if(isset($this->getlang)){
			$news .= '<div class="list-div medium">';
			foreach(parent::s_news_listing($this->getlang,$limit,$max,$offset) as $pnews){
				$islang = $pnews['iso'];
				$curl = new magixglobal_model_dateformat($pnews['date_register']);
				$datepublish = new magixglobal_model_dateformat($pnews['date_publish']);
				$news .= '<div class="list-div-elem">';
				$news .='<a class="img">';
						$news .='<img src="/skin/default/img/catalog/no-picture.png" />';
					$news .='</a>';
					
					$news .='<p class="name">';
						$news .= '<a href="'.magixglobal_model_rewrite::filter_news_url($this->getlang,$curl->date_europeen_format(),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
					$news .= '</p>';
					$news .= '<span class="descr">';
						$news .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['n_content'],240,''));
					$news .= '</span>';
					$news .= '<div class="clear"></div>';
					$news .='<div class="date rfloat">'.$datepublish->SQLDate().'</div>';
					$news .= '<span class="tag">';
						$news .= '<a href="#">Mon tag</a>, <a href="#">Mon tag</a>, <a href="#">Mon tag</a>, <a href="#">Mon tag</a>, ';
					$news .= '</span>';
					$news .= '</div>';
			}
			$news .= '</div>';
		}
		frontend_model_template::assign('listnews',$news);
		/*$cnews = parent::s_count_news($this->getlang);
		if($cnews['total'] >= $max){
			frontend_model_template::assign('npagination',self::news_pagination($max));
		}else{
			frontend_model_template::assign('npagination',null);
		}*/
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
					frontend_model_template::assign('date_publish',$page['date_publish']);
					frontend_model_template::assign('n_title',$page['n_title']);
					frontend_model_template::assign('n_content',$page['n_content']);
					frontend_model_template::assign('n_image',$page['n_image']);
			}else{
				
			}
		}
	}
	/**
	 * Retourne la page qui liste les news avec pagination
	 * @access public
	 */
	private function display_list(){
		self::s_all_linknews();
		frontend_model_template::display('news/index.phtml');
	}
	public function run(){
		if(isset($this->getnews)){
			$this->display_getnews($this->getnews,$this->getdate);
			frontend_model_template::display('news/record.phtml');
		}else{
			self::display_list();
		}
	}
}
?>