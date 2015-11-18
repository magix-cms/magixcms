/**
* MAGIX CMS
* @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien,
    * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
    * @license    Dual licensed under the MIT or GPL Version 3 licenses.
    * @version    1.0
* @author Gérits Aurélien <aurelien@magix-cms.com>
* JS theme default
*
*/
$(function()
{
        // *** In case you don't have firebug...
    if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }

        // *** target_blank
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });

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

    // *** Smooth Scroll to Top
    var speed = 1000;
    $('.toTop').click(function(e){
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, speed);
        return false;
    });

    // *** Cross effect on mobile
    var width = $(window).width();
    if(width < 768) {
        $('button.navbar-toggle').click(function(){
            var target = $($(this).data('target'));
            if($(this).hasClass('open') || $(target).hasClass('collapse in')){
                $(this).removeClass('open');
            }else{
                $(this).addClass('open');
            }
        });
    }
    /*
        // *** for gallery videos
    $(".video").fancybox({
        type: 'iframe',
        autoSize : true,
        padding : 5
    });
*/
});