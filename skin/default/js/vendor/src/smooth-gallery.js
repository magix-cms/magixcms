/*! ========================================================================
 * Smooth Gallery: smooth-galler.js v1.0.0
 * ========================================================================
 * Copyright 2015, Salvatore Di Salvo (disalvo-infographiste[dot]be)
 * ======================================================================== */

+function ($) {
    'use strict';

    // SMOOTH GALLERY PUBLIC CLASS DEFINITION
    // =======================================

    var SmoothGallery = function (element, options) {
        this.$element  = $(element)
        this.options   = $.extend({}, this.defaults(), options)
        this.structure   = $.extend({}, this.parts())
        this.init()
    }

    SmoothGallery.VERSION  = '1.0.0'

    SmoothGallery.DEFAULTS = {
		container : this,
		scrollSpeed: 500,
		draggable: false,
		list: 'ul',
		item: 'ul > li:first-child',
		items: 'ul li',
		btn: {
			prv: '.button.prev',
			nxt: '.button.next'
		},
		vars: {}
    }

    SmoothGallery.prototype.parts = function() {
        return {
            $container      : this.$element,
            $list           : $(this.options.list, this.$element),
            $item           : $(this.options.item, this.$element),
            $items          : $(this.options.items, this.$element),
            $btn            : {
				prv: $(this.options.btn.prv, this.$element),
				nxt: $(this.options.btn.nxt, this.$element)
			}
        }
    }

    SmoothGallery.prototype.defaults = function() {
        return {
            container      : SmoothGallery.DEFAULTS.container,
			scrollSpeed   : this.$element.attr('data-scrollSpeed') || SmoothGallery.DEFAULTS.scrollSpeed,
			draggable   : this.$element.attr('data-draggable') || SmoothGallery.DEFAULTS.draggable,
			list  : SmoothGallery.DEFAULTS.list,
			item  : SmoothGallery.DEFAULTS.item,
			items : SmoothGallery.DEFAULTS.items,
			btn   : SmoothGallery.DEFAULTS.btn,
			vars  : SmoothGallery.DEFAULTS.vars
        }
    }

    SmoothGallery.prototype.init = function() {
		var $this = this,
			nbli = this.structure.$items.length;

		if (nbli > 0) {
			this.options.vars.startPos 	= parseInt($('.thumbs ul').css('left').slice(0,-2));
			this.options.vars.liw 		= this.structure.$item.width();
			this.options.vars.gutter 	= parseInt(this.structure.$item.css('margin-right').slice(0,-2));
			this.options.vars.contW 	= $('.thumbs').width();

			// Define list size, max scrolling and offset on click
			this.options.vars.listW 	= ( this.options.vars.liw * nbli ) + ( this.options.vars.gutter * ( nbli - 1 ) );
			this.options.vars.maxOffset =  - ( this.options.vars.startPos + ( this.options.vars.listW - this.options.vars.contW ) );
			this.options.vars.offset 	= this.options.vars.liw + this.options.vars.gutter;

			// this flag is checked against to see if the "click" function can happen
			this.options.vars.clickIsValid = true;
			// this is how many milliseconds you want to allow before click doesn't count
			this.options.vars.delay = 500;
			this.options.vars.cancelClick = null;

			// Hold click functions on buttons prev and next
			this.structure.$btn.prv.mousedown( function() {
				$this.hold('prev');
			});
			this.structure.$btn.nxt.mousedown( function() {
				$this.hold('next');
			});

			// Hold click functions on buttons prev and next
			this.structure.$btn.prv.mouseup( function(e) {
				e.preventDefault();
				$this.release('prev');
			});
			this.structure.$btn.nxt.mouseup( function(e) {
				e.preventDefault();
				$this.release('next');
			});

			if (this.options.draggable) {
				this.$element.addClass('draggable');
			}
		}
    }

	SmoothGallery.prototype.hold = function(dir) {
		var $this = this;
		this.options.vars.cancelClick = setTimeout( function() {
			$this.options.vars.clickIsValid = false;

			var posL = parseInt($this.structure.$list.css('left').slice(0,-2)),
				speed = $this.options.scrollSpeed;

			if (dir == 'prev') {
				$this.options.vars.nextPos = 0;
				speed   = Math.abs( Math.round( ( ( 0 - posL) / $this.options.vars.offset ) * $this.options.scrollSpeed ) );
			}
			if (dir == 'next') {
				$this.options.vars.nextPos = $this.options.vars.maxOffset;
				speed   = Math.abs( Math.round( ( ( $this.options.vars.maxOffset - posL ) / $this.options.vars.offset ) * $this.options.scrollSpeed ) );
			}

			$this.structure.$list.animate({ left: $this.options.vars.nextPos+'px' },speed);
		}, this.options.vars.delay );
	}

	SmoothGallery.prototype.release = function(dir) {
		clearTimeout( this.options.vars.cancelClick );

		//if the time limit wasn't passed, this will be true
		if ( this.options.vars.clickIsValid ) {
			this.click(dir);
		} else {
			this.structure.$list.stop();
		}

		this.options.vars.clickIsValid = true;
	}

	SmoothGallery.prototype.click = function(dir) {
		var $this = this;
		var posL = parseInt(this.structure.$list.css('left').slice(0,-2)),
			nextPos = 0;

		if (dir == 'prev') {
			nextPos = posL + $this.options.vars.offset;
			if( nextPos > 0) {
				nextPos = 0;
			}
		}
		if (dir == 'next') {
			nextPos = posL - $this.options.vars.offset;
			if( nextPos < $this.options.vars.maxOffset) {
				nextPos = $this.options.vars.maxOffset;
			}
		}

		this.structure.$list.animate({ left: nextPos+'px' },this.options.scrollSpeed);
	}


    // SMOOTH GALLERY PLUGIN DEFINITION
    // =================================

    function Plugin() {
        var arg = arguments;
        return this.each(function () {
            var $this   = $(this),
                data    = $this.data('bs.dropdownselect'),
                method  = arg[0];

            if( typeof(method) == 'object' || !method ) {
                var options = typeof method == 'object' && method;
                if (!data) $this.data('bs.dropdownselect', (data = new SmoothGallery(this, options)));
            } else {
                if (data[method]) {
                    method = data[method];
                    arg = Array.prototype.slice.call(arg, 1);
                    if(arg != null || arg != undefined || arg != [])  method.apply(data, arg);
                } else {
                    $.error( 'Method ' +  method + ' does not exist on jQuery.SmoothGallery' );
                    return this;
                }
            } })
    }

    var old = $.fn.smoothGallery

    $.fn.smoothGallery             = Plugin
    $.fn.smoothGallery.Constructor = SmoothGallery

    // SMOOTH GALLERY NO CONFLICT
    // ===========================

    $.fn.toggle.noConflict = function () {
        $.fn.smoothGallery = old
        return this
    }

    // SMOOTH GALLERY DATA-API
    // ========================

    $(function() {
        $('.smooth-gallery').smoothGallery();
    });
}(jQuery);