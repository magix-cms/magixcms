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
	if(!$.browser.msie){
		$("form input").filter(":checkbox,:radio").checkbox();
	}
	//menu accordeon
	/*$("#extra .sidebar #page-menu-home,#extra .sidebar #page-menu-home-lang").accordion({
		header: "h3",
		icons: {
			header: false,
			headerSelected: false
		},
		alwaysOpen: true,
		active: 0,
		autoHeight: false
	});
	$("#extra .sidebar #page-menu-nolang,#extra .sidebar #page-cat-lang").accordion({
		header: "h3",
		icons: {
			header: false,
			headerSelected: false
		},
		navigation: true,
		active: '.selected',
		autoHeight: false,
		clearStyle: true,
		collapsibe: true,
		alwaysOpen: false,
		animated: 'slide',
		//change state for menu accordion
		change: function(event,ui) {
			var hid = ui.newHeader.children('a').attr('id');
			if (hid === undefined) {
				$.cookie('pagestate', null);
			} else {
				$.cookie('pagestate', hid, { expires: 2 });
			}
		}
	});
	// check cookie for accordion state
	if($.cookie('pagestate')) {
	   $('#extra .sidebar #page-menu-nolang,#extra .sidebar #page-cat-lang').accordion('option', 'animated', false);
	   $('#extra .sidebar #page-menu-nolang,#extra .sidebar #page-cat-lang').accordion('activate', $('#' + $.cookie('pagestate')).parent('h3'));
	   $('#extra .sidebar #page-menu-nolang,#extra .sidebar #page-cat-lang').accordion('option', 'animated', 'slide');
	}
	$("#extra .sidebar #catalog-menu").accordion({
		header: "h3",
		icons: {
			header: false,
			headerSelected: false
		},
		navigation: true,
		active: '.selected',
		autoHeight: false,
		clearStyle: true,
		collapsibe: true,
		alwaysOpen: false,
		animated: 'slide',
		//change state for menu accordion
		change: function(event,ui) {
			var hid = ui.newHeader.children('a').attr('id');
			if (hid === undefined) {
				$.cookie('catalogstate', null);
			} else {
				$.cookie('catalogstate', hid, { expires: 2 });
			}
		}
	});
	// check cookie for accordion state
	if($.cookie('catalogstate')) {
	   $('#extra .sidebar #catalog-menu').accordion('option', 'animated', false);
	   $('#extra .sidebar #catalog-menu').accordion('activate', $('#' + $.cookie('catalogstate')).parent('h3'));
	   $('#extra .sidebar #catalog-menu').accordion('option', 'animated', 'slide');
	}*/
});