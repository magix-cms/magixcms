<?php
/**
 * @category   load Config
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * 
 */
/**
 * Ini name data Mysql
 */
$config = dirname(__FILE__).'/config.php';
if (file_exists($config)) {
	require $config;
}/*else{
	print 'Error config Files';
	exit;
}*/
setlocale(LC_TIME, 'fr_FR.UTF8', 'fr.UTF8', 'fr_FR.UTF-8', 'fr.UTF-8');
if(defined('M_LOG')){
	if(M_LOG == 'debug'){
		$dis_errors = 1;
	}elseif(M_LOG == 'log'){
		$dis_errors = 1;
	}else{
		$dis_errors = 0;
	}
	ini_set('display_errors', $dis_errors);
}
/*error_reporting(E_WARNING);*/ 
?>