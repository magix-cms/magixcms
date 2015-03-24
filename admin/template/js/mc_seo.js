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
 * Date: 17/02/13
 * Time: 23:56
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_seo = (function ($, undefined) {
    //Fonction Private
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/seo.php?json_graph=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#graph').html(loader);
            },
            successParams:function(data){
                $('#graph').empty();
                $.nicenotify.initbox(data,{
                    display:false
                });
                var $graph = data;
                //var obj = $.parseJSON($graph);
                //console.log($graph);
                new Morris.Bar({
                    resize: true,
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y'],
                    labels: ['REWRITE'],
                    barSizeRatio: 0.35
                });
            }
        });
    }

    /**
     * Configuration de insertAtCaretPos
     */
    function addTags(){
        $("#add-category").bind("click",function (){
            var myContent = $("#strrewrite").val();
            $("#strrewrite").insertAtCaretPos("[[category]]");
            return false;
        });
        $("#add-subcategory").bind("click",function (){
            var myContent = $("#strrewrite").val();
            $("#strrewrite").insertAtCaretPos("[[subcategory]]");
            return false;
        });
        $("#add-product").bind("click",function (){
            var myContent = $("#strrewrite").val();
            $("#strrewrite").insertAtCaretPos("[[record]]");
            return false;
        });
    }

    /**
     * La liste des métas
     * @param baseadmin
     * @param iso
     * @param getlang
     */
    function jsonList(baseadmin,iso,getlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/seo.php?getlang='+getlang+'&action=list&json_list_seo=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_seo').html(loader);
            },
            successParams:function(j){
                $('#list_seo').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_seo")
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
                            $(document.createElement("th")).append("attribut"),
                            $(document.createElement("th")).append("idmetas"),
                            $(document.createElement("th")).append("metas"),
                            $(document.createElement("th")).append(Globalize.localize( "level", iso )),
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
                tbl.appendTo('#list_seo');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-seo")
                                .attr("href", "#")
                                .attr("data-delete", item.idrewrite)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.idrewrite)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-trash-o")
                            )
                        );
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/seo.php?getlang='+getlang+'&action=edit&edit='+item.idrewrite)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.idrewrite)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-edit")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(item.idrewrite),
                                $(document.createElement("td")).append(item.attribute),
                                $(document.createElement("td")).append(item.idmetas),
                                $(document.createElement("td")).append(item.strrewrite),
                                $(document.createElement("td")).append(item.level),
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
                                $(document.createElement("span")).addClass("fa fa-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            )
                        )
                    )
                }
            }
        });
    }

    /**
     * Ajout d'une nouvelle métas
     * @param baseadmin
     * @param iso
     * @param getlang
     */
    function add(baseadmin,iso,getlang){
        var url = '/'+baseadmin+'/seo.php?getlang='+getlang+'&action=add';
        var formsAdd = $('#forms_seo_add').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                attribute: {
                    required: true
                },
                level: {
                    required: true
                },
                idmetas: {
                    required: true
                },
                strrewrite: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: url,
                    typesend: 'post',
                    idforms: $(form),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        jsonList(baseadmin,iso,getlang);
                    }
                });
                return false;
            }
        });
        $('#forms_seo_add').formsAdd;
    }

    /**
     * Mise à jour d'une métas
     * @param getlang
     * @param edit
     * @param baseadmin
     */
    function update(baseadmin,getlang,edit){
        var url = '/'+baseadmin+'/seo.php?getlang='+getlang+'&action=edit&edit='+edit;
        var formsUpdate = $('#forms_seo_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                attribute: {
                    required: true
                },
                level: {
                    required: true
                },
                idmetas: {
                    required: true
                },
                strrewrite: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: url,
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
        $('#forms_seo_edit').formsUpdate;
    }

    /**
     * Suppression SEO
     * @param baseadmin
     * @param ison
     * @param getlang
     */
    function remove(baseadmin,iso,getlang){
        $(document).on('click','.delete-seo',function(event){
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
                            uri: '/'+baseadmin+'/seo.php?getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delete_metas:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonList(baseadmin,iso,getlang);
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
        runList:function(baseadmin,iso,getlang){
            addTags();
            add(baseadmin,iso,getlang);
            jsonList(baseadmin,iso,getlang);
            remove(baseadmin,iso,getlang);
        },
        runEdit:function(baseadmin,getlang,edit){
            update(baseadmin,getlang,edit);
        }
    };
})(jQuery);