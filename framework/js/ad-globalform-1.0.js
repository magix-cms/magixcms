/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ad-globalform
 *
 */
/**
 * Menu select dynamique avec retour html
 * @addon Dépendance avec jquery relatedselect
 * @param id
 * @param url
 * @param params
 */
function dynamical_select_html(id,url,params){
	$.getScript('/framework/js/tools/jquery.relatedselects.min.js', function() {
		$(id).relatedSelects({
			onChangeLoad: url,
			dataType: 'html',
			defaultOptionText: 'Choose an Option',
			loadingMessage: 'Loading, please wait...',
			disableIfEmpty:true,
			selects: params
		});
	});
}
/**
 * Menu select dynamique avec retour json
 * @addon Dépendance avec jquery relatedselect
 * @param id
 * @param url
 * @param params
 */
function dynamical_select_json(id,url,params){
	$.getScript('/framework/js/tools/jquery.relatedselects.min.js', function() {
		$(id).relatedSelects({
			onChangeLoad: url,
			dataType: 'json',
			defaultOptionText: 'Choose an Option',
			loadingMessage: 'Loading, please wait...',
			disableIfEmpty:true,
			selects: params
		});
	});
}
/**
 * Execution de la barre de téléchargement de base
 * @returns {Boolean}
 */
function updateProgress() {
	  var progress;
	  progress = $("#progressbar")
	    .progressbar("option","value");
	  if (progress <= 100) {
	      $("#progressbar")
	        .progressbar("option", "value", progress + 5);
	      $("#progressText").text(progress+"%");
	      setTimeout(updateProgress, 100);
	  }
	  if(progress>=100){
		  location.reload();
	  }
	 return false;
}
/**
 * Execution de la barre de téléchargement supplémentaire
 * @returns {Boolean}
 */
function updateProgress2() {
	  var progress;
	  progress = $("#progressbar2")
	    .progressbar("option","value");
	  if (progress <= 100) {
	      $("#progressbar2")
	        .progressbar("option", "value", progress + 5);
	      $("#progressText2").text(progress+"%");
	      setTimeout(updateProgress2, 100);
	  }
	  if(progress>=100){
		  location.reload();
	  }
	 return false;
}
/**
 * Proposition aléatoire de mot de passe
 * @returns {String}
 */
function randomPassword() {
	var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+";
	var size = 10;
	var i = 1;
	var ret = '';
	while ( i <= size ) {
		$max = chars.length-1;
		$num = Math.floor(Math.random()*$max);
		$temp = chars.substr($num, 1);
		ret += $temp;
		i++;
	}
	return ret;
}
/**
 * Nettoie une chaine de caractères
 * @param string
 * @returns
 */
function cleanString(string) {
	  clean = string.replace(/[àâä]/g,"a");
	  clean = clean.replace(/[ÈÉÊËèéêë]/g,"e");
	  clean = clean.replace(/[îï]/g,"i");
	  clean = clean.replace(/[ôö]/g,"o");
	  clean = clean.replace(/[ùûü]/g,"u");
	  return clean;
}
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
			else
				if(element.next().is(":submit") || element.next().is(":button") || element.next().is(":file")){
					error.insertAfter(element.next());
					$("<br />").insertBefore(error);
				}else if(element.next().is(".ui-datepicker-trigger")){
					error.insertAfter(element.next());
					$("<br />").insertBefore(error);
				}else{
					error.insertAfter(element);
				}
		},
		errorClass: "stateVal",
		errorElement:"div",
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("").addClass("checked");
		}
	});
	$("div.stateVal").prepend('<span class="lfloat ui-icon ui-icon-alert"></span>');
		$("#pseudo").focus(function() {
			cleanString($(this).val().toLowerCase());
		});
		$("#pseudo").keyup(function(){
	        $(this).val(cleanString($(this).val()));
		});
		$('#randPassword').click(function(){
			$('#word_composer').val( randomPassword() );
			return false;
		});
		$("#cryptpass").keyup(function() {
			  $(this).valid();
		});
		//$('input').checkBox();
	//$("form input").filter(":checkbox,:radio").checkbox();
});