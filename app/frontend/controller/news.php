<?php
/**
 * @category   Controller 
 * @package    news
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_controller_news{
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
	 * function construct
	 *
	 */
	function __construct(){
		if(isset($_GET['strLangue'])){
			$this->getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
			$this->slang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
		}
		if(isset($_GET['getnews'])){
			$this->getnews = ($_GET['getnews']);
		}
		if(isset($_GET['getdate'])){
			$this->getdate = ($_GET['getdate']);
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
	public function news_offset_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		return $pagination->pageOffset($max,$this->getpage);
	}
	/**
	 * Appel la pagination pour les articles (news)
	 * @param $max
	 * @access public
	 */
	public function news_pager($max){
		$pagination = new magixcjquery_pager_pagination();
		$request = frontend_db_news::publicDbNews()->s_count_news_publish_max();
		return $pagination->pagerData($request,'total',$max,$this->getpage,'/news/','.html',false,'page');
	}
	/**
	 * Retourne la pagination des news
	 * @param $max
	 * @access public
	 */
	public function news_pagination($max){
		return '<div class="pagination"><div class="middle">'.self::news_pager($max).'</div></div>';
	}
	/**
	 * Affiche la liste des news avec la pagination
	 * @access public
	 */
	public function s_all_linknews(){
		$max = 5;
		$news = '';
		$offset = self::news_offset_pager($max);
		if(isset($this->getlang)){
			foreach(frontend_db_news::publicDbNews()->s_news_plugins_lang($this->getlang,true,$max,$offset) as $pnews){
				$islang = $pnews['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pnews['codelang']: '';
				$curl = date_create($pnews['date_sent']);
				$news .= '<div class="listnews">';
				$news .='<div class="listnews-header">';
				$news .= '<a class="listnews-header-link" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$pnews['rewritelink'].'.html'.'">'.magixcjquery_string_convert::ucFirst($pnews['subject']).'</a>';
				$news .='<div style="float:right;"><span style="float:left;" class="ui-icon ui-icon-calendar"></span>'.$pnews['date_sent'].'</div></div>';
				$news .= '<div class="listnews-content">';
				$news .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['content'],240,''));
				$news .= '</div>';
				$news .= '</div>';
			}
		}else{
			foreach(frontend_db_news::publicDbNews()->s_news_plugins(true,$max,$offset) as $pnews){
				$islang = $pnews['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pnews['codelang']: '';
				$curl = date_create($pnews['date_sent']);
				$news .= '<div class="listnews">';
				$news .='<div class="listnews-header">';
				$news .= '<a class="listnews-header-link" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$pnews['rewritelink'].'.html'.'">'.magixcjquery_string_convert::ucFirst($pnews['subject']).'</a>';
				$news .='<div style="float:right;"><span style="float:left;" class="ui-icon ui-icon-calendar"></span>'.$pnews['date_sent'].'</div></div>';
				$news .= '<div class="listnews-content">';
				$news .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['content'],240,''));
				$news .= '</div>';
				$news .= '</div>';
			}
		}
		frontend_config_smarty::getInstance()->assign('listnews',$news);
		$cnews = frontend_db_news::publicDbNews()->s_count_news_publish_max();
		if($cnews['total'] >= $max){
			frontend_config_smarty::getInstance()->assign('npagination',self::news_pagination($max));
		}else{
			frontend_config_smarty::getInstance()->assign('npagination',null);
		}
	}
	/**
	 * Retourne le contenu de la news courante
	 * @access public
	 */
	public function load_news_content(){
		$news = frontend_db_news::publicDbNews()->s_news_page($this->getdate,$this->getnews);
		frontend_config_smarty::getInstance()->assign('subject',magixcjquery_string_convert::ucFirst($news['subject']));
		frontend_config_smarty::getInstance()->assign('content',$news['content']);
		frontend_config_smarty::getInstance()->assign('date_sent',$news['date_sent']);
	}
	/**
	 * Retourne la page de la news courante
	 * @access public
	 */
	public function display_getnews(){
		self::load_news_content();
		frontend_config_smarty::getInstance()->display('news/index.phtml');
	}
	/**
	 * Retourne la page qui liste les news avec pagination
	 * @access public
	 */
	public function display_list(){
		self::s_all_linknews();
		frontend_config_smarty::getInstance()->display('news/list.phtml');
	}
}
?>