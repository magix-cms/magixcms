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
 * @category   lib 
 * @package    Bootstrap
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
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
$pathdir = dirname(realpath( __FILE__ ));
$arraydir = array('lib', 'lib');
$bootpath = str_replace($arraydir,array('','') , $pathdir);
# Does config.php.in exist?
$config_in = $bootpath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'common.inc.php';
if (file_exists($config_in)) {
	require $config_in;
}else{
	print 'Error config Files';
	exit;
}
$magixjquery = dirname(__FILE__).DIRECTORY_SEPARATOR.'magixcjquery'.DIRECTORY_SEPARATOR.'_common.php';
if (file_exists($magixjquery)) {
	require $magixjquery;
	$errorHandler = new magixcjquery_error_errorHandler;
	$errorHandler->attach($mock = new mockWriter());
	set_error_handler(array($errorHandler,'error'));
	foreach ($errorHandler as $writer) {
		echo get_class($writer);
	}
}else{
	print 'Error lib';
	exit;
}
$mailer = dirname(__FILE__).DIRECTORY_SEPARATOR.'swiftmailer'.DIRECTORY_SEPARATOR.'swift_required.php';
if (file_exists($mailer)) {
	require ($mailer);
}else{
	print 'Error MAIL Config';
	exit;
}
$phpthumb = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpthumb'.DIRECTORY_SEPARATOR.'ThumbLib.inc.php';
if (file_exists($phpthumb)) {
	require ($phpthumb);
}else{
	print 'Error thumbnail Config';
	exit;
}
$loadglobal = $bootpath.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'magixglobal'.DIRECTORY_SEPARATOR.'autoload.php';
if (file_exists($loadglobal)) {
	require ($loadglobal);
}
/*
 * Chargement automatique des classes plugins
 */
$loadplugin = $bootpath.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'autoload.php';
if (file_exists($loadplugin)) {
	require ($loadplugin);
}
if(defined('M_FIREPHP')){
	if(M_FIREPHP){
		magixcjquery_debug_magixfire::configErrorHandler();
	}
}
magixglobal_Autoloader::register();
?>