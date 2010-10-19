/*
MediaBrowser v1.0
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
*/
jQuery.TreeView = function(){
	
	var shiftTimerId = 0;
	
	// Zorgen dat links in beeld scrollen als je er met de muis overheen gaat
	$('ul.treeview a')
		.mouseover(function(){
			var center = 0;
			var intScroll = 0;
			var width = $(this).width();
			var divWidth = $('div#tree').width();		
			var offset = $(this).offset()
			
			// Verschuiven als er 1 seconde op de link gehoverd wordt.
			shiftTimerId = setTimeout ( function(){
												 
				if ($(this).parent().parent().is('ul.treeview')){
					
					// Als er over een top-level link gehoverd wordt dan is scrollLeft 0
					$('div#tree').animate({scrollLeft: 0}, 500);
					
				} else {
					
					// Berekenen wanneer link precies in het midden staat
					center = Math.floor((divWidth - width) / 2);
					
					// Kijken of link al in het midden staat. Zo nee, dan rekening houden met de reeds gescrollde breedte
					// en berekenen hoeveel er gescrolld moet worden zodat link in het midden komt te staan.
					if(offset.left != center) {
						intScroll = offset.scrollLeft + (offset.left - center);
						$('div#tree').animate({scrollLeft: intScroll}, 500);
					}
				}
				
			}, 1000);
			
		})
		
		.mouseout(function(){
			// Als er niet 1 seconde op de link gehoverd wordt, dan moet verschuiving afgebroken worden.
			clearTimeout ( shiftTimerId );				
		})
	
		// Zorgen dat de eindcap getoond wordt als er gehoverd wordt.
		.append('<span class="endcap"><img src="img/spacer.gif" width="6" height="22" /></span>')
		
		// Icoontje toevoegen aan link aan de hand van de naam van de class
		.each(function(){
			
			$(this).prepend('<span class="icon"><img src="img/spacer.gif" width="26" height="22" /></span>');							 
		})
		
		// De links een class 'link' geven
		.addClass('link')
		
	.end();
	
	// Spacer toevoegen voor link
	$('ul.treeview li').prepend('<a class="spacer"><img src="img/spacer.gif" width="16" height="22" /></a>');
	
	// Als listitem kinderen bevat dan class 'children' toevoegen zodat handler getoond wordt
	$('ul.treeview li:has(ul) > a.spacer').addClass('children');
	
	// Zorgen dat handlers verschijnen bij mouseovers en verdwijnen bij mouseouts 
	$('ul.treeview a.children').css({'opacity' : 0});
	$('div#tree').hover(
		function(){
			$('ul.treeview a.children').animate({'opacity' : 1}, 'slow');
		}, function(){
			$('ul.treeview a.children').animate({'opacity' : 0}, 'slow');	
		}
	);
	
	// Zorgen dat bij klik op handler de kinderen getoond of verborgen worden
	$('ul.treeview a.children').bind('click', function(){
		$(this).toggleClass('open');
		$(this).next().next().toggle();	
		return false;
	});
};