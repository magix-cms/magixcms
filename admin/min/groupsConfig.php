<?php
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
	'adminjs' => array('//libjs/jquery-1.8.3.min.js','//libjs/jquery-ui-1.10.0.custom.min.js',
     '//libjs/plugins/jquery.form.3.20.js','//libjs/plugins/jquery.validate.1.10.0.min.js','//libjs/plugins/additional-methods.1.10.0.min.js',
     '//'.PATHADMIN.'/template/js/plugins/bootstrap.2.2.2.min.js','//'.PATHADMIN.'/template/js/plugins/holder.js'),
	'jimagine' => array('//libjs/jimagine/config.js','//libjs/jimagine/jmConstant.js',
	'//libjs/jimagine/plugins/jquery.nicenotify.js','//libjs/jimagine/plugins/jquery.jmShowIt.js',
    '//'.PATHADMIN.'/template/js/plugins/jquery.fancybox.js','//'.PATHADMIN.'/template/js/setting.js'),
	'globalize'=> array('//libjs/globalize/globalize.js','//libjs/globalize/cultures/globalize.cultures.js'),
    'charts'=>array('//'.PATHADMIN.'/template/js/plugins/raphael-min.js','//'.PATHADMIN.'/template/js/plugins/morris.min.js'),
    'tinymce' => array('//'.PATHADMIN.'/template/js/tiny_mce.'.VERSION_EDITOR.'/jquery.tinymce.js'),
    'css' => array('//'.PATHADMIN.'/template/css/bootstrap.2.2.3.css','//'.PATHADMIN.'/template/css/font-awesome.css',
    '//'.PATHADMIN.'/template/css/ui-bootstrap/jquery-ui-1.10.0.custom.css','//'.PATHADMIN.'/template/css/fancybox/jquery.fancybox.css',
    '//'.PATHADMIN.'/template/css/morris.css','//'.PATHADMIN.'/template/css/jquery.tagsinput.css','//'.PATHADMIN.'/template/css/style.css'),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);