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
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2013 Gerits Aurelien,
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @contributor jbdemonte
 * @name jmMap
 */
;(function ( $, window, document, undefined ) {
    var methods = {
        getLatLng: function (value){
            if (value.lat !== false && value.lng !== false){
              $(this).gmap3({
                  map:{
                      options:{
                          zoom: value.zoom,
                          center: [value.lat, value.lng],
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
                      latLng: [value.lat, value.lng],
                      options: value.markerImg ? {
                          draggable: false,
                          icon: new google.maps.MarkerImage(value.markerImg)
                      } : {
                        draggable: false
                      }
                  },
                  infowindow:{
                      options:{
                          size: new google.maps.Size(20,20),
                          content: value.content
                      }
                  }
              });
            }
        },
        getPosition: function(value){
            var $this = $(this);
            if (value.address){
                $this.gmap3({
                    clear:{name:'marker'},
                    map:{
                        address: value.address,
                        options:{
                            zoom: value.zoom,
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
                        address: value.address,
                        options:{
                            draggable: true
                        },
                        events: {
                            dragend:function(marker){
                                $(value.lat).val( marker.getPosition().lat() );
                                $(value.lng).val( marker.getPosition().lng() );
                                $this.gmap3({
                                    //clear:{name:'marker'},
                                    getaddress:{
                                        latLng: marker.getPosition(),
                                        callback: function(results){
                                            var content, 
                                                map = $this.gmap3("get"),
                                                infowindow = $this.gmap3({get:"infowindow"}),
                                                data = {};

                                            $.each(results[0].address_components, function (i, component) {
                                                data[component.types[0]] = component.long_name;
                                            });
                                            content = (data.sublocality || data.locality || "") + '&nbsp;' + (data.postal_code || "") + '<br />' + (data.country || "");
                                            
                                            if (infowindow){
                                                infowindow.open(map, marker);
                                                infowindow.setContent(content);
                                            } else {
                                                $this.gmap3({
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
                                $(value.lat).val( marker.getPosition().lat() );
                                $(value.lng).val( marker.getPosition().lng() );
                            }
                        }
                    },
                    infowindow:{
                        options:{
                            size: new google.maps.Size(20,20),
                            content: value.address
                        }
                    }
                });
            }
        },
        getDirection: function(value){
            var $this = $(this);
            if(value.autocomplete){
                $(value.search).autocomplete({
                    //This bit uses the geocoder to fetch address values
                    source: function(request, response) {
                        $this.gmap3({
                            getaddress:{
                                address: request.term,
                                callback:function(results){
                                    if (!results) return;
                                    response($.map(results, function(item) {
                                        return {
                                            label: item.formatted_address,
                                            value: item.formatted_address,
                                            latLng: item.geometry.location
                                        };
                                    }));
                                }
                            }
                        });
                    }
                });
            }
            if(value.button){
                $(value.button).on('click',function(event){
                    if(value.debug){
                        console.log('Event Click %o', event);
                    }
                    $(value.direction).empty();
                    event.stopPropagation();
                    if($(value.search).val().length){
                        $(value.direction).addClass('size-direction').show(800);
                        $this.gmap3({
                            clear: {name:"getroute"},
                            getroute:{
                                options:{
                                    origin: $(value.search).val(),
                                    destination: value.address,
                                    travelMode: google.maps.DirectionsTravelMode.DRIVING
                                },
                                callback: function(results){
                                    if (!results) return;
                                    $(this).gmap3({
                                        directionsrenderer:{
                                            container: $(value.direction),
                                            options:{
                                                directions: results
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
    },
    defaults = {
        getLatLng:{
            content: null,
            zoom:7,
            lat: false,
            lng: false,
            markerImg: false,
            debug: false
        },
        getPosition:{
            zoom:7,
            lat: false,
            lng: false,
            address: false,
            debug: false
        },
        getDirection:{
            button: '.btn-direction',
            search: '#input-address',
            address: false,
            autocomplete: false,
            direction: false,
            debug: false
        }
    };
    $.fn.jmMap = function(options){
        if ($.fn.gmap3 && this.length) {
            this.each(function() {
                var method, opts;
                for (method in options) {
                    if (options.hasOwnProperty(method) && methods.hasOwnProperty(method)){
                        opts = $.extend(true, {}, defaults[method], options[method]);
                        if(opts.debug){
                            console.log(opts);
                        }
                        methods[method].call(this, opts);
                    }
                }
            });
        }
        return this;
    };
})( jQuery, window, document );
/**
 * mapTimer
 *
 * Example:
 * if($("#googlemap").length !=0){
        $('#getaddress').keypress(function(){
            $.mapTimer({ts:'',func:'position();'});
        }).change(function(){
            $.mapTimer({ts:100,func:'position();'});
        });
    }
 */
;(function ( $, window, document, undefined ) {
    $.mapTimer = function(settings){
        // Default options value
        var options = {
            ts: 100,
            func:''
        };
        if ($.isPlainObject(settings)) {
            var o = $.extend(true, {}, options, settings);
        }else{
            console.log("%s: %o","helpmap.timer settings is not object");
        }
        function updateTimer(ts,func){
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(func, ts ? ts : 1000);
        }
        return updateTimer(o.ts, o.func);
    }
})( jQuery, window, document );