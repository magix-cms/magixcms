<?php
/**
 * MAGIX CMS
 * @category   admin
 * @package    Exec Files
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name home
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$adminpathdir = dirname(realpath( __FILE__ ));
$adminarraydir = array('admin');
$adminpath = str_replace($adminarraydir,array('') , $adminpathdir);
$loaderFilename = $adminpath.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@cms-site.com</p>";
	exit;
}else{
	require $loaderFilename;
}
require(magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'backend'.DIRECTORY_SEPARATOR.'autoload.php');
$config = magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
if (!file_exists($config)) {
	//Header("Location: /install/index.php");
	print '<p>La base de donnée n\'existe pas, veuillez suivre la procédure pour faire l\'<a href="/install/">installation</a> de Magix CMS</p>';
	exit;
}
/**
 * Autoload Frontend
 */
backend_Autoloader::register();
$members = new backend_controller_admin();
$members->securePage();
$members->closeSession();
if(magixcjquery_filter_request::isSession('useradmin')){
backend_controller_config::load_attribute_config();
	$cms = new backend_controller_cms();
	$cms->run();
}