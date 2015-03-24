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
 * Date: 11/01/13
 * Time: 23:44
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_news = (function ($, undefined) {
    //Fonction Private
    /**
     * Statistiques des news
     * @param baseadmin
     */
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/news.php?json_graph=true',
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
                    labels: ['PAGES', 'TAGS']
                });
            }
        });
    }

    /**
     * Retourne un tableau HTML des actualités
     * @param getlang
     * @param baseadmin
     * @param iso
     */
    function jsonPages(baseadmin,iso,getlang,access){
        var getpage = $('.pagination li.active').text();
        if(getpage.length == 0){
            getpage = 1;
        }
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=list&json_list_news=true&page='+getpage,
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_news').html(loader);
            },
            successParams:function(j){
                $('#list_news').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_news")
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
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-picture-o")
                            ),
                            $(document.createElement("th")).append(Globalize.localize( "redactor", iso )),
                            $(document.createElement("th")).append(Globalize.localize( "date_register", iso )),
                            $(document.createElement("th")).append(Globalize.localize( "date_publisher", iso )),
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
                tbl.appendTo('#list_news');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {

                        if(item.n_content != 0){
                            var content = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var content = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.n_image != 0){
                            var image = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var image = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.date_publish != "0000-00-00 00:00:00"){
                            var date_publish = item.date_publish;
                        }else{
                            var date_publish = $(document.createElement("span")).addClass("fa fa-minus");
                        }
                        if(item.published == '0'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idnews)
                                    .attr("title", item.n_title).append(
                                    $(document.createElement("span")).addClass("fa fa-eye-slash")
                                )
                            )
                        }else if(item.published == '1'){
                            var active = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .addClass("active-pages")
                                    .attr("href", "#")
                                    .attr("data-active", item.idnews)
                                    .attr("title", item.n_title).append(
                                    $(document.createElement("span")).addClass("fa fa-eye")
                                )
                            )
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+item.idnews)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.n_title)
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
                                    .addClass("delete-news")
                                    .attr("href", "#")
                                    .attr("data-delete", item.idnews)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.n_title)
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
                                .append(
                                $(document.createElement("td")).append(item.idnews),
                                $(document.createElement("td")).append(
                                    $(document.createElement("a"))
                                        .attr("href", '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+item.idnews)
                                        .attr("title", Globalize.localize( "edit", iso )+": "+item.n_title)
                                        .append(
                                        item.n_title
                                    )
                                ),
                                $(document.createElement("td")).append(content),
                                $(document.createElement("td")).append(image),
                                $(document.createElement("td")).append(item.pseudo),
                                $(document.createElement("td")).append(item.date_register),
                                $(document.createElement("td")).append(date_publish),
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
     * Ajout d'une news
     * @param getlang
     * @param baseadmin
     * @param iso
     */
    function add(baseadmin,iso,getlang,access){
        var formsAddNews = $("#forms_news_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                n_title: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonPages(baseadmin,iso,getlang,access);
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
                minHeight: 210,
                buttons: {
                    'Save': function() {
                        $("#forms_news_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddNews.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Modificatio du statut de l'actualité
     * @param baseadmin
     * @param getlang
     * @param iso
     */
    function updateActive(baseadmin,iso,getlang,access){
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
                                uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit',
                                typesend: 'post',
                                noticedata:{published:1,idnews:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonPages(baseadmin,iso,getlang,access);
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
                                uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit',
                                typesend: 'post',
                                noticedata:{published:0,idnews:id},
                                successParams:function(j){
                                    $.nicenotify.initbox(j,{
                                        display:false
                                    });
                                    jsonPages(baseadmin,iso,getlang,access);
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
     * Suppression de l'actualité
     * @param baseadmin
     * @param getlang
     * @param iso
     */
    function remove(baseadmin,iso,getlang,access){
        $(document).on('click','.delete-news',function(event){
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
                            uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delete_news:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonPages(baseadmin,iso,getlang,access);
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
     *
     * @param getlang
     * @param edit
     * @constructor
     * @param baseadmin
     */
    function JsonUrlPage(baseadmin,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+edit+'&json_urinews=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#newslink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                loader.insertAfter('#newslink');
            },
            successParams:function(j){
                $.nicenotify.initbox(j,{
                    display:false
                });
                $('.loader').remove();
                var uri = j.newslink;
                $("#newslink").show();
                $("#newslink").val(uri);
                $(".post-preview").attr({
                    'data-fancybox-href':uri
                });
            }
        });
    }

    /**
     * Chargement de l'image associée à la news
     * @param getlang
     * @param edit
     * @param baseadmin
     */
    function getImage(baseadmin,getlang,edit){
        if($('#load_news_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+edit+'&ajax_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    )
                    $('#load_news_img #contener_image').html(loader);
                },
                successParams:function(e){
                    $('#load_news_img #contener_image').html(e);
                    if($('.ajax-image').length != 0){
                        Holder.run({
                            themes: {
                                "simple":{
                                    background:"white",
                                    foreground:"gray",
                                    size:12
                                }
                            },
                            images: ".ajax-image"
                        });
                    }
                }
            });

        }
    }

    /**
     * Modification de l'actualité
     * @param baseadmin
     * @param getlang
     * @param edit
     * @param tab
     */
    function update(baseadmin,getlang,edit,tab){
        var url = '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+edit;
        if(tab === 'text'){
            var formsUpdatePages = $('#forms_news_edit').validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    n_title: {
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
            $('#forms_news_edit').formsUpdatePages;
        }else if(tab === 'image'){
            $("#forms_news_edit_image").on('submit',function(){
                $.nicenotify({
                    ntype: "submit",
                    uri: url,
                    typesend: 'post',
                    idforms: $(this),
                    resetform:true,
                    successParams:function(data){
                        $('#n_image:file').val('');
                        $.nicenotify.initbox(data,{
                            display:false
                        });
                        getImage(baseadmin,getlang,edit);
                    }
                });
                return false;
            });
        }
    }

    /**
     * Suppression de l'image d'actualité
     * @param baseadmin
     * @param getlang
     * @param edit
     * @param iso
     */
    function removeImage(baseadmin,iso,getlang,edit){
        $(document).on('click','.delete-image',function(event){
            event.preventDefault();
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
                            uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delete_image:edit},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                getImage(baseadmin,getlang,edit);
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
        runList:function(baseadmin,iso,getlang,access){
            add(baseadmin,iso,getlang,access);
            jsonPages(baseadmin,iso,getlang,access);
            updateActive(baseadmin,iso,getlang,access);
            remove(baseadmin,iso,getlang,access);
        },
        runEdit:function(baseadmin,iso,getlang,edit){
            $('#name_tag').tagsInput({
                defaultText: Globalize.localize( "add_tag", iso ),
                width:'',
                onAddTag:function(tag){
                    if ($(this).tagExist(tag)) {
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+edit,
                            typesend: 'post',
                            idforms: $(this),
                            resetform:false,
                            noticedata:{name_tag:tag},
                            successParams:function(data){
                                $.nicenotify.initbox(data,{
                                    display:false
                                });
                            }
                        });
                        return false;
                    }
                },
                onRemoveTag:function(tag){
                    $.nicenotify({
                        ntype: "ajax",
                        uri: '/'+baseadmin+'/news.php?getlang='+getlang+'&action=edit&edit='+edit,
                        typesend: 'post',
                        idforms: $(this),
                        resetform:false,
                        noticedata:{delete_tag:tag},
                        successParams:function(data){
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                        }
                    });
                    return false;
                }
            });
            JsonUrlPage(baseadmin,getlang,edit);
            getImage(baseadmin,getlang,edit);
            removeImage(baseadmin,iso,getlang,edit);
            update(baseadmin,getlang,edit,'text');
            update(baseadmin,getlang,edit,'image');
        }
    };
})(jQuery);