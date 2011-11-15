/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_
 *
 */
var ns_juser = {
	_addNewUser:function(){
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
					required: 'Enter a username'
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
				$.nicenotify({
					ntype: "submit",
					uri: '/admin/users.php?add',
					typesend: 'post',
					idforms: form,
					resetform: true,
					successParams:function(e){
						$.nicenotify.initbox(e,{
							reloadhtml:true
						});
					}	
				});
				return false;
			}
		});
		$("#forms-users").formsusers;
	},
	_editUser:function(){
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
				$.nicenotify({
					ntype: "submit",
					uri: '/admin/users.php?edit='+iduser+'&post',
					typesend: 'post',
					idforms: form,
					resetform: false,
					successParams:function(e){
						$.nicenotify.initbox(e,{
							reloadhtml:true
						});
					}	
				});
			}
		});
		$("#forms-users-update").updateformsusers;
	},
	_deleteUser:function(){
		/**
	     * Requête ajax pour la suppression des utilisateurs
	     */
	    $('.deleteuser').click(function (e){
	    	e.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog_delete").dialog({
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
						/*$.ajax({
							type:'get',
							url: "/admin/users.php?deluser="+lg,
							async: false,
							cache:false,
							success : function(){
								location.reload();
					    	}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: "/admin/users.php",
							typesend: 'post',
							noticedata:"deluser="+lg,
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
							}
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	runEdit:function(){
		this._editUser();
	},
	run:function(){
		this._addNewUser();
		this._deleteUser();
	}
};