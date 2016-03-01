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
		$(".big-image a").animate({ opacity: 0, 'z-index': -1 }, 200);
		$(target).animate({ opacity: 1, 'z-index': 1 }, 200);
	});
}

function getPosition(element) {
	var xPosition = 0;
	var yPosition = 0;

	while(element) {
		xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
		yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
		element = element.offsetParent;
	}
	return { x: xPosition, y: yPosition };
}

$(function()
{
	var width = $(window).width();

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

	// *** Bootstrap components
	$('[data-toggle="tooltip"]').tooltip();
	$('.carousel').carousel()
	//$('[data-toggle="popover"]').popover();

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

	// *** Smooth Scroll to Top
	var speed = 1000;
	$('.toTop').click(function(e){
		e.preventDefault();
		$('html, body').animate({ scrollTop: 0 }, speed);
		return false;
	});

	// *** Enable affix elements on large devices
	if(width > 767) {
		// *** Auto-position of the affix header
		var aHead = typeof document.getElementById('header-fixed');
		if (aHead != undefined) {
			if ($('#header-fixed').hasClass('affix-menubar')) {
				var headTarget = getPosition(document.getElementById('main-menu'));
			} else {
				var headTarget = getPosition(document.getElementById('header'));
			}
		}

		// *** Auto-position of the affix back to top
		var btt = document.getElementById('btt');
		var btnExist = typeof btt;
		if (btnExist != undefined) {
			var scrollTarget = {y: btt.dataset.offset};
		}

		// *** Affix elements
		if (btnExist != undefined || aHead != undefined) {
			$(window).scroll(function () {
				var scrollTop = $(window).scrollTop();
				if (aHead != undefined) {
					if (scrollTop > headTarget.y) {
						$('#header-fixed').addClass('affix affix-top')
					} else {
						$('#header-fixed').removeClass('affix affix-top')
					}
				}
				if (btnExist != undefined) {
					if (scrollTop > scrollTarget.y) {
						$('#btt').addClass('affix')
					} else {
						$('#btt').removeClass('affix')
					}
				}
			});
		}
	}

    // *** Cross effect on mobile
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
});