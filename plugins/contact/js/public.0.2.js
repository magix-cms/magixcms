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
			submitHandler: function(form) {
				$.nicenotify({
					ntype: "submit",
					uri: '/'+lang+'/magixmod/contact/',
					typesend: 'post',
					idforms: $(form),
					resetform:true
				});
			 	return false;
		 	}
		});
		$("#forms-plugin-contact").formsplugincontact;
	},
	run:function(iso){
		this._init();
		this._postFieldData(iso);
	}
};