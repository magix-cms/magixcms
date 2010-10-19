/**
 * MAGIX CMS
 * @category   javascript
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @package    Ckeditor
 * @name	   Ckeditor
 *
 */
$(function() {
	$.getScript('/framework/js/ckeditor/adapters/jquery.js', function() {
	var config = 
	{/*baseHref : 'http://www.example.com/path/',*/
		customConfig: "/framework/js/ckeditor/config.js",
		skin : 'kama',
		uiColor : '#C2CEEA',
		filebrowserBrowseUrl : manager_filebrowserBrowseUrl,
        filebrowserImageBrowseUrl : manager_filebrowserImageBrowseUrl,
		toolbar:
	      [
	        ['Source','-','NewPage','Preview','-','Templates'],
		    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
		    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
		    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['Link','Unlink','Anchor'],
		    ['Image','Flash','Table','HorizontalRule','SpecialChar','PageBreak'],
		    '/',
		    ['Styles','Format','Font','FontSize'],
		    ['TextColor','BGColor'],
		    ['Maximize', 'ShowBlocks','-']
	      ],
	      language : 'fr'
	};
	$('.mceEditor').ckeditor(config); 
	});
});