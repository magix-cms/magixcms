function initGallery(titles,iso){
    // *** for gallery pictures
    $(".img-gallery").fancybox({
        helpers : {
            title : 'outside'
        },
        tpl: {
            closeBtn : '<a title="'+titles[iso]['close']+'" class="fancybox-item fancybox-close" href="javascript:;"></a>',
            next     : '<a title="'+titles[iso]['next']+'" class="fancybox-nav fancybox-next" href="javascript:;"><span></span></a>',
            prev     : '<a title="'+titles[iso]['prev']+'" class="fancybox-nav fancybox-prev" href="javascript:;"><span></span></a>'
        }
    });

    $(".show-img").click(function(e){
        e.preventDefault();
        var target = $(this).data('target');
        $(".big-image a").animate({ opacity: 0, 'z-index': 0 }, 200);
        $(target).animate({ opacity: 1, 'z-index': 1 }, 200);
    });
}

$(function(){
    // *** Fancybox gallery
    var titles = {
            'fr': {'close':'Fermer','next':'Suivant','prev':'Précédent'},
            'nl': {'close':'Dicht','next':'Volgende','prev':'Voorgaand'},
            'en': {'close':'Close','next':'Next','prev':'Previous'}
        },
        lang = $('html').attr('lang'),
        iso = lang ? lang : 'en';
    // *** for one picture
    $(".img-zoom").fancybox({
        helpers : {
            title : 'outside'
        },
        tpl: {
            closeBtn : '<a title="'+titles[iso]['close']+'" class="fancybox-item fancybox-close" href="javascript:;"></a>'
        }
    });

    initGallery(titles,iso);

    // *** for gallery videos
    /*$(".video").fancybox({
     type: 'iframe',
     autoSize : true,
     padding : 5
     });
     */
});