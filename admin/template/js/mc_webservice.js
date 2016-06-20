var MC_webservice = (function($, window, document, undefined){
    /**
     * set ajax load data
     * @param type
     * @param baseadmin
     * @param getlang
     * @param edit
     * @returns {string}
     */
    function setAjaxUrlLoad(baseadmin){
        var baseUrl = '/'+baseadmin+'/webservice.php';
        return baseUrl
    }

    /**
     * add or update
     * @param baseadmin
     * @param id
     */
    function save(baseadmin,id){
        $(id).on('submit',function(){
            $.nicenotify({
                ntype: "submit",
                uri: setAjaxUrlLoad(baseadmin),
                typesend: 'post',
                idforms: $(this),
                resetform:false,
                successParams:function(data){
                    if(data.statut != false){
                        window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                    }else{
                        window.setTimeout(function() { $(".alert-warning").alert('close'); }, 4000);
                    }
                    $.nicenotify.initbox(data.notify,{
                        display:true
                    });
                }
            });
            return false;
        });
    }
    /**
     * Function generates a random string for use in unique IDs, etc
     *
     * @param <int> n - The length of the string
     */
    function randString(n)
    {
        if(!n)
        {
            n = 32;
        }

        var uuid = '';
        var random = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for(var i=0; i < n; i++)
        {
            uuid += random.charAt(Math.floor(Math.random() * random.length));
        }

        return uuid;
    }

    return {
        //Fonction public
        run: function (baseadmin) {
            save(baseadmin,'#forms_webservice');
            $(document).on('click','#key_generator',function() {
                $('#ws_key').val(randString(32));
            });
        }
    }
})(jQuery, window, document);