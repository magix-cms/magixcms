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
    'jquery' => array(
        '//libjs/jquery-1.12.0.min.js'
    ),
    'form' => array(
        '//libjs/vendor/jquery.form.3.51.min.js',
        '//libjs/vendor/jquery.validate.1.17.0.min.js',
        '//libjs/vendor/additional-methods.1.17.0.min.js',
        '//libjs/jimagine/plugins/jquery.nicenotify.js'
    ),
    'globalize'=> array(
        '//libjs/globalize/globalize.js',
        '//libjs/globalize/cultures/globalize.cultures.js'
    ),
    'maxAge' => 31536000,
    'setExpires' => time() + 86400 * 365
);