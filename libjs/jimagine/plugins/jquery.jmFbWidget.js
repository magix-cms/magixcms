/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of Jimagine.
 # Toolbox for jQuery
 # Copyright (C) 2011 - 2013  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
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
 * MAGIX DEV
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name socialXFBML
 *
 * Exemple for French : http://connect.facebook.net/fr_FR/all.js#xfbml=1
 * @exemple with like box facebook widget:
 * $("#fb_like_box").jmFbWidget({
		widget : "like-box", 
		attributs : {
			"width":"440",
			"show_faces":true,
			"stream":false,
			"header":false,
			"border_color":"",
			"href":"https://www.facebook.com/pages/Magix-Dev/227636040597626"
		}
	});
 * $("#fb_like").jmFbWidget({
         widget : "like",
         attributs : {
             "width":"100",
             "show_faces":false,
             "stream":false,
             "header":false,
             "border_color":"",
             "layout":"button_count",
             "href":"https://www.facebook.com/pages/Magix-Dev/227636040597626"
         }
 * });
 */
;(function ( $, window, document, undefined ) {
	$.fn.jmFbWidget = function(settings){
		// Default options value
	    var options = {
	      widget: "like",
	      attributs: {}
	    };
	    if ($.isPlainObject(settings)) {
	    	var o = $.extend(true,options, settings || {});
        }else{
        	console.log("%s: %o","jmFbWidget settings is not object");
        }
	    //var o = options;
	    // Reference to the container element
    	var $this = $(this);
		//params = params || {};
	    if(o.widget != ""){
	    	return this.each(function() {
		    	var fb = $("<fb:" + o.widget + "></fb:" + o.widget + ">");
		    	if(options.attributs != ''){
		    		$.each(options.attributs, function( key , value ) {
                        fb.attr( key , value );
		    		});
                    fb.appendTo($this);
		    	}else{
		    		console.log("%s: %o","attributs is null",o.widget);
		    	}
	    	});
        }else if(o.widget == "undefined"){
        	console.log("%s: %o","widget is undefined",o.widget);
        	return false;
        }else{
        	console.log("%s: %o","widget is not found",o.widget);
        	return false;
        }
	};
})( jQuery, window, document );