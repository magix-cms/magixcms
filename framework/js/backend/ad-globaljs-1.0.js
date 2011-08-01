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
	 * Le sous menu
	 */
	var submenu = $('#submenu ul');
	submenu.find("li:first-child").prepend('<span class="lfloat ui-icon ui-icon-home"></span>');
	submenu.find("li:not(:first-child)").prepend('<span class="lfloat ui-icon ui-icon-arrowthickstop-1-e"></span>');
	submenu.find("li").addClass('ui-state-default ui-corner-all');
	submenu.find("li").hover(
		function(){ 
			$(this).addClass("ui-state-hover"); 
		},
		function(){ 
			$(this).removeClass("ui-state-hover"); 
		}
	);
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
		/**
		 * Bouton de recherche
		 */
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
		$(".btnwrench").button({
	        icons: {
	            primary: 'ui-icon-wrench'
	        },
	        text: false
	    });
		$(".btn-decoration:button").button();
		/**
		 * Construction du bouton de fermeture de la notification
		 */
		$(".close-notify").button({
	        icons: {
	            primary: "ui-icon-closethick"
	        }
	    });
		/**
		 * Définition de jquery button pour les boutons radio dans un contener radio_contener
		 */
		$(".radio_contener").buttonset();
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
		$('#showmetas').button({ icons: {primary:'ui-icon-plusthick'} });
		$.openDiv({
			visible:'#showmetas',
			container:'#metascontener'
		});
		// Les widgets ou utilitaire dashboard
		$.dashboardWidget();
		$('#addvarprofil').bind("click", function(){
	 		$('#varprofil').show("drop", {direction:"up"}, 500);
	 		return false;
		});
	  //function replace targetblank for valid w3c
	    $('a.targetblank').click( function() {
			 window.open($(this).attr('href'));
			 return false;
		});
	    /**
	     * Initialisation de colorbox dans l'administration pour la prévisualisation
	     */
	    //Prévisualisation dans une iframe
	    $(".post-preview").colorbox({width:"95%", height:"95%", iframe:true});
	    //Prévisualisation d'images
	    $(".imagebox").colorbox();
	    /**
		 * Ajout d'une classe spécifique au survol d'un éditeur
		 */
		$(".block-preview:not(.ui-state-highlight)").hover(
			function(){
				if($(this).find('ui-widget-content')){
					$(this).removeClass("ui-widget-content");
				}
				$(this).addClass("ui-state-hover");
			},
			function(){ 
				if(!$(this).hasClass('ui-state-highlight')){
					$(this).removeClass("ui-state-hover");
					$(this).addClass("ui-widget-content");
				}
			}
		);
	    /**
	     * Sidebar
	     */
	    $("#sidebar ul li a").hover(
		    function () {
		        $(this).addClass('ui-state-hover');
		    }, 
		    function () {
		      $(this).removeClass('ui-state-hover');
		    }
	    );
});