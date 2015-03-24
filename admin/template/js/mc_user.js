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
 * Date: 27/12/12
 * Time: 15:43
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_user = (function ($, undefined) {
    //Fonction Private
    function graph(baseadmin){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/employee.php?json_graph=true',
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
                    ykeys: ['y', 'z', 'a', 'b'],
                    labels: ['HOME', 'NEWS', 'PAGES', 'PRODUCT']
                });
            }
        });
    }

    /**
     * Ajoute un utilisateur
     * @param baseadmin
     */
    function add(baseadmin,iso){
        var formsAddUser = $("#forms_user_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                pseudo_admin: {
                    required: true,
                    minlength: 2
                },
                email_admin: {
                    required: true,
                    email: true
                },
                passwd_admin: {
                    //password: "#pseudo",
                    required: true,
                    minlength: 4
                },
                passwd_confirm: {
                    required: true,
                    equalTo: "#passwd_admin"
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/'+baseadmin+'/employee.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                        $('#forms-add').dialog('close');
                        jsonUser(baseadmin,iso);
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
                        $("#forms_user_add").submit();
                    },
                    Cancel: function() {
                        $(this).dialog('close');
                        formsAddUser.resetForm();
                    }
                }
            });
            return false;
        });
    }
    function jsonUser(baseadmin,iso){
        $.nicenotify({
            ntype: "ajax",
            uri: '/'+baseadmin+'/employee.php?action=list&json_list_user=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_user').html(loader);
            },
            successParams:function(j){
                $('#list_user').empty();
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
                                    .addClass("fa fa-key")
                            ),
                            $(document.createElement("th")).append(Globalize.localize( "nickname", iso )),
                            $(document.createElement("th")).append("Mail"),
                            $(document.createElement("th")).append(Globalize.localize( "role", iso )),
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
                tbl.appendTo('#list_user');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        var edit = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .attr("href", '/'+baseadmin+'/employee.php?action=edit&edit='+item.idadmin)
                                .attr("title", Globalize.localize( "edit", iso )+": "+item.pseudo)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-edit")
                            )
                        );
                        var remove = $(document.createElement("td")).append(
                            $(document.createElement("a"))
                                .addClass("delete-user")
                                .attr("href", "#")
                                .attr("data-delete", item.idadmin)
                                .attr("title", Globalize.localize( "remove", iso )+": "+item.pseudo)
                                .append(
                                $(document.createElement("span")).addClass("fa fa-trash-o")
                            )
                        );
                        tbody.append(
                            $(document.createElement("tr"))
                                .append(
                                $(document.createElement("td")).append(item.idadmin),
                                $(document.createElement("td")).append(
                                    $(document.createElement("a"))
                                    .attr("href", '/'+baseadmin+'/employee.php?action=edit&edit='+item.idadmin)
                                    .attr("title", Globalize.localize( "edit", iso )+": "+item.pseudo)
                                    .append(
                                        item.pseudo
                                    )
                                ),
                                $(document.createElement("td")).append(item.email),
                                $(document.createElement("td")).append(item.role_name)
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
     * Mise à jour des informations d'un utilisateurs
     * @param baseadmin
     * @param edit
     */
    function update(baseadmin,edit){
        var url = '/'+baseadmin+'/employee.php?action=edit&edit='+edit;
        var formsUpdateData = $('#forms_user_data_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                pseudo: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
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
        var formsUpdateRole = $('#forms_user_data_role').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                id_role: {
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
                    }
                });
                return false;
            }
        });
        var formsUpdatePassword = $('#forms_user_password_edit').validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                cryptpass: {
                    required: true,
                    minlength: 4
                },
                cryptpass_confirm: {
                    required: true,
                    equalTo: "#cryptpass"
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
                    }
                });
                return false;
            }
        });

        $('#forms_user_data_edit').formsUpdateData;
        $('#forms_user_data_role').formsUpdateRole;
        $('#forms_user_password_edit').formsUpdatePassword;
    }

    /**
     * Suppression d'un utilisateur
     * @param baseadmin
     * @param iso
     */
    function remove(baseadmin,iso){
        $(document).on('click','.delete-user',function(event){
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
                            uri: '/'+baseadmin+'/employee.php?action=remove',
                            typesend: 'post',
                            noticedata : {delete_employee:elem},
                            successParams:function(e){
                                $.nicenotify.initbox(e,{
                                    display:true
                                });
                                jsonUser(baseadmin,iso);
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
    function updateInputActive(baseadmin,edit){
        $(document).on('change',".active_admin", function () {
            var active = $(this).val();
            //console.log(id_access);
            if(active != undefined){
                if (this.checked) {
                    // do stuff for a checked box
                    var access_value = 1;
                } else {
                    // do stuff for an unchecked box
                    var access_value = 0;
                }
                $.nicenotify({
                    ntype: "ajax",
                    uri: '/'+baseadmin+'/employee.php?action=edit&edit='+edit,
                    typesend: 'post',
                    noticedata: "active_admin="+active,
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
    return {
        //Fonction Public
        runCharts:function(baseadmin){
            graph(baseadmin);
        },
        runList:function(baseadmin,iso){
            add(baseadmin,iso);
            jsonUser(baseadmin,iso);
            remove(baseadmin,iso);
        },
        runEdit:function(baseadmin,edit){
            update(baseadmin,edit);
            updateInputActive(baseadmin,edit);
        }
    };
})(jQuery);