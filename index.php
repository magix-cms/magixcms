<?php
/**
 * @category   Index
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
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
$config = 'app/config/config.php';
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
if(isset($_GET['news'])){
	$news = new frontend_controller_news();
	if(isset($_GET['getnews'])){
		$news->display_getnews();
	}else{
		$news->display_list();
	}
}elseif(isset($_GET['getpurl'])){
	$ini = new frontend_controller_cms();
	$ini->display();
}elseif(isset($_GET['forms'])){
	$ini = new frontend_controller_formsconstruct();
	if(isset($_GET['getforms'])){
		$ini->display();
	}
}elseif(isset($_GET['catalog'])){
	$catalog = new frontend_controller_catalog();
	if(isset($_GET['idclc'])){
		if(isset($_GET['idcatalog'])){
			$catalog->display_product();
		}elseif(isset($_GET['idcls'])){
			$catalog->display_sub_category();
		}else{
			$catalog->display_category();
		}
	}else{
		$catalog->display_catalog();
	}
}else{
	$ini = new frontend_controller_home();
	$ini->display();
}
?>