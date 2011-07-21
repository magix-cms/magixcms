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
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 *
 */
/**
 * Smarty {widget_news_tags} 
 * function plugin
 *
 * Type:     function
 * Name:     widget news
 * Date:     Jully 21 2011
 * Update:   
 * Purpose:  
 * Examples: {widget_news_tags}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_tags($params, $template){
	if(magixcjquery_filter_request::isGet('tag')){
		$gettag = magixcjquery_url_clean::make2tagString($_GET['tag']);
		$news = '';
		$news .= '<div class="list-div medium">';
		if(frontend_db_block_news::s_sort_tagnews(urldecode($gettag)) != null){
			foreach(frontend_db_block_news::s_sort_tagnews(urldecode($gettag)) as $pnews){
				$tag = frontend_db_block_news::s_news_tag($pnews['idnews']);
				$islang = $pnews['iso'];
				$curl = new magixglobal_model_dateformat($pnews['date_register']);
				$datepublish = new magixglobal_model_dateformat($pnews['date_publish']);
				if ($pnews['n_image'] != null){
					$image = '<img src="/upload/news/s_'.$pnews['n_image'].'" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
				}else{
					$image = '<img src="/skin/default/img/catalog/no-picture.png" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
				}
				$news .= '<div class="list-div-elem">';
				$news .='<a class="img">';
					$news .= $image;
				$news .='</a>';
				
				$news .='<p class="name">';
					$news .= '<a href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],$curl->date_europeen_format(),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
				$news .= '</p>';
				$news .= '<span class="descr">';
					$news .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['n_content'],240,''));
				$news .= '</span>';
				$news .= '<div class="clear"></div>';
				$news .='<div class="date rfloat">'.$datepublish->SQLDate().'</div>';
				if($tag != null){
					$news .= '<span class="tag">';
					$tagnews = '';
					foreach ($tag as $t){
						$uritag = magixglobal_model_rewrite::filter_news_tag_url($pnews['iso'],urlencode($t['name_tag']),true);
		  				$tagnews[]= '<a href="'.$uritag.'" title="'.$t['name_tag'].'">'.$t['name_tag'].'</a>';
					}
					$news .= implode(',', $tagnews);
					$news .= '</span>';
				} 
				$news .= '</div>';
			}
		}
		$news .= '</div>';
	}
	return $news;
}