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
 * @category   exec 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name check
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
require('../lib/mcinstall.php');
/**
 * Autoload Exec install
 */
exec_Autoloader::register();
$check = new exec_controller_analyze();
if(magixcjquery_filter_request::isGet('version')){
	$check->testing_php_version();
}elseif(magixcjquery_filter_request::isGet('mbstr')){
	$check->testing_mbstring();
}elseif(magixcjquery_filter_request::isGet('iconv')){
	$check->testing_iconv();
}elseif(magixcjquery_filter_request::isGet('obst')){
	$check->testing_obstart();
}elseif(magixcjquery_filter_request::isGet('simple')){
	$check->testing_simplexml();
}elseif(magixcjquery_filter_request::isGet('dom')){
	$check->testing_domxml();
}elseif(magixcjquery_filter_request::isGet('spl')){
	$check->testing_spl();
}else{
	$check->display_testing_page();
}
?>