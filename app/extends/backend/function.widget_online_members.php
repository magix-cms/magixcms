<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * MAGIX CMS
 * @category   extends 
 * @package    Smarty
 * @subpackage function
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty {widget_online_members} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     14 July, 2010
 * Purpose:  
 * Examples: {widget_online_members}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_widget_online_members($params, $template){
	if(isset($_SESSION['useradmin'])){
		$session = backend_db_admin::adminDbMember()->s_session_membres();
		$plugin = '<table class="clear">
							<thead>
								<tr>
									<th><span style="float:left;" class="ui-icon ui-icon-person"></span></th>
									<th><span style="float:left;" class="magix-icon magix-icon-perms"></span></th>
									<th><span style="float:left;" class="magix-icon magix-icon-online"></span></th>
								</tr>
							</thead>
							<tbody>';
		foreach($session as $data){
			switch($data['perms']){
				case 1:
					$perms = 'Seo Agency';
					break;
				case 2:
					$perms = 'Web Agency';
					break;
				case 3:
					$perms = 'User admin';
					break;
				case 4:
					$perms = 'User';
					break;
			}
			switch($data['connex']){
				case 0:
					$connex = '<span style="float:left;" class="nonactiveicon"></span>';
					break;
				case 1:
					$connex = '<span style="float:left;" class="activeicon"></span>';
					break;
			}
			$plugin .= '<tr class="line">';
			$plugin .= '<td class="maximal">'.$data['pseudo'].'</td>';
			$plugin .= '<td class="nowrap">'.$perms.'</td>';
			$plugin .= '<td class="nowrap">'.$connex.'</td>';
			$plugin .= '</tr>';
		}
		$plugin .= '</tbody></table>';
	}
	return $plugin;
}
?>