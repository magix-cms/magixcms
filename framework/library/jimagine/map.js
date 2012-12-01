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
 * @name map
 */
var jm_map = (function ($, undefined) {
    //Function private
    /**
     * Stop évènement
     * @param e
     * @private
     */
    function _stopEvent(e){
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        } else {
            e.cancelBubble = true;
            e.returnValue = false;
        }
    }

    /**
     * Retourne le marker
     * @param options
     * @return {String}
     */
    function initMarker(options){
        if(typeof options['markerPath'] !== "undefined"){
            var markerPath = options['markerPath'];
        }else{
            var markerPath = 'markers/';
        }
        if(typeof options['markerImg'] !== "undefined"){
            var markerImg = options['markerImg'];
        }else{
            var markerImg;
        }
        switch(markerImg){
            case 'red':
                return markerPath+'red-dot.png';
                break;
            case 'blue':
                return markerPath+'blue-dot.png';
                break;
            case 'green':
                return markerPath+'green-dot.png';
                break;
            case 'lightblue':
                return markerPath+'ltblue-dot.png';
                break;
            case 'pink':
                return markerPath+'pink-dot.png';
                break;
            case 'yellow':
                return markerPath+'yellow-dot.png';
                break;
            case 'purple':
                return markerPath+'purple-dot.png';
                break;
            default:
                return markerPath+'red-dot.png';
                break;
        }
    }

    /**
     * Retourne la configuration
     * @param setting array
     * @return {*}
     */
    function setConfig(setting){
        if(!$.isPlainObject(setting)){
            console.error('Error setting is not object');
        }else if($.isEmptyObject(setting)){
            console.error('Error setting is empty');
        }
        if(typeof setting['latitude'] !== "undefined"){
            setting['latitude'];
        }
        if(typeof setting['longitude'] !== "undefined"){
            setting['longitude'];
        }
        if(typeof setting['zoom'] !== "undefined"){
            if(setting['zoom'] != null || setting['zoom'] != ''){
                if(!isNaN(parseFloat(setting['zoom'])) && isFinite(setting['zoom'])){
                    var zoomsize = setting['zoom'];
                }else{
                    console.error('zoom "%s" is not numeric',setting['zoom']);
                }
            }else{
                console.error('zoom "%s" is NULL',setting['zoom']);
            }
        }
        if(typeof setting['address'] !== "undefined"){
            setting['address'];
        }
        if(typeof setting['eventclick'] !== "undefined"){
            setting['eventclick'];
        }
        if(typeof setting['inputext'] !== "undefined"){
            setting['inputext'];
        }
        return setting;
    }

    /**
     * Retourne les options de setting
     * @param options
     */
    function setOptions(options){
        if(typeof options['markerImg'] !== "undefined" && typeof options['markerPath'] !== "undefined"){
            options['markerImg'];
            options['markerPath'];
        }
        return options;
    }
    /**
     * Retourne la carte suivant la latitude et longitude
     * @param id
     * @param setting
     * @param options
     * @param debug
     */
    function getLatLng(id,setting,options,debug){
        if(jQuery().gmap3){
            if($(id).length != 0){
                config = setConfig(setting);
                opt = setOptions(options);
                if(debug!=false){
                    console.log('Zoom %o',config['zoom']);
                    console.log('latitude %o',config["latitude"]);
                    console.log('longitude %o',config["longitude"]);
                    console.log('content %o',config["content"]);
                }
                if(typeof config['content'] !== "undefined"){
                    var infocontent = config["content"];
                }else{
                    var infocontent = '';
                }
                var pos = [config["latitude"],config["longitude"]];

                if(opt != null && opt != ''){
                    if(debug!=false){
                        console.log('Options %o',opt);
                    }
                    $(id).gmap3({
                        map:{
                            options:{
                                zoom: 15,
                                center: pos,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                mapTypeControl: true,
                                mapTypeControlOptions: {
                                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                                },
                                navigationControl: true,
                                scrollwheel: true,
                                streetViewControl: true
                            }
                        },
                        marker:{
                            latLng: pos,
                            options:{
                                draggable:false,
                                icon:new google.maps.MarkerImage(initMarker(opt))
                            }
                        },
                        infowindow:{
                            options:{
                                size: new google.maps.Size(20,20),
                                content: infocontent
                            }
                        }
                    });
                    //END LENGTH
                }else{
                    if(debug!=false){
                        console.log('Options %o',opt);
                    }
                    $(id).gmap3({
                        map:{
                            options:{
                                zoom: 15,
                                center: pos,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                mapTypeControl: true,
                                mapTypeControlOptions: {
                                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                                },
                                navigationControl: true,
                                scrollwheel: true,
                                streetViewControl: true
                            }
                        },
                        marker:{
                            latLng: pos,
                            options:{
                                draggable:false
                            }
                        },
                        infowindow:{
                            options:{
                                size: new google.maps.Size(20,20),
                                content: infocontent
                            }
                        }
                    });
                    //END LENGTH
                }
            }
            //END TEST IS PLUGINS
        }
    }

    /**
     * Retourne la longitude et latitude dans des champs
     * @param id
     * @param setting
     * @param debug
     */
    function getAddressPosition(id,setting,debug){
        if(jQuery().gmap3){
            if($(id).length != 0){
                setting = setConfig(setting);
                if(debug!=false){
                    //console.log('%clatitude','color:red; background-color:grey',latitude);
                    console.log('address %o',setting["address"]);
                    console.log('Zoom %o',setting['zoom']);
                    console.log('latitude %o',setting["latitude"]);
                    console.log('longitude %o',setting["longitude"]);
                }
                $(id).gmap3({
                    clear:{name:'marker'},
                    map:{
                        address: setting['address'],
                        options:{
                            zoom: setting["zoom"],
                            mapTypeId: google.maps.MapTypeId.ROADMAP,
                            mapTypeControl: true,
                            mapTypeControlOptions: {
                                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                            },
                            navigationControl: true,
                            scrollwheel: true,
                            streetViewControl: true
                        }
                    },
                    marker:{
                        address: setting['address'],
                        options:{
                            draggable: true
                        },
                        events: {
                            dragend:function(marker){
                                $(setting["latitude"]).val( marker.getPosition().lat() );
                                $(setting["longitude"]).val( marker.getPosition().lng() );
                                $(this).gmap3({
                                    //clear:{name:'marker'},
                                    getaddress:{
                                        latLng:marker.getPosition(),
                                        callback:function(results){
                                            var map = $(this).gmap3("get"),
                                            infowindow = $(this).gmap3({get:"infowindow"}),
                                            //content = results && results[1] ? results && results[1].formatted_address : "no address";
                                            arrAddress = results[0].address_components;
                                            var content,sublocality,locality,postcode,country;

                                            $.each(arrAddress, function (i, component) {
                                                //console.log(component.types[0]);
                                                /*if (component.types[0] == "route"){
                                                 content = component.long_name;
                                                 }
                                                 if (component.types[0] == "administrative_area_level_1"){
                                                 content = component.long_name;
                                                 }*/
                                                if (component.types[0] == "sublocality"){
                                                    sublocality = component.long_name;
                                                }
                                                if (component.types[0] == "locality"){
                                                    locality = component.long_name;
                                                }
                                                if (component.types[0] == "postal_code"){
                                                    postcode = component.long_name;
                                                }
                                                if (component.types[0] == "country"){
                                                    country = component.long_name;
                                                }
                                                //return false; // break the loop*/

                                                if(typeof sublocality !== "undefined"){
                                                    content = sublocality+'&nbsp;'+postcode+'<br />'+country;
                                                }else{
                                                    content = locality+'&nbsp;'+postcode+'<br />'+country;
                                                }
                                            });
                                            if (infowindow){
                                                infowindow.open(map, marker);
                                                infowindow.setContent(content);
                                            } else {
                                                $(this).gmap3({
                                                    infowindow:{
                                                        anchor:marker,
                                                        options:{
                                                            size: new google.maps.Size(20,20),
                                                            content: content
                                                        }
                                                    }
                                                });
                                            }
                                        }
                                    }
                                });
                            }
                        },
                        callback:function(marker){
                            if (marker){
                                $(setting["latitude"]).val( marker.getPosition().lat() );
                                $(setting["longitude"]).val( marker.getPosition().lng() );
                            }
                        }
                    },
                    infowindow:{
                        options:{
                            size: new google.maps.Size(20,20),
                            content: setting['address']
                        }
                    }
                });
            }
        }
    }

    /**
     * autocomplete avec jquery ui
     * @param elem
     * @param container
     */
    function autocomplete(elem,container){
        $(elem).autocomplete({
            //This bit uses the geocoder to fetch address values
            source: function(request, response) {
                $(container).gmap3({
                    getaddress:{
                        address: request.term,
                        callback:function(results){
                            if (!results) return;
                            response($.map(results, function(item) {
                                return {
                                    label: item.formatted_address,
                                    value: item.formatted_address,
                                    latLng:item.geometry.location
                                };
                            }));
                        }
                    }
                });
            }
        });
    }

    /**
     * getDirection with googlemap
     * @param elem
     * @param address
     * @param input
     * @param container
     * @param direction
     */
    //function getDirection(elem,address,input,container,direction){
    function getDirection(id,setting,debug){
        setting = setConfig(setting);
        var eventclick,address,inputext;
        if(typeof setting['address'] !== "undefined"){
            address = setting['address'];
        }
        if(typeof setting['eventclick'] !== "undefined"){
            eventclick = setting['eventclick'];
        }else{
            eventclick = false;
        }
        if(typeof setting['inputext'] !== "undefined"){
            inputext = setting['inputext'];
        }
        if(eventclick != false){
            $(eventclick).on('click',function(event){
                $(setting['direction']).empty();
                _stopEvent(event);
                if($(setting['inputext']).val().length != 0){
                    $(setting['direction']).addClass('size-direction').show(800);
                    $(id).gmap3({
                        clear: {name:"getroute"},
                        getroute:{
                            options:{
                                origin: $(setting['inputext']).val(),
                                destination: setting['address'],
                                travelMode: google.maps.DirectionsTravelMode.DRIVING
                            },
                            callback: function(results){
                                if (!results) return;
                                $(this).gmap3({
                                    directionsrenderer:{
                                        container: $(setting['direction']),
                                        options:{
                                            directions:results
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        }
    }
    return {
        //Fonction Public
        /**
         * @exemple:
         var tabconfig = {
			latitude : $('#lat').val(),
			longitude : $('#lng').val(),
			zoom : 14,
			content: "my society"
		};
         latLng('#my_map',tabconfig,false);
         */
        latLng:function (id,setting,options,debug) {
            getLatLng(id,setting,options,debug);
        },
        /**
         * @exemple:
         *  var confcontent = '$("#title").val();
         var tabconfig = {
			address: "Place Saint Lambert, Liège",
			latitude : '#lat',
			longitude : '#lng',
			zoom : 14
		};
         jm_map.addressPosition('#my_map',tabconfig,false);
         */
        addressPosition:function(id,setting,debug){
            getAddressPosition(id,setting,debug);
        },
        /**
         * autocomplete with jquery UI
         * @param elem
         * @param container
         */
        autocomplete:function(elem,container){
            autocomplete(elem,container);
        },
        /**
         * getDirection with googlemap
         * @param elem
         * @param address
         * @param input
         * @param container
         * @param direction
         */
        getDirection:function(elem,address,input,container,direction){
            getDirection(elem,address,input,container,direction);
        },
        /**
         * @exemple :
         * if($("#mymap").length !=0){
			$('#myaddress').keypress(function(){
				jm_map._updateTimer('','myclass._loadMap();');
			}).change(function(){
				jm_map._updateTimer(100,'myclass._loadMap();');
			});
		}
         */
        updateTimer:function(ts,func){
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(func, ts ? ts : 1000);
        }
    };
})(jQuery);