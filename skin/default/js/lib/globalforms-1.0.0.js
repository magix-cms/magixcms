$(document).ready(function(){
/*####################Formulaire Validation######################*/
	    $.validator.setDefaults({
			debug: false,
			highlight: function(element, errorClass) {
			       $(element).css('border',"1px solid red");
			},
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
				error.prependTo( element.parents().siblings('.errorInput') );
			},
			// set this class to error-labels to indicate valid fields
			success: function(label) {
				// set &nbsp; as text for IE
				label.html("&nbsp;").addClass("checked");
			},
			unhighlight: function(element, errorClass) {
				$(element).css('border',"1px solid #ccc");
			}
		});
		$.validator.addMethod("accept", function(value, element, param) {
			return value.match(new RegExp("." + param + "$"));
		});	
		$.validator.addMethod('maxWords', function(value, element, params) {
		    return !$(element).val() || $(element).val().match(/\b\w+\b/g).length < params;
		}, 'Please enter {0} words or less.');
		$.validator.addMethod('minWords', function(value, element, params) {
		    return !$(element).val() || $(element).val().match(/\b\w+\b/g).length >= params;
		}, 'Please enter at least {0} words.');
		$.validator.addMethod('rangeWords', function(value, element, params) {
		    return !$(element).val() || ($(element).val().match(/\b\w+\b/g).length >= params[0] && $(element).val().match(/\b\w+\b/g).length < params[1]);
		}, 'Please enter between {0} and {1} words.');
		$.each($.validator.messages, function(i) {
			$.validator.messages[i] = "*";
		});
		$.validator.addMethod("letterswithbasicpunc", function(value, element) {
			return !$.validator.methods.required(value, element) || /^[a-z\-\.,\(\)\'\"\s]+$/i.test(value);
		}, "Letters or punctuation only please");  
		$.validator.addMethod("alphanumeric", function(value, element) {
			return !$.validator.methods.required(value, element) || /^\w+$/i.test(value);
		}, "Letters, numbers, spaces or underscores only please");  
		$.validator.addMethod("lettersonly", function(value, element) {
			return !$.validator.methods.required(value, element) || /^[a-z]+$/i.test(value);
		}, "Letters only please"); 
		$.validator.addMethod("nowhitespace", function(value, element) {
			return !$.validator.methods.required(value, element) || /^\S+$/i.test(value);
		}, "No white space please"); 
		$.validator.addMethod("anything", function(value, element) {
			return !$.validator.methods.required(value, element) || /^.+$/i.test(value);
		}, "May contain any characters."); 
		$.validator.addMethod("integer", function(value, element) {
			return !$.validator.methods.required(value, element) || /^\d+$/i.test(value);
		}, "Numbers only please");
		$.validator.addMethod("phone", function(value, element) {
			return !$.validator.methods.required(value, element) || /^\d{3}-\d{3}-\d{4}$/.test(value);
		}, "Must be XXX-XXX-XXXX");
		$.validator.addMethod("url", function(value, element) {
			return !$.validator.methods.required(value, element) || /^(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(value);
		}, "URL FORMAT http://www.mysite.com");
});