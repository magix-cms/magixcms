/** 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @package    TinyMCE
 * @name	   codehighlight
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
			var dom = ed.dom;
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
			ed.onVisualAid.add(t._visualAid, t);
		},
		// Private methods

		_visualAid : function(ed, e, s) {
			var dom = ed.dom;
			tinymce.each(dom.select('pre.codehighlight', e), function(e) {
				dom.setStyles(e, {'background-color' : '#dcdcdc', 'padding': '2px'});
			});
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
				author : 'Gérits Aurélien',
				authorurl : 'http://www.magix-cjquery.com',
				infourl : 'http://www.magix-cjquery.com',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('codehighlight', tinymce.plugins.CodeHighLight);
})();