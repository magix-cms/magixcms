<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, un CMS optimisé pour le référencement
# Copyright (C) 2010 - 2011  Gerits Aurelien (aurelien@magix-cms.com)
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * MAGIX CMS
 * @category   index 
 * @package    Exec Files
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name index
 *
 */
/**
 * Charge toutes les Classes de l'application
 */
$loadfrontend = dirname(realpath( __FILE__ )).DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'frontend'.DIRECTORY_SEPARATOR.'autoload.php';
if (!file_exists($loadfrontend)) {
	print "<p>Loader is not found<br />Contact Support Magix CMS: support@cms-site.com</p>";
	exit;
}else{
	require $loadfrontend;
}

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
		if(isset($_GET['idproduct'])){
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