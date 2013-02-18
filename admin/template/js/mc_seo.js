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
    function jsonList(getlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/seo.php?getlang='+getlang+'&action=list&json_list_seo=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("attribut"),
                            $(document.createElement("th")).append("idmetas"),
                            $(document.createElement("th")).append("metas"),
                            $(document.createElement("th")).append("niveau"),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-edit")
                            )
                            ,
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                                .attr("title", "Supprimer "+": "+item.idrewrite)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/seo.php?getlang='+getlang+'&action=edit&edit='+item.idrewrite)
                                .attr("title", "Editer "+item.idrewrite)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
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
                                $(document.createElement("span")).addClass("icon-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("icon-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("icon-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("icon-minus")
                            ),
                            $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("icon-minus")
                            )
                        )
                    )
                }
            }
        });
    }
    function add(getlang){
        var url = '/admin/seo.php?getlang='+getlang+'&action=add';
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
                        jsonList(getlang);
                    }
                });
                return false;
            }
        });
        $('#forms_seo_add').formsAdd;
    }
    function update(getlang,edit){
        var url = '/admin/seo.php?getlang='+getlang+'&action=edit&edit='+edit;
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
    return {
        //Fonction Public        
        run:function () {
        },
        runList:function(getlang){
            addTags();
            add(getlang);
            jsonList(getlang);
        },
        runEdit:function(getlang,edit){
            update(getlang,edit);
        }
    };
})(jQuery);