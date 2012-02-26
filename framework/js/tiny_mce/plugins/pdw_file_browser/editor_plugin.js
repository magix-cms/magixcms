(function() {
	tinymce.create('tinymce.plugins.PDWFileBrowser', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			
			var PDWfilebrowser = function(field_name, url, type, win, insert) {

			  var fileBrowserURL = tinyMCE.activeEditor.settings.pdw_file_browser_url + "?editor=tinymce&filter=" + type;
			  var vars = insert ? insert : {};
			  vars = tinymce.extend(vars, {
			    window: win,
			    input: field_name,
			    type: type
			  });

			  tinyMCE.activeEditor.windowManager.open({
			    title: "intelligentgolf File Browser",
			    url: fileBrowserURL,
			    width: 900,
			    height: 600,
			    maximizable: 1,
			    close_previous: 0,
			    inline: false
			  },vars);
			}
		
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('pdw_insertimage', function() {
				PDWfilebrowser('', '', 'image', window,{insert:'toDocument'});
			});

			// Register example button
			ed.addButton('pdw_insertimage', {
				title : 'Insert Image',
				cmd : 'pdw_insertimage',
				image : url + '/img/insertimage.gif'
			});

			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('pdw_inserfile', function() {
				PDWfilebrowser('', '', 'file', window,{insert:'toDocument'});
			});

			// Register example button
			ed.addButton('pdw_insertfile', {
				title : 'Insert File',
				cmd : 'pdw_inserfile',
				image : url + '/img/insertfile.gif'
			});
	
			tinyMCE.activeEditor.settings.file_browser_callback = PDWfilebrowser;

			// Add a node change handler, selects the button in the UI when a image is selected
			//ed.onNodeChange.add(function(ed, cm, n) {
			//	cm.setActive('example', n.nodeName == 'IMG');
			//});
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
				longname : 'Example plugin',
				author : 'Some author',
				authorurl : 'http://tinymce.moxiecode.com',
				infourl : 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/example',
				version : "1.0"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('pdw_file_browser', tinymce.plugins.PDWFileBrowser);
})();

