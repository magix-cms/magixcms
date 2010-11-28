/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * JS theme default
 *
 */
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
	/*
	 * $(".select").selectmenu({width: 200,maxWidth: 200});
	 * $('.checkbox').checkbox();
	 * */
	$("#product-tabs").tabs();
	/**
	 * Notification après installation pour le dossier "install"
	 */
	if ($('#notify-install').length != 0){
		$.notice({
			ntype: "dir",
			nparams: 'install'
		});
	}else if ($('#notify-folder').length != 0){
		$.notice({
			ntype: "dir",
			nparams: 'chmod'
		});
	}
	$('.personnal-side-list a.active-page').prepend('<span style="float:left;" class="ui-icon ui-icon-triangle-1-e"></span>');
	$('.personnal-side-list a:not(.active-page)').hover(function() {
		$(this).stop().animate({ opacity: '1',backgroundColor: "transparent",color: "#622181" }, 'normal');
	  }, function() {
	    $(this).stop().animate({ opacity: '1',backgroundColor: "transparent",color: "#F29400" }, 'normal');
	});
	/**
	 * Jquery treeview pour le catalogue
	 */
	$("#catalog-hierarchy").treeview({
		animated: "fast"

	});
});