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
 * @category   backend
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
final class backendConfig{
    public static function backendLoaderFiles($files,array $arraydir){
        $libraryArraydir = $arraydir;
        return str_replace($libraryArraydir, array('') , $files);
    }
}

$magixglobal = backendConfig::backendLoaderFiles(dirname(realpath( __FILE__ )).'app/magixglobal/autoload.php',array('lib'));
$mcbackend = backendConfig::backendLoaderFiles(dirname(realpath( __FILE__ )).'app/backend/autoload.php',array('lib'));
if (!file_exists($magixglobal) || !file_exists($mcbackend)) {
	throw new Exception("Autoload is not found Contact Webmestre: support@magix-cms.com");
	exit;
}else{
	require($magixglobal);
	require($mcbackend);
}
$loaderFilename = dirname(realpath( __FILE__ )).'/loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@magix-cms.com</p>";
	exit;
}else{
	require $loaderFilename;
}

$dbconfig = backendConfig::backendLoaderFiles(dirname(realpath( __FILE__ )).'app/config/config.php',array('lib'));
if (!file_exists($dbconfig)) {
	print '<p>La base de donnée n\'existe pas, veuillez suivre la procédure pour faire l\'<a href="/install/">installation</a> de Magix CMS</p>';
	exit;
}
magixglobal_Autoloader::register();
backend_Autoloader::register();
?>