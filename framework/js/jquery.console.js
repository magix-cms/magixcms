/**
 * jQuery Tools for firebug console
 * @author Gerits Aurelien
 * Copyright (c) 2010 Gerits aurelien (magix-cjquery.com)
 * Dual licensed under the MIT and AGPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/agpl.html
 *
 */
;(function($) {
	//In case you don't have firebug...
	/*if (!window.console || !console.firebug) {
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
		window.console = {};
		for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};*/
		//if (window.console) window.console.log("text");
	if (! ('console' in window) || !('firebug' in console)) {
	    var names = ['log', 'debug', 'info', 'warn', 'error', 'assert', 'dir', 'dirxml', 'group', 'groupEnd', 'time', 'timeEnd', 'count', 'trace', 'profile', 'profileEnd'];
	    window.console = {};
	    for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
	}else{
		/**
		 * $(element).msglog
		 * @Exemple:
		 * $('#some_div').find('li.source > input:checkbox').log("sources to uncheck").removeAttr("checked");
		 * $('#test').msglog();
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msglog = function (msg) {
			console.log("%s: %o", msg, this);
			return this;
		};
		/**
		 * $(element).msgdebug()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msgdebug = function (msg) {
			console.debug("%s: %o", msg, this);
			return this;
		};
		/**
		 *  $(element).msginfo()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msginfo = function (msg) {
			console.debug("%s: %o", msg, this);
			return this;
		};
		/**
		 *  $(element).msgwarning()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msgwarning = function (msg) {
			console.debug("%s: %o", msg, this);
			return this;
		};
		/**
		 *  $(element).msgerror()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msgerror = function (msg) {
			console.debug("%s: %o", msg, this);
			return this;
		};
		/**
		 * Initialisation de jquery log firebug
		 * $.log(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.log(test);
		 */
		jQuery.log = function(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        var result = console.log(object);
		        return result;
			}
		};
	}
})(jQuery);