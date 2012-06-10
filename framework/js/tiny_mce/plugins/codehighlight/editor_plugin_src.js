/**
 * http://www.magix-dev.be, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @package    TinyMCE
 * @name	   codehighlight
 * GPL 3 LICENCES
 */
(function() {
	//Load the language file.
	tinymce.PluginManager.requireLangPack('codehighlight');
	
	tinymce.create('tinymce.plugins.CodeHighLight', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			var t = this;

			t.editor = ed;
			//var dom = ed.dom;
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('mceCodeHighLight', function() {
				ed.windowManager.open({
					file : url + '/dialog.htm',
					width : 450 + parseInt(ed.getLang('codehighlight.delta_width', 0)),
					height : 400 + parseInt(ed.getLang('codehighlight.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});

			// Register example button
			ed.addButton('codehighlight', {
				title : 'codehighlight.desc',
				cmd : 'mceCodeHighLight',
				image : url + '/img/codehighlight.png'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('codehighlight', n.nodeName == 'IMG');
			});
			//ed.onVisualAid.add(t._visualAid, t);

            ed.onInit.add(function( ed )
            {
                ed.dom.loadCSS(url + '/css/codeditor.css');
            });
        // MSIE and WebKit inserts a new PRE each time the user hits enter.
        // Gecko and Opera inserts a BR element. This will make sure that IE and WebKit has the same behaviour as Fx and Opera.
        if ( tinymce.isIE || tinymce.isWebKit ){
            ed.onKeyDown.add(function( ed, e )
            {
                var brElement;
                var selection = ed.selection;

                if ( e.keyCode == 13 && selection.getNode().nodeName === 'PRE' )
                {
                    selection.setContent('<br id="__codehighlight" /> ', {format : 'raw'}); // Do not remove the space after the BR element.

                    brElement = ed.dom.get('__codehighlight');
                    brElement.removeAttribute('id');
                    selection.select(brElement);
                    selection.collapse();
                    return tinymce.dom.Event.cancel(e);
                }
            });
        }

        // Inserts a tab in Gecko and Opera when the user hits the tab key.
        if ( tinymce.isGecko || tinymce.isOpera )
        {
            ed.onKeyDown.add(function( ed, e )
            {
                var selection = ed.selection;

                if ( e.keyCode == 9 && selection.getNode().nodeName === 'PRE' )
                {
                    selection.setContent('\t', {format : 'raw'});
                    return tinymce.dom.Event.cancel(e);
                }
            });
        }

        if ( tinymce.isGecko )
        {
            ed.onSetContent.add(function( ed, o )
            {
                t._replaceNewlinesWithBrElements(ed);
            });
        }

        ed.onPreProcess.add(function( ed, o )
        {
            t._replaceBrElementsWithNewlines(ed, o.node);

            if ( tinymce.isWebKit )
            {
                t._removeSpanElementsInPreElementsForWebKit(ed, o.node);
            }

            var el = ed.dom.get('__codehighlightFixTooltip');
            ed.dom.remove(el);
        });
    },

    // -----------------------------------------------------------------------------------------------------------------
    // Private methods
    _nl2br: function( strelem )
    {
        var t = this;
        //Redefined the espace and unescape function

        if(!(t.escape && t.unescape)) {
            var escapeHash = {
                _ : function(input) {
                    var ret = escapeHash[input];
                    if(!ret) {
                        if(input.length - 1) {
                            ret = String.fromCharCode(input.substring(input.length - 3 ? 2 : 1));
                        }
                        else {
                            var code = input.charCodeAt(0);
                            ret = code < 256
                                ? "%" + (0 + code.toString(16)).slice(-2).toUpperCase()
                                : "%u" + ("000" + code.toString(16)).slice(-4).toUpperCase();
                        }
                        escapeHash[ret] = input;
                        escapeHash[input] = ret;
                    }
                    return ret;
                }
            };
            t.escape = t.escape || function(str) {
                return str.replace(/[^\w @\*\-\+\.\/]/g, function(aChar) {
                    return escapeHash._(aChar);
                });
            };
            t.unescape = t.unescape || function(str) {
                return str.replace(/%(u[\da-f]{4}|[\da-f]{2})/gi, function(seq) {
                    return escapeHash._(seq);
                });
            };
        }
        strelem = t.escape(strelem);
        var newlineChar;

        if(strelem.indexOf('%0D%0A') > -1 )
        {
            newlineChar = /%0D%0A/g ;
        }
        else if ( strelem.indexOf('%0A') > -1 )
        {
            newlineChar = /%0A/g ;
        }
        else if ( strelem.indexOf('%0D') > -1 )
        {
            newlineChar = /%0D/g ;
        }

        if ( typeof(newlineChar) == "undefined")
        {
            return t.unescape( strelem );
        }
        else
        {
            return t.unescape( strelem.replace(newlineChar, '<br/>') );
        }
    },

    _replaceNewlinesWithBrElements: function( ed )
    {
        var t = this;
        
        var preElements = ed.dom.select('pre');
        for ( var i = 0; i < preElements.length; i++ )
        {
            preElements[i].innerHTML = t._nl2br(preElements[i].innerHTML);
        }
    },

    // -----------------------------------------------------------------------------------------------------------------

     _replaceBrElementsWithNewlines: function( ed, node )
    {
        var brElements = ed.dom.select('pre br', node);
        var newlineChar = tinymce.isIE ? '\r' : '\n';
        var newline;

        for ( var i = 0; i < brElements.length; i++ )
        {
            newline = ed.getDoc().createTextNode(newlineChar);

            ed.dom.insertAfter(newline, brElements[i]);
            ed.dom.remove(brElements[i]);
        }
    },
    // -----------------------------------------------------------------------------------------------------------------

    _removeSpanElementsInPreElementsForWebKit: function( ed, node )
    {
        // WebKit inserts a span element each time the users hits the tab key.
        // This removes the element.
        var spanElements = ed.dom.select('pre span', node);
        var space;
        for ( var i = 0; i < spanElements.length; i++ )
        {
            space = ed.getDoc().createTextNode(spanElements[i].innerHTML);
            ed.dom.insertAfter(space, spanElements[i]);
            ed.dom.remove(spanElements[i]);
        }
    },
		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Code Highlight',
				author : 'Gerits Aurelien',
				authorurl : 'http://www.magix-dev.be',
				infourl : 'http://www.magix-cjquery.com',
				version : "1.2"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('codehighlight', tinymce.plugins.CodeHighLight);
})();