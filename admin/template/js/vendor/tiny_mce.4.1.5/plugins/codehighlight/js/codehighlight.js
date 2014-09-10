/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of tinyMCE.
 # YouTube for tinyMCE
 # Copyright (C) 2011 - 2013  Gerits Aurelien <aurelien[at]magix-dev[dot]be> - <contact[at]aurelien-gerits[dot]be>
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
 */
// Namespace Youtube
var codeHighLight = (function($, window, document, undefined){
    /**
     * Format HTML
     * @param data
     * @param language
     * @param options
     * @returns {string}
     */
    function dataToHtml(data,language,options){
        if(data != false){
            var objectCode = '<pre class="codehighlight brush: ';
            objectCode += language + ';' + options + '">';
            objectCode +=  parent.tinymce.activeEditor.dom.encode(data);
            objectCode += '</pre> ';
            objectCode += '<p>&nbsp;</p>';
            return objectCode;
        }
    }

    /**
     * Return Format data
     * @returns {string}
     */
    function insert(){
        var options = '',
            nogutter = $("#nogutter").is(":checked"),
            light = $("#light").is(":checked"),
            collapse = $("#collapse").is(":checked");
        switch (nogutter){
            case false:
                options += '';
                break;
            case true:
                options += 'gutter: false; ';
                break;
            default:
                options += '';
                break;
        }
        switch (light){
            case false:
                options += '';
                break;
            case true:
                options += 'light: true; ';
                break;
            default:
                options += '';
                break;
        }
        switch (collapse){
            case false:
                options += '';
                break;
            case true:
                options += 'collapse: true; ';
                break;
            default:
                options += '';
                break;
        }
        var firstline = $('#firstline').val();
        var highlight = $('#highlight').val();
        var language = $('#language').val();
        var data = $('#code').val();
        if(firstline != '') {
            options += 'first-line: ' + parseInt(firstline) + '; ';
        }
        if(highlight != '') {
            options += 'highlight: [' + highlight + ']; ';
        }
        return dataToHtml(data,language,options);
    }
    /**
     * public
     */
    return {
        run:function(){
            if(insert()){
                //editor.insertContent(objectCode);
                parent.tinymce.activeEditor.insertContent(insert());
                parent.tinymce.activeEditor.windowManager.close();
            }else{
                parent.tinymce.activeEditor.windowManager.close();
            }
        }
    }
})(jQuery, window, document);

/**
 * Execute namespace codeHighLight
 */
$(function(){
    // Init templatewith mustach
    var data = {
        "highlight_options": parent.tinymce.util.I18n.translate('highlight_options'),
        "paste": parent.tinymce.util.I18n.translate('paste'),
        "choose_language": parent.tinymce.util.I18n.translate('choose_language'),
        "nogutter": parent.tinymce.util.I18n.translate('nogutter'),
        "light": parent.tinymce.util.I18n.translate('light'),
        "collapse": parent.tinymce.util.I18n.translate('collapse'),
        "firstline": parent.tinymce.util.I18n.translate('firstline'),
        "highlight": parent.tinymce.util.I18n.translate('highlight')
    };
    //Use jQuery's get method to retrieve the contents of our template file, then render the template.
    $.get('view/forms.html' , function (template) {
        filled = Mustache.render( template, data );
        $('#template-container').append(filled);
        $('#insert-btn').on('click',function(){
            codeHighLight.run();
        });
    });
});