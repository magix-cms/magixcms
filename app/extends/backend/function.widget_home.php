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
 * Smarty {widget_home} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     September 2, 2010
 * UPDATE:   Novembre 27 2010
 * Purpose:  
 * Examples: {widget_home}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_home($params, $template){
	$viewuser = empty($params['viewuser']) ? true : false;
	if($viewuser){
		$thuser = '<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>';
	}else{
		$thuser = '';
	}
	$plugin .= '<table class="clear">
					<thead>
						<tr>
						<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-igoogle-t"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-igoogle-d"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
						'.$thuser.'
						<th><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
						</tr>
					</thead>
					<tbody>';
	if(backend_db_home::adminDbHome()->s_home_page_plugin() != null){
		foreach(backend_db_home::adminDbHome()->s_home_page_plugin() as $phome){
			$islang = $phome['iso'] ? magixcjquery_html_helpersHtml::unixSeparator().$phome['iso'].magixcjquery_html_helpersHtml::unixSeparator(): '';
			if($phome['metatitle'] == null){
				$icons_t = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
			}else{
				$icons_t = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}
			if($phome['metadescription'] == null){
				$icons_d = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
			}else{
				$icons_d = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}
			switch($phome['idlang']){
				case 0:
					$iso = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$iso = $phome['iso'];
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal"><a class="linkurl" href="/admin/home.php?edit='.$phome['idhome'].'">'.magixcjquery_string_convert::cleanTruncate($phome['subject'],40,"").'</a></td>';
			 $plugin .= '<td class="nowrap">'.$icons_t.'</td>';
			 $plugin .= '<td class="nowrap">'.$icons_d.'</td>';
			 $plugin .= '<td class="nowrap">'.$iso.'</td>';
			 $plugin .=	$viewuser ? '<td class="nowrap">'.$phome['pseudo'].'</td>':'';
			 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/home.php?edit='.$phome['idhome'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a class="deletehome" title="'.$phome['idhome'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 $plugin .= '</tr>';
		}
	}else{
		$plugin .= '<tr class="line">';
		$plugin .= '<td class="maximal"></td>';
		$plugin .= '<td class="nowrap"></td>';
		$plugin .= '<td class="nowrap"></td>';
		$plugin .= '<td class="nowrap"></td>';
		$plugin .= '<td class="nowrap"></td>';
		$plugin .= '<td class="nowrap"></td>';
		$plugin .= '</tr>';
	}
	$plugin .= '</tbody></table>';
	return $plugin;
}
?>