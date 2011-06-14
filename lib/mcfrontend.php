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
 * @category   frontend
 * @package    load class and config files
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name mcbackend
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$magixglobal = 'app/magixglobal/autoload.php';
$mcfrontend = 'app/frontend/autoload.php';
if (!file_exists($magixglobal) || !file_exists($mcfrontend)) {
	throw new Exception("Autoload is not found Contact Webmestre: support@magix-cms.com");
	exit;
}else{
	require($magixglobal);
	require($mcfrontend);
}
$loaderFilename = 'lib/loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@magix-cms.com</p>";
	exit;
}else{
	require $loaderFilename;
}
$config = 'app/config/config.php';
if (!file_exists($config)) {
	//Header("Location: /install/index.php");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Pragma: no-cache" ); 
	header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
	header('Content-Type: text/html; charset=utf-8'); 
	print '<p>La base de donnée n\'existe pas, veuillez suivre la procédure pour faire l\'<a href="/install/">installation</a> de Magix CMS</p>';
	exit;
}
magixglobal_Autoloader::register();
/**
 * Autoload Frontend
 */
frontend_Autoloader::register();
session_name('lang');
ini_set('session.hash_function',1);
session_start();
$lang = new frontend_model_IniLang();
$lang->autoLangSession();
?>