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
 * Date: 22/02/13
 * Time: 01:42
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_sitemap = (function ($, undefined) {
    //Fonction Private
    function addIndex(){
        $('#sitemap_index').on('click',function(event){
            event.preventDefault();
            $.nicenotify({
                ntype: "ajax",
                uri: '/admin/sitemap.php?action=add',
                typesend: 'post',
                idforms: $(this),
                noticedata:{xml_type:'index'},
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        })
    }
    function add(type){
        $('#forms_sitemap_'+type+'_add').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                idlang: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/sitemap.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    noticedata:{xml_type:type},
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });

    }
    return {
        //Fonction Public        
        run:function () {
            addIndex();
            add('url');
            add('images');
        }
    };
})(jQuery);