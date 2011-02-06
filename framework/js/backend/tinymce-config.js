/**
 * MAGIX CMS
 * @category   javascript
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @package    TinyMCE
 * @name	   tinymce
 *
 */
$(function() {
	$.getScript('/framework/js/tiny_mce/jquery.tinymce.js', function() {
		$('.mceEditor').tinymce({
			// Location of TinyMCE script
			script_url : '/framework/js/tiny_mce/tiny_mce.js',
			//document_base_url :"/",
			apply_source_formatting : true,
			mode : "exact",
			relative_urls : false,
			elements : 'absurls',
			//remove_script_host : false,
			theme : "advanced",
			plugins : "safari,xhtmlxtras,inlinepopups,advlink,advimage,insertdatetime,style,layer,table,fullscreen,contextmenu,paste,preview,rj_insertcode,tablegrid,youtube,cmspage,loremipsum"+manager_tinymce_plugin,
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontsizeselect,fullscreen,preview",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,forecolor,backcolor,|,link,unlink,anchor"+manager_tinymce_button+",image,|,insertdate,inserttime,code",
			/*tabledraw,convertcelltype,*/
			theme_advanced_buttons3 : "tablegrid,|,row_props,cell_props,|,row_before,row_after,delete_row,|,col_before,col_after,delete_col,|,split_cells,merge_cells,|,tabledraw,convertcelltype,|,hr,removeformat,|,rj_insertcode,loremipsum,youtube,cmspage",
			//tableextras_col_size: 10, // Optional
			//tableextras_row_size: 10, // Optional
			// Available table grid settings
			file_browser_callback: tinymce_call_back,
		    tablegrid_row_size: 10,
		    tablegrid_col_size: 10,
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,
			theme_advanced_styles : "imagebox=imagebox;targetblank=targetblank",
			// Drop lists for link/image/media/template dialogs
			/*template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",*/
			cleanup : true,
			cleanup_on_startup : true,
			valid_elements : "*[*]",
			skin : "o2k7",
			skin_variant : "silver",
			width: '98%',
			height:'300px',
			theme_advanced_resizing_min_width : 320,
			language : 'fr'
		});
	});
});
function filebrowser(field_name, url, type, win) {
	fileBrowserURL = "/framework/js/tiny_mce/plugins/pdw_file_browser/index.php?filter=" + type;
	tinyMCE.activeEditor.windowManager.open({
		title: "PDW File Browser",
		url: fileBrowserURL,
		width: 950,
		height: 650,
		inline: 1,
		maximizable: 1,
		close_previous: 0
	},{
		window : win,
		input : field_name
	});	
}