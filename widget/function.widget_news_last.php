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
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_lastnews limit="" delimiter="" ui=true} 
 * function plugin
 *
 * Type:     function
 * Name:     widget news
 * Date:     December 2, 2009
 * Update:   01-08-2011 
 * Purpose:  
 * Examples: {widget_news_last
				css_param=[
					'class_elem'=>'list-div-elem',
					'class_img'=>'img'
				] 
				tag=""
				limit="" 
				delimiter=""
			}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_last($params, $template){
//Paramètres des classes CSS
	if (isset($params['css_param'])) {
		if(is_array($params['css_param'])){
			$tabs = $params['css_param'];
		}else{
			trigger_error("css_param is not array");
			return;
		}
	}else{
		$tabs= array(
				'class_elem'=>'list-div-elem'
				,'class_img'=>'img'
			);
	}
	$filter = new magixglobal_model_imagepath();
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 250 ;
	$delimiter = $params['delimiter']? $params['delimiter']: '';
	$newsall = $params['newsall'];
	$iniDB = new frontend_db_block_news();
	$pnews = $iniDB->s_lastnews_plugins(frontend_model_template::current_Language());
	$news_uri = magixglobal_model_rewrite::filter_news_root_url($pnews['iso'],true);
	if(isset($params['tag']) AND $params['tag'] != ''){
		if($iniDB->s_lastnews_plugins(frontend_model_template::current_Language(),$params['tag']) != null){
			$pnews = $iniDB->s_lastnews_plugins(frontend_model_template::current_Language(),$params['tag']);
			$news_alluri=magixglobal_model_rewrite::filter_news_tag_url($pnews['iso'], $params['tag'],true);
		}
	}else{
		$pnews = $iniDB->s_lastnews_plugins(frontend_model_template::current_Language());
		$news_alluri = $news_uri;
	}
	if($pnews != null){
		if ($pnews['n_image'] != null){
			$image = '<img src="'.$filter->filterPathImg(array('filtermod'=>'news','img'=>'s_'.$pnews['n_image'])).'" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
		}else{
			$image = '<img src="'.$filter->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png')).'" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
		}
		$curl = date_create($pnews['date_register']);
		$widget = '<div class="'.$tabs['class_elem'].'">';
		$widget .='<a href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],date_format($curl,'Y/m/d'),$pnews['n_uri'],$pnews['keynews'],true).'" class="'.$tabs['class_img'].'">';
				$widget .= $image;
		$widget .='</a>';
		$widget .='<p class="name">';
		$widget .= '<a href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],date_format($curl,'Y/m/d'),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
		$widget .= '</p>';
		$widget .= '<span class="descr">';
			$widget .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['n_content'],$length,$delimiter));
		$widget .= '</span>';	
		$widget .= '<a href="'.$news_alluri.'">'.$newsall.'</a>';
		$widget .= '</div>';
	}
	return $widget;
}