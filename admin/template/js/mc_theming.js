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
 * Date: 2/01/13
 * Time: 23:53
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_theming = (function ($, undefined) {
    //Fonction Private
    /**
     * Rafraichissement de la liste des templates
     */
    function refresh(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/theming.php?action=list&ajax_tpl=true',
            typesend: 'get',
            datatype: 'html',
            beforeParams:function(){
                $('#theming').empty();
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/admin/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                loader.appendTo('#theming');
            },
            successParams:function(data){
                $.nicenotify.initbox(data,{
                    display:false
                });
                $('.loader').remove();
                $('#theming').html(data);
            }
        });
    }

    /**
     * changement de template
     */
    function update(baseadmin){
        $("#theming").on("click",'.skin-tpl', function(event){
            event.preventDefault();
            var skin = $(this).data("skin");
            if(skin != null){
                $.nicenotify({
                    ntype: "ajax",
                    uri: '/'+baseadmin+'/theming.php?action=edit',
                    typesend: 'post',
                    noticedata:{theme:skin},
                    successParams:function(j){
                        $.nicenotify.initbox(j,{
                            display:true
                        });
                        refresh(baseadmin);
                    }
                });
                return false;
            }
        });
    }
    return {
        //Fonction Public        
        run:function (baseadmin) {
            update(baseadmin);
        }
    };
})(jQuery);