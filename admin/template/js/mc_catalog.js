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
            }
        }
    };
})(jQuery);