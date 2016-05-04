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
                var url = baseUrl+'?action=add';
            }else if(action === 'list'){
                var url = baseUrl+'?action=html';
            }
            else if(action === 'remove'){
                var url = baseUrl+'?action=remove';
            }
            else if(action === 'edit'){
                var url = baseUrl+'?action=edit';
            }
        }else{
            var url = baseUrl;
        }
        return url
    }
    /**
     * Update page list
     */
    function updateList() {
        var rows = $('#list_page tr');
        if (rows.length > 1) {
            $('#no-entry').addClass('hide');

            $('a.toggleModal').off();
            $('a.toggleModal').click(function () {
                if ($(this).attr('href') != '#') {
                    var id = $(this).attr('href').slice(1);
                    $('#delete_country').val(id);
                }
            });
        } else {
            $('#no-entry').removeClass('hide');
        }
    }

    /**
     * AddLine
     * @param line
     */
    function addLine(line) {
        $('#no-entry').before(line);
        updateList();
    }

    /**
     * Set input data for iso country
     */
    function setInputData(){
        $('select#country').on('change',function() {
            var $currentOption = $(this).find('option:selected').data('iso');
            $('#iso').val($currentOption);
        });
    }

    /**
     * add or update
     * @param baseadmin
     * @param action
     * @param id
     */
    function save(baseadmin,action,id){
        var formsAdd = $(id).validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                country: {
                    required: true
                },
                iso: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: setAjaxUrlLoad(baseadmin,action),
                    typesend: 'post',
                    idforms: $(form),
                    resetform:true,
                    successParams:function(data){
                        $('#add-country').modal('hide');
                        if(data.statut != false){
                            window.setTimeout(function() { $(".alert-success").alert('close'); }, 4000);
                        }else{
                            window.setTimeout(function() { $(".alert-warning").alert('close'); }, 4000);
                        }
                        if(data.statut && data.result != null){
                            addLine(data.result);
                        }
                        $.nicenotify.initbox(data.notify,{
                            display:true
                        });
                    }
                });
                return false;
            }
        });
    }
    /**
     * suppression de la page
     * @param id
     * @param getlang
     */
    function remove(baseadmin,action,id) {
        $(id).validate({
            onsubmit: true,
            event: 'submit',
            rules: {
                delete_country: {
                    required: true,
                    number: true,
                    minlength: 1
                }
            },
            submitHandler: function (form) {
                $.nicenotify({
                    ntype: "submit",
                    uri: setAjaxUrlLoad(baseadmin,action),
                    typesend: 'post',
                    idforms: $(form),
                    resetform: true,
                    successParams: function (data) {
                        $('#deleteModal').modal('hide');
                        /*window.setTimeout(function () {
                            $(".alert-success").alert('close');
                        }, 4000);*/
                        $.nicenotify.initbox(data, {
                            display: false
                        });
                        $('#item_'+$('#delete_country').val()).remove();
                        updateList();
                    }
                });
                return false;
            }
        });
    }
    return {
        //Fonction public
        run: function (baseadmin) {
            setInputData();
            save(baseadmin,'add','#forms_add_country');
            remove(baseadmin,'remove','#del_country');
            updateList();
        }
    }
})(jQuery, window, document);