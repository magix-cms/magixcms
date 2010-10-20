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
 * @category   config 
 * @package    config
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name common.inc.php
 *
 */
/**
 * Ini name data Mysql
 */
$config = dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
if (file_exists($config)) {
	require $config;
}/*else{
	print 'Error config Files';
	exit;
}*/
setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
if(defined('M_LOG')){
	if(M_LOG == 'debug'){
		$dis_errors = 1;
	}elseif(M_LOG == 'log'){
		$dis_errors = 1;
	}else{
		$dis_errors = 0;
	}
	ini_set('display_errors', $dis_errors);
}
//error_reporting(E_ALL ^ E_NOTICE);
?>