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
 * Date: 25/01/13
 * Time: 21:31
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_catalog = (function ($, undefined) {
    //Fonction Private
    /**
     * Création du graphique de statistique
     */
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?json_graph=true',
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
                    ykeys: ['y', 'z', 'a'],
                    labels: ['CATEGORY', 'SUBCATEGORY', 'CATALOG']
                });
            }
        });
    }

    /**
     * Retourne au format JSON les catégories recherchés
     * @param section
     * @param getlang
     */
    function autoCompleteCategory(baseadmin,section,getlang){
        $( "#name_category" ).autocomplete({
            minLength: 2,
            source: function(req, add){
                //pass request to server
                $.ajax({
                    url:'/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&callback=?&action=list',
                    type:"get",
                    dataType: 'json',
                    data: 'name_category='+req.term,
                    async: true,
                    cache: true,
                    success: function(data){
                        add($.map(data, function(item) {
                            return {
                                value : item.clibelle,
                                url : '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idclc
                            }
                        }));
                    }
                });
            },
            focus : function(event, ui) {
                $(this).val(ui.item.clibelle);
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

    /**
     * Retourne la liste des catégories dans la langue
     * @param section
     * @param getlang
     */
    function jsonListCategory(baseadmin,iso,section,getlang,access){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=list&json_list_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_category').html(loader);
            },
            successParams:function(j){
                $('#list_category').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_category")
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
                                        $(document.createElement("th")).append(Globalize.localize( "name", iso )),
                                        $(document.createElement("th")).append(Globalize.localize( "content", iso )),
                                        $(document.createElement("th")).append(
                                            $(document.createElement("span"))
                                                .addClass("fa fa-picture-o")
                                        ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-edit")
                                            ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_category');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.c_content != 0){
                            var c_content = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var c_content = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idclc)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.clibelle)
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
                                    .attr("data-delete", item.idclc)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.clibelle)
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
                                .attr("id","order_pages_"+item.idclc)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idclc
                                    ),
                                    $(document.createElement("td")).append(
                                        $(document.createElement("a"))
                                            .attr("href", '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idclc)
                                            .attr("title", Globalize.localize( "edit", iso )+": "+item.clibelle)
                                            .append(item.clibelle)
                                    ),
                                    $(document.createElement("td")).append(c_content),
                                    $(document.createElement("td")).append(img),
                                    edit
                                    ,
                                    remove
                                )
                        )
                    });
                    $('#table_category > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_category > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit',
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
                    $('#table_category > tbody').disableSelection();
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Ajouter une catégorie
     * @param section
     * @param getlang
     */
    function addCategory(baseadmin,iso,section,getlang,access){
        var formsAdd = $("#forms_catalog_category_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                clibelle: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListCategory(baseadmin,iso,section,getlang,access);
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
                        $("#forms_catalog_category_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAdd.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Suppression de la catégorie
     * @param section
     * @param getlang
     */
    function removeCategory(baseadmin,iso,section,getlang,access){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delete_category:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonListCategory(baseadmin,iso,section,getlang,access);
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
     * Retourne l'url de la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @constructor
     */
    function JsonUrlCategory(baseadmin,section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&json_uri_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#categorylink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                loader.insertAfter('#categorylink');
            },
            successParams:function(j){
                $.nicenotify.initbox(j,{
                    display:false
                });
                $('.loader').remove();
                var uri = j.categorylink;
                $("#categorylink").show();
                $("#categorylink").val(uri);
            }
        });
    }

    /**
     * Mise à jour d'une catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function updateCategory(baseadmin,section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_category_edit').on('submit',function(){
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(this),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        JsonUrlCategory(baseadmin,section,getlang,edit)
                    }
                });
                return false;
            });
        }else if(tab === 'image'){
            $("#forms_catalog_category_image").validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    img_c: {
                        required: true,
                        minlength: 1,
                        accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#img_c:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageCategory(baseadmin,section,getlang,edit);
                        }
                    });
                    return false;
                }
            });
        }
    }

    /**
     * Chargement de l'image associée à la catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function getImageCategory(baseadmin,section,getlang,edit){
        if($('#load_catalog_category_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_category_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    )
                    $('#load_catalog_category_img #contener_image').html(loader);
                },
                successParams:function(e){
                    $('#load_catalog_category_img #contener_image').html(e);
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
     * Retourne la liste des produits dans la catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function jsonListCategoryProduct(baseadmin,iso,section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product&json_category_product=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_category_product').html(loader);
            },
            successParams:function(j){
                $('#list_category_product').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_category_product")
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
                                        $(document.createElement("th")).append(Globalize.localize( "name", iso )),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_category_product');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {

                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idproduct)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.titlecatalog)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idproduct)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idproduct
                                    ),
                                    $(document.createElement("td")).append(item.titlecatalog)
                                    ,
                                    remove
                                )
                        )
                    });
                    $('#table_category_product > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_category_product > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product',
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
                    $('#table_category_product > tbody').disableSelection();
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Suppression du produit dans la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeCategoryProduct(baseadmin,iso,section,getlang,edit,tab){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'product'){
                                    jsonListCategoryProduct(baseadmin,iso,section,getlang,edit);
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
    //SOUS CATEGORIE
    /**
     * Retourne la liste des sous catégories de la catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function jsonListSubCategory(baseadmin,iso,section,getlang,edit,access){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat&json_list_subcategory=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_subcategory').html(loader);
            },
            successParams:function(j){
                $('#list_subcategory').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_subcategory")
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
                                        $(document.createElement("th")).append(Globalize.localize( "name", iso )),
                                        $(document.createElement("th")).append(Globalize.localize( "content", iso )),
                                        $(document.createElement("th")).append(
                                            $(document.createElement("span"))
                                                .addClass("fa fa-picture-o")
                                        ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-edit")
                                            ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_subcategory');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.s_content != 0){
                            var s_content = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var s_content = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/catalog.php?section=sub'+section+'&getlang='+getlang+'&action=edit&edit='+item.idcls)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.slibelle)
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
                                    .attr("data-delete", item.idcls)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.slibelle)
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
                                .attr("id","order_pages_"+item.idcls)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idcls
                                    ),
                                    $(document.createElement("td")).append(
                                        $(document.createElement("a"))
                                            .attr("href", '/'+baseadmin+'/catalog.php?section=sub'+section+'&getlang='+getlang+'&action=edit&edit='+item.idcls)
                                            .attr("title", Globalize.localize( "edit", iso )+": "+item.slibelle)
                                            .append(item.slibelle)
                                    ),
                                    $(document.createElement("td")).append(s_content),
                                    $(document.createElement("td")).append(img),
                                    edit
                                    ,
                                    remove
                                )
                        )
                    });
                    $('#table_subcategory > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_subcategory > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat',
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
                    $('#table_subcategory > tbody').disableSelection();
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Ajouter une sous catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function addSubCategory(baseadmin,iso,section,getlang,edit,access){
        var formsAdd = $("#forms_catalog_subcategory_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                slibelle: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListSubCategory(baseadmin,iso,section,getlang,edit,access);
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
                        $("#forms_catalog_subcategory_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAdd.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Suppression d'une sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeSubCategory(baseadmin,iso,section,getlang,edit,tab,access){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_subcategory:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonListSubCategory(baseadmin,iso,section,getlang,edit,access);
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
     * Retourne l'url de la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @constructor
     */
    function JsonUrlSubCategory(baseadmin,section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&json_uri_subcategory=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#subcategorylink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                loader.insertAfter('#subcategorylink');
            },
            successParams:function(j){
                $.nicenotify.initbox(j,{
                    display:false
                });
                $('.loader').remove();
                var uri = j.subcategorylink;
                $("#subcategorylink").show();
                $("#subcategorylink").val(uri);
            }
        });
    }

    /**
     * Mise à jour de la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function updateSubCategory(baseadmin,section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_subcategory_edit').on('submit',function(event){
                event.preventDefault();
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(this),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        JsonUrlSubCategory(baseadmin,section,getlang,edit)
                    }
                });
                return false;
            });
        }else if(tab === 'image'){
            $("#forms_catalog_subcategory_image").validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    img_s: {
                        required: true,
                        minlength: 1,
                        accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#img_s:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageSubCategory(baseadmin,section,getlang,edit);
                        }
                    });
                    return false;
                }
            });
        }
    }

    /**
     * Chargement de l'image associée à la catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function getImageSubCategory(baseadmin,section,getlang,edit){
        if($('#load_catalog_subcategory_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_subcategory_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    )
                    $('#load_catalog_subcategory_img #contener_image').html(loader);
                },
                successParams:function(e){
                    $('#load_catalog_subcategory_img #contener_image').html(e);
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
     * Retourne la liste des produits dans la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function jsonListSubCategoryProduct(baseadmin,iso,section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product&json_subcategory_product=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_subcategory_product').html(loader);
            },
            successParams:function(j){
                $('#list_subcategory_product').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_subcategory_product")
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
                                        $(document.createElement("th")).append(Globalize.localize( "name", iso )),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_subcategory_product');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/catalog.php?section=product&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.titlecatalog)
                                .append(
                                $(document.createElement("td")).append(item.titlecatalog)
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idproduct)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.titlecatalog)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idproduct)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idproduct
                                    ),
                                    edit
                                    ,
                                    remove
                                )
                        )
                    });
                    $('#table_subcategory_product > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_subcategory_product > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product',
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
                    $('#table_subcategory_product > tbody').disableSelection();
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Suppression du produit dans la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeSubCategoryProduct(baseadmin,iso,section,getlang,edit,tab){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'product'){
                                    jsonListSubCategoryProduct(baseadmin,iso,section,getlang,edit);
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

    //PRODUCT
    /**
     * Autocomplete des produits
     * @param section
     * @param getlang
     */
    function autoCompleteCatalog(baseadmin,section,getlang){
        $( "#name_product" ).autocomplete({
            minLength: 2,
            source: function(req, add){
                //pass request to server
                $.ajax({
                    url:'/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&callback=?&action=list',
                    type:"get",
                    dataType: 'json',
                    data: 'name_product='+req.term,
                    async: true,
                    cache: true,
                    success: function(data){
                        add($.map(data, function(item) {
                            return {
                                value : item.titlecatalog,
                                url : '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idcatalog
                            }
                        }));
                    }
                });
            },
            focus : function(event, ui) {
                $(this).val(ui.item.titlecatalog);
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

    /**
     * Ajouter un produit
     * @param section
     * @param getlang
     */
    function addProduct(baseadmin,iso,section,getlang,access,getpage){
        var formsAdd = $("#forms_catalog_product_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                titlecatalog: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListProduct(baseadmin,iso,section,getlang,access,getpage);
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
                        $("#forms_catalog_product_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAdd.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Retourne la liste de produits dans la langue
     * @param section
     * @param getlang
     */
    function jsonListProduct(baseadmin,iso,section,getlang,access,getpage){
        /*var getpage = $('.pagination li.active').text();
        if(getpage.length == 0){
            getpage = 1;
        }*/
        if(getpage == ""){
            getpage = 1;
        }
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=list&json_listing_product=true&page='+getpage,
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                )
                $('#list_catalog_product').html(loader);
            },
            successParams:function(j){
                $('#list_catalog_product').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_product")
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
                                        $(document.createElement("th")).append(Globalize.localize( "name", iso )),
                                        $(document.createElement("th")).append(
                                            $(document.createElement("span"))
                                                .addClass("fa fa-picture-o")
                                        ),
                                        $(document.createElement("th")).append(
                                            $(document.createElement("span"))
                                                .addClass("fa fa-money")
                                        ),
                                        $(document.createElement("th")).append(Globalize.localize( "content", iso )),
                                        $(document.createElement("th")).append("Rédacteur"),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-copy")
                                            ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-arrows")
                                            ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-edit")
                                            ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_catalog_product');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.content != 0){
                            var content = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var content = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("fa fa-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("fa fa-warning");
                        }
                        if(access.edit == '1'){
                            var edit = $(document.createElement("td")).append(
                                $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.titlecatalog)
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
                                    .attr("data-delete", item.idcatalog)
                                    .attr("title", Globalize.localize( "remove", iso )+": "+item.titlecatalog)
                                    .append(
                                        $(document.createElement("span")).addClass("fa fa-trash-o")
                                    )
                            );
                        }else{
                            var remove = $(document.createElement("td")).append(
                                $(document.createElement("span")).addClass("fa fa-minus")
                            );
                        }
                        var copy = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("copy-pages")
                                .attr("href", "#")
                                .attr("data-copy", item.idcatalog)
                                .attr("title", Globalize.localize( "copy", iso )+": "+item.titlecatalog)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-copy")
                                )
                        );
                        var move = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("move-pages")
                                .attr("href", "#")
                                .attr("data-move", item.idcatalog)
                                .attr("title", Globalize.localize( "move", iso )+": "+item.titlecatalog)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-arrows")
                                )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idcatalog
                                    ),
                                    $(document.createElement("td")).append(
                                        $(document.createElement("a"))
                                            .attr("href", '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                            .attr("title", Globalize.localize( "edit", iso )+": "+item.titlecatalog)
                                            .append(item.titlecatalog)
                                    ),
                                    $(document.createElement("td")).append(img),
                                    $(document.createElement("td")).append(item.price),
                                    $(document.createElement("td")).append(content),
                                    $(document.createElement("td")).append(item.pseudo),
                                    copy
                                    ,
                                    move
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Mise à jour de la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function updateProduct(baseadmin,iso,section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_product_edit').on('submit',function(event){
                event.preventDefault();
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
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
        }else if(tab === 'image'){
            $("#forms_catalog_product_image").validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    imgcatalog: {
                        required: true,
                        minlength: 1,
                        accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#imgcatalog:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageProduct(baseadmin,section,getlang,edit);
                        }
                    });
                    return false;
                }
            });
        }else if(tab === 'category'){
            $("#forms_catalog_product_category").validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    idclc: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=category',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:false,
                        successParams:function(data){
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            jsonListProductCategory(baseadmin,iso,section,getlang,edit);
                        }
                    });
                    return false;
                }
            });
        }else if(tab === 'galery'){
            $("#forms_catalog_product_galery").validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    imgcatalog: {
                        required: true,
                        minlength: 1,
                        accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=galery',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#imgcatalog:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            loadListGalery(baseadmin,section,getlang,edit,"galery");
                        }
                    });
                    return false;
                }
            });
        }
    }

    /**
     * Copie un produit
     * @param section
     * @param getlang
     */
    function copyProduct(baseadmin,iso,section,getlang,access,getpage){
        $(document).on('click','.copy-pages',function(event){
            event.preventDefault();
            var elem = $(this).data("copy");
            $("#window-dialog:ui-dialog").dialog( "destroy" );
            $('#window-dialog').dialog({
                modal: true,
                resizable: false,
                height:100,
                width:350,
                title:"Copier cet élément",
                buttons: {
                    'Copy': function() {
                        $(this).dialog('close');
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=copy',
                            typesend: 'post',
                            noticedata : {copy:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                jsonListProduct(baseadmin,iso,section,getlang,access,getpage);
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
     * Déplacement d'un produit dans une autre langue
     * @param section
     * @param getlang
     */
    function moveProduct(baseadmin,iso,section,getlang,access,getpage){
        $(document).on('click','.move-pages',function(event){
            event.preventDefault();
            var elem = $(this).data("move");
            $("#forms-move:ui-dialog").dialog( "destroy" );
            $('#forms-move').dialog({
                modal: true,
                resizable: false,
                height:220,
                width:350,
                title:"Déplacer cet élément",
                buttons: {
                    'Copy': function() {
                        $(this).dialog('close');
                        $.nicenotify({
                            ntype: "ajax",
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=move',
                            typesend: 'post',
                            noticedata : {move:elem,idlang:$('#idlang').val()},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                jsonListProduct(baseadmin,iso,section,getlang,access,getpage);
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
     * Suppression d'un produit et de ses dépendances
     * @param section
     * @param getlang
     */
    function removeProduct(baseadmin,iso,section,getlang,access,getpage){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=remove',
                            typesend: 'post',
                            noticedata : {delete_catalog:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                jsonListProduct(baseadmin,iso,section,getlang,access,getpage);
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
     * Chargement de l'image associée à la catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function getImageProduct(baseadmin,section,getlang,edit){
        if($('#load_catalog_product_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_product_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    )
                    $('#load_catalog_product_img #contener_image').html(loader);
                },
                successParams:function(e){
                    $('#load_catalog_product_img #contener_image').html(e);
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
     * Supprime l'image de l'élément de section
     * @param section
     * @param getlang
     * @param edit
     */
    function removeImage(baseadmin,section,getlang,edit){
        $(document).on('click','.delete-image',function(event){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                            typesend: 'post',
                            noticedata : {delete_image:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(section === 'category'){
                                    getImageCategory(baseadmin,section,getlang,edit);
                                }else if(section === 'subcategory'){
                                    getImageSubCategory(baseadmin,section,getlang,edit);
                                }else if(section === 'product'){
                                    getImageProduct(baseadmin,section,getlang,edit);
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
     * Retourne la liste des catégories dans le produits
     * @param section
     * @param getlang
     * @param edit
     */
    function jsonListProductCategory(baseadmin,iso,section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=category&json_product_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_product_category').html(loader);
            },
            successParams:function(j){
                $('#list_product_category').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_product_category")
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
                                        $(document.createElement("th")).append(
                                            Globalize.localize( "category", iso )
                                        ),
                                        $(document.createElement("th")).append(
                                            Globalize.localize( "subcategory", iso )
                                        ),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_product_category');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.slibelle != null){
                            var slibelle = item.slibelle;
                            var remove_slibelle = ' '+item.slibelle;
                        }else{
                            var slibelle = $(document.createElement("span")).addClass("fa fa-minus");
                            var remove_slibelle = '';
                        }
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idproduct)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.clibelle+remove_slibelle)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idproduct)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idproduct
                                    ),
                                    $(document.createElement("td")).append(item.clibelle),
                                    $(document.createElement("td")).append(slibelle)
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
                                )
                            )
                    )
                }
            }
        });
    }

    /**
     * Suppression d'une catégorie pour le produit
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeProductRel(baseadmin,iso,section,getlang,edit,tab){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'category'){
                                    jsonListProductCategory(baseadmin,iso,section,getlang,edit);
                                }else if(tab === 'product'){
                                    jsonListProductRel(baseadmin,iso,section,getlang,edit,'product');
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
     * Liste des images de la galerie produit
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function loadListGalery(baseadmin,section,getlang,edit,tab){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab+'&json_list_galery=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#load_catalog_product_galery').html(loader);
            },
            successParams:function(j){
                $('#load_catalog_product_galery').empty();
                var div = $(document.createElement('div'))
                        .attr('id','list_product_galery')
                        .addClass('row')
                ;

                $.nicenotify.initbox(j,{
                    display:false
                });
                if($.isEmptyObject(j) === false){
                    setContener = $(document.createElement('ul'))
                        .addClass('list-unstyled list-inline list-picture');
                }else{
                    setContener = $(document.createElement('div'));
                }
                div.append(
                    $(document.createElement('div'))
                        .addClass('col-md-12').append(
                            setContener
                        )
                    );

                div.appendTo('#load_catalog_product_galery');

                if(j === undefined){
                    console.log(j);
                }

                if($.isEmptyObject(j) === false){
                    var Width = $('.list-picture img').width(),col;
                    if(Width > 150){
                        col = 'col-md-3 col-sm-3 col-xs-6';
                    }else{
                        col = 'col-md-2 col-sm-2 col-xs-6';
                    }
                    $('.list-picture li').addClass(col);
                    $.each(j, function(i,item) {
                        setContener.append(
                            $(document.createElement("li")).addClass(col)
                                .attr("id","img_order_"+item.idmicro)
                                .append(
                                $(document.createElement("div")).append(
                                    $(document.createElement("a"))
                                        .attr('href','#')
                                        .attr("data-delete", item.idmicro)
                                        .addClass('btn btn-xs btn-danger')
                                        .addClass('delete-image')
                                        .append(
                                            '&times;'
                                        )
                                ).addClass('block-remove'),
                                $(document.createElement("div")).append(
                                    $(document.createElement("img"))
                                        .attr('src','/upload/catalogimg/galery/mini/'+item.imgcatalog)
                                        .addClass('img-responsive')
                                    //.addClass('img-polaroid')
                                )
                            )
                        );
                    });
                    // Image galery sortable
                    $('.list-picture').sortable({
                         //items: "> li",
                         //placeholder: "ui-state-highlight",
                         cursor: "move",
                         //axis: "x",
                         update : function() {
                             var serial = $('.list-picture').sortable('serialize');
                             $.nicenotify({
                                 ntype: "ajax",
                                 uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
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
                    $('.list-picture').disableSelection();
                }else{
                    setContener.append(
                        $(document.createElement("img"))
                            .attr('data-src','holder.js/140x140/text:Thumnails')
                            .addClass('ajax-image img-thumbnail')
                    );

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
            }
        });
    }

    /**
     * Suppression d'une image galerie d'un produit
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeGalery(baseadmin,iso,section,getlang,edit,tab){
        $(document).on('click','.delete-image',function(event){
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
                            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_galery:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                loadListGalery(baseadmin,section,getlang,edit,'galery');
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
     * Autocomplete pour les produits
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function autoCompleteProduct(baseadmin,iso,section,getlang,edit,tab){
        $( "#titleproduct" ).autocomplete({
            minLength: 2,
            scrollHeight: 220,
            source: function(request, add){
                //pass request to server
                $.ajax({
                    url:'/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=list&callback=?',
                    type: "get",
                    dataType: 'json',
                    data: 'title_search='+request.term,
                    async: true,
                    cache: true,
                    success: function(data){
                        add($.map(data, function(item) {
                            return {
                                id : item.idproduct,
                                category : item.clibelle,
                                subcategory : item.slibelle,
                                title : item.titlecatalog
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $.nicenotify({
                    ntype: "ajax",
                    uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                    typesend: 'post',
                    noticedata : {idproduct:ui.item.id},
                    successParams:function(data){
                        $('#titleproduct:text').val('');
                        $.nicenotify.initbox(data,{
                            display:false
                        });
                        jsonListProductRel(baseadmin,iso,section,getlang,edit,tab);
                    }
                });
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            if(item.subcategory != null){
                subcategory = $(document.createElement("span")).append(
                    "&nbsp;|&nbsp;",
                    item.subcategory
                );
            }else{
                subcategory = "";
            }
            return $("<li></li>").data("ui-item.autocomplete", item).append(
                $(document.createElement("a")).append(
                        $(document.createElement("span")).append(item.category),
                        $(document.createElement("span")).append(
                            "&nbsp;|&nbsp;",
                            item.title
                        ),
                        subcategory
                    )
                    //.attr('href','#')
                    .addClass('autcomplete-product')
            ).appendTo(ul.addClass('autocomplete-list-row'));
        };
    }

    /**
     * Requête JSON pour la liste des produits relatif
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function jsonListProductRel(baseadmin,iso,section,getlang,edit,tab){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab+'&json_product_rel=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_product_rel').html(loader);
            },
            successParams:function(j){
                $('#list_product_rel').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_product_rel")
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
                                        $(document.createElement("th")).append(Globalize.localize( "category", iso )),
                                        $(document.createElement("th")).append(Globalize.localize( "subcategory", iso )),
                                        $(document.createElement("th"))
                                            .append(
                                                $(document.createElement("span"))
                                                    .addClass("fa fa-trash-o")
                                            )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_product_rel');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.slibelle != null){
                            var slibelle = $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/catalog.php?section=subcategory&getlang='+getlang+'&action=edit&edit='+item.idcls)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.slibelle)
                                .append(item.slibelle);
                        }else{
                            var slibelle = $(document.createElement("span")).addClass("fa fa-minus");
                        }
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idrelproduct)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.titlecatalog)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .attr("id","order_pages_"+item.idrelproduct)
                                //.addClass("ui-state-default")
                                .append(
                                    $(document.createElement("td")).append(
                                        item.idrelproduct
                                    ),
                                    $(document.createElement("td")).append(
                                        $(document.createElement("a"))
                                            .attr("href", '/'+baseadmin+'/catalog.php?section=product&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                            .attr("title", Globalize.localize( "edit", iso )+": "+item.titlecatalog)
                                            .append(item.titlecatalog)
                                    ),
                                    $(document.createElement("td")).append(
                                        $(document.createElement("a"))
                                            .attr("href", '/'+baseadmin+'/catalog.php?section=category&getlang='+getlang+'&action=edit&edit='+item.idclc)
                                            .attr("title", Globalize.localize( "edit", iso )+": "+item.clibelle)
                                            .append(item.clibelle)
                                    ),
                                    $(document.createElement("td")).append(slibelle)
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
    return {
        //Fonction Public
        runCharts:function(){
            graph(baseadmin);
        },
        runListCategory:function(baseadmin,iso,section,getlang,access){
            autoCompleteCategory(baseadmin,section,getlang);
            jsonListCategory(baseadmin,iso,section,getlang,access);
            addCategory(baseadmin,iso,section,getlang,access);
            removeCategory(baseadmin,iso,section,getlang,access);
        },
        runEditCategory:function(baseadmin,iso,section,getlang,edit){
            autoCompleteCategory(baseadmin,section,getlang);
            if($("#categorylink").length != 0){
                JsonUrlCategory(baseadmin,section,getlang,edit);
                updateCategory(baseadmin,section,getlang,edit,'text');
            }else if($('#list_subcategory').length != 0){
                jsonListSubCategory(baseadmin,iso,section,getlang,edit,access);
                addSubCategory(baseadmin,iso,section,getlang,edit,access);
                removeSubCategory(baseadmin,iso,section,getlang,edit,'subcat',access);
            }else if($('#load_catalog_category_img').length != 0){
                getImageCategory(baseadmin,section,getlang,edit);
                updateCategory(baseadmin,section,getlang,edit,'image');
                removeImage(baseadmin,section,getlang,edit);
            }else if($('#list_category_product').length != 0){
                jsonListCategoryProduct(baseadmin,iso,section,getlang,edit);
                removeCategoryProduct(baseadmin,iso,section,getlang,edit,'product');
            }
        },
        runEditSubcategory:function(baseadmin,iso,section,getlang,edit){
            if($("#subcategorylink").length != 0){
                JsonUrlSubCategory(baseadmin,section,getlang,edit);
                updateSubCategory(baseadmin,section,getlang,edit,'text');
            }else if($('#load_catalog_subcategory_img').length != 0){
                getImageSubCategory(baseadmin,section,getlang,edit);
                updateSubCategory(baseadmin,section,getlang,edit,'image');
                removeImage(baseadmin,section,getlang,edit);
            }else if($('#list_subcategory_product').length != 0){
                jsonListSubCategoryProduct(baseadmin,iso,section,getlang,edit);
                removeSubCategoryProduct(baseadmin,iso,section,getlang,edit,'product');
            }
        },
        runListProduct:function(baseadmin,iso,section,getlang,access,getpage){
            autoCompleteCatalog(baseadmin,section,getlang);
            jsonListProduct(baseadmin,iso,section,getlang,access,getpage);
            addProduct(baseadmin,iso,section,getlang,access,getpage);
            copyProduct(baseadmin,iso,section,getlang,access,getpage);
            moveProduct(baseadmin,iso,section,getlang,access,getpage);
            removeProduct(baseadmin,iso,section,getlang,access,getpage);
        },
        runEditProduct:function(baseadmin,iso,section,getlang,edit){
            autoCompleteCatalog(baseadmin,section,getlang);
            if($("#urlcatalog").length != 0){
                updateProduct(baseadmin,iso,section,getlang,edit,'text');
            }else if($('#load_catalog_product_img').length != 0){
                getImageProduct(baseadmin,section,getlang,edit);
                updateProduct(baseadmin,iso,section,getlang,edit,'image');
                removeImage(baseadmin,section,getlang,edit);
            }else if($('#forms_catalog_product_category').length != 0){
                $('#forms_catalog_product_category').relatedSelects({
                    onChangeLoad: '/'+baseadmin+'/catalog.php?section='+section+'&getlang='+getlang+'&action=list',
                    dataType: 'json',
                    defaultOptionText: 'Choose an Option',
                    loadingMessage: 'Loading, please wait...',
                    disableIfEmpty:true,
                    selects: ['idclc','idcls']
                });
                jsonListProductCategory(baseadmin,iso,section,getlang,edit);
                updateProduct(baseadmin,iso,section,getlang,edit,'category');
                removeProductRel(baseadmin,iso,section,getlang,edit,'category');
            }else if($('#load_catalog_product_galery').length != 0){
                loadListGalery(baseadmin,section,getlang,edit,'galery');
                updateProduct(baseadmin,iso,section,getlang,edit,'galery');
                removeGalery(baseadmin,iso,section,getlang,edit,'galery');
            }else if($('#forms_catalog_product_related').length != 0){
                autoCompleteProduct(baseadmin,iso,section,getlang,edit,'product');
                jsonListProductRel(baseadmin,iso,section,getlang,edit,'product');
                removeProductRel(baseadmin,iso,section,getlang,edit,'product');
            }
        }
    };
})(jQuery);