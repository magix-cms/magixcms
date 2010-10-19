/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name mc_editor_config
 *
 */
/**
 * Fonction pour retourner les paramètres supplémentaires de l'éditeur html
 * @name editorhtml
 * @param settings
 */
(function($) { 
    $.editorhtml = function(settings) { 
    	var options =  { 
    		editor: "tinymce"
    	};
        $.extend(options, settings);
        switch(options.editor){
        	case "tinymce":
        		var config = tinyMCE.triggerSave(true,true);
        	break;
        	case "ckeditor":
        		var config = "";
        	break;
        }
        if(options.editor != ""){
        	return config;
        }else if(options.editor == undefined){
        	console.log("%s: %o","editorhtml is undefined",config);
        	return false;
        }else{
        	console.log("%s: %o","Config is not found",config);
        	return false;
        }
    }; 
})(jQuery); 