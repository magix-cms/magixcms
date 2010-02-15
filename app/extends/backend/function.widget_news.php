<?php
/**
 * @category   Smarty Plugin
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cmsa.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-30
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_news max=0} function plugin
 *
 * Type:     function
 * Name:     widget_news
 * Date:     October 30, 2009
 * Purpose:  
 * Examples: {widget_news max=0}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news($params, &$smarty){
	$max = empty($params['max']) ? 5 : $params['max'];
	if (!isset($params['limit'])) {
	 	$smarty->trigger_error("limit: missing 'limit' parameter");
		return;
	}
	$viewuser = empty($params['viewuser']) ? true : false;
	if($viewuser){
		$thuser = '<th>Users</th>';
	}else{
		$thuser = '';
	}
	/**
	* variable pour la pagination de page
	*/
	$pager = null;
	if($params['limit'] == "true"){
		$limit = true;
		if($params['getpage'] == true){
			$pag = new backend_controller_news();
			$offset =  $pag->offset_pager($max);
			$pagernews= '<div class="pagination"><div class="middle">'.$pag->news_pager($max).'</div></div>';
		}
	}elseif($params['limit'] == "false"){
		$limit = false;
	}
	$plugin .= '<table class="clear">
						<thead>
							<tr>
							'.$thuser.'
							<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-calendar"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-suitcase"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
	if(backend_db_news::adminDbNews()->s_news_plugin($limit,$max,$offset)){
		foreach(backend_db_news::adminDbNews()->s_news_plugin($limit,$max,$offset) as $pnews){
			$islang = $pnews['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pnews['codelang']: '';
			$curl = date_create($pnews['date_sent']);
			switch($pnews['publish']){
				case 0:
					$publisher = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-close"></span></div>';
				break;
				case 1: 
					$publisher = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
				break;
			}
			switch($pnews['idlang']){
				case 0:
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$codelang = $pnews['codelang'];
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	$viewuser?'<td class="maximal">'.$pnews['pseudo'].'</td>':'';
			 $plugin .=	$viewuser?'<td class="nowrap">'.magixcjquery_string_convert::cleanTruncate($pnews['subject'],20,'...').'</td>':'<td class="maximal">'.magixcjquery_string_convert::cleanTruncate($pnews['subject'],20,'...').'</td>';
			 $plugin .=	'<td class="nowrap">'.$pnews['date_sent'].'</td>';
			 $plugin .=	'<td class="nowrap">'.$publisher.'</td>';
			 $plugin .= '<td class="nowrap">'.$codelang.'</td>';
			 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'news'.magixcjquery_html_helpersHtml::unixSeparator().date_format($curl,'Y/m/d').magixcjquery_html_helpersHtml::unixSeparator().$pnews['rewritelink'].'.html'.'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/news/edit/'.$pnews['idnews'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a class="deletenews" title="'.$pnews['idnews'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 $plugin .= '</tr>';
		}
	}else{
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '</tr>';
	}
	$plugin .= '</tbody></table>';
	$plugin .= $pagernews;
	return $plugin;
}
?>