$(function(){
	/*################## USER ##############*/
    /**
     * Ajout d'un utilisateur
     */
    var formsusers = $("#forms-users").validate({
		onsubmit: true,
		event: 'submit',
		rules: {
			pseudo: {
				required: true,
				minlength: 2
			},
			email: {
				required: true,
				email: true
			},
			cryptpass: {
				password: "#pseudo",
				required: true,
				minlength: 4
			},
			cryptpass_confirm: {
				required: true,
				equalTo: "#cryptpass"
			}
		},
		messages: {
			pseudo: {
				required: "Enter a username"
			},
			email: {
				required: "Enter a email",
				email: "Enter a valid mail"
			},
			cryptpass: {
				password: "the password is weak",
				required: "Enter a password",
				minlength: "Enter a min length"
			},
			cryptpass_confirm: {
				required: "Repeat your password",
				minlength: "",
				equalTo: "Enter the same password as above"
			}
		},
		submitHandler: function(form) {
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: form,
	    		uri: '/admin/users.php?add',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
		}
	});
	$("#forms-users").formsusers;
	/**
	 * Mise à jour d'un utilisateur avec validation
	 */
	var updateformsusers = $("#forms-users-update").validate({
		onsubmit: true,
		event: 'submit',
		rules: {
			pseudo: {
				required: true,
				minlength: 2
			},
			email: {
				required: true,
				email: true
			},
			cryptpass: {
				password: "#pseudo",
				required: true,
				minlength: 4
			},
			cryptpass_confirm: {
				required: true,
				equalTo: "#cryptpass"
			}
		},
		messages: {
			pseudo: {
				required: "Enter a username"
			},
			email: {
				required: "Enter a email",
				email: "Enter a valid mail"
			},
			cryptpass: {
				password: "the password is weak",
				required: "Enter a password",
				minlength: "Enter a min length"
			},
			cryptpass_confirm: {
				required: "Repeat your password",
				minlength: "",
				equalTo: "Enter the same password as above"
			}
		},
		submitHandler: function(form) {
			var iduser = $("#iduser").val();
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: form,
	    		uri: '/admin/users.php?edit='+iduser+'&post',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:false,
	    		time:2,
	    		reloadhtml:true	
			});
		}
	});
	$("#forms-users-update").updateformsusers;
    /**
     * Requête ajax pour la suppression des utilisateurs
     */
    $('.deleteuser').click(function (e){
    	e.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			title: 'Suppression d\'utilisateur',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete User': function() {
					$(this).dialog('close');
					$.ajax({
						type:'get',
						url: "/admin/users.php?deluser="+lg,
						async: false,
						cache:false,
						success : function(){
							location.reload();
				    	}
				     });
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
});