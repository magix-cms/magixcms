/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of Jimagine.
 # Toolbox for jQuery
 # Copyright (C) 2011 - 2013  Gerits Aurelien <aurelien[at]magix-dev[dot]be>
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
 * @copyright  MAGIX DEV Copyright (c) 2011 - 2013 Gerits Aurelien,
 * http://www.magix-dev.be
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.3
 * @author Gérits Aurélien <aurelien[at]magix-dev[dot]be> - <gerits[dot]aurelien[at]gmail[dot]com>
 * @name nicenotify
 * @example :
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
	                display: true,
	                refresh: false,
	                delay: 3000,
	                text: ''
	            },{
	                box:'meerkat',
	                time: 4,
	                elemid : '#notify-header',
	                elemclass : '.mc-head-request',
	                background : "#efefef"
	            });
		}
	});
 /**
 * Définir les valeurs par defaut pour le comportement du callback
 * *
 $.nicenotify.defaults = {
    display: true,
    refresh: false,
    delay: 2800,
    text: ''
};
 /**
 * Définir les valeurs par defaut pour le mode de notification
 * *
$.nicenotify.notifier = {
    box:'meerkat',
    time: 2,
    elemid : '#notify-header',
    elemclass : '.mc-head-request',
    background : "#efefef"
};
 */
