;(function ( $, window, document, undefined ) {
    var tinyLanguage;
    switch(iso){
        case 'fr':
            tinyLanguage = 'fr_FR';
            break;
        case 'en':
            tinyLanguage = 'en_EN';
            break;
        default :
            tinyLanguage = iso;
            break;
    }
    $('.mceEditor').tinymce({
        // Location of TinyMCE script
        script_url : '/'+baseadmin+'/template/js/tiny_mce.'+editor_version+'/tinymce.min.js',
        theme: "modern",
        relative_urls : false,
        entity_encoding : "raw",
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste textcolor youtube mc_pages mc_news'+catalog_tinymce_plugin+manager_tinymce_plugin
        ],
        toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | forecolor backcolor',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | '+manager_tinymce_button+' image media | link unlink anchor | code | preview',
        toolbar3: 'table | hr removeformat | fullscreen | visualblocks template | inserttime | youtube | mc_pages mc_news mc_catalog',
        menubar: false,
        toolbar_items_size: 'small',
        image_advtab: true ,
        external_filemanager_path: '/'+baseadmin+'/template/js/filemanager/',
        filemanager_title:"Responsive Filemanager" ,
        external_plugins: {
            "filemanager" : '/'+baseadmin+'/template/js/filemanager/plugin.min.js'
        },
        language : tinyLanguage,
        //content_css: "css/content.css",
        schema: "html5",
        end_container_on_empty_block: false,
        /*fix_list_elements : true*/
        content_css : content_css
    });
})( jQuery, window, document );