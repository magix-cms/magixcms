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
    'publiccss' => array('//framework/css/notification.css'),
	'publicjs' => array('//framework/library/jquery-1.8.3.min.js','//framework/library/jquery-ui-1.10.0.custom.min.js',
     '//framework/plugins/jquery.form.3.20.js','//framework/plugins/jquery.validate.1.10.0.min.js'),
	'jimagine' => array('//framework/library/jimagine/config.js','//framework/library/jimagine/jmConstant.js',
	'//framework/library/jimagine/plugins/jquery.nicenotify.js','//framework/library/jimagine/plugins/jquery.jmShowIt.js'
    ),
	'globalize'=> array('//framework/library/globalize/globalize.js','//framework/library/globalize/cultures/globalize.cultures.js'),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);