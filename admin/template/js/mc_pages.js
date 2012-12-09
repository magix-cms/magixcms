/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2012 sc-box.com <support@magix-cms.com>
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
                )
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
                Morris.Bar({
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y', 'z'],
                    labels: ['PARENT', 'CHILD']
                });
            }
        });
    }
    function add(){
        $('#open-add').on('click',function(){
            $('#forms-add').dialog({
                modal: true,
                resizable: true,
                width: 400,
                height:220,
                buttons: {
                    "Save": function () {
                        $(this).dialog("close");
                    },
                    "Cancel": function () {
                        $(this).dialog("close");
                    }
                }
            });
            return false;
        });
    }
    function jsonListParent(idlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/cms.php?getlang='+idlang+'&json_page_p=true',
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
                                    .addClass("icon-remove")
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
                                .attr("href", '/admin/cms.php?getlang='+idlang+'&get_page_p='+item.idpage)
                                .attr("title", "Gestion des pages enfants de : "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-group")
                            )
                        );
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/cms.php?getlang='+getlang+'&movepage='+item.idpage)
                                .attr("title", "Déplacement de la page: "+item.title_page)
                                .append(
                                $(document.createElement("span")).addClass("icon-move")
                            )
                        );
                        if(item.sidebar_page == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", "#")
                                    .attr("data-active", item.idpage)
                                    .attr("title", item.title_page).append(
                                        $(document.createElement("span")).addClass("icon-eye-close")
                                    )
                            )
                        }else if(item.sidebar_page == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
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
                                $(document.createElement("span")).addClass("icon-remove")
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
    function JsonUrlPage(edit){
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
                    href:uri
                });
            }
        });
    }
    return {
        //Fonction Public
        runCharts:function(){
            graph();
        },
        runParents:function (getlang) {
            add();
            jsonListParent(getlang);
        },
        runEdit:function(edit){
            JsonUrlPage(edit);
        }
    };
})(jQuery);