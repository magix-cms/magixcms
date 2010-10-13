<?php
/**
 * @see groupsConfig
 * minify dans admin
 */
return array(
	'admincss'=>array('//framework/css/ui/dark-backend-1-8-5/jquery-ui-1.8.5.custom.css',
	'//framework/css/colorbox-simple/colorbox.css','//framework/css/ui/ui.selectmenu.1.8.4.css','//framework/css/ui/ui.checkbox.1.4.css',
	'//framework/css/ui/ui.spinner.1-20.css','//framework/css/notification.css','//framework/css/globalforms.css','//framework/css/globalcss.css'),
	'adminjs'=> array('//framework/js/jquery-1.4.2.min.js','//framework/js/jquery-ui-1.8.5.custom.min.js','//framework/js/ui/i18n-1.8/jquery-ui-i18n.js',
	'//framework/js/ui/ui.checkbox.1.4.js','//framework/js/jquery.form-2.47.js','//framework/js/jquery.validate-1.7.js',
	'//framework/js/jquery.validate.password-1.0.js','//framework/js/jquery.cookie.js','//framework/js/jquery.colorbox-min-1.3.9.js',
	'//framework/js/ui/ui.spinner.1-20.min.js','//framework/js/ui/ui.selectmenu-1-8-4.js','//framework/js/jquery.jfirebug.js',
	'//framework/js/tools/notice-tpl.js','//framework/js/ad-globalform-1.0.js','//framework/js/ad-globaljs-1.0.js'),
	'editor'=>array('//framework/js/tiny_mce-3-3-9-2/jquery.tinymce.js','//framework/js/tinymce-config.js'),
	'maxAge' => 31536000,
	'setExpires' => time() + 86400 * 365
);
?>