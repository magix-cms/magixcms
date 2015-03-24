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
 * Date: 3/12/12
 * Time: 23:41
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_pages = (function ($, undefined) {
    //Fonction Private
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/cms.php?json_graph=true',
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
                    ykeys: ['y', 'z'],
                    labels: ['PARENT', 'CHILD']
                });
            }
        });
    }

    /**
     * Ajoute une nouvelle page
     * @param baseadmin
     * @param getlang
     * @param getParent
     * @param iso
     */
    function add(baseadmin,iso,getlang,getParent,access){
        if(getParent != 0){
            var idforms = $("#forms_cms_add_child");
            var url = '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=add&get_page_p='+getParent;
        }else{
            var idforms = $("#forms_cms_add_parent");
            var url = '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=add';
        }
        var formsAddPages = idforms.validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                title_page: {
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
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        if(getParent != 0){
                            jsonListChild(baseadmin,iso,getlang,getParent,access)
                        }else{
                            jsonListParent(baseadmin,iso,getlang,access);
                        }
                    }
                });
                return false;
            }
        });
        $('#open-add').on('click',function(){
            $('#forms-add').dialog({
                modal: true,
                resizable: true,
                width: 400,
                height:'auto',
                minHeight: 210,
                buttons: {
                    'Save': function() {
                        idforms.submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddPages.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Modification d'une page
     * @param baseadmin
     * @param getlang
     * @param edit
     */
    function update(baseadmin,getlang,edit){
        var url = '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+edit;
        var formsUpdatePages = $('#forms_cms_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                title_page: {
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
                        JsonUrlPage(baseadmin,getlang,edit);
                    }
                });
                return false;
            }
        });
        $('#forms_cms_edit').formsUpdatePages;
    }

    /**
     * Liste des pages parentes
     * @param baseadmin
     * @param getlang
     */
    function jsonListParent(baseadmin,iso,getlang,access){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list&json_page_p=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_page_p').html(loader);
            },
            successParams:function(j){
                $('#list_page_p').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_pages")
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
                            $(document.createElement("th")).append(Globalize.localize( "heading", iso )),
                            $(document.createElement("th")).append(Globalize.localize( "content", iso )),
                            $(document.createElement("th")).append("Metas Title"),
                            $(document.createElement("th")).append("Metas Description"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-arrows")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-group")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-eye")
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
                tbl.appendTo('#list_page_p');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.content_page != 0){
                            var content_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var content_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.seo_title_page != 0){
                            var seo_title_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var seo_title_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.seo_desc_page != 0){
                            var seo_desc_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var seo_desc_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(access.edit == '1'){
                            var titlePage = $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+item.idpage)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.title_page)
                                .append(
                                    item.title_page
                                );
                        }else{
                            var titlePage = item.title_page
                        }
                        var child = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list&get_page_p='+item.idpage)
                                .attr("title", Globalize.localize( "management_child_pages", iso )+" "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-group")
                            )
                        );
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=move&edit='+item.idpage)
                                .attr("title", Globalize.localize( "move_page", iso )+" "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-arrows")
                            )
                        );
                        if(item.sidebar_page == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                        $(document.createElement("span")).addClass("fa fa-eye-slash")
                                    )
                            )
                        }else if(item.sidebar_page == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                        $(document.createElement("span")).addClass("fa fa-eye")
                                    )
                            )
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+item.idpage)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.title_page)
                                    .append(
                                        $(document.createElement("span")).addClass("fa fa-edit")
                                    )
                            );
                        }else{
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            );
                        }
                        if(access.delete == '1'){
                            var remove = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("delete-pages")
                                    .attr("href", "#")
                                    .attr("data-delete", item.idpage)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.title_page)
                                    .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                            );
                        }else{
                            var remove = $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            );
                        }
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idpage)
                                //.addClass("ui-state-default")
                                .append(
                                $(document.createElement("td")).append(
                                    item.idpage
                                ),
                                $(document.createElement("td")).append(
                                    titlePage
                                ),
                                $(document.createElement("td")).append(content_page),
                                $(document.createElement("td")).append(seo_title_page),
                                $(document.createElement("td")).append(seo_desc_page),
                                move
                                ,
                                child
                                ,
                                active
                                ,
                                edit
                                ,
                                remove
                            )
                        )
                    });
                    $('#table_pages > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_pages > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list',
                                typesend: 'post',
                                noticedata : serial,
                                successParams:function(e){
                                    $.nicenotify.initbox(e,{
                                        display:false
                                    });
                                }
                            });
                        }
                    });
                    $('#table_pages > tbody').disableSelection();
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
     * Retourne l'URL de la page courante
     * @param getlang
     * @param edit
     * @constructor
     * @param baseadmin
     */
    function JsonUrlPage(baseadmin,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+edit+'&json_uricms=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#cmslink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                loader.insertAfter('#cmslink');
            },
            successParams:function(j){
                $.nicenotify.initbox(j,{
                    display:false
                });
                $('.loader').remove();
                var uri = j.cmsuri;
                $("#cmslink").show();
                $("#cmslink").val(uri);
                $(".post-preview").attr({
                    'data-fancybox-href':uri
                });
            }
        });
    }

    /**
     * Retourne la liste des pages enfants
     * @param getlang
     * @param getParent
     * @param baseadmin
     */
    function jsonListChild(baseadmin,iso,getlang,getParent,access){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list&get_page_p='+getParent+'&json_child_p=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_child').html(loader);
            },
            successParams:function(j){
                $('#list_child').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_pages")
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
                            $(document.createElement("th")).append(Globalize.localize( "heading", iso )),
                            $(document.createElement("th")).append(Globalize.localize( "content", iso )),
                            $(document.createElement("th")).append("Metas Title"),
                            $(document.createElement("th")).append("Metas Description"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-arrows")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-eye")
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
                tbl.appendTo('#list_child');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(access.edit == '1'){
                            var titlePage = $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+item.idpage)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.title_page)
                                .append(
                                    item.title_page
                                );
                        }else{
                            var titlePage = item.title_page
                        }
                        if(item.content_page != 0){
                            var content_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var content_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.seo_title_page != 0){
                            var seo_title_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var seo_title_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.seo_desc_page != 0){
                            var seo_desc_page = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var seo_desc_page = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=move&edit='+item.idpage)
                                .attr("title", Globalize.localize( "move_page", iso )+" :"+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-arrows")
                            )
                        );
                        if(item.sidebar_page == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                    $(document.createElement("span")).addClass("fa fa-eye-slash")
                                )
                            )
                        }else if(item.sidebar_page == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                    $(document.createElement("span")).addClass("fa fa-eye")
                                )
                            )
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+item.idpage)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.title_page)
                                    .append(
                                    $(document.createElement("span")).addClass("fa fa-edit")
                                )
                            );
                        }else{
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            );
                        }
                        if(access.delete == '1'){
                            var remove = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("delete-pages")
                                    .attr("href", "#")
                                    .attr("data-delete", item.idpage)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.title_page)
                                    .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                            );
                        }else{
                            var remove = $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            );
                        }
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idpage)
                                //.addClass("ui-state-default")
                                .append(
                                $(document.createElement("td")).append(
                                    item.idpage
                                ),
                                $(document.createElement("td")).append(
                                    titlePage
                                ),
                                $(document.createElement("td")).append(content_page),
                                $(document.createElement("td")).append(seo_title_page),
                                $(document.createElement("td")).append(seo_desc_page),
                                move
                                ,
                                active
                                ,
                                edit
                                ,
                                remove
                            )
                        )
                    });
                    $('#table_pages > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_pages > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list',
                                typesend: 'post',
                                noticedata : serial,
                                successParams:function(e){
                                    $.nicenotify.initbox(e,{
                                        display:false
                                    });
                                }
                            });
                        }
                    });
                    $('#table_pages > tbody').disableSelection();
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
     * Suppression de la page
     * @param getlang
     * @param getParent
     * @param baseadmin
     * @param iso
     */
    function remove(baseadmin,iso,getlang,getParent,access){
        $(document).on('click','.delete-pages',function(event){
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
                            uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delpage:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                if(getParent != 0){
                                    jsonListChild(baseadmin,iso,getlang,getParent,access);
                                }else{
                                    jsonListParent(baseadmin,iso,getlang,access);
                                }
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

    /**
     * Active la page
     * @param getlang
     * @param getParent
     * @param baseadmin
     * @param iso
     */
    function updateActive(baseadmin,iso,getlang,getParent,access){
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
                        text: Globalize.localize( "activate", iso ),
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list',
                                typesend: 'post',
                                noticedata:{sidebar_page:1,idpage:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    if(getParent != 0){
                                        jsonListChild(baseadmin,iso,getlang,getParent,access);
                                    }else{
                                        jsonListParent(baseadmin,iso,getlang,access);
                                    }
                                }
                            });
                            return false;
                        }
                    },
                    {
                        text: Globalize.localize( "deactivate", iso ),
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=list',
                                typesend: 'post',
                                noticedata:{sidebar_page:0,idpage:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    if(getParent != 0){
                                        jsonListChild(baseadmin,iso,getlang,getParent,access);
                                    }else{
                                        jsonListParent(baseadmin,iso,getlang,access);
                                    }
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
     * Déplacement de la page
     * @param getlang
     * @param edit
     * @param baseadmin
     */
    function move(baseadmin,getlang,edit){
        var url = '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=move&edit='+edit;
        $('#forms_cms_move').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                title_page: {
                    required: true,
                    minlength: 2
                },
                idlang : {
                    required: true
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
                        JsonUrlPage(baseadmin,getlang,edit);
                    }
                });
                return false;
            }
        });
    }

    /**
     * Autocomplete pour les pages
     * @param baseadmin
     * @param getlang
     */
    function autoCompleteSearch(baseadmin,getlang){
        $( "#title_search" ).autocomplete({
            minLength: 2,
            source: function(req, add){
                //pass request to server
                $.ajax({
                    url:'/'+baseadmin+'/cms.php?getlang='+getlang+'&callback=?&action=list',
                    type:"get",
                    dataType: 'json',
                    data: 'title_search='+req.term,
                    async: true,
                    cache: true,
                    success: function(data){
                        add($.map(data, function(item) {
                            return {
                                value : item.title_page,
                                url : '/'+baseadmin+'/cms.php?getlang='+getlang+'&action=edit&edit='+item.idpage
                            }
                        }));
                    }
                });
            },
            focus : function(event, ui) {
                $(this).val(ui.item.title_page);
                return false;
            },
            select : function(event, ui) {
                window.location.href = ui.item.url;
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>").data("ui-item.autocomplete", item).append(
                '<a href="'+item.url+'">' + item.value + '</span></a>')
                .appendTo(ul.addClass('list-row'));
        };
    }
    return {
        //Fonction Public
        runCharts:function(baseadmin){
            graph(baseadmin);
        },
        runParents:function (baseadmin,iso,getlang,access) {
            add(baseadmin,iso,getlang,0,access);
            jsonListParent(baseadmin,iso,getlang,access);
            updateActive(baseadmin,iso,getlang,0,access);
            remove(baseadmin,iso,getlang,0,access);
            autoCompleteSearch(baseadmin,getlang);
        },
        runChild:function(baseadmin,iso,getlang,getParent,access){
            jsonListChild(baseadmin,iso,getlang,getParent,access);
            add(baseadmin,iso,getlang,getParent,access);
            updateActive(baseadmin,iso,getlang,getParent,access);
            remove(baseadmin,iso,getlang,getParent,access);
            autoCompleteSearch(baseadmin,getlang);
        },
        runEdit:function(baseadmin,getlang,edit){
            JsonUrlPage(baseadmin,getlang,edit);
            update(baseadmin,getlang,edit);
            autoCompleteSearch(baseadmin,getlang);
        },
        runMove:function(baseadmin,getlang,edit){
            move(baseadmin,getlang,edit);
            autoCompleteSearch(baseadmin,getlang);
        }
    };
})(jQuery);