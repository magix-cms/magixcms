/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Jimagine.
# Toolbox for jQuery
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
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
 * @link init URI : http://connect.facebook.net/replace_width_iso/all.js#xfbml=1
 * Exemple for French : http://connect.facebook.net/fr_FR/all.js#xfbml=1
 * @exemple with like box facebook widget:
 * $("#fb_like_box").fbwidget({
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
 */
(function($){
	$.fn.fbwidget = function(settings){
		// Default options value
	    var options = {
	      widget: "like",
	      iso: "fr",
	      attributs: {}
	    };
	    if ($.isPlainObject(settings)) {
	    	var o = $.extend(true,options, settings || {});
        }else{
        	console.log("%s: %o","socialXFBML settings is not object");
        }
	    //var o = options;
	    // Reference to the container element
    	var obj = $(this);
		//params = params || {};
	    if(o.widget != ""){
	    	if(o.iso != ""){
	    		switch(o.iso){
	    			case "fr":
	    				var iso_code = "fr_FR";
	    			break;
	    		}
		    	$.ajax({
	        		url:"http://connect.facebook.net/"+iso_code+"/all.js#xfbml=1",
	        		type:'get',
	        		dataType: "script",
	        		statusCode: {
	    				0: function() {
	    					console.error("jQuery Error");
	    				},401: function() {
	    					console.warn("access denied");
	    				},404: function() {
	    					console.warn("object not found");
	    				},403: function() {
	    					console.warn("request forbidden");
	    				},408: function() {
	    					console.warn("server timed out waiting for request");
	    				},500: function() {
	    					console.error("Internal Server Error");
	    				}
	    			},
	        		success: function(data, status, xhr){
	        			return this.each(function() {
	        		    	fb_dom = $("<fb:" + o.widget + "></fb:" + o.widget + ">");
	        		    	if(options.attributs != ''){
	        		    		$.each(options.attributs, function( key , value ) {
	        		    			fb_dom.attr( key , value );
	        		    		});
	        		    		fb_dom.appendTo(obj);
	        		    	}else{
	        		    		console.log("%s: %o","attributs is null",o.widget);
	        		    	}
	        	    	});
	        		}
	        	}).fail(function(xhr, status, error){
	    			console.group('Error socialXFBML');
	            		console.error('Status %s ',status);
	            		console.error('%s',error);
	            	console.groupEnd();
	        	});
	    	}
        }else if(o.widget == undefined){
        	console.log("%s: %o","widget is undefined",o.widget);
        	return false;
        }else{
        	console.log("%s: %o","widget is not found",o.widget);
        	return false;
        }
	};
})(jQuery);