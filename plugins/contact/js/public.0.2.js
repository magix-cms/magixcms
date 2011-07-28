var plugins_contact = {
	_init:function(){
		/**
		 * Support input button with jquery ui button
		 */
		$(".subcontact:submit").button();
	},
	_postFieldData:function(lang){
		/**
	     * Ajout d'un utilisateur
	     */
	    var formsplugincontact = $("#forms-plugin-contact").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				nom: {
					required: true,
					minlength: 2
				},
				prenom: {
					required: true,
					minlength: 2
				},
				email: {
					required: true,
					email: true
				},
				message: {
					required: true,
					minlength: 2
				}
			},
			messages: {
				nom: {
					required: '* Enter a lastname'
				},
				prenom: {
					required: '* Enter a firstname'
				},
				email: {
					required: "* Enter a email",
					email: "* Enter a valid mail: johndoe@mail.com"
				},
				message: {
					required: "* Enter a message"
				}
			},
			submitHandler: function(form) {
			 	$(form).ajaxSubmit({
				 	url:'/'+lang+'/magixmod/contact/',
				 	type:"post",
				 	resetForm: true,
				 	beforeSubmit:function(){},
				 	success:function(request){
				 		$.notice({
							ntype: "simple",
							time:2
						});
        				$(".mc-head-request").html(request);
				 	}
				});
			 	return false;
		 	}
		});
		$("#forms-plugin-contact").formsplugincontact;
	},
	run:function(){
		this._init();
		this._postFieldData($("#getLanguage").val());
	}
};