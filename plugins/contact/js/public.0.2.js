var plugins_contact = {
	_postFieldData:function(lang){
        // *** Set required fields for validation
	    var formsplugincontact = $("#contact-form").validate({
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
		$("#contact-form").formsplugincontact;
	},
	run:function(iso){
		this._postFieldData(iso);
	}
};