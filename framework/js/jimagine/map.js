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
 * http://www.magix-dev.be,http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-cms[dot]com>
 * @name nicenotify
 * @exemple :
 * 
 */
var jm_map = {
	/**
	 * @exemple:
	 *  var confcontent = '$("#title").val();
		var tabconfig = {
			latitude : $('#lat').val(),
			longitude : $('#lng').val(),
			zoom : 14,
			content: confcontent
		};
		jm_map._baselatLng('#my_map',tabconfig,false);
	 */
	_baselatLng:function(id,tabconfig,debug){
		if(jQuery().gmap3){
			if($(id).length != 0){
				if(!$.isPlainObject(tabconfig)){
					console.error('Error tabconfig is not object');
				}else if($.isEmptyObject(tabconfig)){
					console.error('Error tabconfig is empty');
				}
				if(typeof tabconfig['latitude'] !== "undefined"){
					tabconfig['latitude'];
				}else {
					console.log('latitude is not defined');
				}
				if(typeof tabconfig['longitude'] !== "undefined"){
					tabconfig['longitude'];
				}else{
					console.log('longitude is not defined');
				}
				if(typeof tabconfig['zoom'] !== "undefined"){
					if(tabconfig['zoom'] != null || tabconfig['zoom'] != ''){
						if(!isNaN(parseFloat(tabconfig['zoom'])) && isFinite(tabconfig['zoom'])){
							var zoomsize = tabconfig['zoom'];
						}else{
							console.error('zoom "%s" is not numeric',tabconfig['zoom']);
						}
					}else{
						console.error('zoom "%s" is NULL',tabconfig['zoom']);
					}
				}
				if(typeof tabconfig['content'] !== "undefined"){
					var infocontent = tabconfig["content"];
				}else{
					var infocontent = '';
				}
				if(debug!=false){
					console.log('Zoom %o',tabconfig['zoom']);
					console.log('latitude %o',tabconfig["latitude"]);
					console.log('longitude %o',tabconfig["longitude"]);
					console.log('content %o',tabconfig["content"]);
				}
				var pos = [tabconfig["latitude"],tabconfig["longitude"]];
		        $(id).gmap3(
		    		{
					    action: 'addMarker',
					    latLng: pos,
					    marker:{
					        options:{
					          draggable: false
					        }
					   },
					   map:{
					    	center: true,
					    	zoom: zoomsize,
					    	mapTypeId: google.maps.MapTypeId.ROADMAP,
						    mapTypeControl: true,
						    mapTypeControlOptions: {
						      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
						    },
						    navigationControl: true,
						    scrollwheel: true,
						    streetViewControl: true
					    }
					},{
						action: 'addInfoWindow',
						latLng: pos,
						infowindow:{
				            options:{
				                  size: new google.maps.Size(20,20),
				                  content: infocontent
			                }
				        }
					}
				);
		        //END LENGTH
			}
			//END TEST IS PLUGINS
		}
	},
	/**
	 * @exemple:
	 *  var confcontent = '$("#title").val();
		var confadress = $('#adress').val()+','+$('#city').val()+' '+$('#country').val();
		var tabconfig = {
			adress: confadress,
			latitude : '#lat',
			longitude : '#lng',
			zoom : 14,
			content: confcontent
		};
		jm_map._adressChPosition('#my_map',tabconfig,false);
	 */
	_adressChPosition:function(id,tabconfig,debug){
		if(jQuery().gmap3){
			if($(id).length != 0){
				if(!$.isPlainObject(tabconfig)){
					console.error('Error tabconfig is not object');
				}else if($.isEmptyObject(tabconfig)){
					console.error('Error tabconfig is empty');
				}
				if(typeof tabconfig['adress'] !== "undefined"){
					tabconfig['adress'];
				}else{
					console.warn('adress is not defined');
				}
				if(typeof tabconfig['latitude'] !== "undefined"){
					tabconfig['latitude'];
				}else {
					console.log('latitude is not defined');
				}
				if(typeof tabconfig['longitude'] !== "undefined"){
					tabconfig['longitude'];
				}else{
					console.log('longitude is not defined');
				}
				if(typeof tabconfig['zoom'] !== "undefined"){
					if(tabconfig['zoom'] != null || tabconfig['zoom'] != ''){
						if(!isNaN(parseFloat(tabconfig['zoom'])) && isFinite(tabconfig['zoom'])){
							var zoomsize = tabconfig['zoom'];
						}else{
							console.error('zoom "%s" is not numeric',tabconfig['zoom']);
						}
					}else{
						console.error('zoom "%s" is NULL',tabconfig['zoom']);
					}
				}
				if(typeof tabconfig['content'] !== "undefined"){
					var infocontent = tabconfig["content"];
				}else{
					var infocontent = '';
				}
				if(debug!=false){
					//console.log('%clatitude','color:red; background-color:grey',latitude);
					console.log('adress %o',tabconfig["adress"]);
					console.log('Zoom %o',tabconfig['zoom']);
					console.log('latitude %o',tabconfig["latitude"]);
					console.log('longitude %o',tabconfig["longitude"]);
					console.log('content %o',tabconfig["content"]);
				}
				$(id).gmap3(
		            {action:'clear'},
		            {action: 'addMarker',
		            address: tabconfig['adress'],
		            map:{
		                center: true,
		                zoom: tabconfig["zoom"],
		                mapTypeId: google.maps.MapTypeId.ROADMAP,
					    mapTypeControl: true,
					    mapTypeControlOptions: {
					      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
					    },
					    navigationControl: true,
					    scrollwheel: true,
					    streetViewControl: true
		            },
		            marker:{
		                options:{
		                    draggable: true
		                },
		                 events: {
		                   dragend:function(marker){
		                	   $(tabconfig["latitude"]).val( marker.getPosition().lat() );
		                	   $(tabconfig["longitude"]).val( marker.getPosition().lng() );
		                     }
		                },
		                callback:function(marker){
		                  if (marker){
		                	  $(tabconfig["latitude"]).val( marker.getPosition().lat() );
		                	  $(tabconfig["longitude"]).val( marker.getPosition().lng() );
		                  }
		                }
		            }/*{
						action: 'addInfoWindow',
						//latLng: [jm_constant.get("idlatitude"),jm_constant.get("idlongitude")],
						infowindow:{
				            options:{
				                  size: new google.maps.Size(20,20),
				                  content: content
			                }
				        }
					}*/
		            ,infowindow:{
	                    options:{
	                      size: new google.maps.Size(20,20),
	                      content: infocontent
	                    }
		            }
		        });
			}
		}
	},
	/**
	 * @exemple :
	 * if($("#mymap").length !=0){
			$('#myadress').keypress(function(){ 
				jm_map._updateTimer('','myclass._loadMap();'); 
			}).change(function(){ 
				jm_map._updateTimer(100,'myclass._loadMap();'); 
			});
		}
	 */
	_updateTimer:function(ts,func){
        if (this.timer) clearTimeout(this.timer);
        this.timer = setTimeout(func, ts ? ts : 1000);
    }
};