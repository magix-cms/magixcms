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
/**
 * Plugins dashboardWidget
 */
(function($) { 
	$.dashboardWidget = function(settings) { 
		var options = {};
	    $.extend(options, settings);
	    $(".dashboard-widget").find(".dashboard-widget-header a").prepend('<span style="float:left;" class="ui-icon ui-icon-circle-minus"></span>').end();
	    if($(".dashboard-widget").find(".dashboard-hidden")){
	    	$(".dashboard-hidden").hide();
	    	$(".dashboard-hidden").prev().find('.dashboard-open span').toggleClass("ui-icon-circle-minus").addClass("ui-icon-circle-plus");
	    }
	    $(".dashboard-open").click(function(event) {
	    	var icons = $("span",this);
	    	event.preventDefault();
			var dashboard = $(this).parents(".dashboard-widget:first").find(".dashboard-widget-content");
			if (dashboard.is(":visible")) {
				icons.toggleClass("ui-icon-circle-minus").addClass("ui-icon-circle-plus");
				dashboard.hide();
				dashboard.addClass("dashboard-hidden");
			}else{
				icons.toggleClass("ui-icon-circle-plus").addClass("ui-icon-circle-minus");
				dashboard.show();
				dashboard.removeClass("dashboard-hidden");
			}
		});
	};
})(jQuery);
/**
 * Plugin for IETester
 */
(function($) { 
	$.ieTester = function(settings) { 
		var options = {
			version: '7'
		};
	    $.extend(options, settings);
	    var ua = $.browser;
	    if(ua.msie){
	    	var ieVersion = parseFloat(ua.version, 10) || 0;
	    	if(isNaN(ieVersion)){
	    		console.error("The version is not a number");
	    	}
	    	if(ieVersion == options.version){
	    		//alert(ua.version.slice(0,3));
	    		return true;	
	    	}
	    }
	};
})(jQuery);
(function($) { 
	$.fn.inputLock = function(settings) { 
		var options = {};
	    $.extend(options, settings);
	    var inputElement = $(this);
	    inputElement.attr("readonly","readonly");
	    $('.unlocked').live('click',function(event){
			event.preventDefault();
			inputElement.removeClass('inputdisabled').addClass('inputtext').attr("readonly","");
			$(this).fadeOut(400);
		});
	};
})(jQuery);
/**
 * plugins pour afficher/cacher un container depuis un style de bouton
 * @param visible
 * @param container
 */
(function($) { 
    $.openDiv = function(settings) { 
    	var options =  { 
    		visible: "",
    		container: ""
    	};
        $.extend(options, settings);
      //Hide (Collapse) the toggle containers on load
 	   $(options.container).hide();
 	   //Switch the "Open" and "Close" state per click (+ ou - dans le CSS)
 	   $(options.visible).toggle(function(){ // on pourrais aussi utiliser toggleClass
 	      //$(this).addClass("active");
 		   	$(options.visible).button({ icons: {primary:'ui-icon-minusthick'} });
 	      }, function () {
 	     // $(this).removeClass("active");
 	    	$(options.visible).button({ icons: {primary:'ui-icon-plusthick'} });
 	   });
 	   //ouverture et fermeture par glissé
 	   $(options.visible).click(function(){
 	      $(this).next(options.container).slideToggle("slow");
 	   });
    }; 
})(jQuery);
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
		/*$("#showmetas span").addClass("ui-icon ui-icon-circle-plus");
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
		 });*/
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