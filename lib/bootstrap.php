<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * @category   lib 
 * @package    Bootstrap
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name bootstrap
 *
 */
/**
 * include library Magix cjQuery
 **/
if (version_compare(phpversion(), '5.2.0', '<')) {
	echo  'Votre version de PHP est incompatible';
	exit;
}
/*if (version_compare(phpversion(), '5.3.0', '>=')) {
	echo  'Votre version de PHP n\'est pas supporté';
	exit;
}*/
$config_in = dirname(__FILE__).'/../app/config/common.inc.php';
if (file_exists($config_in)) {
	require $config_in;
}else{
	throw new Exception('Error Ini Common Files');
	exit;
}
$magixjquery = dirname(__FILE__).'/magixcjquery/_common.php';
if (file_exists($magixjquery)) {
	require $magixjquery;
	$errorHandler = new magixcjquery_error_errorHandler;
	$errorHandler->attach($mock = new mockWriter());
	set_error_handler(array($errorHandler,'error'));
	foreach ($errorHandler as $writer) {
		echo get_class($writer);
	}
}else{
	throw new Exception('Error load library');
	exit;
}
$mailer = dirname(__FILE__).'/Swift-5.2.1/lib/swift_required.php';
if (file_exists($mailer)) {
	require ($mailer);
}else{
	print 'Error MAIL Config';
	exit;
}
$phpthumb = dirname(__FILE__).'/phpthumb/ThumbLib.inc.php';
if (file_exists($phpthumb)) {
	require ($phpthumb);
}else{
	print 'Error thumbnail Config';
	exit;
}
/**
 * Include smarty3
 */
$smarty = dirname(__FILE__).'/smarty3/Smarty.class.php';
if (file_exists($smarty)) {
    require ($smarty);
}else{
    print 'Error Smarty Config';
    exit;
}
/*
 * Chargement automatique des classes plugins
 */
$loadplugin = dirname(__FILE__).'/../plugins/autoload.php';
if (file_exists($loadplugin)) {
	require ($loadplugin);
}
if(defined('M_FIREPHP')){
	if(M_FIREPHP){
		magixcjquery_debug_magixfire::configErrorHandler();
	}
}
?>