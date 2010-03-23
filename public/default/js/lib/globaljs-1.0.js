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
	$('.personnal-side-list a:not(.active-page)').hover(function() {
		$(this).stop().animate({ opacity: '0.7',left: 10,backgroundColor: "#696969",color: "#FFFFFF" }, 'fast');
	  }, function() {
	    $(this).stop().animate({ opacity: '1',left: 0,backgroundColor: "#BFBFBF",color: "#333333" }, 'fast');
	});
});