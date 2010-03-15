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
 * Smarty {widget_home} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     October 30, 2009
 * Purpose:  
 * Examples: {widget_home}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_home($params, &$smarty){
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
			$islang = $phome['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$phome['codelang'].magixcjquery_html_helpersHtml::unixSeparator(): '';
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
					$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
				break;
				default: 
					$codelang = $phome['codelang'];
				break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal">'.magixcjquery_string_convert::cleanTruncate($phome['subject'],40,"").'</td>';
			 $plugin .= '<td class="nowrap">'.$icons_t.'</td>';
			 $plugin .= '<td class="nowrap">'.$icons_d.'</td>';
			 $plugin .= '<td class="nowrap">'.$codelang.'</td>';
			 $plugin .=	$viewuser ? '<td class="nowrap">'.$phome['pseudo'].'</td>':'';
			 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
			 $plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/home/edit/'.$phome['idhome'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
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