<?php
/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/
/*return array(
	'publiccss' => array('//public/css/globalpublic.css','//public/css/overcast/jquery-ui-1.7.2.custom.css',
	'//framework/css/colorbox-simple/colorbox.css','//framework/css/ui.selectmenu.css','//public/css/globalforms.css'),
	'publicjs'=> array('//framework/js/jquery-1.4.min.js','//framework/js/jquery-ui-1.7.2.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.33.js','//framework/js/ui.selectmenu.js',
	'//framework/js/jquery.validate.min.js','//framework/js/ui.checkbox.js','//framework/js/jquery.colorbox-min.js',
	'//public/js/lib/globalforms-1.0.0.js','//public/js/lib/globaljs-1.0.js','//framework/js/jquery.cookie.js'),
	'admincss'=>array('//framework/css/ui/vader/jquery-ui-1.7.2.custom.css','//framework/css/ui/ui.checkbox.css',
	'//framework/css/globalcss.css','//framework/css/colorbox-simple/colorbox.css','//framework/css/ui.selectmenu.css',
	'//framework/css/globalforms.css','//framework/css/ui.spinner.css'),
	'adminjs'=> array('//framework/js/jquery-1.3.2.min.js','//framework/js/jquery-ui-1.7.2.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.33.js','//framework/js/jquery.validate.min.js',
	'//framework/js/jquery.validate.password.js','//framework/js/jquery.cookie.js','//framework/js/jquery.colorbox-min.js',
	'//framework/js/ui.checkbox.js','//framework/js/ui.spinner.js','//framework/js/ui.selectmenu.js',
	'//framework/js/ad-globalform-1.0.js','//framework/js/ad-globaljs-1.0.js'),
	'editor'=>array('//framework/js/tiny_mce/jquery.tinymce.js','//framework/js/tinymce-config.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);*/
 return array_merge(
    (require 'public.php'),
    (require 'admin.php')
); 