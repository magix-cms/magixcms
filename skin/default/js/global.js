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
$(function() {
    //In case you don't have firebug...
    if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }
    var ie6 = ($.browser.msie && $.browser.version < 7);
    var ie7 = ($.browser.msie && $.browser.version > 6);
    //function replace targetblank for valid w3c
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });
    /**
     * Construction du bouton de fermeture de la notification
     */
    $(".close-notify").button({
        icons: {
            primary: "ui-icon-closethick"
        }
    });
    /**
     * Initialise imagebox
     */
    $(".imagebox").colorbox();
    $(".video").colorbox({iframe:true, innerWidth:425, innerHeight:344});
    /*
     * $(".select").selectmenu({width: 200,maxWidth: 200});
     * $('.checkbox').checkbox();
     * */
    //$("#product-tabs").tabs();
    /**
     * Notification après installation pour le dossier "install"
     */
    if ($('#notify-install').length != 0){
        $.ajax({
            url:'/framework/js/jquery.meerkat.1.3.min.js',
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
                    $("#notify-install").destroyMeerkat();
                    $("#notify-install").meerkat({
                        background: "#efefef",
                        width: '100%',
                        position: 'top',
                        close: '.close-notify',
                        animationIn: 'fade',
                        animationOut: 'slide',
                        animationSpeed: '750',
                        height: '80px',
                        opacity: '0.90',
                        timer: null,
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
        });
    }else if ($('#notify-folder').length != 0){
        $.ajax({
            url:'/framework/js/jquery.meerkat.1.3.min.js',
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
                    $("#notify-folder").destroyMeerkat();
                    $("#notify-folder").meerkat({
                        background: "#efefef",
                        width: '100%',
                        position: 'top',
                        close: '.close-notify',
                        animationIn: 'fade',
                        animationOut: 'slide',
                        animationSpeed: '750',
                        height: '80px',
                        opacity: '0.90',
                        timer: null,
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
        });
    }
});