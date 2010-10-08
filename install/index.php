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
 * @name index
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