/** 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <gerits.aurelien@gmail.com>
 * @package    TinyMCE
 * @name	   codehighlight
 */
tinyMCEPopup.requireLangPack();
var CodeHighLightDialog = {
	init : function() {
	},
	insert : function() {
		var f = document.forms[0], objectCode, options = '';
		//If no code just return.
		if(f.codehighlight_code.value == '') {
		  tinyMCEPopup.close();
		  return false;
		}
		if(f.codehighlight_nogutter.checked) {
		  options += 'gutter: false; ';
		}
		if(f.codehighlight_light.checked) {
		  options += 'light: true; ';
		}
		if(f.codehighlight_collapse.checked) {
		  options += 'collapse: true; ';
		}
		/*if(f.codehighlight_fontsize.value != '') {
		  var fontsize=parseInt(f.codehighlight_fontsize.value);
		  options += 'fontsize: ' + fontsize + '; ';
		}*/
		if(f.codehighlight_firstline.value != '') {
		  var linenumber = parseInt(f.codehighlight_firstline.value);
		  options += 'first-line: ' + linenumber + '; ';
		}
		if(f.codehighlight_highlight.value != '') {
		  options += 'highlight: [' + f.codehighlight_highlight.value + ']; ';
		}
		var objectCode = '<pre class="codehighlight brush: ';
		objectCode += f.codehighlight_language.value + ';' + options + '">';
		objectCode +=  tinyMCEPopup.editor.dom.encode(f.codehighlight_code.value);
		objectCode += '</pre> ';
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, objectCode);
		tinyMCEPopup.close();
	}
};
tinyMCEPopup.onInit.add(CodeHighLightDialog.init, CodeHighLightDialog);