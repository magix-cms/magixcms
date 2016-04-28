/**
 * Retourne la langue courante pour la redirection
 * @params lang
 * @params redirect
 */
(function($) {
    $.redirect = function(settings) {
        var options =  {
            lang: "fr",
            url: '/',
            time: 2800
        };
        $.extend(options, settings);
        function getLang(){
            var $$getLang = options.lang;
            if($$getLang != null){
                return $$getLang;
            }else{
                return 'fr';
            }
        }
        if(typeof(getLang()) != ""){
            setTimeout(function(){
                window.location.href = "/" + getLang() + options.url;
            },options.time);
        }else if(typeof(getLang()) == "undefined"){
            console.log("%s: %o","lang is undefined",getLang());
            return false;
        }else{
            console.log("%s: %o","Domaine is not found",getLang());
            return false;
        }
    };
})(jQuery);