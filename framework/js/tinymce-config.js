$(function() {
	$('.mceEditor').tinymce({
	// Location of TinyMCE script
	script_url : '/framework/js/tiny_mce/tiny_mce.js',
	document_base_url : "{geturl}",
	apply_source_formatting : true,
	theme : "advanced",
	/*tableextras,*/
	plugins : "safari,xhtmlxtras,emotions,advimage,insertdatetime,style,layer,tableextras,table,fullscreen,contextmenu,paste,imagemanager,filemanager,preview",
	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,insertimage,insertfile,image,cleanup,code,|,forecolor,backcolor,|,insertdate,inserttime,preview",
	/*tabledraw,convertcelltype,*/
	theme_advanced_buttons3 : "tabledraw,convertcelltype,tablecontrols,|,hr,removeformat,visualaid,|,fullscreen",
	theme_advanced_buttons4 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_styles : "Gras=bold;Italic=italic;Italic Gras=italicbold;Souligné=underline;",
	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",
	relative_urls : false,
	convert_urls : false,
	cleanup : true,
	valid_elements : "*[*]",
	skin : "o2k7",
	skin_variant : "silver",
	width:'800px',
	height:'300px',
	language : 'en'
	});
});