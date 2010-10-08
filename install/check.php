<?php
/**
 * MAGIX CMS
 * @category   exec 
 * @package    INSTALL
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name check
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$pathinstall = dirname(realpath( __FILE__ ));
$arrayinstall = array('install');
$incinstall = str_replace($arrayinstall,array('') , $pathinstall);
require(dirname(__FILE__).'/exec/autoload.php');
$loaderFilename = $incinstall.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Webmestre: aurelien@web-solution-way.be</p>";
	exit;
}else{
	require $loaderFilename;
}
/**
 * Autoload Frontend
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