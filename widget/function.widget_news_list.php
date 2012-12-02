<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
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
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_news_list limit="" delimiter=""} 
 * function plugin
 *
 * Type:     function
 * Name:     widget news list
 * Date:     Jully 18 2011
 * Update:   2 December 2011 22:30
 * Purpose:  
 * Examples: {widget_news_list
				css_param=[
					'class_container'=>'ch1-2 ch-light',
					'class_name'=>'name',
					'class_elem'=>'child',
					'class_box'=>'box',
					'class_img'=>'img',
					'class_desc'=>'descr'
				] max=10 delimiter="" col=2}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.6
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_list($params, $template){
	$fcn = new frontend_controller_news();
	if (!isset($params['max'])) {
	 	trigger_error("limit: missing 'max' parameter");
		return;
	}
	$limit = $params['max'];
	$max = $params['max'];
	// Parametre pour la description du produit
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 240 ;
	// Le délimiteur pour tronqué le texte
	$delimiter = $params['delimiter'] ? $params['delimiter'] : '';
	// Nombre de colones (utilisé pour l"ajout d'une class last par ligne)
	$last = $params['col']? $params['col'] : 0 ;
	$news = '';
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
				'class_container'=>'ch1-2 ch-light',
				'class_name'=>'name',
				'class_elem'=>'child',
				'class_box'=>'box',
				'class_img'=>'img',
				'class_desc'=>'descr',
				'class_pagination' => 'clear pagination'
			);
	}
	$class_container = ($tabs['class_container'] != null)? ' class="' . $tabs['class_container'] . '"' : '' ;
	$class_elem = ($tabs['class_elem'] != null)?  $tabs['class_elem'] : null ;
	$class_box = ($tabs['class_box'] != null)?  ' class="' . $tabs['class_box'] . '"' : '' ;
	$class_name = ($tabs['class_name'] != null)? ' class="' . $tabs['class_name'] . '"' : '' ;
	$class_img = ($tabs['class_img'] != null)? ' class="' . $tabs['class_img'] . '"' : '' ;
	$class_desc = ($tabs['class_desc'] != null)? ' class="' . $tabs['class_desc'] . '"' : '' ;
	$offset = $fcn->news_offset_pager($max);
	$filter = new magixglobal_model_imagepath();
	$news .= '<div'.$class_container.'>';
	$i = 1; //Définis pour l'ajout de la class 'last'
	$dateformat = new magixglobal_model_dateformat();
	if(frontend_db_block_news::s_news_listing(frontend_model_template::current_Language(),$limit,$max,$offset) != null){
		foreach(frontend_db_block_news::s_news_listing(frontend_model_template::current_Language(),$limit,$max,$offset) as $pnews){
			//Application de la class last pour enfant courant
			//-----------------------------------------------
			//Test si l'élément courant besoin class last
			if ($i == $last ) {
				$last_elem = ' last';
				$i = 1;
			} else {
				$last_elem = null;
				$i++;
			}
			$tag = frontend_db_block_news::s_news_tag($pnews['idnews']);
			$islang = $pnews['iso'];
			if ($pnews['n_image'] != null){
				$image = '<img src="'.$filter->filterPathImg(array('filtermod'=>'news','img'=>'s_'.$pnews['n_image'])).'" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
			}else{
				$image = '<img src="'.$filter->filterPathImg(array('img'=>'skin/'.frontend_model_template::frontendTheme()->themeSelected().'/img/catalog/no-picture.png')).'" alt="'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'" />';
			}
			$news .= '<div class="'. $class_elem . $last_elem .'">';
			$news .= '<div'. $class_box .'>'."\n";
			$news .='<a'.$class_img .' href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],$dateformat->date_europeen_format($pnews['date_register']),$pnews['n_uri'],$pnews['keynews'],true).'">';
				$news .= $image;
			$news .='</a>';
			
			$news .='<p'.$class_name .'>';
				$news .= '<a href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],$dateformat->date_europeen_format($pnews['date_register']),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
			$news .= '</p>';
			$news .= '<span'. $class_desc .'>';
				$news .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['n_content'],$length,$delimiter));
			$news .= '</span>';
			//$news .= '<div class="clear"></div>';
			$news .='<div class="date rfloat">'.$dateformat->SQLDate($pnews['date_publish']).'</div>';
			if($tag != null){
				$news .= '<span class="tag">';
				$tagnews = '';
				foreach ($tag as $t){
					$uritag = magixglobal_model_rewrite::filter_news_tag_url($pnews['iso'],$t['name_tag'],true);
	  				$tagnews[]= '<a href="'.$uritag.'" title="'.$t['name_tag'].'">'.$t['name_tag'].'</a>';
				}
				$news .= implode(',', $tagnews);
				$news .= '</span>';
			} 
			$news .= '</div>';
			$news .= '</div>';
		}
	}
	$news .= '</div>';
	$cnews = frontend_db_block_news::s_count_news(frontend_model_template::current_Language());
	if($cnews[0]['total'] >= $max){
		$news .= $fcn->news_pagination($max,$tabs['class_pagination']);
	}
	return $news;
}