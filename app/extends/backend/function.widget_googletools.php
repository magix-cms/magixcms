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
 * Smarty {widget_googletools} function plugin
 *
 * Type:     function
 * Name:     widget_googletools
 * Date:    
 * Purpose:  
 * Examples: {widget_googletools}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_googletools($params, &$smarty){
	$webmasterdata = backend_model_setting::select_uniq_setting('webmaster');
	$analyticsdata = backend_model_setting::select_uniq_setting('analytics');
	$plugin = '<table class="clear">
					<thead>
					<tr>
						<th><span style="float:left;" class="magix-icon magix-icon-webmaster"></span></th>
						<th><span style="float:left;" class="magix-icon magix-icon-analytics"></span></th>
						<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
					</tr>
					</thead>
					<tbody>
					<tr>';
	if($webmasterdata['setting_value'] == null){
		$webtools = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
	}else{
		$webtools = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
	}
	if($analyticsdata['setting_value'] == null){
		$analytics = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-alert"></span></div>';
	}else{
		$analytics = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
	}
	$plugin .= '<td class="maximal">'.$webtools.'</td>
				<td class="medium">'.$analytics.'</td>
				<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/googletools/"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
	$plugin .= '</tr></tbody></table>';
	return $plugin;
}