$(function() {
	//In case you don't have firebug...
	if (!window.console || !console.firebug) {
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
		window.console = {};
		for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
	}
	var ie6 = ($.browser.msie && $.browser.version < 7);
	var ie7 = ($.browser.msie && $.browser.version > 6);
    //function replace targetblank for valid w3c
	 $('a.targetblank').click( function() {
		 window.open($(this).attr('href'));
		 return false;
	});
	//all hover and click logic for buttons
	$(".fg-button:not(.ui-state-disabled)").hover(
		function(){ 
			$(this).addClass("ui-state-hover"); 
		},
		function(){ 
			$(this).removeClass("ui-state-hover"); 
		}
	)
	.mousedown(function(){
			$(this).parents('.fg-buttonset-single:first').find(".fg-button.ui-state-active").removeClass("ui-state-active");
			if( $(this).is('.ui-state-active.fg-button-toggleable, .fg-buttonset-multi .ui-state-active') ){ $(this).removeClass("ui-state-active"); }
			else { $(this).addClass("ui-state-active"); }	
	})
	.mouseup(function(){
		if(! $(this).is('.fg-button-toggleable, .fg-buttonset-single .fg-button,  .fg-buttonset-multi .fg-button') ){
			$(this).removeClass("ui-state-active");
		}
	});
	$(".imagebox").colorbox();
	$(".select").selectmenu({width: 200,maxWidth: 200});
	$('.checkbox').checkbox();
	$("#product-tabs").tabs();
	/**
	 * Notification après installation pour le dossier "install"
	 */
	if ($('#notify-install').length != 0){
		$('#notify-install').destroyMeerkat();
		$('#notify-install').meerkat({
			//background: 'url(\'../images/meerkat-top-bg.png\') repeat-x left bottom',
			background:"#fdd",
			width: '100%',
			position: 'top',
			close: '.close-notify',
			dontShowAgain: '.dont-notify',
			animationIn: 'fade',
			animationOut: 'slide',
			animationSpeed: '750',
			//removeCookie: '.reset',
			height: '80px',
			opacity: '0.90',
			onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
		}).addClass('pos-top');
	}else if ($('#notify-folder').length != 0){
		$('#notify-folder').destroyMeerkat();
		$('#notify-folder').meerkat({
			background:"#efefef",
			width: '100%',
			position: 'top',
			close: '.close-notify',
			dontShowAgain: '.dont-notify',
			animationIn: 'fade',
			animationOut: 'slide',
			animationSpeed: '750',
			//removeCookie: '.reset',
			height: '80px',
			opacity: '0.90',
			onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
		}).addClass('pos-top');
	}
	$('.personnal-side-list a.active-page').prepend('<span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span>');
	$('.personnal-side-list a:not(.active-page)').hover(function() {
		$(this).stop().animate({ opacity: '0.7',left: 0,backgroundColor: "#696969",color: "#FFFFFF" }, 'fast');
	  }, function() {
	    $(this).stop().animate({ opacity: '1',left: 0,backgroundColor: "#FFFFFF",color: "#000000" }, 'fast');
	});
});