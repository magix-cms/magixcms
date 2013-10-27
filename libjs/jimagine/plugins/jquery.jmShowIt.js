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
 * @version    0.3
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name jmShowIt
 * @category plugin jquery
 */
/**
 * Exemple : 
 * $('a.showit').jmShowIt({
	   open: 'open',
        contenerClass : 'div.collapse-item',
        activeClass : 'on',
        debug : false
   });
 HTML without data:

     <a data-href="#mydiv" href="#" class="showit">
        My test
     </a>
     <div id="mydiv">
        <p>Foo</p>
     </div>

 HTML with data:

     <a href="#mydiv" class="showit">
         My test
     </a>
     <div id="mydiv">
        <p>Foo</p>
     </div>
 */
;(function ( $, window, document, undefined ) {
	$.fn.jmShowIt = function(options){
		var defaults = {
            open: 'open',
			contenerClass : 'div.collapse-item',
            activeClass : 'on',
			debug : false
            //showcontener:'div.showcontent',
		},
		opts = $.extend(true,{}, defaults, options);
		return this.each(function(i, item){
			var jObjContainers = $(opts.contenerClass);
            //Suppression du gestionnaire d'évènement
			$(item).off();
			$(item).on('click',function(e){
				e.preventDefault();
				var selfelem = $(this);
                //Test la présence d'un attribut data
                if (typeof selfelem.attr('data-href') !== 'undefined'
                    && selfelem.attr('data-href') !== false
                    && selfelem.attr('data-href') !== null) {
                    var selfid = selfelem.attr('data-href');
                }else{
                    var selfid = selfelem.attr('href');
                }
				var jObjShowit = $(selfid);
				//var jObjShowit = $(opts.elem_id + $(this).data("showit"));
				if(opts.debug!=false){
					console.log('%s ',selfid);
				}
				jObjContainers.each(function(j, jtem){
					//console.log('jtem: ',jtem);
					if ((jtem != jObjShowit[0]) && ($(jtem).css("display") != "none")){
                        jObjShowit.removeClass(opts.activeClass);
						$(jtem).slideToggle();
                        if(opts.debug!=false){
                            console.log('Current index closed: %i ',j);
                        }
					}
				});
				jObjShowit.slideToggle('slow', function() {
                    var selfClass = selfelem.attr('class');
					$('.'+selfClass+'.'+opts.open).removeClass(opts.open);
					if (jObjShowit.is(":visible")) {
                        jObjShowit.addClass(opts.activeClass);
						selfelem.addClass(opts.open);
			        } else {
                        jObjShowit.removeClass(opts.activeClass);
			        	selfelem.removeClass(opts.open);
			        }
				});
				return false;
			});
		});
	};
})( jQuery, window, document );
