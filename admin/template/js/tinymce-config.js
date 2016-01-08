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
        script_url : '/'+baseadmin+'/template/js/vendor/tiny_mce.'+editor_version+'/tinymce.min.js',
        theme: "modern",
        relative_urls : false,
        entity_encoding : "raw",
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen colorpicker textpattern wordcount directionality',
            'insertdatetime media table contextmenu paste textcolor template youtube codehighlight imagetools fontawesome mc_pages mc_news'+catalog_tinymce_plugin+manager_tinymce_plugin
        ],
        toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | fontsizeselect | forecolor backcolor',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | '+manager_tinymce_button+' image media | link unlink anchor | code | preview',
        toolbar3: 'table | hr removeformat | fullscreen | visualblocks | loremipsum | inserttime | styleselect | template | youtube | mc_pages mc_news mc_catalog codehighlight fontawesome',
        menubar: false,
        toolbar_items_size: 'small',
        image_advtab: true,
        external_filemanager_path: '/'+baseadmin+'/template/js/filemanager/',
        filemanager_title: "Responsive Filemanager",
        external_plugins: {
            "filemanager" : '/'+baseadmin+'/template/js/filemanager/plugin.min.js'
        },
        setup: function(ed) {
            ed.addButton('loremipsum', {
                title: 'loremipsum',
                //text : 'loremipsum',
                image: '/'+baseadmin+'/template/img/ico/loremipsum.png',
                icon: true,
                onclick: function() {
                    var li = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.|Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.|Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.|Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
                    ed.insertContent(li);
                }
            });
        },
        formats: {
            strikethrough: {inline: 'del'}
        },
        style_formats: [
            {title: 'Link', items: [
                {title: 'TargetBlank', selector: 'a', classes: 'targetblank'}
            ]},
            {title: 'Image', items: [
                {title: 'Lightbox simple', selector: 'a', classes: 'img-zoom',
                    attributes: {
                        'data-fancybox-group': 'lightbox'
                    }
                },
                {title: 'Lightbox galery', selector: 'a', classes: 'img-gallery',
                    attributes: {
                        'data-fancybox-group': 'lightbox'
                    }
                },
                {title: 'Image Responsive', selector: 'img', classes: 'img-responsive'},
                {title: 'Image float left', selector: 'img', classes: 'pull-left img-float'},
                {title: 'Image float right', selector: 'img', classes: 'pull-right img-float'},
                {title: 'Image rounded', selector: 'img', classes: 'img-rounded'},
                {title: 'Image circle', selector: 'img', classes: 'img-circle'},
                {title: 'Image thumbnail', selector: 'img', classes: 'img-thumbnail'}
            ]},
            {title: 'Table', items: [
                {title: 'Table', selector: 'table', classes: 'table'},
                {title: 'Table Condensed', selector: 'table', classes: 'table-condensed'},
                {title: 'Table Bordered', selector: 'table', classes: 'table-bordered'},
                {title: 'Table Hover', selector: 'table', classes: 'table-hover'},
                {title: 'Table Striped', selector: 'table', classes: 'table-striped'},
                {title: 'TR', items: [
                    {title : 'Active', selector : 'tr', classes : 'active'},
                    {title : 'Success', selector : 'tr', classes : 'success'},
                    {title : 'Warning', selector : 'tr', classes : 'warning'},
                    {title : 'Danger', selector : 'tr', classes : 'danger'},
                    {title : 'Info', selector : 'tr', classes : 'info'}
                ]},
                {title: 'TD', items: [
                    {title : 'Active', selector : 'td', classes : 'active'},
                    {title : 'Success', selector : 'td', classes : 'success'},
                    {title : 'Warning', selector : 'td', classes : 'warning'},
                    {title : 'Danger', selector : 'td', classes : 'danger'},
                    {title : 'Info', selector : 'td', classes : 'info'}
                ]},
                {title: "Blocks", items: [
                    {title: "Div responsive", block: "div", classes: 'table-responsive'}
                ]}
            ]},
            {title: 'Helper classes', items: [
                {title: "Blocks", items: [
                    {title: "Div center", block: "div", classes: 'center-block'},
                    {title: "Div clearfix", block: "div", classes: 'clearfix'}
                ]},
                {title: "Paragraph", items: [
                    {title: "Text Muted", block: "p", classes: 'text-muted'},
                    {title: "Text Primary", block: "p", classes: 'text-primary'},
                    {title: "Text Success", block: "p", classes: 'text-success'},
                    {title: "Text Info", block: "p", classes: 'text-info'},
                    {title: "Text Warning", block: "p", classes: 'text-warning'},
                    {title: "Text Danger", block: "p", classes: 'text-danger'},
                    {title: "Bg Primary", block: "p", classes: 'bg-primary'},
                    {title: "Bg Success", block: "p", classes: 'bg-success'},
                    {title: "Bg Info", block: "p", classes: 'bg-info'},
                    {title: "Bg Warning", block: "p", classes: 'bg-warning'},
                    {title: "Bg Danger", block: "p", classes: 'bg-danger'}
                ]}
            ]},
            {title: 'Alert', items: [
                {title: "Blocks", items: [
                    {title: "Alert success", block: "div", classes: 'alert alert-success'},
                    {title: "Alert info", block: "div", classes: 'alert alert-info'},
                    {title: "Alert warning", block: "div", classes: 'alert alert-warning'},
                    {title: "Alert danger", block: "div", classes: 'alert danger-info'}
                ]},
                {title: "Paragraph", items: [
                    {title: "Alert success", block: "p", classes: 'alert alert-success'},
                    {title: "Alert info", block: "p", classes: 'alert alert-info'},
                    {title: "Alert warning", block: "p", classes: 'alert alert-warning'},
                    {title: "Alert danger", block: "p", classes: 'alert danger-info'}
                ]},
                {title: "Link", items: [
                    {title: 'Alert link', selector: 'a', classes: 'alert-link'}
                ]}
            ]},
            {title: 'Embed', items: [
                {title: "Blocks", items: [
                    {title: "Media 16:9", block: "div", classes: 'embed-responsive embed-responsive-16by9'},
                    {title: "Media 4:3", block: "div", classes: 'embed-responsive embed-responsive-4by3'}
                ]}
            ]},
        ],
        templates : '/'+baseadmin+'/ajax.php?action=list&tab=snippet',
        language : tinyLanguage,
        schema: "html5",
        extended_valid_elements: "+span[*],+iframe[src|width|height|name|align|class],+strong[*]",
        //end_container_on_empty_block: false,
        /*fix_list_elements : true*/
        content_css : content_css
    });
})( jQuery, window, document );