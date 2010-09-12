<?php
/**
 * @category   check configuration
 * @package    Install
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
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