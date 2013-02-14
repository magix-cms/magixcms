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
 * Date: 12/02/13
 * Time: 00:37
 * License: Dual licensed under the MIT or GPL Version
 */

tinyMCEPopup.requireLangPack();

/**
 * Insertion du lien au format HTML
 * @param href
 * @param name
 */

function insert_product_link(href,name){
    tinyMCE.execCommand('mceInsertContent',false,'<a title="'+name+'" href="'+href+'">'+name+'</a>');
}

/**
 * nom du dossier de l'administration
 * @return {*}
 */

function basedir(){
    return baseadmin;
}

var McCatalogDialog = {
    init : function() {
        var t = this;
        t._search();
    },
    _search : function(){
        var t = this;
        $("#forms-product-search").on('submit',function(){
            $(this).ajaxSubmit({
                url: '/'+basedir()+'/catalog.php',
                type:"post",
                dataType:"json",
                resetForm: true,
                beforeSubmit:function(){
                    var loader = $(document.createElement("span")).addClass("loader offset5").append(
                        $(document.createElement("img"))
                            .attr('src','/framework/img/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    );
                    $('#list_product_search').html(loader);
                },
                success:function(data) {
                    t._result(data);
                }
            });
            return false;
        });
    },
    _addslashes: function(ch) {
        ch = ch.replace(/\\/g,"\\\\");
        ch = ch.replace(/\'/g,"\\'");
        ch = ch.replace(/\"/g,"\\\"");
        return ch;
    },
    _result:function(data){
        var t = this;
        $('#list_product_search').empty();
        var tbl = $(document.createElement('table')),
            tbody = $(document.createElement('tbody'));
        tbl.attr("id", "table_product_search")
            .addClass('table table-bordered table-condensed table-hover')
            .append(
            $(document.createElement("thead"))
                .append(
                $(document.createElement("tr"))
                    .append(
                    $(document.createElement("th")).append("ISO"),
                    $(document.createElement("th")).append("Produit"),
                    $(document.createElement("th")).append("Catégorie"),
                    $(document.createElement("th")).append("Sous Catégorie"),
                    $(document.createElement("th")).append("Liens")
                )
            ),
            tbody
        );
        tbl.appendTo('#list_product_search');
        if(data === undefined){
            console.log(data);
        }
        if(data !== null){
            $.each(data, function(i,item) {
                if(item.iso != null){
                    flaglang = item.iso;
                }else{
                    flaglang = $(document.createElement("span")).addClass("icon-minus");
                }
                if(item.iso != null){
                    flaglang = item.iso;
                }else{
                    flaglang = $(document.createElement("span")).addClass("icon-minus");
                }
                if(item.subcategory != null){
                    subcategory = item.subcategory;
                }else{
                    subcategory = '-';
                }
                var titleproduct = t._addslashes(item.titlecatalog);
                tbody.append(
                    $(document.createElement("tr"))
                        .append(
                        /*$(document.createElement("td")).append(
                            item.idproduct
                        ),*/
                        $(document.createElement("td")).append(flaglang),
                        $(document.createElement("td")).append(item.titlecatalog),
                        $(document.createElement("td")).append(item.category),
                        $(document.createElement("td")).append(subcategory),
                        $(document.createElement("td")).append(
                            $(document.createElement("a"))
                            .attr('onclick', 'tinyMCEPopup.close();')
                            .attr('onmousedown', 'insert_product_link(\''+item.uriproduct+'\',\''+titleproduct+'\');')
                            .addClass('btn btn-mini btn-link')
                            .append('Insert')
                        )
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
                    )
                )
            )
        }
    },
    insert: function () {
        return null;
    }
};
tinyMCEPopup.onInit.add(McCatalogDialog.init, McCatalogDialog);