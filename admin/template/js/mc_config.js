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
 * Date: 6/01/13
 * Time: 00:56
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_config = (function ($, undefined) {
    //Fonction Private
    function updateConfig(baseadmin){
        $('#forms_config_edit').on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: '/'+baseadmin+'/config.php?action=edit',
                typesend: 'post',
                idforms: $(this),
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        })
    }

    /**
     * Mise à jour du manager/editeur
     */
    function updateManager(baseadmin){
        var formsUpdate = $('#forms_editor_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                manager_setting: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/config.php?section=editor&action=edit',
                    typesend: 'post',
                    idforms: $(form),
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
        $('#forms_editor_edit').formsUpdate;
    }

    /**
     * Mise à jour des CSS frontend à intégré dans tinyMCE
     */
    function updateContentCss(baseadmin){
        $('#forms_editor_css_edit').on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: '/'+baseadmin+'/config.php?section=editor&action=edit',
                typesend: 'post',
                idforms: $(this),
                resetform:false,
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        });
    }

    /**
     * Modification de la taille des images
     * @param formsId
     */
    function updateImage(baseadmin,formsId){
        $('#'+formsId).on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: '/'+baseadmin+'/config.php?section=imagesize&action=edit',
                typesend: 'post',
                idforms: $(this),
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        });
    }

    /**
     * Mise à jour du statut de la concaténation
     */
    function updateConcat(baseadmin){
        $('#forms_config_concat').on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: '/'+baseadmin+'/config.php?section=cache&action=edit',
                typesend: 'post',
                idforms: $(this),
                resetform:false,
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        });
    }

    /**
     * Mise à jour du système de cache
     */
    function updateCache(baseadmin){
        $('#forms_config_cache').on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: '/'+baseadmin+'/config.php?section=cache&action=edit',
                typesend: 'post',
                idforms: $(this),
                resetform:false,
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
            return false;
        });
    }
    return {
        //Fonction Public        
        runConfig:function (baseadmin) {
            updateConfig(baseadmin);
        },
        runEditor:function (baseadmin) {
            updateManager(baseadmin);
            updateContentCss(baseadmin);
            updateConcat(baseadmin);
            updateCache(baseadmin);
        },
        runImages:function () {
            $('.spincount').spinner({
                min: 50
            });
            $(".forms-config").each(function(){
                var formsId = $(this).attr('id');
                updateImage(baseadmin,formsId);
            });
        }
    };
})(jQuery);