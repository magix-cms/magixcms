<?php
/**
 * @category   Plugins
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
require($_SERVER['DOCUMENT_ROOT'].'/app/frontend/autoload.php');
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
frontend_Autoloader::register();
session_name('lang');
ini_set('session.hash_function',1);
session_start();
$lang = new frontend_model_IniLang();
$lang->autoLangSession();
if(isset($_GET['static'])){
	$plugin = new frontend_plugins_promotions();
	$plugin->display();
}elseif(isset($_GET['contact'])){
	/*if(isset($_GET['achatvente'])){
		$cvente = new frontend_plugins_contactvente();
		$cvente->display();
	}else{*/
		$contact = new frontend_plugins_contact();
		$contact->display();
	//*}
}elseif(isset($_GET['voyage'])){
	$voyage = new frontend_plugins_voyagesurmesure();
	$voyage->display();
}
?>