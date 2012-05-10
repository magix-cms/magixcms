/**
 * You Tube plug-in for TinyMCE version 3.x
 * @author     Gerits Aurelien
 * @version    $Rev: 13 $
 * @package    YouTube
 * @link http://magix-cjquery.com or http://www.magix-cms.com
 * YouTube plugin for TinyMCE
 * GPL 3 LICENCES
 */

(function() {
	// Load plugin specific language pack
	tinymce.PluginManager.requireLangPack('youtube');

	tinymce.create('tinymce.plugins.YouTubePlugin', {
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
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceYouTube');
			ed.addCommand('mceYouTube', function() {
				ed.windowManager.open({
					file : url + '/youtube.htm',
					width : 400 + parseInt(ed.getLang('youtube.delta_width', 0)),
					height : 240 + parseInt(ed.getLang('youtube.delta_height', 0)),
					inline : 1
				}, {
					plugin_url : url, // Plugin absolute URL
					some_custom_arg : 'custom arg' // Custom argument
				});
			});

			// Register youtube button
			ed.addButton('youtube', {
				title : 'youtube.desc',
				cmd : 'mceYouTube',
				image : url + '/img/youtube.gif'
			});

			// Add a node change handler, selects the button in the UI when a image is selected
			ed.onNodeChange.add(function(ed, cm, n) {
				cm.setActive('youtube', n.nodeName == 'IMG');
			});
			ed.onVisualAid.add(t._visualAid, t);
		},
		// Private methods

		_visualAid : function(ed, e, s) {
			var dom = ed.dom;
			tinymce.each(dom.select('div.youtube', e), function(e) {
				dom.setStyles(e, {'background-color' : '#dcdcdc', 'padding': '2px'});
				/*if (s){
					dom.addClass(e, 'mceItemMedia');
					dom.addClass(e, 'mceItem');
				}else{
					dom.removeClass(e, 'mceItemMedia');
					dom.removeClass(e, 'mceItem');
				}*/
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
				longname : 'YouTube plugin',
				author : 'Gerits Aurelien',
				authorurl : 'http://www.magix-cms.com',
				infourl : 'http://www.magix-dev.be',
				version : "1.4"
			};
		}
	});
	// Register plugin
	tinymce.PluginManager.add('youtube', tinymce.plugins.YouTubePlugin);
})();