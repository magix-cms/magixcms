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
 * Date: 24/02/13
 * Time: 14:10
 * License: Dual licensed under the MIT or GPL Version
 */
var MC_install = (function ($, undefined) {
    //Fonction Private
    /**
     * Création de la base de données
     */
    function upgrade(){
        $("#forms_upgrade_version").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                version: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/install/upgrade.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform: true,
                    beforeParams:function(){
                        var btn = $('#upgrade_db');
                        var loader = $(document.createElement("span")).addClass("loader").append(
                            $(document.createElement("img"))
                                .attr('src','/install/template/img/small_loading.gif')
                                .attr('width','20px')
                                .attr('height','20px')
                        );
                        $('#upgrade_table').html(loader);
                        btn.remove();
                    },
                    successParams:function(data){
                        $('#upgrade_table').empty();
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });
    }

    /**
     * Retourne le tableau du résultat des analyses
     */
    function jsonAnalysis(iso){
        $.nicenotify({
            ntype: "ajax",
            uri: '/install/analysis.php?json_check=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/install/template/img/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_checking').html(loader);
            },
            successParams:function(j){
                $('#list_checking').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_checking")
                    .addClass('table table-bordered table-condensed table-hover')
                    .append(
                    $(document.createElement("thead"))
                        .append(
                        $(document.createElement("tr"))
                            .append(
                            $(document.createElement("th")).append(
                                Globalize.localize( "extension", iso )
                            ),
                            $(document.createElement("th")).append(
                                Globalize.localize( "resolution", iso )
                            )
                        )
                    ),
                    tbody
                );
                tbl.appendTo('#list_checking');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.phpversion != 0){
                            var phpversion = $(document.createElement("tr")).addClass('success');
                            var phpversion_result = "PHP Version is compatible";
                        }else{
                            var phpversion = $(document.createElement("tr")).addClass('error');
                            var phpversion_result = "PHP Version is not compatible";
                        }
                        if(item.mbstring != 0){
                            var mbstring = $(document.createElement("tr")).addClass('success');
                            var mbstring_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var mbstring = $(document.createElement("tr")).addClass('error');
                            var mbstring_result = Globalize.localize( "is_not_installed", iso );
                        }
                        if(item.iconv != 0){
                            var iconv = $(document.createElement("tr")).addClass('success');
                            var iconv_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var iconv = $(document.createElement("tr")).addClass('error');
                            var iconv_result = Globalize.localize( "is_not_installed", iso );
                        }
                        if(item.ob_start != 0){
                            var ob_start = $(document.createElement("tr")).addClass('success');
                            var ob_start_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var ob_start = $(document.createElement("tr")).addClass('error');
                            var ob_start_result = Globalize.localize( "is_not_installed", iso );
                        }
                        if(item.simplexml != 0){
                            var simplexml = $(document.createElement("tr")).addClass('success');
                            var simplexml_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var simplexml = $(document.createElement("tr")).addClass('error');
                            var simplexml_result = Globalize.localize( "is_not_installed", iso );
                        }
                        if(item.dom != 0){
                            var dom = $(document.createElement("tr")).addClass('success');
                            var dom_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var dom = $(document.createElement("tr")).addClass('error');
                            var dom_result = Globalize.localize( "is_not_installed", iso );
                        }
                        if(item.spl != 0){
                            var spl = $(document.createElement("tr")).addClass('success');
                            var spl_result = Globalize.localize( "is_installed", iso );
                        }else{
                            var spl = $(document.createElement("tr")).addClass('error');
                            var spl_result = Globalize.localize( "is_not_installed", iso );
                        }
                        tbody.append(
                            phpversion
                            .append(
                                $(document.createElement("td")).append("phpversion"),
                                $(document.createElement("td")).append(
                                    phpversion_result
                                )
                            ),
                            mbstring
                                .append(
                                $(document.createElement("td")).append("mbstring"),
                                $(document.createElement("td")).append(
                                    mbstring_result
                                )
                            ),
                            iconv
                                .append(
                                $(document.createElement("td")).append("iconv"),
                                $(document.createElement("td")).append(
                                    iconv_result
                                )
                            ),
                            ob_start
                                .append(
                                $(document.createElement("td")).append("ob_start"),
                                $(document.createElement("td")).append(
                                    ob_start_result
                                )
                            ),
                            simplexml
                                .append(
                                $(document.createElement("td")).append("simplexml"),
                                $(document.createElement("td")).append(
                                    simplexml_result
                                )
                            ),
                            dom
                                .append(
                                $(document.createElement("td")).append("dom_xml"),
                                $(document.createElement("td")).append(
                                    dom_result
                                )
                            ),
                            spl
                                .append(
                                $(document.createElement("td")).append("spl"),
                                $(document.createElement("td")).append(
                                    spl_result
                                )
                            )
                        )
                    });
                }
            }
        });
    }

    /**
     * Analyse les permissions de dossiers
     */
    function jsonChmod(iso){
        $.nicenotify({
            ntype: "ajax",
            uri: '/install/analysis.php?json_chmod=true',
            typesend: 'get',
            datatype: 'json',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/install/template/img/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list_chmod').html(loader);
            },
            successParams:function(j){
                $('#list_chmod').empty();
                $.nicenotify.initbox(j,{
                    display:false
                });
                var tbl = $(document.createElement('table')),
                    tbody = $(document.createElement('tbody'));
                tbl.attr("id", "table_checking")
                    .addClass('table table-bordered table-condensed table-hover')
                    .append(
                        $(document.createElement("thead"))
                            .append(
                                $(document.createElement("tr"))
                                    .append(
                                        $(document.createElement("th")).append(
                                            Globalize.localize( "dir", iso )
                                        ),
                                        $(document.createElement("th")).append(
                                            Globalize.localize( "permission", iso )
                                        )
                                    )
                            ),
                        tbody
                    );
                tbl.appendTo('#list_chmod');
                if(j === undefined){
                    console.log(j);
                }
                if(j !== null){
                    $.each(j, function(i,item) {
                        if(item.var_caching != 0){
                            var var_caching = $(document.createElement("tr")).addClass('success');
                            var var_caching_result = Globalize.localize( "is_writable", iso );
                        }else{
                            var var_caching = $(document.createElement("tr")).addClass('error');
                            var var_caching_result = Globalize.localize( "is_not_writable", iso );
                        }
                        if(item.config != 0){
                            var config = $(document.createElement("tr")).addClass('success');
                            var config_result = Globalize.localize( "is_writable", iso );
                        }else{
                            var config = $(document.createElement("tr")).addClass('error');
                            var config_result = Globalize.localize( "is_not_writable", iso );
                        }
                        if(item.caching != 0){
                            var caching = $(document.createElement("tr")).addClass('success');
                            var caching_result = Globalize.localize( "is_writable", iso );
                        }else{
                            var caching = $(document.createElement("tr")).addClass('error');
                            var caching_result = Globalize.localize( "is_not_writable", iso );
                        }

                        tbody.append(
                            var_caching
                                .append(
                                    $(document.createElement("td")).append("/var"),
                                    $(document.createElement("td")).append(
                                        var_caching_result
                                    )
                                ),
                            config
                                .append(
                                    $(document.createElement("td")).append("/app/config"),
                                    $(document.createElement("td")).append(
                                        config_result
                                    )
                                ),
                            caching
                                .append(
                                    $(document.createElement("td")).append("/admin/caching"),
                                    $(document.createElement("td")).append(
                                        caching_result
                                    )
                                )
                        )
                    });
                }
            }
        });
    }

    /**
     * Création du fichier de configuration
     */
    function addConfig(){
        $("#forms_config_add").validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                M_DBHOST: {
                    required: true,
                    minlength: 2
                },
                M_DBNAME:{
                    required: true,
                    minlength: 2
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: '/install/config.php?action=add',
                    typesend: 'post',
                    idforms: $(form),
                    resetform: true,
                    successParams:function(data){
                        $.nicenotify.initbox(data,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });
    }

    /**
     * Test la connexion MYSQL
     */
    function testConnexion(){
        $('#test_connexion').on('click',function(event){
            event.preventDefault();
            $.nicenotify({
                ntype: "ajax",
                uri: '/install/config.php?action=testconnexion',
                typesend: 'post',
                noticedata: {
                    M_DBDRIVER:$('#M_DBDRIVER').val(),
                    M_DBHOST:$('#M_DBHOST').val(),
                    M_DBUSER:$('#M_DBUSER').val(),
                    M_DBPASSWORD:$('#M_DBPASSWORD').val(),
                    M_DBNAME:$('#M_DBNAME').val()
                },
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
        })
    }

    /**
     * Création de la base de données
     */
    function database(){
        $('#process_db').on('click',function(event){
            event.preventDefault();
            $.nicenotify({
                ntype: "ajax",
                uri: '/install/database.php?action=add',
                typesend: 'get',
                beforeParams:function(){
                    var loader = $(document.createElement("span")).addClass("loader").append(
                        $(document.createElement("img"))
                            .attr('src','/install/template/img/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    );
                    $('#install_table').html(loader);
                },
                successParams:function(data){
                    $('#install_table').empty();
                    $.nicenotify.initbox(data,{
                        display:true
                    });
                }
            });
        })
    }

    /**
     * Ajoute un administrateur
     */
    function addUser(){
        $("#forms_user_add").validate({
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
                    uri: '/install/employee.php?action=add',
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
    }
    function cache(){
        $('#process_cache').on('click',function(event){
            event.preventDefault();
            $.nicenotify({
                ntype: "ajax",
                uri: '/install/clear.php?action=remove',
                typesend: 'post',
                noticedata: {cache:1},
                beforeParams:function(){},
                successParams:function(data){
                    $.nicenotify.initbox(data,{
                        display:false
                    });
                    setTimeout(function(){
                        window.location.href = "/";
                    },1800);
                }
            });
        })
    }
    return {
        //Fonction Public
        runUpgrade:function(){
            upgrade();
        },
        runAnalysis:function (iso) {
            jsonAnalysis(iso);
            jsonChmod(iso);
        },
        runConfig:function () {
            addConfig();
            testConnexion();
        },
        runDatabase:function(){
            database();
        },
        runUser:function(){
            addUser();
        },
        runClear:function(){
            cache();
        }
    };
})(jQuery);