<?php
/**
 * @category   Smarty Plugin
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
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
function smarty_function_widget_catalog($params, &$smarty){
	$max = empty($params['max']) ? 5 : $params['max'];
	if (!isset($params['limit'])) {
	 	$smarty->trigger_error("limit: missing 'limit' parameter");
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
							<th><span class="ui-icon ui-icon-image"></span></th>
							<th><span class="ui-icon ui-icon-flag"></span></th>
							<th><span class="ui-icon ui-icon-link"></span></th>
							'.$thuser.'
							<th><span class="ui-icon ui-icon-pencil"></span></th>
							<th><span class="ui-icon ui-icon-transferthick-e-w"></span></th>
							<th><span class="ui-icon ui-icon-copy"></span></th>
							<th><span class="ui-icon ui-icon-close"></span></th>
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
					$imgcatalog = '<div class="ui-state-error" style="border:none;"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/catalog.php?product&amp;getimg='.$pcms['idcatalog'].'"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></a></div>';
				break;
				default: 
					$imgcatalog = '<div class="ui-state-highlight" style="border:none;"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/catalog.php?product&amp;getimg='.$pcms['idcatalog'].'"><span style="float:left" class="ui-icon ui-icon-check"></span></a></div>';
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