/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
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

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
/**
 * Author: Gerits Aurelien <aurelien[at]magix-cms[point]com>
 * Copyright: MAGIX CMS
 * Date: 2/12/12
 * Time: 21:27
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_dashboard = (function ($, undefined) {
    //Fonction Private
    function loadVersion(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/dashboard.php?action=version',
            typesend: 'get',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("min-loader").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#version').html(loader);
            },
            successParams:function(e){
                $('.min-loader').remove();
                $('#version').html(e);
                $.nicenotify.initbox(e,{
                    display:false
                });
            }
        });
    }
    return {
        //Fonction Public        
        run:function () {
            loadVersion();
        }
    };
})(jQuery);