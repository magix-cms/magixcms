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
var MC_access = (function ($, undefined) {
    //Fonction Private
    function jsonProfiles(iso,baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/access.php?action=list&json_profiles=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#load_json_profiles').html(loader);
            },
            successParams:function(j){
                $('#load_json_profiles').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_profiles")
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
                tbl.appendTo('#load_json_profiles');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.id_role !== "1"){
                            var remove = $(document.createElement("a"))
                                .addClass("delete-role")
                                .attr("href", "#")
                                .attr("data-delete", item.id_role)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.role_name)
                                .append(
                                    $(document.createElement("span")).addClass("fa fa-trash-o")
                                );
                        }else{
                            var remove = $(document.createElement("span")).addClass("fa fa-minus");
                        }
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(item.id_role),
                                $(document.createElement("td")).append(item.role_name),
                                $(document.createElement("td")).append(
                                    $(document.createElement("a"))
                                        .attr("href", '/'+baseadmin+'/'+"access.php?action=edit&edit="+item.id_role)
                                        .attr("title", "Editer "+item.role_name)
                                        .append(
                                        $(document.createElement("span")).addClass("fa fa-edit")
                                    )
                                ),
                                $(document.createElement("td")).append(
                                    remove
                                )
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
     * Ajour de nouvelles données
     * @param iso
     * @param baseadmin
     */
    function add(iso,baseadmin){
        var formsAdd = $('#forms_role_add').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                role_name: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/access.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonProfiles(iso,baseadmin);
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
                        formsAdd.resetForm();
                    }
                }
            });
            return false;
        });
    }

    /**
     * Mise a jour des données
     * @param iso
     * @param baseadmin
     * @param edit
     */
    function update(iso,baseadmin,edit){
        $("#forms_role_update").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                role_name: {
                    required: true,
                    minlength: 6
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/access.php?action=edit&edit='+edit,
                    typesend: 'post',
                    idforms: $(form),
                    //resetform:true,
                    beforeParams:function(){
                        $('#scmodule-access-edit :submit').hide();
                        //$('#scmodule-home-add :submit').after('<img class="mini-loader rfloat" src="/framework/img/small_loading.gif" />');
                    },
                    successParams:function(e){
                        $.nicenotify.initbox(e,{
                            display:true
                        });
                        //$('#scmodule-home-add').find('.mini-loader').remove();
                        $('#scmodule-access-edit :submit').show();
                    }
                });
                return false;
            }
        });
    }
    function addAccess(iso,baseadmin,edit){
        $("#forms_access_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                name_class: {
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/access.php?action=add&edit='+edit,
                    typesend: 'post',
                    idforms: $(form),
                    //resetform:true,
                    beforeParams:function(){
                        $('#forms_access_add :submit').hide();
                        //$('#scmodule-home-add :submit').after('<img class="mini-loader rfloat" src="/framework/img/small_loading.gif" />');
                    },
                    successParams:function(e){
                        $.nicenotify.initbox(e,{
                            display:false
                        });
                        jsonAccess(iso,baseadmin,edit);
                        //$('#scmodule-home-add').find('.mini-loader').remove();
                        $('#forms_access_add :submit').show();
                    }
                });
                return false;
            }
        });
    }
    function updateInputAccess(access_type,baseadmin,edit){
        $(document).on('change',"."+access_type, function () {
            //var id_access = $(this).parent().find('.id_access').html();
            var id_access = $(this).data('id');
            //console.log(id_access);
            if(id_access != undefined){
                if (this.checked) {
                    // do stuff for a checked box
                    var access_value = 1;
                } else {
                    // do stuff for an unchecked box
                    var access_value = 0;
                }
                $.nicenotify({
                    ntype: "ajax",
                    uri: '/'+baseadmin+'/access.php?action=edit&edit='+edit,
                    typesend: 'post',
                    noticedata: "id_access="+id_access+"&"+access_type+"="+access_value,
                    beforeParams:function(){},
                    successParams:function(e){
                        $.nicenotify.initbox(e,{
                            display:false
                        });
                    }
                });
                return false;
            }
        });
    }
    function jsonAccess(iso,baseadmin,edit){
        //$("[id^=view_access_]")
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/access.php?action=list&edit='+edit+'&json_access=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#load_json_access').html(loader);
            },
            successParams:function(j){
                $('#load_json_access').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_access")
                    .addClass('table table-bordered table-condensed table-hover')
                    .append(
                    $(document.createElement("thead"))
                        .append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("th")).append(
                                Globalize.localize( "class_name", iso )
                            ),
                            $(document.createElement("th")).append('Plugin'),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-eye")
                                    .attr("title", Globalize.localize( "view", iso ))
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-plus-circle")
                                    .attr("title", Globalize.localize( "add", iso ))
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-edit")
                                    .attr("title", Globalize.localize( "edit", iso ))
                            ),
                            $(document.createElement("th")).append(
                                $(document.createElement("span"))
                                    .addClass("fa fa-trash-o")
                                    .attr("title", Globalize.localize( "remove", iso ))
                            )
                        )
                    ),
                    tbody
                );
                tbl.appendTo('#load_json_access');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.plugins != 0){
                            plugin_name = $(document.createElement("span")).addClass("fa fa-check-circle");
                        }else{
                            plugin_name = $(document.createElement("span")).addClass("fa fa-minus-circle");
                        }
                        if(item.id_role != '1'){
                            if(item.view_access == '1'){
                                var view_checked = $(document.createElement("input"))
                                    .addClass("view_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "view_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.view_access)
                                    .attr("checked", "checked");
                            }else{
                                var view_checked = $(document.createElement("input"))
                                    .addClass("view_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "view_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.view_access);
                            }
                            if(item.add_access == '1'){
                                var add_checked = $(document.createElement("input"))
                                    .addClass("add_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "add_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.add_access)
                                    .attr("checked", "checked");
                            }else{
                                var add_checked = $(document.createElement("input"))
                                    .addClass("add_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "add_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.add_access);
                            }
                            if(item.edit_access == '1'){
                                var edit_checked = $(document.createElement("input"))
                                    .addClass("edit_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "edit_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.edit_access)
                                    .attr("checked", "checked");
                            }else{
                                var edit_checked = $(document.createElement("input"))
                                    .addClass("edit_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "edit_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.edit_access);
                            }
                            if(item.delete_access == '1'){
                                var delete_checked = $(document.createElement("input"))
                                    .addClass("delete_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "delete_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.delete_access)
                                    .attr("checked", "checked");
                            }else{
                                var delete_checked = $(document.createElement("input"))
                                    .addClass("delete_access")
                                    .attr("type", "checkbox")
                                    .attr("name", "delete_access")
                                    .attr("data-id", item.id_access)
                                    .attr("value", item.delete_access);
                            }
                        }else{
                            var view_checked = $(document.createElement("input"))
                                .addClass("view_access")
                                .attr("type", "checkbox")
                                .attr("name", "view_access")
                                .attr("data-id", item.id_access)
                                .attr("value", item.view_access)
                                .attr("checked", "checked")
                                .attr("disabled", "disabled");
                            var add_checked = $(document.createElement("input"))
                                .addClass("add_access")
                                .attr("type", "checkbox")
                                .attr("name", "add_access")
                                .attr("data-id", item.id_access)
                                .attr("value", item.add_access)
                                .attr("checked", "checked")
                                .attr("disabled", "disabled");
                            var edit_checked = $(document.createElement("input"))
                                .addClass("edit_access")
                                .attr("type", "checkbox")
                                .attr("name", "edit_access")
                                .attr("data-id", item.id_access)
                                .attr("value", item.edit_access)
                                .attr("checked", "checked")
                                .attr("disabled", "disabled");
                            var delete_checked = $(document.createElement("input"))
                                .addClass("delete_access")
                                .attr("type", "checkbox")
                                .attr("name", "delete_access")
                                .attr("data-id", item.id_access)
                                .attr("value", item.delete_access)
                                .attr("checked", "checked")
                                .attr("disabled", "disabled");
                        }
                        tbody.append(
                            $(document.createElement("tr"))
                            .append(
                                $(document.createElement("td")).append(item.class_name),
                                $(document.createElement("td")).append(plugin_name),
                                $(document.createElement("td")).append(
                                    view_checked
                                ),
                                $(document.createElement("td")).append(
                                    add_checked
                                ),
                                $(document.createElement("td")).append(
                                    edit_checked
                                ),
                                $(document.createElement("td")).append(
                                    delete_checked
                                )
                            )
                        )
                    });
                    updateInputAccess('view_access',baseadmin,edit);
                    updateInputAccess('add_access',baseadmin,edit);
                    updateInputAccess('edit_access',baseadmin,edit);
                    updateInputAccess('delete_access',baseadmin,edit);
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
                            )
                        )
                    )
                }
            }
        });
    }

    /**
     * Suppression d'un rôle
     * @param baseadmin
     * @param iso
     */
    function remove(baseadmin,iso){
        $(document).on('click','.delete-role',function(event){
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
                            uri: '/'+baseadmin+'/access.php?action=remove',
                            typesend: 'post',
                            noticedata : {delete_role:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonProfiles(iso,baseadmin);
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
    function checkAll(){
        $('#selectAll').on('click',function(event) {  //on click
            if(this.checked) { // check select status
                $('.checkbox-access').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox-access"
                });
            }else{
                $('.checkbox-access').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox-access"
                });
            }
        });
    }

    return {
        //Fonction Public        
        run:function (iso,baseadmin) {
            if($('#load_json_profiles').length != 0){
                jsonProfiles(iso,baseadmin);
            }
            if($('#forms_role_add').length != 0){
                add(iso,baseadmin);
            }
            remove(baseadmin,iso);
        },
        runEdit:function (iso,baseadmin,edit){
            checkAll();
            if($('#forms_role_update').length != 0 && $('#forms_access_add').length != 0){
                update(iso,baseadmin,edit);
                addAccess(iso,baseadmin,edit);
            }
            jsonAccess(iso,baseadmin,edit);
        }
    };
})(jQuery);