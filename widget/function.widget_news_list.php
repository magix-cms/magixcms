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
 * Smarty {widget_lastnews limit="" delimiter="" ui=true} 
 * function plugin
 *
 * Type:     function
 * Name:     widget news
 * Date:     Jully 18 2011
 * Update:   
 * Purpose:  
 * Examples: {widget_news_list}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_list($params, $template){
	if(magixcjquery_filter_request::isGet('strLangue')){
		$getlang = magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		$fcn = new frontend_controller_news();
		if (!isset($params['max'])) {
		 	trigger_error("limit: missing 'max' parameter");
			return;
		}
		$limit = $params['max'];
		$max = $params['max'];
		$news = '';
		$offset = $fcn->news_offset_pager($max);
		if(isset($getlang)){
			$news .= '<div class="list-div medium">';
			foreach(frontend_db_block_news::s_news_listing($getlang,$limit,$max,$offset) as $pnews){
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
						$news .= '<a href="'.magixglobal_model_rewrite::filter_news_url($getlang,$curl->date_europeen_format(),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
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
		$cnews = frontend_db_block_news::s_count_news($getlang);
		if($cnews['total'] >= $max){
			$news .= $fcn->news_pagination($max);
		}
	}
	return $news;
}