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
 * Date: 22/12/12
 * Time: 02:00
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_home = (function ($, undefined) {
    //Fonction Private
    function graph(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/home.php?json_graph=true',
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
                new Morris.Bar({
                    element: 'graph',
                    data: $graph,
                    xkey: 'x',
                    ykeys: ['y'],
                    labels: ['HOME'],
                    barSizeRatio: 0.25
                });
            }
        });
    }
    function jsonHome(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/home.php?action=list&json_list_home=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_home').html(loader);
            },
            successParams:function(j){
                $('#list_home').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_home")
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
                            $(document.createElement("th")).append("ISO"),
                            $(document.createElement("th")).append("subject"),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append("pseudo"),
                            $(document.createElement("th")).append("Metas Title"),
                            $(document.createElement("th")).append("Metas Description"),
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
                tbl.appendTo('#list_home');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {

                        if(item.content != 0){
                            var content = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var content = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.metatitle != 0){
                            var metatitle = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var metatitle = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.metadescription != 0){
                            var metadescription = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var metadescription = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/home.php?action=edit&edit='+item.idhome)
                                .attr("title", "Editer "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-home")
                                .attr("href", "#")
                                .attr("data-delete", item.idhome)
                                .attr("title", "Supprimer "+": "+item.iso)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(item.idhome),
                                $(document.createElement("td")).append(item.iso),
                                $(document.createElement("td")).append(item.subject),
                                $(document.createElement("td")).append(content),
                                $(document.createElement("td")).append(item.pseudo),
                                $(document.createElement("td")).append(metatitle),
                                $(document.createElement("td")).append(metadescription)
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
    function add(){
        var formsAddHome = $("#forms_home_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                subject: {
                    required: true,
                    minlength: 2
                },
                idlang: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/home.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        //jsonLang();
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
                        $("#forms_home_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddHome.resetForm();
                    }
                }
            });
            return false;
        });
    }
    function update(edit){
        var url = '/admin/home.php?action=edit&edit='+edit;
        var formsUpdatePages = $('#forms_home_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                subject: {
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
        $('#forms_home_edit').formsUpdatePages;
    }
    return {
        //Fonction Public        
        runCharts:function(){
            graph();
        },
        runList:function(){
            jsonHome();
            add();
        },
        runEdit:function(edit){
            update(edit);
        }
    };
})(jQuery);