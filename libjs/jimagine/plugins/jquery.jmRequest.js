/**
 * Définir les valeurs par defaut pour le comportement du callback
 * *
 $.jmRequest.defaults = {
    display: true,
    refresh: false,
    redirectUrl: null,
    timeout: 2800,
    debug: false
};

 /**
 * Définir les valeurs par defaut pour le mode de notification
 * *
 $.jmRequest.notifier = {
    class : '.mc-message'
};

 $.jmRequest({
    handler: "ajax",
    url: '',
    method: 'GET',
    dataType: 'json'
});

 $("#my_form").on('submit',function(){
     $.jmRequest({
            handler: "submit",
            url: '',
            method: 'post',
            form: $(this),
            resetForm:true,
            beforeSend:function(){},
            success:function(e){
                $.jmRequest.initbox(e,{
                        display: true
                    },{
                        class : '.mc-message'
                    }
                );
            }
	 });
	 return false;
});
 *
 */

;(function ( $, window, document, undefined ) {
    $.jmRequest = function(options){
        var settings = {
            handler: "ajax",
            method: "POST",
            dataType : '',
            url: null,
            data: {},/*data: { key1: 'value1', key2: 'value2' }*/
            form: null,
            /*
            * beforeSerialize: function($form, options) {
             // return false to cancel submit
             }
            * */
            beforeSerialize:null,
            resetForm: null,
            clearForm: null,/*Boolean flag indicating whether the form should be cleared if the submit is successful*/
            target: null,
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
            cache: false,
            dataFilter: function (response) {},
            beforeSend: function(){},
            xhr: function() {},
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                console.log(ajaxOptions);
                console.log(thrownError);
            },
            success: function(e){
                $.jmRequest.initbox(e);
            },
            complete: function () {}
        };
        var opt = $.extend(true,{},settings,options);
        //console.log(opt.uri);
        //var self : this,
        if(typeof opt != 'object' || opt == "undefined"){
            console.log(opt);
        }
        if(opt.handler == "undefined" || opt.handler == '' || opt.handler == null){
            console.log('handler is null');
        }
        var initHandler = {
            jmAjax: function(){
                // --- Default options of the ajax request
                $.ajax({
                    method: opt.method,
                    type: opt.method,
                    url: opt.url,
                    dataType: opt.dataType,
                    statusCode: opt.statusCode,
                    async: opt.async,
                    cache: opt.cache,
                    data: opt.data,
                    dataFilter: opt.dataFilter,
                    xhr: opt.xhr,
                    beforeSend: opt.beforeSend,
                    success: opt.success

                }).done(function ( data ) {
                    if(opt.debug == true){
                        if( console && console.log ) {
                            console.log(data);
                        }
                    }
                }).fail(function(xhr, status, error){
                    console.group('Error jmRequest');
                    console.error('Status %s ',status);
                    console.error('URL: '+opt.url+' %s',error);
                    console.groupEnd();
                });
            },
            jmSubmit: function(){

                if(jQuery().ajaxSubmit) {
                    if(opt.debug == true){
                        $(opt.form).ajaxSubmit.debug = true;
                    }else{
                        $(opt.form).ajaxSubmit.debug = false;
                    }
                    $(opt.form).ajaxSubmit({
                        url:opt.url,
                        type:opt.method,
                        data:opt.data,
                        dataType: opt.dataType,
                        resetForm: opt.resetForm,
                        clearForm: opt.clearForm,
                        forceSync:false,
                        beforeSerialize:opt.beforeSerialize,
                        beforeSubmit:opt.beforeSend,
                        success: opt.success
                    });
                }else{
                    console.error('jquery form is not defined');
                }
            },
            jmForm: function(){

                if(jQuery().ajaxForm) {
                    if(opt.debug == true){
                        $(opt.form).ajaxForm.debug = true;
                    }else{
                        $(opt.form).ajaxForm.debug = false;
                    }
                    $(opt.form).ajaxForm({
                        url:opt.url,
                        type:opt.method,
                        data:opt.data,
                        dataType: opt.dataType,
                        resetForm: opt.resetForm,
                        clearForm: opt.clearForm,
                        forceSync:false,
                        beforeSerialize:opt.beforeSerialize,
                        beforeSubmit:opt.beforeSend,
                        success: opt.success
                    });
                }else{
                    console.error('jquery form is not defined');
                }
            }
        }
        if(opt.handler == ""){
            console.log("%s: %o","handler is null");
            return false;
        }else if(typeof(opt.handler) === "undefined"){
            console.log("%s: %o","handler is undefined");
            return false;
        }else{
            switch(opt.handler){
                case "ajax":
                    initHandler.jmAjax();
                    break;
                case "submit":
                    initHandler.jmSubmit();
                    break;
                case "form":
                    initHandler.jmForm();
                    break;
            }
        }
    };
    /**
     * Paramètres par defaut pour le comportement du callback
     * @type {Object}
     */
    $.jmRequest.defaults = {
        display: true,
        refresh: false,
        redirectUrl: null,
        timeout: 2800,
        debug: false
    };

    /**
     * Paramètres par defaut pour le mode de notification
     * @type {Object}
     */
    $.jmRequest.notifier = {
        class : '.mc-message'
    };

    /**
     * Redirection function.
     * @param {string} loc - url where to redirect.
     * @param {int} [timeout=2800] - Time before redirection.
     */
    function redirect(loc,timeout) {
        timeout = typeof timeout !== 'undefined' ? timeout : 2800;
        setTimeout(function(){
            window.location.href = loc;
        },timeout);
    }

    function reload(timeout){
        timeout = typeof timeout !== 'undefined' ? timeout : 2800;
        setTimeout(function(){
            location.reload();
        },timeout);
    }

    /**
     * Retourne le setting avec des conditions pour la notification
     * @param setting
     * @return {Object|String}
     * @private
     */
    function setBoxParams(setting){
        var optDefault = $.jmRequest.notifier;
        if(setting != null){
            if(typeof(setting.class) === "undefined"){
                setClass = optDefault.class;
            }else{
                setClass = setting.class;
            }
        }else{
            if(typeof(optDefault.class) === "undefined" || optDefault.class === ""){
                setClass = "";
            }else{
                setClass = optDefault.class;
            }
        }
        var config = {
            class : setClass
        };
        if ( typeof config != 'object' ){
            console.log("%s: %o","config is not objet");
        }else{
            return config;
        }
    }

    /**
     * Définition du comportement de l'affichage du callback
     * @param response
     * @param setDefault
     * @param setNotifier
     */
    $.jmRequest.initbox = function(response,setDefault,setNotifier) {
        var opts = $.extend(true,{},$.jmRequest.defaults,setDefault);
        var optsNotifier = $.extend(true,{},$.jmRequest.notifier,setBoxParams(setNotifier));
        if ( !$.isPlainObject( opts ) ){
            console.log( optsNotifier.class );
        }
        if(typeof opts !== 'object'){
            console.log("%s: %o","jmRequest default initbox is not object");
        }else if(typeof optsNotifier != 'object'){
            console.log("%s: %o","jmRequest notifier initbox is not object");
        }
        if(opts.display !== false){

            if(optsNotifier.class !== '' || optsNotifier.class !==null){
                var classContainer = optsNotifier.class;
            }else{
                var classContainer = '';
            }

            if(opts.debug == true){
                console.info(classContainer);
            }
            $(classContainer).html(response);
        }

        if(opts.redirectUrl !== null || opts.redirectUrl !== ""){
            redirect(opts.redirectUrl,opts.timeout);
        }

        if(opts.refresh == true){
            reload(opts.timeout);
        }
    }
})( jQuery, window, document );