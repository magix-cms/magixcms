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
	public $n_title;
	/**
	 * 
	 * @var string
	 */
	public $n_uri;
	/**
	 * 
	 * @var string
	 */
	public $n_content;
	/**
	 * 
	 * @var string
	 */
	public $idlang;
	public $n_image,$post;
	/**
	 * 
	 * @var string
	 */
	public $published;
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
	public function __construct(){
		if(magixcjquery_filter_request::isGet('edit')){
			$this->getnews = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(magixcjquery_filter_request::isPost('n_title')){
			$this->n_title = magixcjquery_form_helpersforms::inputClean($_POST['n_title']);
		}
		if(magixcjquery_filter_request::isPost('n_uri')){
			$this->n_uri = magixcjquery_url_clean::rplMagixString($_POST['n_uri']);
		}
		if(magixcjquery_filter_request::isPost('n_content')){
			$this->n_content = ($_POST['n_content']);
		}
		if(isset($_FILES['n_image']["name"])){
			$this->n_image = magixcjquery_url_clean::rplMagixString($_FILES['n_image']["name"]);
		}
		if(magixcjquery_filter_request::isGet('post')){
			$this->post = magixcjquery_form_helpersforms::inputClean($_GET['post']);
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
		if(magixcjquery_filter_request::isPost('published')){
			$this->published = magixcjquery_filter_isVar::isPostNumeric($_POST['published']);
		}
		if(magixcjquery_filter_request::isPost('delnews')){
			$this->delnews = magixcjquery_filter_isVar::isPostNumeric($_POST['delnews']);
		}
		if(magixcjquery_filter_request::isPost('status_news')) {
			$this->status_news = (integer) magixcjquery_filter_isVar::isPostNumeric($_POST['status_news']);
		}
		if(magixcjquery_filter_request::isGet('get_news_publication')) {
			$this->get_news_publication = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['get_news_publication']);
		}
	}
	/**
	 * @access private
	 * Le dossier images des news 
	 */
	private function dir_img_news(){
		return magixglobal_model_system::base_path().'/upload/news/';
	}
	/**
	 * 
	 * Génération d'un identifiant alphanumérique avec une longueur définie
	 * @param integer $numString
	 */
	private function extract_random_idnews($numString){
		return magixglobal_model_cryptrsa::short_alphanumeric_id($numString);
	}
	/**
	 * 
	 * Insert une image dans les news
	 * @param string $nimage
	 * @param void $confimg
	 * @param bool $update
	 * @throws Exception
	 */
	private function insert_image_news($nimage,$confimg,$update=false){
		if(isset($nimage)){
			try{
				$makeFiles = new magixcjquery_files_makefiles();
				if($update == true){
					$vimage = parent::s_n_image_news($this->getnews);
					if(file_exists(self::dir_img_news().$vimage['n_image'])){
						$makeFiles->removeFile(self::dir_img_news(),$vimage['n_image']);
						$makeFiles->removeFile(self::dir_img_news(),'s_'.$vimage['n_image']);
					}else{
						throw new Exception('file: '.$vimage['n_image'].' is not found');
					}
				}
				/**
				 * Envoi une image dans le dossier "racine" catalogimg
				 */
				backend_model_image::upload_img($confimg,'upload'.DIRECTORY_SEPARATOR.'news'.DIRECTORY_SEPARATOR);
				/**
				 * Analyze l'extension du fichier en traitement
				 * @var $fileextends
				 */
				$fileextends = backend_model_image::image_analyze(self::dir_img_news().$nimage);
				/**
				 * 
				 * Enter description here ...
				 * @var unknown_type
				 */
				$rimage = magixglobal_model_cryptrsa::uniq_id();
				/**
				 * Initialisation de la classe phpthumb 
				 * @var void
				 */
				$thumb = PhpThumbFactory::create(self::dir_img_news().$nimage);
				$imageuri = $rimage.$fileextends;
				$imgsetting = new backend_model_setting();
				$imgsizesmall = $imgsetting->uniq_data_img_size('news','news','small');
				$imgsizemed = $imgsetting->uniq_data_img_size('news','news','medium');
				//Redimensionnement et changement de nom suivant la catégorie
				switch($imgsizemed['img_resizing']){
					case 'basic':
						$thumb->resize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_news().$imageuri);
					break;
					case 'adaptive':
						$thumb->adaptiveResize($imgsizemed['width'],$imgsizemed['height'])->save(self::dir_img_news().$imageuri);
					break;
				}
				switch($imgsizesmall['img_resizing']){
					case 'basic':
						$thumb->resize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_news().'s_'.$imageuri);
					break;
					case 'adaptive':
						$thumb->adaptiveResize($imgsizesmall['width'],$imgsizesmall['height'])->save(self::dir_img_news().'s_'.$imageuri);
					break;
				}
				//Supprime le fichier original pour gagner en espace
				if(file_exists(self::dir_img_news().$nimage)){
					$makeFiles->removeFile(self::dir_img_news(),$nimage);
				}else{
					throw new Exception('file: '.$nimage.' is not found');
				}
				return $imageuri;
			}catch (Exception $e){
				magixglobal_model_system::magixlog('An error has occured :',$e);
			}
		}
	}
	/**
	 * @access private
	 * insertion d'une nouvelle news
	 */
	private function insert_data_forms(){
		if(isset($this->n_title) AND isset($this->n_content)){
			if(empty($this->n_title) OR empty($this->n_content)){
				backend_controller_template::display('request/empty.phtml');
			}else{
					parent::i_new_news(
						$this->extract_random_idnews(20),
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->n_title,
						magixcjquery_url_clean::rplMagixString($this->n_title),
						$this->n_content
					);
					backend_controller_template::display('request/success.phtml');
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
			$dateformat = new magixglobal_model_dateformat($data['date_register']);
			$uri = magixglobal_model_rewrite::filter_news_url(
				$data['iso'], 
				$dateformat->date_europeen_format(), 
				$data['n_uri'], 
				$data['keynews'],
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
	private function load_data_forms($data){
		/**
		 * Retourne un tableau des données
		 * @var 
		 */
		backend_controller_template::assign('n_title',$data['n_title']);
		backend_controller_template::assign('n_content',$data['n_content']);
		backend_controller_template::assign('n_uri',$data['n_uri']);
		backend_controller_template::assign('idlang',$data['idlang']);
		backend_controller_template::assign('iso',$data['iso']);
		backend_controller_template::assign('date_register',$data['date_register']);
		backend_controller_template::assign('published',$data['published']);
	}
	/**
	 * @access private
	 * Charge les données de l'image de la news
	 * @param string $news_img
	 */
	private function news_image($news_img){
		if($news_img != null){
			$img = '<img style="position:relative;margin:auto;" src="/upload/news/s_'.$news_img.'" alt="" />';
		}else{
			$img = '<div style="margin-top:40%;text-align:center;">Aucune image pour cette news</div>';
		}
		print $img;
	}
	/**
	 * @access private
	 * POST le formulaire de mise à jour des données
	 */
	private function update_data_forms(){
		if(isset($this->n_title) AND isset($this->n_content)){
			if(empty($this->n_title) OR empty($this->n_content)){
				backend_controller_template::display('request/empty.phtml');
			}else{
				switch($this->published){
					case 0:
						$date_publication = '0000-00-00 00:00:00';
					break;
					case 1:
						$dateformat = new magixglobal_model_dateformat();
						$date_publication = $dateformat->SQLDateTime();
					break;
				}
				if(!empty($this->n_uri)){
					$uri = $this->n_uri;
				}else{
					$uri = magixcjquery_url_clean::rplMagixString($this->n_title);
				}
				parent::u_news_page(
					$this->n_title,
					$uri,
					$this->n_content,
					backend_model_member::s_idadmin(),
					$date_publication,
					$this->published,
					$this->getnews
				);
				$rss = new backend_controller_rss();
				$rss->run('news');
				backend_controller_template::display('request/success.phtml');
			}
		}
	}
	private function update_news_image(){
		if(isset($this->n_image)){
			if($this->n_image != null){
				$img = self::insert_image_news($this->n_image,'n_image',true);
			}else{
				$makeFiles = new magixcjquery_files_makefiles();
				$vimage = parent::s_n_image_news($this->getnews);
				if(file_exists(self::dir_img_news().$vimage['n_image'])){
					$makeFiles->removeFile(self::dir_img_news(),$vimage['n_image']);
					$makeFiles->removeFile(self::dir_img_news(),'s_'.$vimage['n_image']);
				}
				$img = null;
			}
			parent::u_news_image($img, $this->getnews);
			//backend_controller_template::display('request/success.phtml');
		}
	}
	/**
	 * @access private
	 * Modifie le status de la news
	 */
	private function update_status_publication(){
		if(isset($this->status_news)){
			parent::u_status_publication_of_news($this->get_news_publication,$this->status_news);
			$rss = new backend_controller_rss();
				$rss->run('news');
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
	 * @access private
	 * Requête JSON pour les statistiques du CMS
	 */
	private function json_news_chart(){
		if(parent::s_count_news_by_lang() != null){
			foreach (parent::s_count_news_by_lang() as $s){
				$rowNews[]= $s['countnews'];
			}
		}else{
			$rowNews = array(0);
		}
		if(backend_db_block_lang::s_data_lang() != null){
			foreach (backend_db_block_lang::s_data_lang() as $s){
				$rowLang[]= json_encode(magixcjquery_string_convert::upTextCase($s['iso']));
			}
		}else{
			$rowLang = array(0);
		}
		print '{"news_count":['.implode(',',$rowNews).'],"lang":['.implode(',',$rowLang).']}';
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		$header= new magixglobal_model_header();
		if(magixcjquery_filter_request::isGet('edit')){
			$data = parent::s_news_record($this->getnews);
			if(magixcjquery_filter_request::isPost('n_title')){
				$this->update_data_forms();
			}elseif(magixcjquery_filter_request::isGet('post')){
				$this->update_news_image();
			}elseif(magixcjquery_filter_request::isGet('load_json_uri_news')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				self::load_json_uri_news();
			}elseif(magixcjquery_filter_request::isGet('imgnews')){
				$this->news_image($data['n_image']);
			}else{
				$this->load_data_forms($data);
				backend_controller_template::display('news/edit.phtml');
			}
		}elseif(magixcjquery_filter_request::isGet('get_news_publication')){
			self::update_status_publication();
		}elseif(magixcjquery_filter_request::isGet('add')){
			if(magixcjquery_filter_request::isPost('n_title')){
				self::insert_data_forms();
			}else{
				backend_controller_template::assign('selectlang',backend_model_blockDom::select_language());
				backend_controller_template::display('news/addnews.phtml');
			}
		}elseif(magixcjquery_filter_request::isPost('delnews')){
			$this->del_news();
		}else{
			if(magixcjquery_filter_request::isGet('json_google_chart_news')){
				$header->head_expires("Mon, 26 Jul 1997 05:00:00 GMT");
				$header->head_last_modified(gmdate( "D, d M Y H:i:s" ) . "GMT");
				$header->pragma();
				$header->cache_control("nocache");
				$header->getStatus('200');
				$header->json_header("UTF-8");
				$this->json_news_chart();
			}else{
				backend_controller_template::display('news/index.phtml');
			}
		}
	}
}