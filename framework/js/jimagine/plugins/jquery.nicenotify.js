/*
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of Jimagine.
# Toolbox for jQuery
# Copyright (C) 2011 - 2012  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
# 
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
*/
/**
 * MAGIX DEV
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.1
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be>
 * @name nicenotify
 * @exemple :
   $.nicenotify({
		ntype: "simple"
   });
   $.nicenotify({
		ntype: "ajax",
		uri: '',
		typesend: 'get',
		datatype: 'json'
	});
	$.nicenotify({
		ntype: "submit",
		uri: '',
		typesend: 'post',
		idforms: form,
		resetform:true,
		beforeParams:function(){
			$(":submit").button({
				disabled: true,
				label: "Please wait...."
			});
		},
		successParams:function(e){
			$(":submit").button({disabled: false,label: "Envoyer"});
			$.nicenotify.initbox(e,{
				display : true,
				time: 4,
				reloadhtml:false,
				delay: 3000,
				elemid : '#notify-header',
				elemclass : '.dc-head-request',
				background : "#efefef",
				text : ''
			});
		}
	});
 */
(function($){
	$.nicenotify = function(options){
		opt = $.extend(true,{},$.nicenotify.defaults,options);
		//console.log(opt.uri);
		//var self : this,
		if(typeof opt != 'object'){
			console.log(opt);
		}
		if(opt.ntype == '' || opt.ntype == null){
			console.log('ntype is null');
		}
		var init = {
			_simple: function(successParams){
				successParams;
	        },
			_ajax: function(uri,typesend,datatype,noticedata,beforeParams,successParams){
	        	$.ajax({
	        		url:uri,
	        		type:typesend,
	        		dataType: datatype,
	        		statusCode: {
	    				0: function() {
	    					console.error("jQuery Error");
	    				},401: function() {
	    					console.warn("access denied");
	    				},404: function() {
	    					console.warn("object not found");
	    				},403: function() {
	    					console.warn("request forbidden");
	    				},408: function() {
	    					console.warn("server timed out waiting for request");
	    				},500: function() {
	    					console.error("Internal Server Error");
	    				}
	    			},
	        		async: true,
	        		data: noticedata,
	        		beforeSend: beforeParams,
	        		success: successParams
	        	}).fail(function(xhr, status, error){
	        		console.group('Error nicenotify');
		            	console.error('Status %s ',status);
		            	console.error('URL: '+uri+' %s',error);
	            	console.groupEnd();
	        	});
	        },
	        _submit: function(uri,typesend,noticedata,resetform,beforeParams,successParams){
	        	if(jQuery().ajaxSubmit) {
		        	$(opt.idforms).ajaxSubmit({
		        		url:uri,
		        		type:typesend,
		        		data:noticedata,
		        		resetForm: resetform,
		        		beforeSubmit:beforeParams,
		        		success: successParams
		        	});
	        	}
	        }
		};
		switch(opt.ntype){
	    	case "simple":
	    		init._simple(opt.successParams);
	    	break;
	    	case "ajax":
	    		init._ajax(opt.uri,opt.typesend,opt.datatype,opt.noticedata,opt.beforeParams,opt.successParams);
	    	break;
	    	case "submit":
	    		init._submit(opt.uri,opt.typesend,opt.noticedata,opt.resetform,opt.beforeParams,opt.successParams);
	    	break;
	    }
	    if(opt.ntype == ""){
	    	console.log("%s: %o","ntype is null");
	    	return false;
	    }else if(opt.ntype == undefined){
	    	console.log("%s: %o","ntype is undefined");
	    	return false;
	    }
	};
	$.nicenotify.defaults = {
		ntype: "simple",
		dataType: '',
		idforms: null,
		uri: null,
		typesend: 'post',
		noticedata: {},
		resetform:false,
		beforeParams:function(){},
		successParams: function(e){
			$.nicenotify.initbox(e);
		},
		debug:false
	};
	$.nicenotify.initbox = function(request,settings) {
		var optbox = {
			display : true,
			time: 2,
			reloadhtml:false,
			delay: 2800,
			box:{
				elemid : '#notify-header',
				elemclass : '.mc-head-request',
				background : "#efefef",
				text : '',
				src : '/framework/js/jquery.meerkat.1.3.min.js'
			}
		};
		var opts = $.extend(true,{},optbox,settings);
		if ( !$.isPlainObject( opts ) ){
			console.log( opts.box.elemid );
		}
		if(typeof opts != 'object'){
			console.log('nicenotify initbox is not object');
		}
	    if(opts.display != false){
	    	var $id = $(opts.box.elemid);
			$.ajax({
        		url:opts.box.src,
        		type:'get',
        		dataType: "script",
        		statusCode: {
    				0: function() {
    					console.error("jQuery Error");
    				},401: function() {
    					console.warn("access denied");
    				},404: function() {
    					console.warn("object not found");
    				},403: function() {
    					console.warn("request forbidden");
    				},408: function() {
    					console.warn("server timed out waiting for request");
    				},500: function() {
    					console.error("Internal Server Error");
    				}
    			},
        		success: function(data, status, xhr){
        			if(jQuery().meerkat){
        				$id.destroyMeerkat();
        				$id.meerkat({
    						background: opts.box.background,
    						width: '100%',
    						position: 'top',
    						close: '.close-notify',
    						animationIn: 'fade',
    						animationOut: 'slide',
    						animationSpeed: '750',
    						height: '80px',
    						opacity: '0.90',
    						timer: opts.time,
    						onMeerkatShow: function() { 
    							$(this).animate({opacity: 'show'}, 1000); 
    						}
    					}).addClass('pos-top');
    				}else{
    					// plugin DOES NOT exist
    					//console.log('plugin for display DOES NOT exist');
    					console.log('plugin for display DOES NOT exist');
    				}
        		}
        	}).fail(function(xhr, status, error){
    			console.group('Error nicenotify');
            		console.error('Status %s ',status);
            		console.error('%s',error);
            	console.groupEnd();
        	});
        	/*.then(function(){
        		   console.log("Appel 1");
        	 })
        	.done(function(){
        		   console.log("Fini");
        	});*/
			if(opts.box.text != '' || opts.box.text !=null){
				var boxtext = opts.box.text;
			}else{
				var boxtext = '';
			}
			if(opts.box.elemclass != '' || opts.box.elemclass !=null){
				var class_container = opts.box.elemclass;
			}else{
				var class_container = '';
				console.error('elemclass is empty');
			}
			$(class_container).html(boxtext+request);
	    }
		if(opts.reloadhtml == true){
			setTimeout(function(){
				location.reload();
			},opts.delay);
		}
	}
})(jQuery);