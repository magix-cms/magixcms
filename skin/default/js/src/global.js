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
// Creare's 'Implied Consent' EU Cookie Law Banner v:2.4
// Conceived by Robert Kent, James Bavington & Tom Foyster
// Modified by Simon Freytag for syntax, namespace, jQuery and Bootstrap

C = {
	// Number of days before the cookie expires, and the banner reappears
	cookieDuration : 14,

	// Name of our cookie
	cookieName: 'complianceCookie',

	// Value of cookie
	cookieValue: 'on',

	showDiv: function () {
		$("#cookies").removeClass('hide');
	},

	createCookie: function(name, value, days) {
		console.log("Create cookie");
		var expires = "";
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days*24*60*60*1000));
			expires = "; expires=" + date.toGMTString();
		}
		document.cookie = name + "=" + value + expires + "; path=/";
	},

	checkCookie: function(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ')
				c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) == 0)
				return c.substring(nameEQ.length, c.length);
		}
		return null;
	},

	init: function() {
		if (this.checkCookie(this.cookieName) != this.cookieValue)
			this.showDiv();
	}
};

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
    /*if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }*/

	// *** target_blank
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });

	// *** Bootstrap components
	$('[data-toggle="tooltip"]').tooltip();
	//$('[data-toggle="popover"]').popover();

	// *** Auto-position of the affix header
	var aHead = document.getElementById('header-fixed');
	if (aHead != null) {
		if ($('#header-fixed').hasClass('affix-menubar')) {
			var target = getPosition(document.getElementById('main-menu'));
		} else {
			var target = getPosition(document.getElementById('header'));
		}
		$('#header-fixed').affix({
			offset: {
				top: target.y,
				bottom: function () {
					return (this.bottom = $('.footer').outerHeight(true))
				}
			}
		})
	} else {
		if(width > 768) {
			var target = getPosition(document.getElementById('header-menu'));
			target = target.y;
			var space = $('#header-menu').height();
			var lastPos = $(window).scrollTop();

			/*function affixHead() {
			 var scrollTop = $(window).scrollTop();
			 if (scrollTop > target.y) {
			 $('#header-menu').addClass('affix affix-top');
			 if (document.getElementById('toolbar') != null) $('#toolbar').css('margin-bottom',space)
			 } else {
			 $('#header-menu').removeClass('affix affix-top');
			 if (document.getElementById('toolbar') != null) $('#toolbar').css('margin-bottom',0)
			 }
			 }*/
			function affixHead() {
				var scrollTop = $(window).scrollTop();
				if ((scrollTop > target && lastPos < target) || (scrollTop == lastPos && scrollTop > target)) {
					$('#header-menu').addClass('affix affix-top').prev().css('margin-bottom',space);
					$('body > .toTop').addClass('affix').removeClass('affix-top');
				} else if((lastPos > target && scrollTop < target) || (scrollTop == lastPos && scrollTop < target)){
					$('#header-menu').removeClass('affix affix-top').prev().css('margin-bottom',0);
					$('body > .toTop').addClass('affix-top').removeClass('affix');
				}
				lastPos = scrollTop;
			}
			$(window).scroll(affixHead);
			affixHead();
		}
	}

    // *** Smooth Scroll to Top
    var speed = 1000;
    $('.toTop').click(function(e){
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, speed);
        return false;
    });

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