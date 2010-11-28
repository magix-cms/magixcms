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
 * Smarty {widget_users} function plugin
 *
 * Type:     function
 * Name:     widget_users
 * Date:     March 04, 2010
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
function smarty_function_widget_users($params, $template){
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
			 		$plugin .= '<td class="nowrap"><a href="/admin/users.php?edit='.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "2"){
			 	if($members['perms'] >= "2"){
			 		$plugin .= '<td class="nowrap"><a href="/admin/users.php?edit='.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "3"){
			 	if($members['perms'] >= "3"){
			 		$plugin .= '<td class="nowrap"><a href="/admin/users.php?edit='.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
			 		$plugin .= '<td class="nowrap"><a class="deleteuser" title="'.$members['idadmin'].'" href="#"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>';
			 	}else{
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 		$plugin .= '<td class="nowrap">&nbsp;</td>';
			 	}
			 }elseif($userperm['perms'] <= "4"){
			 	if($members['perms'] >= "4"){
			 		$plugin .= '<td class="nowrap"><a href="/admin/users.php?edit='.$members['idadmin'].'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>';
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