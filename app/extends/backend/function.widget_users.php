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
 * Smarty {widget_users} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     October 31, 2009
 * Purpose:  
 * Examples: {widget_users}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_users($params, &$smarty){
	if(isset($_SESSION['useradmin'])){
		$plugin .= '<table class="clear">
						<thead>
							<tr>
							<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-mail-closed"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-key"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>
							<th><span style="float:left;" class="ui-icon ui-icon-close"></span></th>
							</tr>
						</thead>
						<tbody>';
		$userperm = backend_db_admin::adminDbMember()->perms_session_membres($_SESSION['useradmin']);
		foreach(backend_db_admin::adminDbMember()->view_list_members() as $members){
			switch($members['perms']){
				case "1":
					$perms = 'Seo Agency';
					break;
				case "2":
					$perms = 'Web Agency';
					break;
				case "3":
					$perms = 'User admin';
					break;
				case "4":
					$perms = 'User';
					break;
			}
			 $plugin .= '<tr class="line">';
			 $plugin .=	'<td class="maximal">'.$members['pseudo'].'</td>';
			 $plugin .=	'<td class="nowrap">'.$members['email'].'</td>';
			 $plugin .=	'<td class="nowrap">'.$perms.'</td>';
			 if($userperm['perms'] <= "1"){
			 	if($members['perms'] >= "1"){
			 		$plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/users/edit/'.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "2"){
			 	if($members['perms'] >= "2"){
			 		$plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/users/edit/'.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "3"){
			 	if($members['perms'] >= "3"){
			 		$plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/users/edit/'.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "4"){
			 	if($members['perms'] >= "4"){
			 		$plugin .= '<td class="nowrap"><a href="'.magixcjquery_html_helpersHtml::getUrl().'/admin/dashboard/users/edit/'.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }
			 $plugin .= '</tr>';
		}
		$plugin .= '</tbody></table>';
	}
	return $plugin;
}