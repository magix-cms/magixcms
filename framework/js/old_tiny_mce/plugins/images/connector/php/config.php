<?php
$tinymce_img_dir = dirname(realpath( __FILE__ ));
$tinymce_array_dir = array('framework'.DIRECTORY_SEPARATOR.'js'.DIRECTORY_SEPARATOR.'tiny_mce-3-3-9-2'.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'connector'.DIRECTORY_SEPARATOR.'php');
$tinymce_path = str_replace($tinymce_array_dir,array('') , $tinymce_img_dir);
//Site root dir
define('DIR_ROOT',$tinymce_path);
//Images dir (root relative)
define('DIR_IMAGES','/media');
//Files dir (root relative)
define('DIR_FILES',	'/media');


//Width and height of resized image
define('WIDTH_TO_LINK', 500);
define('HEIGHT_TO_LINK', 500);

//Additional attributes class and rel
define('CLASS_LINK', 'lightview');
define('REL_LINK', 'lightbox');

//date_default_timezone_set('Asia/Yekaterinburg');
?>
