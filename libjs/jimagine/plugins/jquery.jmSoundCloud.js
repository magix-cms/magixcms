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
 * @name jmSoundCloud
 */
;(function ( $, window, document, undefined ) {
    $.fn.jmSoundCloud = function(settings) {
        // Default options value
        var options = {};
        if ($.isPlainObject(settings)) {
            var o = $.extend(true,options, settings || {});
        }else{
            console.log("%s: %o","jmSoundCloud settings is not object");
        }
        // Reference to the container element
        return this.each(function(i, item) {
            var $this = $(item);
            $.getJSON('https://soundcloud.com/oembed?format=js&url=' + $this.attr('href') + '&iframe=true&callback=?', function(response){
                $this.replaceWith(response.html);
            });
        });
    };
})( jQuery, window, document );