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
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
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
 * Date:     December 2, 2009
 * Update:   Jully 28, 2011
 * Purpose:  
 * Examples: {widget_lastnews limit="" delimiter="" ui=true}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.5
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_news_last($params, $template){
	$length = magixcjquery_filter_isVar::isPostNumeric($params['contentlength'])? $params['contentlength']: 250 ;
	$delimiter = $params['delimiter']? $params['delimiter']: '...';
	$ui = $params['ui'];
	$newsall = $params['newsall'];
	if (!isset($length)) {
	 	trigger_error("limit: missing 'Content length' parameter");
		return;
	}elseif(!isset($delimiter)){
		trigger_error("limit: missing 'Delimiter' parameter");
		return;
	}
	if($ui){
		$whead =' ui-widget-header ui-corner-all';
		$wcontent =' ui-widget-content ui-corner-all';
		$wicons = '<span style="float:left;" class="ui-icon ui-icon-calendar"></span>';
	}
	$iniDB = new frontend_db_block_news();
	$pnews = $iniDB->s_lastnews_plugins(frontend_model_template::current_Language());
	if($pnews != null){
		$curl = date_create($pnews['date_register']);
		$widget = '<div class="list-div-elem'.$wcontent.'">';
		$widget .='<p class="name'.$whead.'">';
		$widget .= '<a href="'.magixglobal_model_rewrite::filter_news_url($pnews['iso'],date_format($curl,'Y/m/d'),$pnews['n_uri'],$pnews['keynews'],true).'">'.magixcjquery_string_convert::ucFirst($pnews['n_title']).'</a>';
		$widget .= '</p>';
		$widget .= '<span class="descr">';
			$widget .= magixcjquery_form_helpersforms::inputTagClean(magixcjquery_string_convert::cleanTruncate($pnews['n_content'],$length,$delimiter));
		$widget .= '</span>';	
		$widget .= '<a href="'.magixglobal_model_rewrite::filter_news_root_url($pnews['iso'],true).'">'.$newsall.'</a>';
		$widget .= '</div>';
	}
	return $widget;
}