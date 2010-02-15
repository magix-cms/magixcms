<?php
/**
 * @category   Admin Index
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
require($_SERVER['DOCUMENT_ROOT'].'/app/backend/autoload.php');
$loaderFilename = $_SERVER['DOCUMENT_ROOT'].'/lib/loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Webmestre: aurelien@web-solution-way.be</p>";
	exit;
}else{
	require $loaderFilename;
}
/**
 * Autoload Frontend
 */
backend_Autoloader::register();
$members = new backend_controller_admin();
$members->securePage();
$members->closeSession();
backend_controller_config::load_attribute_config();
if(magixcjquery_filter_request::isSession('useradmin')){
	$home = new backend_controller_dashboard();
	$home->version_cms();
}
?>