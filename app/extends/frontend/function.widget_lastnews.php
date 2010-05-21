<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_lastnews limit="" delimiter="" ui=true} 
 * function plugin
 *
 * Type:     function
 * Name:     widget news
 * Date:     December 2, 2009
 * Update:   February 1, 2010
 * Purpose:  
 * Examples: {widget_lastnews limit="" delimiter="" ui=true}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_lastnews($params, &$smarty){
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 250 ;
	$delimiter = $params['delimiter']? $params['delimiter']: '...';
	$ui = $params['ui'];
	$newsall = $params['newsall'];
	if (!isset($length)) {
	 	$smarty->trigger_error("limit: missing 'Content length' parameter");
		return;
	}elseif(!isset($delimiter)){
		$smarty->trigger_error("limit: missing 'Delimiter' parameter");
		return;
	}
	if($ui){
		$whead =' ui-widget-header ui-corner-all';
		$wcontent =' ui-widget-content ui-corner-all';
		$wicons = '<span style="float:left;" class="ui-icon ui-icon-calendar"></span>';
	}
	$lang = $_GET['strLangue'] ? magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3):'';
	if(isset($_GET['strLangue'])){
		$pnews = frontend_db_news::publicDbNews()->s_lastnews_lang_plugins($lang);
		if($pnews != null){
			$islang = $pnews['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pnews['codelang']: '';
			$curl = date_create($pnews['date_sent']);
			$widget = '<div class="widget-news'.$wcontent.'">';
			$widget .='<div class="widget-news-header'.$whead.'">';
			$widget .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$pnews['rewritelink'].'.html'.'">'.magixcjquery_string_convert::ucFirst($pnews['subject']).'</a>';
			$widget .='<div style="float:right;">'.$wicons.$pnews['date_sent'].'</div></div>';
			$widget .= '<div class="widget-news-content">';
			$widget .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['content'],$length,$delimiter));
			$widget .= '<br /><a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news.html>'.$newsall.'</a>';
			$widget .= '</div>';
			$widget .= '</div>';
		}
	}else{
		$pnews = frontend_db_news::publicDbNews()->s_lastnews_plugins();
		if($pnews != null){
			$islang = $pnews['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pnews['codelang']: '';
			$curl = date_create($pnews['date_sent']);
			$widget = '<div class="widget-news'.$wcontent.'">';
			$widget .='<div class="widget-news-header'.$whead.'">';
			$widget .= '<a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$pnews['rewritelink'].'.html'.'">'.magixcjquery_string_convert::ucFirst($pnews['subject']).'</a>';
			$widget .='<div style="float:right;">'.$wicons.$pnews['date_sent'].'</div></div>';
			$widget .= '<div class="widget-news-content">';
			$widget .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['content'],$length,$delimiter));
			$widget .= '<br /><a href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news.html">'.$newsall.'</a>';
			$widget .= '</div>';
			$widget .= '</div>';
		}
	}	
	return $widget;
}