<?php
/**
 * @see groupsConfig
 * minify dans public
 */
return array(
	'publiccss' => array('//framework/css/ui/ui.selectmenu.1.8.4.css','//framework/css/ui/ui.checkbox-1.8.css','//framework/css/notification.css'),
	'publicjs'=> array('//framework/js/jquery-1.4.2.min.js','//framework/js/jquery-ui-1.8.5.custom.min.js',
	'//framework/js/ui/i18n-1.8/jquery-ui-i18n.js','//framework/js/jquery.form-2.47.js','//framework/js/ui/ui.selectmenu-1-8-4.js',
	'//framework/js/jquery.validate-1.7.js','//framework/js/additional-methods-1.7.js','//framework/js/ui/ui.checkbox-1.8.js','//framework/js/jquery.colorbox-min-1.3.9.js',
	'//framework/js/jquery.meerkat.1.3.js','//framework/js/jquery.cookie.js','//framework/js/jquery.jfirebug.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>