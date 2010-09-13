<?php
/**
 * MAGIX CMS
 * @category   Controller 
 * @package    backend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    4.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name news
 *
 */
class backend_controller_news{
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
	/**
	 * 
	 * 
	 */
	function __construct(){
		if(isset($_GET['edit'])){
			$this->getnews = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(isset($_POST['subject'])){
			$this->subject = magixcjquery_form_helpersforms::inputClean($_POST['subject']);
			$this->rewritelink = magixcjquery_url_clean::rplMagixString($_POST['subject']);
		}
		if(isset($_POST['content'])){
			$this->content = ($_POST['content']);
		}
		if(isset($_POST['idlang'])){
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
		if(isset($_POST['publish'])){
			$this->publish = magixcjquery_filter_isVar::isPostNumeric($_POST['publish']);
		}
		if(isset($_GET['delnews'])){
			$this->delnews = magixcjquery_filter_isVar::isPostNumeric($_GET['delnews']);
		}
	}
	/**
	 * insertion d'une nouvelle news
	 */
	private function insert_data_forms(){
		if(isset($this->subject) AND isset($this->content)){
			if(empty($this->subject) OR empty($this->content)){
				backend_config_smarty::getInstance()->display('request/empty.phtml');
			}else{
					backend_db_news::adminDbNews()->i_new_news(
						$this->subject,
						$this->rewritelink,
						$this->content,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					backend_controller_rss::instance()->exec();
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
		$request = backend_db_news::adminDbNews()->s_count_news_pager_max();
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/admin/news.php?',false,false,'page');
		
	}
	/**
	 * Charge les données du formulaire pour la mise à jour
	 */
	private function load_data_forms(){
		/**
		 * Retourne un tableau des données
		 * @var 
		 */
		$data = backend_db_news::adminDbNews()->s_news_record($this->getnews);
		backend_config_smarty::getInstance()->assign('subject',$data['subject']);
		backend_config_smarty::getInstance()->assign('content',$data['content']);
		backend_config_smarty::getInstance()->assign('idlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('codelang',$data['codelang']);
		backend_config_smarty::getInstance()->assign('date_sent',$data['date_sent']);
		backend_config_smarty::getInstance()->assign('publish',$data['publish']);
		$curl = date_create($data['date_sent']);
		$islang = $data['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$data['codelang']: '';
		backend_config_smarty::getInstance()->assign('url',$islang.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$data['rewritelink'].'.html');
		backend_config_smarty::getInstance()->assign('view',magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$data['rewritelink'].'.html');
	}
	/**
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
							$date_publication = date("Y-m-d H:i:s");
						break;
					}
					backend_db_news::adminDbNews()->u_news_page(
						$this->subject,
						$this->rewritelink,
						$this->content,
						$this->idlang,
						backend_model_member::s_idadmin(),
						$this->getnews,
						$date_publication,
						$this->publish
					);
					backend_controller_rss::instance()->exec();
					backend_config_smarty::getInstance()->display('request/success.phtml');
			}
		}
	}
	/**
	 * Supprime une news
	 */
	public function del_news(){
		if(isset($this->delnews)){
			backend_db_news::adminDbNews()->d_news($this->delnews);
		}
	}
	/**
	 * La page d'edition d'une news
	 */
	public function edit(){
		self::load_data_forms();
		backend_config_smarty::getInstance()->display('news/edit.phtml');
	}
	/**
	 * affiche la page des news
	 */
	function display_addnews(){
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('news/addnews.phtml');
	}
	/**
	 * affiche la page des news
	 */
	function display_news(){
		backend_config_smarty::getInstance()->display('news/index.phtml');
	}
	/**
	 * Execute le module dans l'administration
	 * @access public
	 */
	public function run(){
		if(magixcjquery_filter_request::isGet('edit')){
			if(magixcjquery_filter_request::isGet('post')){
				self::update_data_forms();
			}else{
				self::edit();
			}
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