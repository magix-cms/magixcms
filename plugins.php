<?php
/**
 * MAGIX CMS
 * @category   plugins 
 * @package    Exec Files
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name plugins
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
require(dirname(realpath( __FILE__ )).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'autoload.php');
$loaderFilename = dirname(realpath( __FILE__ )).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'loaderIniclass.php';
if (!file_exists($loaderFilename)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@cms-site.com</p>";
	exit;
}else{
	require $loaderFilename;
}
$config = magixglobal_model_system::base_path().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php';
if (!file_exists($config)) {
	//Header("Location: /install/index.php");
	print '<p>La base de donnée n\'existe pas, veuillez suivre la procédure pour faire l\'<a href="/install/">installation</a> de Magix CMS</p>';
	exit;
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
if(frontend_controller_plugins::getplugin()){
	frontend_controller_plugins::display_plugins();
}
/*elseif(isset($_GET['mix'])){
	$gp = new frontend_plugins_gpageRegional();
	$gp->display();
}*/
?>