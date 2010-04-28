<?php
/**
 * @category   Controller 
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name NEWS
 * @version 4.0
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
	 * @var string
	 */
	public $useradmin;
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
	 * @var integer
	 */
	public $phrase1;
	/**
	 * 
	 * @var string
	 */
	public $phrase2;
	/**
	 * 
	 * @var string
	 */
	public $getrewrite;
	/**
	 * 
	 * @var intéger
	 */
	public $idmetas;
	/**
	 * get delete metas news
	 * @var drmetas $_GET['drmetas']
	 */
	public $drmetas;
	/**
	 * 
	 * 
	 */
	function __construct(){
		if(isset($_GET['edit'])){
			$this->getnews = magixcjquery_filter_isVar::isPostNumeric($_GET['edit']);
		}
		if(isset($_GET['getrewrite'])){
			$this->getrewrite = magixcjquery_filter_isVar::isPostNumeric($_GET['getrewrite']);
		}
		if(isset($_SESSION['useradmin'])){
			$this->useradmin = $_SESSION['useradmin'];
		}
		if(isset($_POST['idmetas'])){
			$this->idmetas = magixcjquery_filter_isVar::isPostNumeric($_POST['idmetas']);
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
		if(isset($_POST['phrase1'])){
			$this->phrase1 = magixcjquery_form_helpersforms::inputClean($_POST['phrase1']);
		}
		if(isset($_POST['phrase2'])){
			$this->phrase2 = magixcjquery_form_helpersforms::inputClean($_POST['phrase2']);
		}
		if(isset($_GET['drmetas'])){
			$this->drmetas = (integer) magixcjquery_filter_isVar::isPostNumeric($_GET['drmetas']);
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
				$fetch = backend_config_smarty::getInstance()->fetch('request/empty.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
			}else{
					backend_db_news::adminDbNews()->i_new_news(
						$this->subject,
						$this->rewritelink,
						$this->content,
						$this->idlang,
						backend_model_member::s_idadmin()
					);
					backend_controller_rss::instance()->exec();
					$fetch = backend_config_smarty::getInstance()->fetch('request/success.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
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
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/admin/dashboard/news/',false,true,'page');
		
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
				$fetch = backend_config_smarty::getInstance()->fetch('request/empty.phtml');
				backend_config_smarty::getInstance()->assign('msg',$fetch);
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
					$fetch = backend_config_smarty::getInstance()->fetch('request/success.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
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
	 * Affiche la reecriture des métas de news trié par langue
	 */
	function view_metas(){
		$title = '<table class="clear">
						<thead>
							<tr>
							<th>type</th>
							<th>subject</th>
							<th>phrase</th>
							<th>subject</th>
							<th>phrase2</th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
		foreach(backend_db_config::adminDbConfig()->s_rewrite_meta(5) as $seo){
			$subject = backend_db_news::adminDbNews()->s_news_keyword($seo['codelang']);
			switch($seo['idmetas']){
				case 1:
					$type = 'TITLE';
					break;
				case 2:
					$type = 'DESCRIPTION';
					break;
			}
		 	$title .= '<tr class="line">';
		 	$title .= '<td class="maximal">'.$type.'</td>';
		 	$title .= '<td class="nowrap">'.$subject['subject'].'</td>';
		 	$title .= '<td class="nowrap">'.$seo['phrase1'].'</td>';
		 	$title .= '<td class="nowrap">'.$subject['subject'].'</td>';
		 	$title .= '<td class="nowrap">'.$seo['phrase2'].'</td>';
		 	$title .= '<td class="nowrap">'.$seo['codelang'].'</td>';
		 	$title .= '<td class="nowrap">'.'<a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/news/metas-rewrite/edit/'.$seo['idrewrite'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
		 	$title .= '<td class="nowrap">'.'<a class="d-news-rmetas" title="'.$seo['idrewrite'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
		 	$title .= '</tr>';
		}
		$title .= '</tbody></table>';
		return $title;;
	}
	/**
	 * insertion de la réécriture des métas
	 */
	private function insertion_rewrite(){
		if(isset($this->phrase1)){
			if(backend_db_config::adminDbConfig()->s_rewrite_v_lang(5,$this->idlang,$this->idmetas) == null){
				backend_db_config::adminDbConfig()->i_rewrite_metas(5,$this->idlang,$this->phrase1,$this->phrase2,null,$this->idmetas,0);
			}else{
					$fetch = backend_config_smarty::getInstance()->fetch('request/element-exist.phtml');
					backend_config_smarty::getInstance()->assign('msg',$fetch);
				}
		}
	}
	/**
	 * Mise à jour de la réécriture des métas
	 */
	private function update_rewrite(){
		if(isset($this->phrase1)){
			backend_db_config::adminDbConfig()->u_rewrite_metas(5,$this->idlang,$this->phrase1,$this->phrase2,'',$this->idmetas,0,$this->getrewrite);
		}
	}
	/**
	 * Supprime une réécriture des métas
	 */
	public function del_rewrite_metas(){
		if(isset($this->drmetas)){
			backend_db_config::adminDbConfig()->d_rewrite_metas($this->drmetas);
		}
	}
	/**
	 * La page d'edition d'une news
	 */
	public function edit(){
		self::update_data_forms();
		self::load_data_forms();
		backend_config_smarty::getInstance()->display('news/edit.phtml');
	}
	/**
	 * affiche la page des news
	 */
	function display_addnews(){
		self::insert_data_forms();
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('news/addnews.phtml');
	}
	/**
	 * 
	 */
	function rewrite_display(){
		self::insertion_rewrite();
		backend_config_smarty::getInstance()->assign('ptitle',self::view_metas());
		backend_config_smarty::getInstance()->assign('selectlang',backend_model_blockDom::select_language());
		backend_config_smarty::getInstance()->display('news/rewrite.phtml');
	}
	function edit_rewrite(){
		self::update_rewrite();
		$data = backend_db_config::adminDbConfig()->s_rewrite_for_edit($this->getrewrite);
		switch($data['idmetas']){
			case 1:
				$metas = 'title';
			break;
			case 2:
				$metas = 'description';
			break;
		}
		backend_config_smarty::getInstance()->assign('umetas',$metas);
		backend_config_smarty::getInstance()->assign('uidmetas',$data['idmetas']);
		backend_config_smarty::getInstance()->assign('uphrase1',$data['phrase1']);
		backend_config_smarty::getInstance()->assign('uphrase2',$data['phrase2']);
		backend_config_smarty::getInstance()->assign('ucodelang',$data['codelang']);
		backend_config_smarty::getInstance()->assign('uidlang',$data['idlang']);
		backend_config_smarty::getInstance()->assign('ptitle',self::view_metas());
		backend_config_smarty::getInstance()->display('news/editrewrite.phtml');
	}
	/**
	 * affiche la page des news
	 */
	function display_news(){
		backend_config_smarty::getInstance()->display('news/index.phtml');
	}
}