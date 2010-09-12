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
 * Smarty {widget_cms} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     October 30, 2009
 * Purpose:  
 * Examples: {widget_cms}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_cms($params, &$smarty){
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
			$pag = new backend_controller_cms();
			$offset =  $pag->cms_offset_pager($max);
			$pagercms= '<div class="pagination"><div class="middle">'.$pag->cms_pager($max).'</div></div>';
		}
	}elseif($params['limit'] == "false"){
		$limit = false;
	}
	$plugin .= '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-folder-collapsed"></span></th>
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
	if(backend_db_cms::adminDbCms()->s_cms_plugin($limit,$max,$offset) != null){
		foreach(backend_db_cms::adminDbCms()->s_cms_plugin($limit,$max,$offset) as $pcms){
			//$islang = $pcms['codelang'] ? 'strLangue='.$pcms['codelang'].'&amp;': '';
			if($pcms['metatitle'] == null){
				$icons_t = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
			}else{
				$icons_t = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}
			if($pcms['metadescription'] == null){
				$icons_d = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
			}else{
				$icons_d = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}
			switch($pcms['idlang']){
				case 0:
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$codelang = $pcms['codelang'];
				break;
			}
			switch($pcms['idcategory']){
				case 0:
					$category = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-home"></span></div>';
					//$catpath = null;
				break;
				default: 
					$category = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
					//$catpath = 'getidcategory='.$pcms['idcategory'].'&amp;getcat='.$pcms['pathcategory'].'&amp;';
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	$viewuser?'<td class="maximal"><a class="linkurl" href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/cms.php?editcms='.$pcms['idpage'].'">'.magixcjquery_string_convert::cleanTruncate($pcms['subjectpage'],45,'').'</a></td>':'<td class="maximal"><a class="linkurl" href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/cms.php?editcms='.$pcms['idpage'].'">'.magixcjquery_string_convert::cleanTruncate($pcms['subjectpage'],30,'').'</a></td>';
			 $plugin .=	'<td class="nowrap">'.$category.'</td>';
			 $plugin .= '<td class="nowrap">'.$icons_t.'</td>';
			 $plugin .= '<td class="nowrap">'.$icons_d.'</td>';
			 $plugin .= '<td class="nowrap">'.$codelang.'</td>';
			 $plugin .=	$viewuser?'<td class="nowrap">'.$pcms['pseudo'].'</td>':'';
			 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixglobal_model_rewrite::filter_cms_url($pcms['codelang'], $pcms['idcategory'], $pcms['pathcategory'], $pcms['idpage'], $pcms['pathpage'])./*magixcjquery_html_helpersHtml::getUrl().'/index.php?'.$islang.$catpath.'getidpage='.$pcms['idpage'].'&amp;'.'getpurl='.$pcms['pathpage'].*/'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/cms.php?editcms='.$pcms['idpage'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a class="deletecms" title="'.$pcms['idpage'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 $plugin .= '</tr>';
		}
	}else{
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal"></td>';
			 $plugin .=	'<td class="nowrap"></td>';
			 //$plugin .=	'<td class="nowrap"></td>';
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