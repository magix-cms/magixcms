<?php
$configdir = 'pathadmin.php';
if(file_exists($configdir)){
    require $configdir;
    if(!defined('PATHADMIN')){
        throw new Exception('PATHADMIN is not defined');
    }
}
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/** 
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 *
 * See http://code.google.com/p/minify/wiki/CustomSource for other ideas
 **/

return array(
	'adminjs' => array('//framework/library/jquery-1.8.3.min.js','//framework/library/jquery-ui-1.9.2.custom.min.js',
        '//framework/plugins/jquery.form.3.20.js','//framework/plugins/jquery.validate.1.10.0.min.js'),
	'jimagine' => array('//framework/library/jimagine/config.js','//framework/library/jimagine/jmConstant.js',
	'//framework/library/jimagine/plugins/jquery.nicenotify.js','///framework/library/jimagine/plugins/jquery.jmShowIt.js'
	),
	'globalize'=> array('//framework/library/globalize/globalize.js','//framework/library/globalize/cultures/globalize.cultures.js'),
    'css' => array('//'.PATHADMIN.'/template/css/bootstrap.2.2.1.css','//'.PATHADMIN.'/template/css/bootstrap-responsive.2.2.1.css','//'.PATHADMIN.'/template/css/font-awesome.css','//'.PATHADMIN.'/template/css/style.css')
);