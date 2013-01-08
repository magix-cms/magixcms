/**
 * MAGIX CMS
 * @category   javascript
 * @copyright  MAGIX CMS Copyright (c) 2012 Gerits Aurelien,
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.4
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @package    TinyMCE
 * @name	   tinymce
 *
 */
$(function() {
    $('.mceEditor').tinymce({
        // Location of TinyMCE script
        script_url : '/admin/template/js/tiny_mce.'+editor_version+'/tiny_mce.js',
        //document_base_url :"/",
        apply_source_formatting : true,
        mode : "exact",
        relative_urls : false,
        elements : 'absurls',
        //remove_script_host : false,
        theme : "advanced",
        plugins : "safari,xhtmlxtras,inlinepopups,advlink,advimage,insertdatetime,style,layer,table,fullscreen,contextmenu,paste,preview,media,wordcount,codehighlight,tablegrid,youtube,cmspage,news_search,loremipsum,visualblocks,pdw"+catalog_tinymce_plugin+manager_tinymce_plugin+filemanager_tinymce_plugin,
        // Theme options
        theme_advanced_buttons1 : "pdw_toggle,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontsizeselect",
        theme_advanced_buttons2 : "image"+manager_tinymce_button+filemanager_tinymce_button+",|,loremipsum,youtube,|,cmspage,news_search"+catalog_tinymce_button+",|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,forecolor,charmap,|,link,unlink,anchor",
        theme_advanced_buttons3 : "tablegrid,|,row_props,cell_props,|,row_before,row_after,delete_row,|,col_before,col_after,delete_col,|,split_cells,merge_cells,|,backcolor,hr,removeformat,|,code,visualblocks,fullscreen,preview",
        theme_advanced_buttons4 : "codehighlight,media,insertdate,inserttime,|,cut,copy,paste,pastetext,pasteword,",
        pdw_toggle_on : 1,
        pdw_toggle_toolbars : "3,4",
        // Available table grid settings
        file_browser_callback: openFilemanager,
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
        visualblocks_default_state: false,

        // default HTML4
        schema: "html4",

        // End container block element when pressing enter inside an empty block
        end_container_on_empty_block: true,

        cleanup : true,
        cleanup_on_startup : true,
        valid_elements : "*[*]",
        //extended_valid_elements : "pre[name|class],span[class]",
        /*skin : "o2k7",
         skin_variant : "silver",
         */
        skin : "bootstrap",
        width: '98%',
        height:'300px',
        theme_advanced_resizing_min_width : 320,
        language : 'fr'
    });
});
function openFilemanager(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file : '/admin/template/js/filemanager/index.php',
        title : 'File Browser',
        width : 800,
        height : 600,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window : win,
        input : field_name
    });
    return false;
}
/*function openKCFinder(field_name, url, type, win) {
    tinyMCE.activeEditor.windowManager.open({
        file: '/admin/template/js/tiny_mce/plugins/kcfinder/browse.php?opener=tinymce&type=' + type+'&lng=fr',
        title: 'KCFinder',
        width: 950,
        height: 650,
        resizable: "yes",
        inline: true,
        close_previous: "no",
        popup_css: false
    }, {
        window: win,
        input: field_name
    });
    return false;
}*/