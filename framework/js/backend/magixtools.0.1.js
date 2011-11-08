/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Magix CMS.
# Magix CMS, a CMS optimized for SEO
# Copyright (C) 2010 - 2011  Gerits Aurelien <aurelien[at]magix-cms[dot]com>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
*/
/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 - 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-cms[dot]com>
 * @name magixtools
 *
 */
/**
 * Plugins dashboardWidget
 * exemple: $.dashboardWidget();
 */
// S'assurer de la présence d'Object.create (introduit ds ES5)
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
/**
 * Plugin pour appliquer un cadenas sur un champ en lecture et le libérer au click
 */
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
 * exemple :
 * $.openDiv({
		visible:'#showmetas',
		container:'#metascontener'
	});
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
/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name mc_editor_config
 *
 */
/**
 * Fonction pour retourner les paramètres supplémentaires de l'éditeur html
 * @name editorhtml
 * @param settings
 */
(function($) { 
    $.editorhtml = function(settings) { 
    	var options =  { 
    		editor: "tinymce"
    	};
        $.extend(options, settings);
        switch(options.editor){
        	case "tinymce":
        		var config = tinyMCE.triggerSave(true,true);
        	break;
        	case "ckeditor":
        		var config = "";
        	break;
        }
        if(options.editor != ""){
        	return config;
        }else if(options.editor == undefined){
        	console.log("%s: %o","editorhtml is undefined",config);
        	return false;
        }else{
        	console.log("%s: %o","Config is not found",config);
        	return false;
        }
    }; 
})(jQuery); 