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
            'insertdatetime media table contextmenu paste textcolor template youtube codehighlight mc_pages mc_news'+catalog_tinymce_plugin+manager_tinymce_plugin
        ],
        toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | fontsizeselect | forecolor backcolor',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | '+manager_tinymce_button+' image media | link unlink anchor | code | preview',
        toolbar3: 'table | hr removeformat | fullscreen | visualblocks | loremipsum | inserttime | styleselect | template | youtube | mc_pages mc_news mc_catalog codehighlight',
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
        style_formats: [
            {title: 'Link', items: [
                {title: 'TargetBlank', selector: 'a', classes: 'targetblank'},
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
            ]}
        ],
        templates : '/'+baseadmin+'/ajax.php?action=list&tab=snippet',
        language : tinyLanguage,
        schema: "html5",
        //end_container_on_empty_block: false,
        /*fix_list_elements : true*/
        content_css : content_css
    });
})( jQuery, window, document );