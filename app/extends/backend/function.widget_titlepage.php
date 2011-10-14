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
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    plugin version
 * @author Gérits Aurélien <aurelien@magix-cms.com> <aurelien@magix-dev.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {widget_titlepage} function plugin
 *
 * Type:     function
 * Name:     widget_titlepage
 * Date:   	 28 Avril 2010
 * Purpose:  
 * Examples: {widget_titlepage}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param    array
 * @param    Smarty
 * @return   string
 */
function smarty_function_widget_titlepage($params,$template){
	$url = $_SERVER['REQUEST_URI'];
	$segment =  explode('/',parse_url($url,PHP_URL_PATH));
	//$segment = str_replace('=',' - ',$segment);
	$root = magixcjquery_html_helpersHtml::getUrl().parse_url($url,PHP_URL_PATH).'?';
	$widget .= 'Magix CMS&trade;'.' | ';
	$widget .= empty($segment[1])? magixcjquery_string_convert::ucfirst($segment[1]): magixcjquery_string_convert::ucfirst($segment[1]);
	return $widget;
}
?>