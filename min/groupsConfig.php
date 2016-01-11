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
    'publicjs' => array(
        '//libjs/jquery-1.12.0.min.js',
        '//libjs/jquery-ui.1.10.4.min.js',
        '//libjs/vendor/jquery.form.3.51.min.js',
        '//libjs/vendor/jquery.validate.1.13.0.min.js'
    ),
	'jimagine' => array(
        '//libjs/jimagine/config.js',
        '//libjs/jimagine/jmConstant.js',
	    '//libjs/jimagine/plugins/jquery.nicenotify.js',
        '//libjs/jimagine/plugins/jquery.jmShowIt.js'
    ),
	'globalize'=> array(
        '//libjs/globalize/globalize.js',
        '//libjs/globalize/cultures/globalize.cultures.js'
    ),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);