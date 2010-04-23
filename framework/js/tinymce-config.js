$(function() {
	$('.mceEditor').tinymce({
	// Location of TinyMCE script
	script_url : '/framework/js/tiny_mce-3-3-1/tiny_mce.js',
	//document_base_url : "{geturl}",
	apply_source_formatting : true,
	mode : "exact",
	relative_urls : false,
	remove_script_host : false,
	theme : "advanced",
	/*tableextras,*/
	plugins : "safari,xhtmlxtras,emotions,advlink,advimage,insertdatetime,style,layer,tableextras,table,fullscreen,contextmenu,paste,imagemanager,filemanager,preview,rj_insertcode",
	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,insertimage,insertfile,image,|,forecolor,backcolor,|,insertdate,inserttime,preview",
	/*tabledraw,convertcelltype,*/
	theme_advanced_buttons3 : "tabledraw,convertcelltype,tablecontrols,|,hr,removeformat,visualaid,|,fullscreen,|,rj_insertcode,code,",
	//tableextras_col_size: 10, // Optional
	//tableextras_row_size: 10, // Optional
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	theme_advanced_styles : "Gras=bold;Italic=italic;Italic Gras=italicbold;Souligné=underline;imagebox=imagebox;targetblank=targetblank",
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
	width:'800px',
	height:'300px',
	language : 'fr'
	});
});