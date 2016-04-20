var MC_country = (function($, window, document, undefined){
    /**
     * set ajax load data
     * @param type
     * @param baseadmin
     * @param getlang
     * @param edit
     * @returns {string}
     */
    function setAjaxUrlLoad(baseadmin,action){
        var baseUrl = '/'+baseadmin+'/country.php';
        if(action){
            if(action === 'add'){
                var url = baseUrl+'&action=add';
            }else if(action === 'list'){
                var url = baseUrl+'&action=html';
            }
            else if(action === 'remove'){
                var url = baseUrl+'&action=remove';
            }
            else if(action === 'edit'){
                var url = baseUrl+'&action=edit';
            }
        }else{
            var url = baseUrl;
        }
        return url
    }
    /**
     *
     * @param baseadmin
     * @param action
     */
    function getHTMLFormat(baseadmin,action){
        $.nicenotify({
            ntype: "ajax",
            uri: setAjaxUrlLoad(baseadmin,action),
            typesend: 'get',
            datatype: 'html',
            beforeParams:function(){
                var loader = $(document.createElement("span")).addClass("loader offset5").append(
                    $(document.createElement("img"))
                        .attr('src','/'+baseadmin+'/template/img/loader/small_loading.gif')
                        .attr('width','20px')
                        .attr('height','20px')
                );
                $('#list-shipping').html(loader);
            },
            successParams:function(data){
                $('#list-shipping').empty();
                $.nicenotify.initbox(data,{
                    display:false
                });
                $('#list-shipping').html(data);
            }
        });
    }
    return {
        //Fonction public
        run: function (baseadmin) {

        }
    }
})(jQuery, window, document);