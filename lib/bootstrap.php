<?php
/**
 * @category   Boostrap
 * @package    Bootsrap
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com - http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * include library Magix cjQuery
 **/
if (version_compare(phpversion(), '5.2.0', '<')) {
	echo  'Votre version de PHP est incompatible';
	exit;
}
if (version_compare(phpversion(), '5.3.0', '>=')) {
	echo  'Votre version de PHP n\'est pas supporté';
	exit;
}
# Does config.php.in exist?
$config_in = dirname(__FILE__).'/../app/config/common.inc.php';
if (file_exists($config_in)) {
	require $config_in;
}else{
	print 'Error config Files';
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
	print 'Error lib';
	exit;
}
$phpmailer = dirname(__FILE__).'/phpmailler/class.phpmailer.php';
if (file_exists($phpmailer)) {
	require ($phpmailer);
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
/*
 * Chargement automatique des classes plugins
 */
$loadplugin = $_SERVER['DOCUMENT_ROOT'].'/plugins/autoload.php';
if (file_exists($loadplugin)) {
	require ($loadplugin);
}
if(defined('M_FIREPHP')){
	if(M_FIREPHP){
		magixcjquery_debug_magixfire::configErrorHandler();
	}
}
?>