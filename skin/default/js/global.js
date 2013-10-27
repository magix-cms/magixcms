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
$(function()
{
        // *** In case you don't have firebug...
    if (!window.console || !console.firebug) {
        var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
        window.console = {};
        for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
    }

        // *** target_blank
    $('a.targetblank').click( function() {
        window.open($(this).attr('href'));
        return false;
    });

    // *** Fancybox gallery
        // *** for one picture
    $(".img-zoom").fancybox();
        // *** for gallery pictures
    $(".img-gallery").fancybox({
        helpers : {
            title : null
        }
    });
    /*
        // *** for gallery videos
    $(".video").fancybox({
        type: 'iframe',
        autoSize : true,
        padding : 5
    });
*/
});