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
 * Date: 27/02/13
 * Time: 01:23
 * License: Dual licensed under the MIT or GPL Version
 */
(function(){tinymce.PluginManager.requireLangPack("mc_pages");tinymce.create("tinymce.plugins.McPages",{init:function(a,b){a.addCommand("mceMcPages",function(){a.windowManager.open({file:b+"/pages.php",width:500+parseInt(a.getLang("mc_pages.delta_width",0)),height:400+parseInt(a.getLang("mc_pages.delta_height",0)),inline:1},{plugin_url:b,some_custom_arg:"custom arg"})});a.addButton("mc_pages",{title:"mc_pages.desc",cmd:"mceMcPages",image:b+"/img/search_page.png"});a.onNodeChange.add(function(d,c,e){c.setActive("mc_pages",e.nodeName=="IMG")})},createControl:function(b,a){return null},getInfo:function(){return{longname:"Mc Pages plugin",author:"Gerits Aurelien",authorurl:"http://www.aurelien-gerits.be",infourl:"http://www.aurelien-gerits.be",version:"2.0"}}});tinymce.PluginManager.add("mc_pages",tinymce.plugins.McPages)})();