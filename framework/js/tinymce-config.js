/**
 * @category   javascript
 * @package    TinyMCE
 * @copyright  Copyright (c) 2010 - 2011 (http://www.logiciel-referencement-professionnel.com)
 * @license    Proprietary software
 * @version    1.3 
 * @Date       2010-05-12
 * @update     2010-06-16
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
$(function() {
	$('.mceEditor').tinymce({
	// Location of TinyMCE script
	script_url : '/framework/js/tiny_mce-3-3-9/tiny_mce.js',
	//document_base_url :"/",
	apply_source_formatting : true,
	mode : "exact",
	relative_urls : false,
	elements : 'absurls',
	//remove_script_host : false,
	theme : "advanced",
	/*tableextras,*/
	plugins : "safari,xhtmlxtras,emotions,advlink,advimage,insertdatetime,style,layer,table,fullscreen,contextmenu,paste,imagemanager,filemanager,preview,rj_insertcode,tableextras,loremipsum",
	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,insertimage,insertfile,image,|,forecolor,backcolor,|,insertdate,inserttime,preview",
	/*tabledraw,convertcelltype,*/
	theme_advanced_buttons3 : "tabledraw,convertcelltype,tablecontrols,|,hr,removeformat,visualaid,|,fullscreen,|,rj_insertcode,loremipsum,code",
	//tableextras_col_size: 10, // Optional
	//tableextras_row_size: 10, // Optional
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_styles : "imagebox=imagebox;targetblank=targetblank",
	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	cleanup : true,
	cleanup_on_startup : true,
	valid_elements : "*[*]",
	skin : "o2k7",
	skin_variant : "silver",
	width:'100%',
	height:'300px',
	language : 'fr'
	});
});