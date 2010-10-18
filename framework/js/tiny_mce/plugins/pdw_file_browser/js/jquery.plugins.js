/*
jquery.treeview.js
JQuery Treeview Plugin

PDW File Browser
Date: May 9, 2010
Url: http://www.neele.name

Copyright (c) 2010 Guido Neele

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
(function(a){a.fn.TreeView=function(){return this.each(function(){obj=a(this);a("a",obj).append('<span class="endcap"><img src="img/spacer.gif" width="6" height="22" /></span>').each(function(){a(this).prepend('<span class="icon"><img src="img/spacer.gif" width="26" height="22" /></span>')}).addClass("link").end();a("li",obj).each(function(){depth=parseInt(a(this).parents("ul").length);width=(depth-1)*12;a(this).prepend('<a class="handler"><img src="img/spacer.gif" width="16" height="22" /></a>');
a(this).prepend('<a class="spacer"><img src="img/spacer.gif" width="'+width+'" height="22" /></a>')});a("li:has(ul) > a.handler",obj).addClass("children");a("a.children",obj).bind("click",function(){a(this).toggleClass("open");a(this).next().next().toggle();return false})})}})(jQuery);

/**
 * jquery.contextmenu.js
 * jQuery Plugin for Context Menus
 * http://www.JavascriptToolbox.com/lib/contextmenu/
 *
 * Copyright (c) 2008 Matt Kruse (javascripttoolbox.com)
 * Dual licensed under the MIT and GPL licenses. 
**/
(function(d){d.contextMenu={shadow:true,shadowOffset:0,shadowOffsetX:5,shadowOffsetY:5,shadowWidthAdjust:-3,shadowHeightAdjust:-3,shadowOpacity:0.2,shadowClass:"context-menu-shadow",shadowColor:"black",offsetX:0,offsetY:0,appendTo:"body",direction:"down",constrainToScreen:true,showTransition:"show",hideTransition:"hide",showSpeed:"",hideSpeed:"",showCallback:null,hideCallback:null,className:"context-menu",itemClassName:"context-menu-item",itemHoverClassName:"context-menu-item-hover",disabledItemClassName:"context-menu-item-disabled",
disabledItemHoverClassName:"context-menu-item-disabled-hover",separatorClassName:"context-menu-separator",innerDivClassName:"context-menu-item-inner",themePrefix:"context-menu-theme-",theme:"default",separator:"context-menu-separator",target:null,menu:null,shadowObj:null,bgiframe:null,shown:false,useIframe:false,create:function(b,c){var a=d.extend({},this,c);if(typeof b=="string")a.menu=d(b);else if(typeof b=="function")a.menuFunction=b;else a.menu=a.createMenu(b,a);if(a.menu){a.menu.css({display:"none"});
d(a.appendTo).append(a.menu)}if(a.shadow){a.createShadow(a);if(a.shadowOffset)a.shadowOffsetX=a.shadowOffsetY=a.shadowOffset}d("body").bind("contextmenu",function(){a.hide()});return a},createIframe:function(){return d('<iframe frameborder="0" tabindex="-1" src="javascript:false" style="display:block;position:absolute;z-index:-1;filter:Alpha(Opacity=0);"/>')},createMenu:function(b,c){var a=c.className;d.each(c.theme.split(","),function(l,k){a+=" "+c.themePrefix+k});for(var e=d('<table cellspacing="0" cellpadding="0" class="contextmenu"></table>').click(function(){c.hide();
return false}),f=d("<tr></tr>"),g=d("<td></td>"),h=d('<div class="'+a+'"></div>'),i=0;i<b.length;i++)if(b[i]==d.contextMenu.separator)h.append(c.createSeparator());else for(var j in b[i])h.append(c.createMenuItem(j,b[i][j]));c.useIframe&&g.append(c.createIframe());e.append(f.append(g.append(h)));return e},createMenuItem:function(b,c){var a=this;if(typeof c=="function")c={onclick:c};var e=d.extend({onclick:function(){},className:"",hoverClassName:a.itemHoverClassName,icon:"",disabled:false,title:"",
hoverItem:a.hoverItem,hoverItemOut:a.hoverItemOut},c),f=e.icon?"background-image:url("+e.icon+");":"";c=d('<div class="'+a.itemClassName+" "+e.className+(e.disabled?" "+a.disabledItemClassName:"")+'" title="'+e.title+'"></div>').click(function(g){return a.isItemDisabled(this)?false:e.onclick.call(a.target,this,a,g)}).hover(function(){e.hoverItem.call(this,a.isItemDisabled(this)?a.disabledItemHoverClassName:e.hoverClassName)},function(){e.hoverItemOut.call(this,a.isItemDisabled(this)?a.disabledItemHoverClassName:
e.hoverClassName)});b=d('<div class="'+a.innerDivClassName+'" style="'+f+'">'+b+"</div>");c.append(b);return c},createSeparator:function(){return d('<div class="'+this.separatorClassName+'"></div>')},isItemDisabled:function(b){return d(b).is("."+this.disabledItemClassName)},hoverItem:function(b){d(this).addClass(b)},hoverItemOut:function(b){d(this).removeClass(b)},createShadow:function(b){b.shadowObj=d('<div class="'+b.shadowClass+'"></div>').css({display:"none",position:"absolute",zIndex:9998,opacity:b.shadowOpacity,
backgroundColor:b.shadowColor});d(b.appendTo).append(b.shadowObj)},showShadow:function(b,c){var a=this;a.shadow&&a.shadowObj.css({width:a.menu.width()+a.shadowWidthAdjust+"px",height:a.menu.height()+a.shadowHeightAdjust+"px",top:c+a.shadowOffsetY+"px",left:b+a.shadowOffsetX+"px"}).addClass(a.shadowClass).show()},beforeShow:function(){return true},show:function(b,c){var a=this,e=c.pageX,f=c.pageY;a.target=b;if(a.beforeShow()!==false){if(a.menuFunction){a.menu&&d(a.menu).remove();a.menu=a.createMenu(a.menuFunction(a,
b),a);a.menu.css({display:"none"});d(a.appendTo).append(a.menu)}b=a.menu;e+=a.offsetX;f+=a.offsetY;e=a.getPosition(e,f,a,c);a.showShadow(e.x,e.y,c);a.useIframe&&b.find("iframe").css({width:b.width()+a.shadowOffsetX+a.shadowWidthAdjust,height:b.height()+a.shadowOffsetY+a.shadowHeightAdjust});b.css({top:e.y+"px",left:e.x+"px",position:"absolute",zIndex:9999}).show();a.shown=true;d(document).one("click",null,function(){a.hide()})}},getPosition:function(b,c,a){b=b+a.offsetX;c=c+a.offsetY;var e=d(a.menu).height(),
f=d(a.menu).width(),g=a.direction;if(a.constrainToScreen){var h=d(window),i=h.height();a=h.width();if(g=="down"&&c+e-h.scrollTop()>i)g="up";f=b+f-h.scrollLeft();if(f>a)b-=f-a}if(g=="up")c-=e;return{x:b,y:c}},hide:function(){var b=this;if(b.shown){b.iframe&&d(b.iframe).hide();b.menu&&b.menu.hide();b.shadow&&b.shadowObj.hide()}b.shown=false}};d.fn.contextMenu=function(b,c){var a=d.contextMenu.create(b,c);return this.each(function(){d(this).bind("contextmenu",function(e){a.show(this,e);return false})})}})(jQuery);