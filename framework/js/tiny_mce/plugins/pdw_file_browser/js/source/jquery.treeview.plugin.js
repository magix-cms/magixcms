/*
PDW File Browser v1.0 beta
Release Date: December 20, 2009

Copyright (c) 2009 Guido Neele

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

---- Converts unordered lists into a treeview ----

<ul class="treeview">
	<li>
		<a href class="folder">Item 1</a>
		<ul>
			<li><a href class="folder">Item 1.1</a></li>
			<li><a href class="folder">Item 1.2</a></li>
			<li><a href class="folder">Item 1.3</a></li>
		</ul>
	</li>
	<li><a href class="folder">Item 2</a></li>
</ul>
*/

(function($){
	$.fn.TreeView = function() {
    
		return this.each(function() {
			obj = $(this); 
			
			$('a', obj)
				//Add end cap
				.append('<span class="endcap"><img src="../img/spacer.gif" width="6" height="22" /></span>')
				//Add icon based on class name
				.each(function(){
					$(this).prepend('<span class="icon"><img src="../img/spacer.gif" width="26" height="22" /></span>');							 
				})
				//Add the class link to every hyperlink
				.addClass('link')	
			.end();
			
			//Add Spacer before link
			$('li', obj).each(function(){
				depth = parseInt($(this).parents('ul').length);
				width = (depth - 1) * 12;
				$(this).prepend('<a class="handler"><img src="../img/spacer.gif" width="16" height="22" /></a>');
				$(this).prepend('<a class="spacer"><img src="../img/spacer.gif" width="' + width + '" height="22" /></a>');
			});
			
			//If list item has children then add class 'children'
			$('li:has(ul) > a.handler', obj).addClass('children');
			
			// Show or hide children when clicked on the handler
			$('a.children', obj).bind('click', function(){
				$(this).toggleClass('open');
				$(this).next().next().toggle();	
				return false;
			});
		});
	};
})(jQuery);