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
 * Smarty {widget_catalog} function plugin
 *
 * Type:     function
 * Name:     widget_catalog
 * Date:     Novembre 25, 2009
 * Update:   Septembre 6, 2010
 * Purpose:  
 * Examples: {widget_catalog}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_catalog($params, $template){
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
			$pag = new backend_controller_catalog();
			$offset =  $pag->catalog_offset_pager($max);
			$pagercms= '<div class="pagination"><div class="middle">'.$pag->catalog_pager($max).'</div></div>';
		}
	}elseif($params['limit'] == "false"){
		$limit = false;
	}
	if($params['sort'] == "product"){
		$sort = 'idcatalog';
	}
	$plugin .= '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-image"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-link"></span></th>
							'.$thuser.'
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-transferthick-e-w"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-copy"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
	if(backend_db_catalog::adminDbCatalog()->s_catalog_plugin($limit,$max,$offset,$sort) != null){
		foreach(backend_db_catalog::adminDbCatalog()->s_catalog_plugin($limit,$max,$offset,$sort) as $pcms){
			$islang = $pcms['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$pcms['codelang']: '';
			switch($pcms['idlang']){
				case 0:
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				$lang = '';
					break;
				default: 
					$codelang = $pcms['codelang'];
					$lang = 'strLangue='.$pcms['codelang'].'&amp;';
				break;
			}
			switch($pcms['imgcatalog']){
				case null:
					$imgcatalog = '<div class="ui-state-error" style="border:none;"><a href="/admin/catalog.php?product&amp;getimg='.$pcms['idcatalog'].'"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></a></div>';
				break;
				default: 
					$imgcatalog = '<div class="ui-state-highlight" style="border:none;"><a href="/admin/catalog.php?product&amp;getimg='.$pcms['idcatalog'].'"><span style="float:left" class="ui-icon ui-icon-check"></span></a></div>';
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	$viewuser?'<td class="maximal"><a class="linkurl" href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/catalog.php?product&amp;editproduct='.$pcms['idcatalog'].'">'.magixcjquery_string_convert::cleanTruncate($pcms['titlecatalog'],40,'').'</a></td>':'<td class="maximal"><a class="linkurl" href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/catalog.php?product&amp;editproduct='.$pcms['idcatalog'].'">'.magixcjquery_string_convert::cleanTruncate($pcms['titlecatalog'],30,'').'</a></td>';
			 $plugin .= '<td class="nowrap">'.$imgcatalog.'</td>';
			 $plugin .= '<td class="nowrap">'.$codelang.'</td>';
			 $plugin .= '<td class="nowrap"><a href="#" class="cat-uri-product" title="'.$pcms['idcatalog'].'"><span class="ui-icon ui-icon-link"></span></a></td>';
			 $plugin .=	$viewuser?'<td class="nowrap">'.$pcms['pseudo'].'</td>':'';
			 $plugin .= '<td class="nowrap"><a href="/admin/catalog.php?product&amp;editproduct='.$pcms['idcatalog'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="/admin/catalog.php?product&amp;moveproduct='.$pcms['idcatalog'].'"><span style="float:left;" class="ui-icon ui-icon-transfer-e-w"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="/admin/catalog.php?product&amp;copyproduct='.$pcms['idcatalog'].'"><span style="float:left;" class="ui-icon ui-icon-copy"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a class="deleteproduct" title="'.$pcms['idcatalog'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 $plugin .= '</tr>';
		}
	}else{
			 $plugin .= '<tr class="line">';
			 $plugin .=	$viewuser?'<td class="maximal"></td>':'';
			 $plugin .=	'<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '<td class="nowrap"></td>';
			 $plugin .= '</tr>';
	}
	$plugin .= '</tbody></table>';
	$plugin .= $pagercms;
	return $plugin;
}
?>