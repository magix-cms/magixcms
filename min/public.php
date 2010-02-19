<?php
/**
 * @see groupsConfig
 * minify dans public
 */
return array(
	'publiccss' => array('//framework/css/colorbox/colorbox.css','//framework/css/ui.selectmenu.css','//framework/css/ui/ui.checkbox.css'),
	'publicjs'=> array('//framework/js/jquery-1.4.1.min.js','//framework/js/jquery-ui-1.7.2.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.33.js','//framework/js/ui.selectmenu.js',
	'//framework/js/jquery.validate.min.js','//framework/js/ui.checkbox.js','//framework/js/jquery.colorbox-min-1.6.js',
	'//framework/js/jquery.cookie.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>