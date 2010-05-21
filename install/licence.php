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
/**
 * Autoload Exec install
 */
exec_Autoloader::register();
$licence = new exec_controller_licence();
if(magixcjquery_filter_request::isGet('postlicence')){
	header('location: '.magixcjquery_html_helpersHtml::getUrl().'/install/adminuser.php');
}else{
	$licence->display_licence_page();
}
?>