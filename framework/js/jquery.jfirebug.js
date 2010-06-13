/**
 * @name  jfirebug
 * jQuery Tools for firebug console
 * @author Gerits Aurelien
 * @create 13 juin 2010
 * @update 
 * @version 1.0.1 beta
 * Copyright (c) 2010 Gerits aurelien (magix-cjquery.com)
 * Dual licensed under the MIT and AGPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/agpl.html
 * 
 * 
 * exemple: 
 * $(function() {
	var test = $("#test").width();
	$("#test").jfirebug({
		command:"log",
		message: test,
		object: true
	});
   });
 *
 */
;(function($) {
	/**
	 * Default value
	 */
	var defaults = {
		command:  "log",
		message:  false,
		object: false
	};
	/**
	 * Ini plugin jfirebug
	 */
	$.fn.jfirebug = function(settings) {
		// Initialize the console
		$.extend(this, defaults, settings);
		var config = this;
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
		}
		/**
		 * Calculate time execution
		 */
		/*jQuery.fn.calculTime = function () {
			console.time(this.title);
			this.functTimer;
			console.timeEnd(this.title);
			return this;
		};*/
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
			console.info("%s: %o", msg, this);
			return this;
		};
		/**
		 *  $(element).msgwarning()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msgwarning = function (msg) {
			console.warn("%s: %o", msg, this);
			return this;
		};
		/**
		 *  $(element).msgerror()
		 * Retourne un message log avec des informations sur l'élément DOM
		 * @return string
		 */
		jQuery.fn.msgerror = function (msg) {
			console.error("%s: %o", msg, this);
			return this;
		};
		 /**
		 * Initialisation de jquery log firebug
		 * $.log(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.log(test);
		 */
		function log(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        return console.log(object);
			}
		};
		/**
		 * Initialisation de jquery debug firebug
		 * $.debug(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.debug(test);
		 */
		function debug(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        return console.debug(object);
			}
		};
		/**
		 * Initialisation de jquery info firebug
		 * $.info(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.info(test);
		 */
		function info(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        return console.info(object);
			}
		};
		/**
		 * Initialisation de jquery warning firebug
		 * $.warning(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.warning(test);
		 */
		function warning(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        return console.warn(object);
			}
		};
		/**
		 * Initialisation de jquery error firebug
		 * $.error(object)
		 * @Example :
		 * var test = $('#test').width();
		 * $.error(test);
		 */
		function error(object,options) {
			if (typeof object != 'undefined') {
		        options = options || {};
		        if (object === null) {
		        	object = '';
		        }
		        return console.error(object);
			}
		};
		/**
		 * Switch command line jfirebug
		 */
		switch (this.command){
		/**
		 * Si message n'est pas vide on retourne la ligne de commande firebug
		 */
			case "log":
				if(this.message != false){
					log(this.message);
					if(this.object != false){
						this.msglog(this.message);
					}
				}else{
					this.msglog("Empty");
				}
				break;
			case "debug":
				if(this.message != false){
					debug(this.message);
					if(this.object != false){
						this.msgdebug(this.message);
					}
				}else{
					this.msgdebug("Empty");
				}
				break;
			case "info":
				if(this.message != false){
					info(this.message);
					if(this.object != false){
						this.msginfo(this.message);
					}
				}else{
					this.msginfo("Empty");
				}
				break;
			case "warning":
				if(this.message != false){
					warning(this.message);
					if(this.object != false){
						this.msgwarning(this.message);
					}
				}else{
					this.msgwarning("Empty");
				}
				break;
			case "error":
				if(this.message != false){
					error(this.message);
					if(this.object != false){
						this.msgerror(this.message);
					}
				}else{
					this.msgerror("Empty");
				}
				break;
			default:
				alert('The command option only accepts "log", "debug", "warning", or "error"');
		}
	};
})(jQuery);