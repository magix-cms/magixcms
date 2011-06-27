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
 * @version    4.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name news
 *
 */
class backend_controller_news extends backend_db_news{
	/**
	 * 
	 * @var integer
	 */
	public $getnews;
	/**
	 * 
	 * @var string
	 */
	public $subject;
	/**
	 * 
	 * @var string
	 */
	public $rewritelink;
	/**
	 * 
	 * @var string
	 */
	public $content;
	/**
	 * 
	 * @var string
	 */
	public $idlang;
	/**
	 * 
	 * @var string
	 */
	public $publish;
	/**
	 * 
	 * @var intéger
	 */
	public $getpage;
	/**
	 * 
	 * @var intéger
	 */
	public $delnews;
	public $status_news,$get_news_publication;
	/**
	 * 
	 * 
	 */
	function __construct(){
		if(magixcjquery_filter_request::isGet('edit')){
			$this->getnews = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('subject')){
			$this->subject = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
			$this->rewritelink = magixcjquery_url_clean::rplMagixString($_POST['subject']);
		}
		if(magixcjquery_filter_request::isPost('content')){
			$this->content = ($_POST['content']);
		}
		if(magixcjquery_filter_request::isPost('idlang')){
			$this->idlang = magixcjquery_filter_isVar::isPostNumeric($_POST['idlang']);
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
		if(magixcjquery_filter_request::isPost('publish')){
			$this->publish = magixcjquery_filter_isVar::isPostNumeric($_POST['publish']);
		}
		if(magixcjquery_filter_request::isGet('delnews')){
			$this->delnews = magixcjquery_filter_isVar::isPostNumeric($_GET['delnews']);
		}
		if(magixcjquery_filter_request::isGet('status_news')) {
			$this->status_news = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['status_news']);
		}
		if(magixcjquery_filter_request::isGet('get_news_publication')) {
			$this->get_news_publication = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['get_news_publication']);
		}
	}
	/**
	 * @access private
	 * insertion d'une nouvelle news
	 */
	private function insert_data_forms(){
		if(isset($this->subject) AND isset($this->content)){
			if(empty($this->subject) OR empty($this->content)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
					parent::i_new_news(
						$this->subject,
						$this->rewritelink,
						$this->content,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					$rss = new backend_controller_rss();
					$rss->run();
					backend_config_smarty::getInstance()->display('request/success.phtml');
				}
			}
	}
	/**
	 * offset for pager in pagination
	 * @param $max
	 */
	public function offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * pagination for news
	 * @param $max
	 */
	public function news_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = parent::s_count_news_pager_max();
		return $pagination->pagerData(
			$request,
			'total',
			$max,$this->getpage,
			'/admin/news.php?',
			false,
			false,
			'page'
		);
	}
	/**
	 * @access private
	 * Chargement de l'url public courante avec JSON
	 */
	private function load_json_uri_news(){
		$data = parent::s_news_record($this->getnews);
		if($data['idnews'] != null){
			$dateformat = new magixglobal_model_dateformat($data['date_sent']);
			$uri = magixglobal_model_rewrite::filter_news_url(
				$data['codelang'], 
				$dateformat->date_europeen_format(), 
				$data['rewritelink'],
				true
			);
			$input= '{"newsuri":'.json_encode(magixcjquery_url_clean::rplMagixString($uri)).'}';
			print $input;
		}
	}
	/**
	 * @access private
	 * Charge les données du formulaire pour la mise à jour
	 */
	private function load_data_forms(){
		/**
		 * Retourne un tableau des données
		 * @var 
		 */
		$data = parent::s_news_record($this->getnews);
		backend_config_smarty::getInstance()->assign('subject',$data['subject']);
		backend_config_smarty::getInstance()->assign('content',$data['content']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		backend_config_smarty::getInstance()->assign('date_sent',$data['date_sent']);
		backend_config_smarty::getInstance()->assign('publish',$data['publish']);
	}
	/**
	 * @access private
	 * POST le formulaire de mise à jour des données
	 */
	private function update_data_forms(){
		if(isset($this->subject) AND isset($this->content)){
			if(empty($this->subject) OR empty($this->content)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
					switch($this->publish){
						case 0:
							$date_publication = null;
						break;
						case 1:
							$dateformat = new magixglobal_model_dateformat();
							$date_publication = $dateformat->SQLDateTime();
						break;
					}
					parent::u_news_page(
						$this->subject,
						$this->rewritelink,
						$this->content,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->getnews,
						$date_publication,
						$this->publish
					);
					$rss = new backend_controller_rss();
					$rss->run();
					backend_config_smarty::getInstance()->display('request/success.phtml');
			}
		}
	}
	/**
	 * @access private
	 * Modifie le status de la news
	 */
	private function update_status_publication(){
		if(isset($this->status_news)){
			parent::u_status_publication_of_news($this->get_news_publication,$this->status_news);
			backend_controller_rss::instance()->exec();
		}
	}
	/**
	 * @access private
	 * Supprime une news
	 */
	private function del_news(){
		if(isset($this->delnews)){
			parent::d_news($this->delnews);
		}
	}
	/**
	 * La page d'edition d'une news
	 */
	private function edit(){
		self::load_data_forms();
		backend_config_smarty::getInstance()->display('news/edit.phtml');
	}
	/**
	 * affiche la page des news
	 */
	private function display_addnews(){
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('news/addnews.phtml');
	}
	/**
	 * affiche la page des news
	 */
	private function display_news(){
		backend_config_smarty::getInstance()->display('news/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_data_forms();
			}elseif(magixcjquery_filter_request::isGet('load_json_uri_news')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				self::load_json_uri_news();
			}else{
				self::edit();
			}
		}elseif(magixcjquery_filter_request::isGet('get_news_publication')){
			self::update_status_publication();
		}elseif(magixcjquery_filter_request::isGet('add')){
			if(magixcjquery_filter_request::isGet('post')){
				self::insert_data_forms();
			}else{
				self::display_addnews();
			}
		}elseif(magixcjquery_filter_request::isGet('delnews')){
			self::del_news();
		}else{
			self::display_news();
		}
	}
}