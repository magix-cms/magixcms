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
    function jsonAnalysis(getlang){
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
                            $(document.createElement("th")).append("Extension"),
                            $(document.createElement("th")).append("Résolution")
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
                            var mbstring_result = "is installed";
                        }else{
                            var mbstring = $(document.createElement("tr")).addClass('error');
                            var mbstring_result = "is not installed";
                        }
                        if(item.iconv != 0){
                            var iconv = $(document.createElement("tr")).addClass('success');
                            var iconv_result = "is installed";
                        }else{
                            var iconv = $(document.createElement("tr")).addClass('error');
                            var iconv_result = "is not installed";
                        }
                        if(item.ob_start != 0){
                            var ob_start = $(document.createElement("tr")).addClass('success');
                            var ob_start_result = "is installed";
                        }else{
                            var ob_start = $(document.createElement("tr")).addClass('error');
                            var ob_start_result = "is not installed";
                        }
                        if(item.simplexml != 0){
                            var simplexml = $(document.createElement("tr")).addClass('success');
                            var simplexml_result = "is installed";
                        }else{
                            var simplexml = $(document.createElement("tr")).addClass('error');
                            var simplexml_result = "is not installed";
                        }
                        if(item.dom != 0){
                            var dom = $(document.createElement("tr")).addClass('success');
                            var dom_result = "is installed";
                        }else{
                            var dom = $(document.createElement("tr")).addClass('error');
                            var dom_result = "is not installed";
                        }
                        if(item.spl != 0){
                            var spl = $(document.createElement("tr")).addClass('success');
                            var spl_result = "is installed";
                        }else{
                            var spl = $(document.createElement("tr")).addClass('error');
                            var spl_result = "is not installed";
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
    return {
        //Fonction Public        
        runAnalysis:function () {
            jsonAnalysis();
        },
        runConfig:function () {
            addConfig();
            testConnexion();
        },
        runDatabase:function(){
            database();
        }
    };
})(jQuery);