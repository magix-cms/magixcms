<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_news max=0} function plugin
 *
 * Type:     function
 * Name:     widget_news
 * Date:     August 02, 2010
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
function smarty_function_widget_news($params, $template){
	$max = empty($params['max']) ? 5 : $params['max'];
	if (!isset($params['limit'])) {
	 	trigger_error("limit: missing 'limit' parameter");
		return;
	}
	$viewuser = empty($params['viewuser']) ? true : false;
	if($viewuser){
		$thuser = '<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>';
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
						<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-calendar"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-calendar-insert"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-suitcase"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
						'.$thuser.'
						<th><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
						</tr>
					</thead>
					<tbody>';
	if(backend_db_block_news::s_news_plugin($limit,$max,$offset)){
		$dateformat = new magixglobal_model_dateformat();
		foreach(backend_db_block_news::s_news_plugin($limit,$max,$offset) as $pnews){
			$islang = $pnews['iso'] ? $pnews['iso']: '';
			switch($pnews['published']){
				case 0:
					$publisher = '<div class="ui-state-error" style="border:none;"><a title="Modifier l\'état de cette news" href="/admin/news.php?get_news_publication='.$pnews['idnews'].'" class="u-news-published"><span style="float:left" class="ui-icon ui-icon-close"></span></a></div>';
				break;
				case 1: 
					$publisher = '<div class="ui-state-highlight" style="border:none;"><a title="Modifier l\'état de cette news" href="/admin/news.php?get_news_publication='.$pnews['idnews'].'" class="u-news-published"><span style="float:left" class="ui-icon ui-icon-check"></span></a></div>';
				break;
			}
			switch($pnews['idlang']){
				case 0:
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$codelang = $pnews['iso'];
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	$viewuser?'<td class="maximal"><a class="linkurl" href="/admin/news.php?edit='.$pnews['idnews'].'">'.magixcjquery_string_convert::cleanTruncate($pnews['n_title'],100,'...').'</a></td>':'<td class="maximal"><a class="linkurl" href="/admin/news.php?edit='.$pnews['idnews'].'">'.magixcjquery_string_convert::cleanTruncate($pnews['n_title'],100,'...').'</a></td>';
			 $plugin .=	'<td class="nowrap">'.$dateformat->SQLDate($pnews['date_register']).'</td>';
			 $plugin .=	'<td class="nowrap">'.$dateformat->SQLDate($pnews['date_publish']).'</td>';
			 $plugin .=	'<td class="nowrap">'.$publisher.'</td>';
			 $plugin .= '<td class="nowrap">'.$codelang.'</td>';
			 $plugin .=	$viewuser?'<td class="nowrap">'.$pnews['pseudo'].'</td>':'';
			 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixglobal_model_rewrite::filter_news_url($islang,$dateformat->date_europeen_format($pnews['date_register']),$pnews['n_uri'],$pnews['keynews'],true).'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="/admin/news.php?edit='.$pnews['idnews'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a class="deletenews" rel="'.$pnews['idnews'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 $plugin .= '</tr>';
		}
	}else{
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
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