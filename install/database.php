<?php
/**
 * @category   install
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-10-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * @name database install
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
 * Autoload Frontend
 */
exec_Autoloader::register();
$database = new exec_controller_database();
if(magixcjquery_filter_request::isGet('cusers')){
	$database->c_database_user();
}elseif(magixcjquery_filter_request::isGet('cperms')){
	$database->c_database_perms();
}elseif(magixcjquery_filter_request::isGet('csessions')){
	$database->c_database_sessions();
}elseif(magixcjquery_filter_request::isGet('ccatalogproduct')){
	$database->c_database_catalog_product();
}elseif(magixcjquery_filter_request::isGet('ccatalogcat')){
	$database->c_database_catalog_category();
}elseif(magixcjquery_filter_request::isGet('ccatalogsubcat')){
	$database->c_database_catalog_subcategory();
}elseif(magixcjquery_filter_request::isGet('ccatalogimg')){
	$database->c_database_catalog_img();
}elseif(magixcjquery_filter_request::isGet('ccataloggalery')){
	$database->c_database_catalog_galery();
}elseif(magixcjquery_filter_request::isGet('ccmscategory')){
	$database->c_database_cms_category();
}elseif(magixcjquery_filter_request::isGet('ccmspage')){
	$database->c_database_cms_page();
}elseif(magixcjquery_filter_request::isGet('clang')){
	$database->c_database_lang();
}elseif(magixcjquery_filter_request::isGet('chome')){
	$database->c_database_home();
}elseif(magixcjquery_filter_request::isGet('cnews')){
	$database->c_database_news();
}elseif(magixcjquery_filter_request::isGet('cnewspublication')){
	$database->c_database_news_publication();
}elseif(magixcjquery_filter_request::isGet('crewrite')){
	$database->c_database_metas_rewrite();
}elseif(magixcjquery_filter_request::isGet('cconfiglimited')){
	$database->c_database_config_limited_module();
}elseif(magixcjquery_filter_request::isGet('cforms')){
	$database->c_database_forms();
}elseif(magixcjquery_filter_request::isGet('cformsinput')){
	$database->c_database_forms_input();
}elseif(magixcjquery_filter_request::isGet('cglobalconf')){
	$database->c_database_global_config();
}elseif(magixcjquery_filter_request::isGet('cplugins')){
	$database->c_database_plugins_module();
}elseif(magixcjquery_filter_request::isGet('csettingconf')){
	$database->c_database_settings();
}else{
	$database->display_database_page();
}