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
 * Author: Salvatore Di Salvo
 * Copyright: MAGIX CMS
 * Date: 05-11-15
 * Time: 13:51
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_plugins_about = (function ($, undefined) {
    /**
     * Save
     * @param id
     * @param collection
     * @param type
     */
    function save(type,id){
        if(type === 'company'){
            // *** Set required fields for validation
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'contact'){
            // *** Set required fields for validation
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'language'){
            // *** Set required fields for validation
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'socials'){
            // *** Set required fields for validation
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'enable_op'){
            // *** Set required fields for validation
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'openinghours'){
            // *** Set required fields for validation
            jQuery.validator.addClassRules("input-hours", {
                required: true,
                number: true,
                min: 0,
                max: 23
            });
            jQuery.validator.addClassRules("input-minutes", {
                required: true,
                number: true,
                min: 0,
                max: 59
            });
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'addpage'){
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    subject : {
                        required: true,
                        minlength: 2
                    },
                    idlang : {
                        required: true,
                        number: true
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&tab=page&action=add',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: true,
                        successParams:function(data){
                            $('#add-page').modal('hide');
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                            getPage(baseadmin);
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'editpage'){
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    title_page : {
                        required: true,
                        minlength: 2
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&tab=page&action=edit',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }else if(type === 'addchild'){
            $(id).validate({
                onsubmit: true,
                event: 'submit',
                rules: {
                    title_page : {
                        required: true,
                        minlength: 2
                    }
                },
                submitHandler: function(form) {
                    $.nicenotify({
                        ntype: "submit",
                        uri: '/'+baseadmin+'/plugins.php?name=about&tab=page&action=savechild',
                        typesend: 'post',
                        idforms: $(form),
                        resetform: false,
                        successParams:function(data){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                            $.nicenotify.initbox(data,{
                                display:true
                            });
                        }
                    });
                    return false;
                }
            });
        }
    }
    function del(id) {
        $(id).validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                delete: {
                    required: true,
                    number: true,
                    minlength: 1
                }
            },
            submitHandler: function (form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/' + baseadmin + '/plugins.php?name=about&tab=page&action=delete',
                    typesend: 'post',
                    idforms: $(form),
                    resetform: true,
                    successParams: function (data) {
                        $('#deleteModal').modal('hide');
                        window.setTimeout(function () {
                            $(".alert-success").alert('close');
                        }, 4000);
                        $.nicenotify.initbox(data, {
                            display: true
                        });
                        $('#item_'+$('#delete').val()).remove();
                        updateList();
                    }
                });
                return false;
            }
        });
    }

    /**
    * Liste des points forts
    * @param getlang
    */
    function getPage(baseadmin) {
        $.nicenotify({
            ntype: "ajax",
            uri: '/' + baseadmin + '/plugins.php?name=about&tab=page&action=getlist',
            typesend: 'get',
            beforeParams: function () {
                var loader = $(document.createElement("tr")).attr('id', 'loader').append(
                    $(document.createElement("td")).addClass('text-center').append(
                        $(document.createElement("span")).addClass("loader offset5").append(
                            $(document.createElement("img"))
                                .attr('src', '/' + baseadmin + '/template/img/loader/small_loading.gif')
                                .attr('width', '20px')
                                .attr('height', '20px')
                        )
                    )
                );
                $('#no-entry').before(loader);
            },
            successParams: function (data) {
                $('#loader').remove();
                $.nicenotify.initbox(data, {
                    display: false
                });
                if (data === undefined) {
                    console.log(data);
                }
                if (data !== null) {
                    $('#no-entry').before(data);
                }
                updateList();
            }
        });
    }
    function updateList() {
        var rows = $('#list_page tr');
        if (rows.length > 1) {
            $('#no-entry').addClass('hide');

            $('a.toggleModal').off();
            $('a.toggleModal').click(function () {
                if ($(this).attr('href') != '#') {
                    var id = $(this).attr('href').slice(1);

                    $('#delete').val(id);
                }
            });
        } else {
            $('#no-entry').removeClass('hide');
        }
    }
    return {
        // Fonction Public        
        run: function (baseadmin) {
            // Init function
            save('company','#info_company_form');
            save('contact','#info_contact_form');
            save('language','#info_language_form');
            save('socials','#info_socials_form');
            save('enable_op','#enable_op_form');
            save('openinghours','#info_opening_form');
            save('addpage','#add_about_page');
            save('editpage','#edit_page_form');
            save('addchild','#add_child_form');
            del('#del_page');
            updateList();

            $(function(){
                $('[data-toggle="popover"]').popover();
                $('[data-toggle="popover"]').click(function(e){
                    e.preventDefault(); return false;
                });

                $('#info_opening_form').collapse();

                $('#enable_op').change(function(){
                    $('#enable_op_form').submit();

                    if($('#enable_op').prop('checked')) {
                        $('#info_opening_form').collapse('show');
                    }else{
                        $('#info_opening_form').collapse('hide');
                    }
                });

                $('.open_day').change(function(){
                    var day = $(this).data('day'),
                        line = $('#opening_'+day);

                    if( $(this).prop("checked") == true) {
                        $('.open_hours input', line).prop('disabled', false);
                        $('.noon_time', line).bootstrapToggle('enable');

                        if($('.noon_time', line).prop('checked')) {
                            $('.noon_hours input', line).prop('disabled', false);
                        }
                    }else{
                        $('.open_hours input', line).prop('disabled', true);
                        $('.noon_hours input', line).prop('disabled', true);
                        $('.noon_time', line).bootstrapToggle('disable');
                    }
                });

                $('.noon_time').change(function(){
                    var day = $(this).data('day'),
                        line = $('#opening_'+day);

                    if( $(this).prop("checked") == true) {
                        $('.noon_hours input', line).prop('disabled', false);
                    }else{
                        $('.noon_hours input', line).prop('disabled', true);
                    }
                });

            });
        }
    };
})(jQuery);