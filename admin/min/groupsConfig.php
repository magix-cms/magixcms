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
	'adminjs' =>    array(
        '//libjs/jquery-1.12.0.min.js',
        '//libjs/jquery-ui.1.10.4.min.js',
        '//libjs/vendor/jquery.form.3.51.min.js',
        '//libjs/vendor/jquery.validate.1.13.0.min.js',
        '//libjs/vendor/additional-methods.1.13.0.min.js',
        '//'.PATHADMIN.'/template/js/vendor/bootstrap.min.js',
        '//'.PATHADMIN.'/template/js/vendor/holder.js'
    ),
	'jimagine' =>   array(
        '//libjs/jimagine/config.js',
        '//libjs/jimagine/jmConstant.js',
	    '//libjs/jimagine/plugins/jquery.nicenotify.js',
        '//libjs/jimagine/plugins/jquery.jmShowIt.js',
        '//'.PATHADMIN.'/template/js/vendor/jquery.fancybox.js',
        '//'.PATHADMIN.'/template/js/setting.js'
    ),
	'globalize' =>  array(
        '//libjs/globalize/globalize.js',
        '//libjs/globalize/cultures/globalize.cultures.js'
    ),
    'charts'    =>  array(
        '//'.PATHADMIN.'/template/js/vendor/raphael-min.js',
        '//'.PATHADMIN.'/template/js/vendor/morris.min.js'
    ),
    'tinymce' => array(
        '//'.PATHADMIN.'/template/js/vendor/tiny_mce.'.VERSION_EDITOR.'/jquery.tinymce.min.js'
    ),
    'css' => array(
        '//'.PATHADMIN.'/template/css/bootstrap/bootstrap.min.css',
        '//'.PATHADMIN.'/template/css/font-awesome/font-awesome.min.css',
        '//'.PATHADMIN.'/template/css/ui-bootstrap/jquery-ui-1.10.3.custom.css',
        '//'.PATHADMIN.'/template/css/fancybox/jquery.fancybox.css',
        '//'.PATHADMIN.'/template/css/morris.css',
        '//'.PATHADMIN.'/template/css/jquery.tagsinput.css',
        '//'.PATHADMIN.'/template/css/main.css'
    ),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);