/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, magix-cms.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * JS theme default
 *
 */
$(document).ready(function(){
/*####################Formulaire Validation######################*/
	$.validator.setDefaults({
		debug: false,
		highlight: function(element, errorClass) {
			$(element).removeClass("ui-widget-content");
		    $(element).addClass("ui-state-error");
		},
		unhighlight: function(element, errorClass) {
			$(element).addClass("ui-widget-content");
			$(element).removeClass("ui-state-error");
		},
		// the errorPlacement has to take the table layout into account
		errorPlacement: function(error, element) {
			//error.prependTo( element.parents().siblings('.errorInput') );
			if ( element.is(":radio") )
				error.insertAfter(element);
			else if ( element.is(":checkbox") )
				error.insertAfter(element);
			else if ( element.is("select") )
				error.insertAfter(element.next());
			else if ( element.next().is(":button") )
				error.insertAfter(element.next());
			else
				error.insertAfter(element);
		},
		errorClass: "stateVal",
		errorElement:"div",
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("").addClass("checked");
		}
	});
});