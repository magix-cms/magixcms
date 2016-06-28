/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2016 magix-cms.com <support@magix-cms.com>
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

tinymce.PluginManager.requireLangPack('prism');
tinymce.PluginManager.add('prism', function(editor, url) {
    function showDialog() {
        var win,
            data = {},
            dom = editor.dom;
        // Open URL based window
        win = editor.windowManager.open({
            title: "Prism Title",
            file: tinyMCE.baseURL + '/plugins/prism/prism.html',
            width: 600,
            height: 400,
            inline: 1,
            resizable: true,
            maximizable: true
        });
    }

    // Add a button that opens a window
    editor.addButton('prism', {
        //text: 'mc_pages',
        icon: true,
        image: url+'/img/prism.jpg',
        tooltip: "Prism Title",
        onclick: showDialog,
        onPostRender: function() {
            var ctrl = this;
            editor.on('NodeChange', function(e) {
                ctrl.active(e.element.nodeName == 'IMG');
            });
        }
    });
});