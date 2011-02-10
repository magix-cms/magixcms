/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ad-globaljs
 *
 */
$(function() {
	//In case you don't have firebug...
	if (!window.console || !console.firebug) {
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
		window.console = {};
		for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
	}
	/**
	 * Effet de survol sur les boutons dans le top sidebar
	 */
		$(".topbutton:not(.ui-state-active)").hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		);
		/**
		 * Support input button with jquery ui button
		 */
		$("input:submit").button();
		$("button.search").button({
            icons: {
                primary: 'ui-icon-search'
            },
            text: false
        });
		$(".button-link").button();
		/**
		 * Bouton pour les modifications dans les templates
		 */
		$(".template-edit").button({
            icons: {
                primary: 'ui-icon-pencil'
            },
            text: false
        });
		$(".template-delete").button({
            icons: {
                primary: 'ui-icon-close'
            },
            text: false
        });
		$(".btn-decoration:button").button();
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
		}else if ($('#notify-header-plus').length != 0){
			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
				$('#notify-header').destroyMeerkat();
				$('#notify-header-plus').meerkat({
					background:"#efefef",
					width: '100%',
					position: 'top',
					close: '.close-notify',
					animationIn: 'fade',
					animationOut: 'slide',
					animationSpeed: '750',
					height: '80px',
					opacity: '0.90',
					timer: 2,
					onMeerkatShow: function() { 
						$(this).animate({opacity: 'show'}, 1000); 
					}
				}).addClass('pos-top');
			});
		}
		/**
		 * Initialisation du menu accordéon avec jquery cookies
		 */
		var accordion = $("#sidebar .management-menu");
		var index = $.cookie("magixadmin");
		var active;
		if (index !== null) {
			active = accordion.find("h3:eq(" + index + ")");
		} else {
			active = 0;
		}
		accordion.accordion({
			header: "h3",
			navigation: false,
			active: active,
			selectedClass: '.current',
			autoHeight: false,
			clearStyle: true,
			collapsibe: true,
			alwaysOpen: false,
			animated: 'slide',
			change: function(event, ui) {
				var index = $(this).find("h3").index ( ui.newHeader[0] );
				$.cookie("magixadmin", index, {path: "/",expires: 1});
			},
			autoHeight: false
		});
		/**
		 * Affiche ou non le module d'ajout des métas dans une div
		 */
		$("#showmetas span").addClass("ui-icon ui-icon-circle-plus");
		 $("#showmetas").click(function(){
		 	 var answer = $('#metas');
		        if (answer.is(":visible")) {
		            answer.hide();
		            $('span',this).removeClass("ui-icon ui-icon-circle-minus");
					$('span',this).addClass("ui-icon ui-icon-circle-plus");
		        } else {
		            answer.show();
		            $('span',this).removeClass("ui-icon ui-icon-circle-plus");
					$('span',this).addClass("ui-icon ui-icon-circle-minus");
		        }
		 });
		// sortable portlets ou déplacement et loking des widgets
		// les colonnes qui contiennet les widget déplaçable
		/*$(".column").sortable({
			connectWith: '.column'
		});
		$(".column").disableSelection();*/
		/*$(".dashboard-widget").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
			.find(".dashboard-widget-header")
				.addClass("ui-widget-header ui-corner-all")
				.prepend('<span class="ui-icon ui-icon-plusthick"></span>')
				.end()
			.find(".portlet-content");*/
		$(".dashboard-widget").find(".dashboard-widget-header").prepend('<span class="ui-icon ui-icon-plusthick"></span>').end().find(".portlet-content");
		$(".dashboard-widget-header .ui-icon").click(function() {
			$(this).toggleClass("ui-icon-minusthick");
			$(this).parents(".dashboard-widget:first").find(".dashboard-widget-content").toggle();
		});
		/*$(".forms-cms-navigation").each(function(n){
			var newid = $(this).attr("class")+"_" + n;
			this.id = newid;  
			$(this).attr("id",newid);
		});*/
		$('#addvarprofil').bind("click", function(){
	 		$('#varprofil').show("drop", {direction:"up"}, 500);
	 		return false;
		});
		// Ajoute un look jquery UI au block
		/*$(".dashboard").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".dashboard-header")
			.addClass("ui-widget-header ui-corner-all")
			.end()
		.find(".portlet-content");*/
	  //function replace targetblank for valid w3c
	    $('a.targetblank').click( function() {
			 window.open($(this).attr('href'));
			 return false;
		});
	    /**
	     * Initialisation de colorbox dans l'administration pour la prévisualisation
	     */
	    //Prévisualisation dans une iframe
	    $(".post-preview").colorbox({width:"90%", height:"90%", iframe:true});
	    //Prévisualisation d'images
	    $(".imagebox").colorbox();
});