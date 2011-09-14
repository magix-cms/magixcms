<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien@magix-cms.com>
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
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * @link http://www.magix-cms.com,http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * Type:     function
 * Name:     sidebar_construct
 * Date:     
 * Purpose:  
 * Examples: {sidebar_construct config_param=['module'=>'cms']}
 * Output:   
 * @param $params
 * @param $template
 * @return void
 */
function smarty_function_sidebar_construct($params, $template){
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	$init_menu = new backend_model_sidebarConstruct();
	switch ($tabs['module']){
		case 'cms':
			$module = $init_menu->getlangFilter('/admin/cms.php?','getlang');
		break;
		case 'catalog':
			$module = $init_menu->getlangFilter('/admin/catalog.php?category=true&amp;','getlang');
		break;
	}
	return $module;
}
?>