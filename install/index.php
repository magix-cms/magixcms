<?php
/**
 * @category   Install
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
require($_SERVER['DOCUMENT_ROOT'].'/install/exec/autoload.php');
$loaderFilename = $_SERVER['DOCUMENT_ROOT'].'/lib/loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Webmestre: aurelien@web-solution-way.be</p>";
	exit;
}else{
	require $loaderFilename;
}
/*$config_in = $_SERVER['DOCUMENT_ROOT'].'/app/config/common.inc.php';
if (is_file($config_in)) {
	exit(sprintf('Configuration file does not exist. Please create one first. '.
		'You may use the <a href="%s">wizard</a>.','check.php'));
	exit;
}else{
	header('location: '.magixcjquery_html_helpersHtml::getUrl()); 
}*/
/**
 * Autoload Frontend
 */
exec_Autoloader::register();
$home = new exec_controller_home();
$home->display_home_page();
?>