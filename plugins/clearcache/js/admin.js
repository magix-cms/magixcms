/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
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
 * Date: 20/01/13
 * Time: 19:37
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_plugins_clearcache = (function ($, undefined) {
    //Fonction Private
    function remove(baseadmin){
        $('.clear-cache').on('click',function(event){
            event.preventDefault();
            var elem = $(this).attr("id");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $('#window-dialog').dialog({
                modal: true,
                resizable: false,
                height:180,
                width:350,
                title:"Vider les caches de cet élément",
                buttons: {
                    'Delete': function() {
                        $(this).dialog('close');
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/plugins.php?name=clearcache&action=remove',
                            typesend: 'post',
                            noticedata : {clear:elem},
                            beforeParams:function(){
                                var loader = $(document.createElement("span")).addClass("btn-loader").append(
                                    $(document.createElement("img"))
                                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                                        .attr('width','20px')
                                        .attr('height','20px')
                                );
                                //$('#graph').html(loader);
                                $('#'+elem).addClass('hide');
                                $('#'+elem).after(loader);
                            },
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                $('#'+elem).removeClass('hide');
                                $('.btn-loader').remove();
                            }
                        });
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                    }
                }
            });
            return false;
        });
    }
    return {
        //Fonction Public        
        run:function (baseadmin) {
            remove(baseadmin);
        }
    };
})(jQuery);