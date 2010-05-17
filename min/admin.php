<?php
/**
 * @see groupsConfig
 * minify dans admin
 */
return array(
	'admincss'=>array('//framework/css/ui/vader-1-7-2/jquery-ui-1.7.2.custom.css','//framework/css/ui/ui.checkbox.css',
	'//framework/css/colorbox-simple/colorbox.css','//framework/css/ui.selectmenu.css',
	'//framework/css/ui.spinner.css','//framework/css/notification.css','//framework/css/globalforms.css','//framework/css/globalcss.css'),
	'adminjs'=> array('//framework/js/jquery-1.4.2.min.js','//framework/js/jquery-ui-1.7.2.min.js',
	'//framework/js/ui/i18n/jquery-ui-i18n.js','//framework/js/jquery.form-2.43.js','//framework/js/jquery.validate-1.7.js',
	'//framework/js/jquery.validate.password-1.0.js','//framework/js/jquery.cookie.js','//framework/js/jquery.colorbox-min-1.6.js',
	'//framework/js/ui.checkbox.js','//framework/js/ui.spinner.js','//framework/js/ui.selectmenu.js',
	'//framework/js/ad-globalform-1.0.js','//framework/js/ad-globaljs-1.0.js'),
	'editor'=>array('//framework/js/tiny_mce-3-3-5-1/jquery.tinymce.js','//framework/js/tinymce-config.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>