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
    function graph(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/cms.php?json_graph=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y', 'z'],
                    labels: ['PARENT', 'CHILD']
                });
            }
        });
    }
    function add(getlang,getParent){
        if(getParent != 0){
            var idforms = $("#forms_cms_add_child");
            var url = '/admin/cms.php?getlang='+getlang+'&get_page_p='+getParent;
        }else{
            var idforms = $("#forms_cms_add_parent");
            var url = '/admin/cms.php?getlang='+getlang;
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
                        jsonListParent(getlang);
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
    function update(getlang,edit){
        var url = '/admin/cms.php?getlang='+getlang+'&edit='+edit;
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
                        JsonUrlPage(getlang,edit);
                    }
                });
                return false;
            }
        });
        $('#forms_cms_edit').formsUpdatePages;
    }
    function jsonListParent(getlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/cms.php?getlang='+getlang+'&json_page_p=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Title"),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append("Metas Title"),
                            $(document.createElement("th")).append("Metas Description"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-move")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-group")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-eye-open")
                            ),
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
                tbl.appendTo('#list_page_p');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.content_page != 0){
                            var content_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var content_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.seo_title_page != 0){
                            var seo_title_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var seo_title_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.seo_desc_page != 0){
                            var seo_desc_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var seo_desc_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var child = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&get_page_p='+item.idpage)
                                .attr("title", "Gestion des pages enfants de : "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-group")
                            )
                        );
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&move='+item.idpage)
                                .attr("title", "Déplacement de la page: "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-move")
                            )
                        );
                        if(item.sidebar_page == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                        $(document.createElement("span")).addClass("icon-eye-close")
                                    )
                            )
                        }else if(item.sidebar_page == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                        $(document.createElement("span")).addClass("icon-eye-open")
                                    )
                            )
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&edit='+item.idpage)
                                .attr("title", "Editer "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idpage)
                                .attr("title", "Supprimer "+": "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idpage)
                                //.addClass("ui-state-default")
                                .append(
                                $(document.createElement("td")).append(
                                    item.idpage
                                ),
                                $(document.createElement("td")).append(item.title_page),
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
                                uri: '/admin/cms.php?getlang='+getlang,
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
    function JsonUrlPage(getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/cms.php?getlang='+getlang+'&edit='+edit+'&json_uricms=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#cmslink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
    function jsonListChild(getlang,getParent){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/cms.php?getlang='+getlang+'&get_page_p='+getParent+'&json_child_p=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Title"),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append("Metas Title"),
                            $(document.createElement("th")).append("Metas Description"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-move")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-eye-open")
                            ),
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
                tbl.appendTo('#list_child');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.content_page != 0){
                            var content_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var content_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.seo_title_page != 0){
                            var seo_title_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var seo_title_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.seo_desc_page != 0){
                            var seo_desc_page = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var seo_desc_page = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&move='+item.idpage)
                                .attr("title", "Déplacement de la page: "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-move")
                            )
                        );
                        if(item.sidebar_page == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                    $(document.createElement("span")).addClass("icon-eye-close")
                                )
                            )
                        }else if(item.sidebar_page == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                    $(document.createElement("span")).addClass("icon-eye-open")
                                )
                            )
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&edit='+item.idpage)
                                .attr("title", "Editer "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idpage)
                                .attr("title", "Supprimer "+": "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idpage)
                                //.addClass("ui-state-default")
                                .append(
                                $(document.createElement("td")).append(
                                    item.idpage
                                ),
                                $(document.createElement("td")).append(item.title_page),
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
                                uri: '/admin/cms.php?getlang='+getlang,
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
    function remove(getlang,getParent){
        $(document).on('click','.delete-pages',function(event){
            event.preventDefault();
            var elem = $(this).data("delete");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $('#window-dialog').dialog({
                modal: true,
                resizable: false,
                height:180,
                width:350,
                title:"Supprimer cet élément",
                buttons: {
                    'Delete': function() {
                        $(this).dialog('close');
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/admin/cms.php?getlang='+getlang,
                            typesend: 'post',
                            noticedata : {delpage:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                if(getParent != 0){
                                    jsonListChild(getlang,getParent);
                                }else{
                                    jsonListParent(getlang);
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
    function updateActive(getlang,getParent){
        $(document).on("click","a.active-pages",function(event){
            event.preventDefault();
            var id = $(this).data("active");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $("#window-dialog").dialog({
                resizable: false,
                height:180,
                width:350,
                modal: true,
                title: "Changer le status d'une page",
                buttons: [
                    {
                        text: "Activer",
                        click: function() {
                            $(this).dialog('close');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/admin/cms.php?getlang='+getlang,
                                typesend: 'post',
                                noticedata:{sidebar_page:1,idpage:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    if(getParent != 0){
                                        jsonListChild(getlang,getParent);
                                    }else{
                                        jsonListParent(getlang);
                                    }
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
                                uri: '/admin/cms.php?getlang='+getlang,
                                typesend: 'post',
                                noticedata:{sidebar_page:0,idpage:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    if(getParent != 0){
                                        jsonListChild(getlang,getParent);
                                    }else{
                                        jsonListParent(getlang);
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
    function move(getlang,edit){
        var url = '/admin/cms.php?getlang='+getlang+'&edit='+edit;
        var formsPages = $('#forms_cms_move').validate({
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
                        JsonUrlPage(getlang,edit);
                    }
                });
                return false;
            }
        });
        $('#forms_cms_edit').formsUpdatePages;
    }
    function autoCompleteSearch(getlang){
        $( "#title_search" ).autocomplete({
            minLength: 2,
            source: function(req, add){
                //pass request to server
                $.ajax({
                    url:'/admin/cms.php?getlang='+getlang+'&callback=?',
                    type:"get",
                    dataType: 'json',
                    data: 'title_search='+req.term,
                    async: true,
                    cache: true,
                    success: function(data){
                        add($.map(data, function(item) {
                            return {
                                value : item.title_page,
                                url : '/admin/cms.php?getlang='+getlang+'&edit='+item.idpage
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
        runCharts:function(){
            graph();
        },
        runParents:function (getlang) {
            add(getlang,0);
            jsonListParent(getlang);
            updateActive(getlang,0);
            remove(getlang,0);
            autoCompleteSearch(getlang);
        },
        runChild:function(getlang,getParent){
            jsonListChild(getlang,getParent);
            add(getlang,getParent);
            updateActive(getlang,getParent);
            remove(getlang,getParent);
            autoCompleteSearch(getlang);
        },
        runEdit:function(getlang,edit){
            JsonUrlPage(getlang,edit);
            update(getlang,edit);
            autoCompleteSearch(getlang);
        }
    };
})(jQuery);