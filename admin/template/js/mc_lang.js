/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 sc-box.com <support@magix-cms.com>
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
 * Date: 17/12/12
 * Time: 01:01
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_lang = (function ($, undefined) {
    //Fonction Private
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/lang.php?json_graph=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#graph').html(loader);
            },
            successParams:function(data){
                $('#graph').empty();
                $.nicenotify.initbox(data,{
                    display:false
                });
                var $graph = data;
                new Morris.Bar({
                    resize: true,
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y', 'z', 'a', 'b'],
                    labels: ['HOME', 'NEWS', 'PAGES', 'PRODUCT']
                });
            }
        });
    }

    /**
     * Retourne la liste des langues
     * @param baseadmin
     * @param iso
     */
    function jsonLang(baseadmin,iso){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/lang.php?action=list&json_list_lang=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_lang').html(loader);
            },
            successParams:function(j){
                $('#list_lang').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_lang")
                    .addClass('table table-bordered table-condensed table-hover')
                    .append(
                    $(document.createElement("thead"))
                        .append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-key")
                            ),
                            $(document.createElement("th"))
                            .append(
                                $(document.createElement("span"))
                                    .attr("title","first tooltip")
                                    .attr("rel","tooltip")
                                    .append("ISO")
                            ),
                            $(document.createElement("th")).append(Globalize.localize( "language", iso )),
                            $(document.createElement("th")).append(Globalize.localize( "default", iso )),
                            $(document.createElement("th")).append(
                                $(document.createElement("span")).addClass("fa fa-eye")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-edit")
                            )
                            ,
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-trash-o")
                            )
                        )
                    ),
                    tbody
                );
                tbl.appendTo('#list_lang');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.default_lang != 0){
                            var default_lang = $(document.createElement("span")).addClass("fa fa-check-square-o");
                        }else{
                            var default_lang = $(document.createElement("span")).addClass("fa fa-square-o");
                        }
                        if(item.active_lang == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idlang)
                                    .attr("title", Globalize.localize( "activate_language", iso )+": "+item.iso).append(
                                    $(document.createElement("span")).addClass("fa fa-eye-slash")
                                )
                            )
                        }else if(item.active_lang == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idlang)
                                    .attr("title", Globalize.localize( "activate_language", iso )+": "+item.iso).append(
                                    $(document.createElement("span")).addClass("fa fa-eye")
                                )
                            )
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/lang.php?action=edit&edit='+item.idlang)
                                .attr("title", "Editer "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-lang")
                                .attr("href", "#")
                                .attr("data-delete", item.idlang)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-trash-o")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(
                                    item.idlang
                                ),
                                $(document.createElement("td")).append(item.iso),
                                $(document.createElement("td")).append(item.language)
                                ,
                                $(document.createElement("td")).append(
                                    default_lang
                                )
                                ,
                                active
                                ,
                                edit
                                ,
                                remove
                            )
                        )
                    });
                }else{
                    tbody.append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("typicn minus")
                            )
                        )
                    )
                }
            }
        });
    }

    /**
     * Ajoute une nouvelle langue
     * @param baseadmin
     * @param iso
     */
    function add(baseadmin,iso){
        var formsAddLang = $("#forms_lang_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                iso: {
                    required: true
                },
                language: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/lang.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonLang(baseadmin,iso);
                    }
                });
                return false;
            }
        });
        $('#open-add').on('click',function(){
            $('#forms-add').dialog({
                modal: true,
                resizable: true,
                width: 350,
                height:'auto',
                minHeight: 300,
                buttons: {
                    'Save': function() {
                        //$(this).dialog('close');
                        $("#forms_lang_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddLang.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Edite une langue
     * @param baseadmin
     * @param edit
     */
    function update(baseadmin,edit){
        var formsUpdatelang = $('#forms_lang_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                iso: {
                    required: true
                },
                language: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/lang.php?action=edit&edit='+edit,
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
        $('#forms_lang_edit').formsUpdatelang;
    }

    /**
     * Modifie le statut d'une langue
     * @param baseadmin
     * @param iso
     */
    function updateActive(baseadmin,iso){
        $(document).on("click","a.active-pages",function(event){
            event.preventDefault();
            var id = $(this).data("active");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $("#window-dialog").dialog({
                resizable: false,
                height:180,
                width:350,
                modal: true,
                title: Globalize.localize( "change_of_status", iso ),
                buttons: [
                    {
                        text: "Activer",
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/lang.php?action=edit',
                                typesend: 'post',
                                noticedata:{active_lang:1,idlang:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonLang(baseadmin,iso);
                                }
                            });
                            return false;
                        }
                    },
                    {
                        text: "Désactiver",
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/lang.php?action=edit',
                                typesend: 'post',
                                noticedata:{active_lang:0,idlang:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonLang(baseadmin,iso);
                                }
                            });
                            return false;
                        }
                    }
                ]
            });
        });
    }

    /**
     * Suppression de la langue
     * @param baseadmin
     * @param iso
     */
    function remove(baseadmin,iso){
        $(document).on('click','.delete-lang',function(event){
            event.preventDefault();
            var elem = $(this).data("delete");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $('#window-dialog').dialog({
                modal: true,
                resizable: false,
                height:180,
                width:350,
                title: Globalize.localize( "delete_item", iso ),
                buttons: {
                    'Delete': function() {
                        $(this).dialog('close');
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/lang.php?action=remove',
                            typesend: 'post',
                            noticedata : {delete_lang:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonLang(baseadmin,iso);
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
        runCharts:function(baseadmin){
            graph(baseadmin);
        },
        runList:function(baseadmin,iso){
            jsonLang(baseadmin,iso);
            add(baseadmin,iso);
            updateActive(baseadmin,iso);
            remove(baseadmin,iso);
        },
        runEdit:function(baseadmin,edit){
            update(baseadmin,edit);
        }
    };
})(jQuery);