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
 * Smarty {widget_online_members} function plugin
 *
 * Type:     function
 * Name:     widget_home
 * Date:     October 31, 2009
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
function smarty_function_widget_online_members($params, &$smarty){
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