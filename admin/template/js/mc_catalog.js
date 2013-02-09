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
    function graph(){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?json_graph=true',
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
                Morris.Bar({
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
     * Retourne la liste des catégories dans la langue
     * @param section
     * @param getlang
     */
    function jsonListCategory(section,getlang){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=list&json_list_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Nom"),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-picture")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-edit")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                            var c_content = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var c_content = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idclc)
                                .attr("title", "Editer "+item.clibelle)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idclc)
                                .attr("title", "Supprimer "+": "+item.clibelle)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
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
                                        .attr("href", '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idclc)
                                        .attr("title", "Editer "+item.clibelle)
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
                                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit',
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

    /**
     * Ajouter une catégorie
     * @param section
     * @param getlang
     */
    function addCategory(section,getlang){
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
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListCategory(section,getlang);
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
     * Retourne l'url de la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @constructor
     */
    function JsonUrlCategory(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&json_uri_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#categorylink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
    function updateCategory(section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_category_edit').on('submit',function(){
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(this),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        JsonUrlCategory(section,getlang,edit)
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
                        uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#img_c:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageCategory(section,getlang,edit);
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
    function getImageCategory(section,getlang,edit){
        if($('#load_catalog_category_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_category_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/framework/img/small_loading.gif')
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
    function jsonListCategoryProduct(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product&json_category_product=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Nom"),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                                .attr("title", "Supprimer "+": "+item.titlecatalog)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
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
                                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product',
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

    /**
     * Suppression du produit dans la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeCategoryProduct(section,getlang,edit,tab){
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
                            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'product'){
                                    jsonListCategoryProduct(section,getlang,edit);
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
    function jsonListSubCategory(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat&json_list_subcategory=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Nom"),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-picture")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-edit")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                            var s_content = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var s_content = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/catalog.php?section=sub'+section+'&getlang='+getlang+'&action=edit&edit='+item.idcls)
                                .attr("title", "Editer "+item.slibelle)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idcls)
                                .attr("title", "Supprimer "+": "+item.slibelle)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
                            )
                        );
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
                                        .attr("href", '/admin/catalog.php?section=sub'+section+'&getlang='+getlang+'&action=edit&edit='+item.idcls)
                                        .attr("title", "Editer "+item.slibelle)
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
                                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat',
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

    /**
     * Ajouter une sous catégorie
     * @param section
     * @param getlang
     * @param edit
     */
    function addSubCategory(section,getlang,edit){
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
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=subcat',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListSubCategory(section,getlang,edit);
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
     * Retourne l'url de la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @constructor
     */
    function JsonUrlSubCategory(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&json_uri_subcategory=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                $("#subcategorylink").hide().val('');
                var loader = $(document.createElement("span")).addClass("loader").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
    function updateSubCategory(section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_subcategory_edit').on('submit',function(event){
                event.preventDefault();
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(this),
                    resetform:false,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        JsonUrlSubCategory(section,getlang,edit)
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
                        uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#img_s:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageSubCategory(section,getlang,edit);
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
    function getImageSubCategory(section,getlang,edit){
        if($('#load_catalog_subcategory_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_subcategory_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/framework/img/small_loading.gif')
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
    function jsonListSubCategoryProduct(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product&json_subcategory_product=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Nom"),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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

                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idproduct)
                                .attr("title", "Supprimer "+": "+item.titlecatalog)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
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
                    $('#table_subcategory_product > tbody').sortable({
                        items: "> tr",
                        placeholder: "ui-state-highlight",
                        cursor: "move",
                        axis: "y",
                        update : function() {
                            var serial = $('#table_subcategory_product > tbody').sortable('serialize');
                            $.nicenotify({
                                ntype: "ajax",
                                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=product',
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
    /**
     * Suppression du produit dans la catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeSubCategoryProduct(section,getlang,edit,tab){
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
                            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'product'){
                                    jsonListSubCategoryProduct(section,getlang,edit);
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
     * Ajouter un produit
     * @param section
     * @param getlang
     */
    function addProduct(section,getlang){
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
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonListProduct(section,getlang);
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
    function jsonListProduct(section,getlang){
        var getpage = $('.pagination li.active').text();
        if(getpage.length == 0){
            getpage = 1;
        }
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=list&json_listing_product=true&page='+getpage,
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Nom"),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-picture")
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("icon-money")
                            ),
                            $(document.createElement("th")).append("Content"),
                            $(document.createElement("th")).append("Rédacteur"),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-edit")
                            ),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                            var content = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var content = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        if(item.img != 0){
                            var img = $(document.createElement("span")).addClass("icon-check");
                        }else{
                            var img = $(document.createElement("span")).addClass("icon-warning-sign");
                        }
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                .attr("title", "Editer "+item.titlecatalog)
                                .append(
                                $(document.createElement("span")).addClass("icon-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idcatalog)
                                .attr("title", "Supprimer "+": "+item.titlecatalog)
                                .append(
                                $(document.createElement("span")).addClass("icon-trash")
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
                                        .attr("href", '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+item.idcatalog)
                                        .attr("title", "Editer "+item.titlecatalog)
                                        .append(item.titlecatalog)
                                ),
                                $(document.createElement("td")).append(img),
                                $(document.createElement("td")).append(item.price),
                                $(document.createElement("td")).append(content),
                                $(document.createElement("td")).append(item.pseudo),
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
    /**
     * Mise à jour de la sous catégorie
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function updateProduct(section,getlang,edit,tab){
        if(tab === 'text'){
            $('#forms_catalog_product_edit').on('submit',function(event){
                event.preventDefault();
                $.nicenotify({
                    ntype: "submit",
                    uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
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
                        uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#imgcatalog:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            getImageProduct(section,getlang,edit);
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
                        uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=category',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:false,
                        successParams:function(data){
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            jsonListProductCategory(section,getlang,edit);
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
                        uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=galery',
                        typesend: 'post',
                        idforms: $(form),
                        resetform:true,
                        successParams:function(data){
                            $('#imgcatalog:file').val('');
                            $.nicenotify.initbox(data,{
                                display:false
                            });
                            loadListGalery(section,getlang,edit,"galery");
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
    function getImageProduct(section,getlang,edit){
        if($('#load_catalog_product_img').length!=0){
            $.nicenotify({
                ntype: "ajax",
                uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=image&ajax_product_image=true',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/framework/img/small_loading.gif')
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
    function removeImage(section,getlang,edit){
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
                            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit,
                            typesend: 'post',
                            noticedata : {delete_image:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(section === 'category'){
                                    getImageCategory(section,getlang,edit);
                                }else if(section === 'subcategory'){
                                    getImageSubCategory(section,getlang,edit);
                                }else if(section === 'product'){
                                    getImageProduct(section,getlang,edit);
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
    function jsonListProductCategory(section,getlang,edit){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab=category&json_product_category=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
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
                                    .addClass("icon-key")
                            ),
                            $(document.createElement("th")).append("Catégorie"),
                            $(document.createElement("th")).append("Sous Catégorie"),
                            $(document.createElement("th"))
                                .append(
                                $(document.createElement("span"))
                                    .addClass("icon-trash")
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
                            var slibelle = $(document.createElement("span")).addClass("icon-minus");
                            var remove_slibelle = '';
                        }
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-pages")
                                .attr("href", "#")
                                .attr("data-delete", item.idproduct)
                                .attr("title", "Supprimer "+": "+item.clibelle+remove_slibelle)
                                .append(
                                    $(document.createElement("span")).addClass("icon-trash")
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

    /**
     * Suppression d'une catégorie pour le produit
     * @param section
     * @param getlang
     * @param edit
     * @param tab
     */
    function removeProduct(section,getlang,edit,tab){
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
                            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_product:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                if(tab === 'category'){
                                    jsonListProductCategory(section,getlang,edit);
                                }else if(tab === 'product'){

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
    function loadListGalery(section,getlang,edit,tab){
        $.nicenotify({
            ntype: "ajax",
            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab+'&json_list_galery=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/framework/img/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#load_catalog_product_galery').html(loader);
            },
            successParams:function(j){
                $('#load_catalog_product_galery').empty();
                var div = $(document.createElement('div'))
                    .attr('id','list_product_galery')
                    .addClass('row-fluid'),
                ul = $(document.createElement('ul'))
                    .addClass('thumbnails list-picture');
                $.nicenotify.initbox(j,{
                    display:false
                });
                div.append(
                    ul
                );
                div.appendTo('#load_catalog_product_galery');

                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        ul.append(
                            $(document.createElement("li")).addClass('span2').append(
                                $(document.createElement("div")).append(
                                    $(document.createElement("a"))
                                    .attr('href','#')
                                    .attr("data-delete", item.idmicro)
                                    .addClass('btn btn-mini btn-danger')
                                    .addClass('delete-image')
                                    .append(
                                        '&times;'
                                    )
                                ).addClass('block-remove'),
                                $(document.createElement("div")).append(
                                    $(document.createElement("img"))
                                    .attr('src','/upload/catalogimg/galery/mini/'+item.imgcatalog)
                                    //.addClass('img-polaroid')
                                )
                            )
                        );
                    });
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
    function removeGalery(section,getlang,edit,tab){
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
                            uri: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=edit&edit='+edit+'&tab='+tab,
                            typesend: 'post',
                            noticedata : {delete_galery:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:false
                                });
                                loadListGalery(section,getlang,edit,'galery');
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
    function autoCompleteProduct(section,getlang){
        $( "#titleproduct" ).autocomplete({
            minLength: 2,
            source: function(request, add){
                //pass request to server
                $.ajax({
                    url:'/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=list&callback=?',
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
                                subcategory : item.subcategory,
                                title : item.titlecatalog
                            }
                        }));
                    }
                });
            },
            select: function(event, ui) {
                $('#idproduct').val(ui.item.id);
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            return $("<li></li>").data("ui-item.autocomplete", item).append(
                item.title)
                .appendTo(ul.addClass('list-row'));
        };
    }
    return {
        //Fonction Public
        runCharts:function(){
            graph();
        },
        runListCategory:function(section,getlang){
            jsonListCategory(section,getlang);
            addCategory(section,getlang);
        },
        runEditCategory:function(section,getlang,edit){
            if($("#categorylink").length != 0){
                JsonUrlCategory(section,getlang,edit);
                updateCategory(section,getlang,edit,'text');
            }else if($('#list_subcategory').length != 0){
                jsonListSubCategory(section,getlang,edit);
                addSubCategory(section,getlang,edit);
            }else if($('#load_catalog_category_img').length != 0){
                getImageCategory(section,getlang,edit);
                updateCategory(section,getlang,edit,'image');
                removeImage(section,getlang,edit);
            }else if($('#list_category_product').length != 0){
                jsonListCategoryProduct(section,getlang,edit);
                removeCategoryProduct(section,getlang,edit,'product');
            }
        },
        runEditSubcategory:function(section,getlang,edit){
            if($("#subcategorylink").length != 0){
                JsonUrlSubCategory(section,getlang,edit);
                updateSubCategory(section,getlang,edit,'text');
            }else if($('#load_catalog_subcategory_img').length != 0){
                getImageSubCategory(section,getlang,edit);
                updateSubCategory(section,getlang,edit,'image');
                removeImage(section,getlang,edit);
            }else if($('#list_subcategory_product').length != 0){
                jsonListSubCategoryProduct(section,getlang,edit);
                removeSubCategoryProduct(section,getlang,edit,'product');
            }
        },
        runListProduct:function(section,getlang){
            jsonListProduct(section,getlang);
            addProduct(section,getlang);
        },
        runEditProduct:function(section,getlang,edit){
            if($("#urlcatalog").length != 0){
                updateProduct(section,getlang,edit,'text');
            }else if($('#load_catalog_product_img').length != 0){
                getImageProduct(section,getlang,edit);
                updateProduct(section,getlang,edit,'image');
                removeImage(section,getlang,edit);
            }else if($('#forms_catalog_product_category').length != 0){
                $('#forms_catalog_product_category').relatedSelects({
                    onChangeLoad: '/admin/catalog.php?section='+section+'&getlang='+getlang+'&action=list',
                    dataType: 'json',
                    defaultOptionText: 'Choose an Option',
                    loadingMessage: 'Loading, please wait...',
                    disableIfEmpty:true,
                    selects: ['idclc','idcls']
                });
                jsonListProductCategory(section,getlang,edit);
                updateProduct(section,getlang,edit,'category');
                removeProduct(section,getlang,edit,'category');
            }else if($('#load_catalog_product_galery').length != 0){
                loadListGalery(section,getlang,edit,'galery');
                updateProduct(section,getlang,edit,'galery');
                removeGalery(section,getlang,edit,'galery');
            }else if($('#forms_catalog_product_related').length != 0){
                autoCompleteProduct(section,getlang);
            }
        }
    };
})(jQuery);