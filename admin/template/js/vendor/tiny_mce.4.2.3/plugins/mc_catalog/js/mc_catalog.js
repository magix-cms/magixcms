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

// Namespace mc_catalog
var mc_catalog;
mc_catalog = (function($, baseAdmin, window, document, undefined){
    //Private function
    /**
     * addSlaches
     * @param ch
     * @returns {XML}
     */
	function addSlashes(ch){
		ch = ch.replace(/\\/g,"\\\\");
        ch = ch.replace(/\'/g,"\\'");
        ch = ch.replace(/\"/g,"\\\"");
        return ch;
	}

    /**
     * FormatHTML
     * @param data
     */
	function formatHTML(data){
        $('#list-catalog-search').empty();
        var tbl = $(document.createElement('table')),
            tbody = $(document.createElement('tbody'));
        tbl.attr("id", "table-pages-search")
            .addClass('table table-striped table-condensed table-hover')
            .append(
            $(document.createElement("thead"))
                .append(
                $(document.createElement("tr"))
                    .append(
                    $(document.createElement("th")).append("ISO"),
                    $(document.createElement("th")).append(
                        mc_catalog.translate("product")
                    ),
                    $(document.createElement("th")).append(
                        mc_catalog.translate("category")
                    ),
                    $(document.createElement("th")).append(
                        mc_catalog.translate("subcategory")
                    ),
                    $(document.createElement("th")).append(
                        mc_catalog.translate("link")
                    )
                )
            ),
            tbody
        );
        tbl.appendTo('#list-catalog-search');
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
                if(item.subcategory != null){
                    subcategory = item.subcategory;
                }else{
                    subcategory = '-';
                }
                var titlepage = addSlashes(item.titlecatalog);
                tbody.append(
                    $(document.createElement("tr"))
                    .append(
                        $(document.createElement("td")).append(
                            flaglang
                        ),
                        $(document.createElement("td")).append(
                            item.titlecatalog
                        ),
                        $(document.createElement("td")).append(
                            item.category
                        ),
                        $(document.createElement("td")).append(
                            subcategory
                        ),
                        $(document.createElement("td")).append(
                            $(document.createElement("a"))
                            .attr('onclick', 'mc_catalog.windowClose();')
                            .attr('onmousedown', 'mc_catalog.insertLink(\''+item.uriproduct+'\',\''+titlepage+'\');')
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
	}

    /**
     * Search forms
     */
	function search(){
		$("#forms-catalog-search").on('submit',function(){
            $(this).ajaxSubmit({
                url: '/'+baseAdmin+'/catalog.php',
                type:"post",
                dataType:"json",
                resetForm: true,
                beforeSubmit:function(){
                    var loader = $(document.createElement("span"))
                    .addClass("loader offset5").append(
                        $(document.createElement("img"))
                            .attr('src','/'+baseAdmin+'/template/img/loader/small_loading.gif')
                            .attr('width','20px')
                            .attr('height','20px')
                    );
                    $('#list-catalog-search').html(loader);
                },
                success:function(data) {
                    formatHTML(data);
                }
            });
            return false;
        });
	}
	/**
     * public function
     */
    return {
    	run:function(){
    		search();
    	},
    	translate:function(varname){
			return parent.tinymce.util.I18n.translate(varname);
		},
        insertLink:function(href,name){
            parent.tinymce.activeEditor.insertContent('<a title="'+name+'" href="'+href+'">'+name+'</a>');
        },
        windowClose:function(){
            parent.tinymce.activeEditor.windowManager.close();
        }
    }
})(jQuery, baseAdmin, window, document);
/**
 * Execute namespace news
 */
$(function(){
    // Init templatewith mustach
    var data = {
        "title": mc_catalog.translate('mc_catalog Title'),
        "product": mc_catalog.translate('product'),
        "category": mc_catalog.translate('category'),
        "subcategory": mc_catalog.translate('subcategory'),
        "search": mc_catalog.translate('search'),
        "description": mc_catalog.translate('mc_catalog description')
    };
    //Use jQuery's get method to retrieve the contents of our template file, then render the template.
    $.get('view/forms.html' , function (template) {
        filled = Mustache.render( template, data );
        $('#template-container').append(filled);
        mc_catalog.run();
         //Product.call(this, name, price);
    });
    
});