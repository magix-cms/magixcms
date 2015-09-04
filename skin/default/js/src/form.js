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

    // *** Set default values for forms validation
	$.validator.setDefaults({
        debug: false,
        highlight: function(element, errorClass, validClass) {
            if($(element).parent().is("p")){
                $(element).parent().addClass("error");
            }else if($(element).parent().is("div")){
                $(element).parent().parent().addClass("error");
            }
        },
        unhighlight: function(element, errorClass, validClass) {
            if($(element).parent().is("p")){
                $(element).parent().removeClass("error");
            }else if($(element).parent().is("div")){
                $(element).parent().parent().removeClass("error");
            }
        },
        // the errorPlacement has to take the table layout into account
        errorPlacement: function(error, element) {
            if ( element.is(":radio") ){
                error.insertAfter(element);
            }else if ( element.is(":checkbox") ){
                error.insertAfter(element);
            }else if ( element.is("select")){
                error.insertAfter(element);
            }else if ( element.is(".checkMail") ){
                error.insertAfter(element.next());
            }else if ( element.is("#cryptpass") ){
                error.insertAfter(element.next());
                $("<br />").insertBefore(error);
            }else{
                if(element.next().is(":button") || element.next().is(":file")){
                    error.insertAfter(element);
                    $("<br />").insertBefore(error);
                }else if ( element.next().is(":submit") ){
                    error.insertAfter(element.next());
                    $("<br />").insertBefore(error);
                }else{
                    error.insertAfter(element);
                }
            }
        },
        errorClass: "alert alert-warning",
        errorElement:"div",
        validClass: "success",
        // set this class to error-labels to indicate valid fields
        success: function(label) {
            // set &nbsp; as text for IE
            label.remove();
        } 
    });
});