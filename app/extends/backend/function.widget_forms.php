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
 * Smarty {widget_forms} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     November 19, 2009
 * Purpose:  
 * Examples: {widget_forms}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_forms($params, &$smarty){
	if(isset($_SESSION['useradmin'])){
		$plugin .= '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>
							<th><span style="float:left;" class="magix-icon magix-icon-h1"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-link"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-script"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
		if(backend_db_formsconstruct::adminDbForms()->s_forms() != null){
			foreach(backend_db_formsconstruct::adminDbForms()->s_forms() as $forms){
				$islang = $forms['codelang'] ? magixcjquery_html_helpersHtml::unixSeparator().$forms['codelang']: '';
				switch($forms['idlang']){
					case 0:
						$codelang = '<div class="ui-state-error" style="border:none;"><span style="float:left" class="ui-icon ui-icon-cancel"></span></div>';
					break;
					default: 
						$codelang = $forms['codelang'];
					break;
				}
				 $plugin .= '<tr class="line">';
				 $plugin .=	'<td class="maximal">'.$codelang.'</td>';
				 $plugin .=	'<td class="nowrap">'.$forms['titleforms'].'</td>';
				 $plugin .=	'<td class="nowrap">'.$forms['urlforms'].'</td>';
				 $plugin .= '<td class="nowrap"><a class="post-preview" href="'.magixcjquery_html_helpersHtml::getUrl().$islang.magixcjquery_html_helpersHtml::unixSeparator().'formulaire'.magixcjquery_html_helpersHtml::unixSeparator().$forms['urlforms'].'/f-'.$forms['idforms'].'.html'.'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>';
				 $plugin .=	'<td class="nowrap"><a style="text-decoration:underline;" href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/formulaires/'.$forms['urlforms'].'-'.$forms['idforms'].'">'.$forms['countinput'].'</a></td>';
				 $plugin .= '<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></td>';
			 	 $plugin .= '<td class="nowrap"><span style="float:left;" class="ui-icon ui-icon-close"></span></td>';
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
			$plugin .= '<td class="nowrap"></td>';
			$plugin .= '</tr>';
		}
		$plugin .= '</tbody></table>';
	}
	return $plugin;
}