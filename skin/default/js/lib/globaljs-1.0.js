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
	/**
	 * Construction du bouton de fermeture de la notification
	 */
	$(".close-notify").button({
        icons: {
            primary: "ui-icon-closethick"
        }
    });
	/**
	 * Initialise imagebox
	 */
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
	/**
	 * Jquery treeview pour le catalogue
	 */
	$("#catalog-hierarchy").treeview({
		animated: "fast"
	});
	
	/**
	 * Jquery treeview pour les pages cms
	 */		
	$("#menu-cms").treeview({
		animated: "fast"
	});	
});