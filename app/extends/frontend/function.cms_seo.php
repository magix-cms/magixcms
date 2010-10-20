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
 * Smarty {cms_seo config=""} function plugin
 *
 * Type:     function
 * Name:     SEO CMS (pages)
 * Date:     December 7, 2009
 * Purpose:  
 * Examples: {cms_seo config="title"} or {cms_seo config="description"}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_cms_seo($params, &$smarty){
	$config = $params['config'];
	$default = $params['default'];
	if (!isset($params['config'])) {
	 	$smarty->trigger_error("config: missing 'config' parameter");
		return;
	}
	$seo = frontend_db_cms::publicDbCms()->s_cms_seo($_GET['getidpage']);
	switch($config){
		case 'title':
			if($seo['metatitle'] != null){
				$seo = $seo['metatitle'];
			}else{
				$seo = $default;
			}
		break;
		case 'description':
			if($seo['metadescription'] != null){
				$seo = $seo['metadescription'];
			}else{
				$seo = $default;
			}
		break;
	}
	return $seo;
}