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
    //'publiccss' => array('//libjs/css/notification.css'),
	'publicjs' => array('//libjs/jquery-1.10.2.min.js','//libjs/jquery-ui-1.10.3.custom.min.js',
     '//libjs/plugins/jquery.form.3.40.min.js','//libjs/plugins/jquery.validate.1.11.1.min.js'),
	'jimagine' => array('//libjs/jimagine/config.js','//libjs/jimagine/jmConstant.js',
	'//libjs/jimagine/plugins/jquery.nicenotify.js','//libjs/jimagine/plugins/jquery.jmShowIt.js'),
	'globalize'=> array('//libjs/globalize/globalize.js','//libjs/globalize/cultures/globalize.cultures.js'),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);