;(function ( $, window, document, undefined ) {
	$.nicenotify = function(options){
        var settings = {
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
            }
        };
		var opt = $.extend(true,{},settings,options);
		//console.log(opt.uri);
		//var self : this,
		if(typeof opt != 'object' || opt == "undefined"){
			console.log(opt);
		}
		if(opt.ntype == "undefined" || opt.ntype == '' || opt.ntype == null){
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
                    cache: true,
                    data: noticedata,
                    beforeSend: beforeParams,
                    success: successParams
                }).done(function ( data ) {
                        if(opt.debug == true){
                            if( console && console.log ) {
                                console.log(data);
                            }
                        }
                }).fail(function(xhr, status, error){
                console.group('Error nicenotify');
                console.error('Status %s ',status);
                console.error('URL: '+uri+' %s',error);
                console.groupEnd();
                });
	        },
	        _submit: function(uri,typesend,noticedata,resetform,beforeParams,successParams){
                if(jQuery().ajaxSubmit) {
                    if(opt.debug == true){
                        $(opt.idforms).ajaxSubmit.debug = true;
                    }else{
                        $(opt.idforms).ajaxSubmit.debug = false;
                    }
                    $(opt.idforms).ajaxSubmit({
                        url:uri,
                        type:typesend,
                        data:noticedata,
                        resetForm: resetform,
                        beforeSubmit:beforeParams,
                        success: successParams
                    });
                }else{
                    console.error('jquery forms is not defined');
                }
	        }
		};
        if(opt.ntype == ""){
            console.log("%s: %o","ntype is null");
            return false;
        }else if(typeof(opt.ntype) == undefined){
            console.log("%s: %o","ntype is undefined");
            return false;
        }else{
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
        }
	};
    /**
     * Paramètres par defaut pour le comportement du callback
     * @type {Object}
     */
    $.nicenotify.defaults = {
        display: true,
        refresh: false,
        delay: 2800,
        debug: false,
        text: ''
    };
    /**
     * Paramètres par defaut pour le mode de notification
     * @type {Object}
     */
    $.nicenotify.notifier = {
        box:'meerkat',
        time: 2,
        elemid : '#notify-header',
        elemclass : '.mc-head-request',
        background : "#efefef"
    };
    /**
     * Retourne le setting avec des conditions pour la notification
     * @param setting
     * @return {Object|String}
     * @private
     */
    function _setBoxParams(setting){
        var optDefault = $.nicenotify.notifier;
        if(setting != null){
            if(typeof(setting.box) === "undefined" || optDefault.box === ""){
                set_box = optDefault.box;
            }else{
                set_box = setting.box;
            }
            if(typeof(setting.time) === "undefined"){
                set_time = optDefault.time;
            }else{
                set_time = setting.time;
            }
            if(typeof(setting.elemid) === "undefined"){
                set_elemid = optDefault.elemid;
            }else{
                set_elemid = setting.elemid;
            }
            if(typeof(setting.elemclass) === "undefined"){
                set_elemclass = optDefault.elemclass;
            }else{
                set_elemclass = setting.elemclass;
            }
            if(typeof(setting.background) === "undefined"){
                set_background = optDefault.background;
            }else{
                set_background = setting.background;
            }
        }else{

            if(typeof(optDefault.box) === "undefined" || optDefault.box === ""){
                set_box = "";
            }else{
                set_box = optDefault.box;
            }
            if(typeof(optDefault.time) === "undefined" || optDefault.time === ""){
                set_time = 2;
            }else{
                set_time = optDefault.time;
            }
            if(typeof(optDefault.elemid) === "undefined" || optDefault.elemid === ""){
                set_elemid = "";
            }else{
                set_elemid = optDefault.elemid;
            }
            if(typeof(optDefault.elemclass) === "undefined" || optDefault.elemclass === ""){
                set_elemclass = "";
            }else{
                set_elemclass = optDefault.elemclass;
            }
            if(typeof(optDefault.background) === "undefined" || optDefault.background === ""){
                set_background = "";
            }else{
                set_background = optDefault.background;
            }
        }
        var config = {
            box : set_box,
            time : set_time,
            elemid : set_elemid,
            elemclass : set_elemclass,
            background : set_background
        };
        if ( typeof config != 'object' ){
            console.log("%s: %o","config is not objet");
        }else{
            return config;
        }
    }

    /**
     * Définition du comportement de l'affichage du callback
     * @param request
     * @param setDefault
     * @param setNotifier
     */
	$.nicenotify.initbox = function(request,setDefault,setNotifier) {
		var opts = $.extend(true,{},$.nicenotify.defaults,setDefault);
        var optsNotifier = $.extend(true,{},$.nicenotify.notifier,_setBoxParams(setNotifier));
		if ( !$.isPlainObject( opts ) ){
			console.log( optsNotifier.elemclass );
		}
		if(typeof opts !== 'object'){
			console.log("%s: %o","nicenotify default initbox is not object");
		}else if(typeof optsNotifier != 'object'){
            console.log("%s: %o","nicenotify notifier initbox is not object");
        }
	    if(opts.display !== false){
            //Si la boite de texte est activé
            if(typeof (opts.text) !== "undefined" || opts.text !== '' || opts.text !==null){
                var boxtext = opts.text;
            }else{
                var boxtext = '';
            }

            if(optsNotifier.elemclass !== '' || optsNotifier.elemclass !==null){
                var class_container = optsNotifier.elemclass;
            }else{
                var class_container = '';
            }

            if(typeof(optsNotifier.elemid) !== "undefined" || optsNotifier.elemid !== '' || optsNotifier.elemid !==null){
                var id_container = optsNotifier.elemid;
                var $id = $(optsNotifier.elemid);
            }else{
                var id_container = '';
                var $id = '';
            }
            if(typeof(optsNotifier.box) !== "undefined"){
                if(optsNotifier.box === ""){
                    if(opts.debug == true){
                        console.info("box is empty");
                    }
                    $(id_container+class_container).html(boxtext+request);
                }else if(optsNotifier.box === 'meerkat'){
                    if(jQuery().meerkat){
                        $id.destroyMeerkat();
                        $id.meerkat({
                            background: optsNotifier.background,
                            width: '100%',
                            position: 'top',
                            close: '.close-notify',
                            animationIn: 'fade',
                            animationOut: 'slide',
                            animationSpeed: '750',
                            height: '80px',
                            opacity: '0.90',
                            timer: optsNotifier.time,
                            onMeerkatShow: function() {
                                $(this).animate({opacity: 'show'}, 1000);
                            }
                        }).addClass('pos-top');
                    }else{
                        // plugin DOES NOT exist
                        //console.log('plugin for display DOES NOT exist');
                        log('plugin for display DOES NOT exist');
                    }
                    if(opts.debug == true){
                        console.info("box is meerkat");
                    }
                    $(class_container).html(boxtext+request);
                }
            }else{
                if(opts.debug == true){
                    console.info("box is undefined");
                }
                $(id_container+class_container).html(boxtext+request);
            }
	    }
		if(opts.refresh == true){
			setTimeout(function(){
				location.reload();
			},opts.delay);
		}
	}
})( jQuery, window, document );