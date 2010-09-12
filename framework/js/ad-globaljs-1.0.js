/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name ad-globaljs
 *
 */
$(function() {
	//In case you don't have firebug...
	if (!window.console || !console.firebug) {
		var names = ["log", "debug", "info", "warn", "error", "assert", "dir", "dirxml", "group", "groupEnd", "time", "timeEnd", "count", "trace", "profile", "profileEnd"];
		window.console = {};
		for (var i = 0; i < names.length; ++i) window.console[names[i]] = function() {};
	}
	var ie6 = ($.browser.msie && $.browser.version < 7);
	var ie7 = ($.browser.msie && $.browser.version > 6);
	var ie = ($.browser.msie);
	/**
	 * Textchange pour les champs avec une information de limitation de caractère
	 */
	$.event.special.textchange = {
		setup: function (data, namespaces) {
			$(this).bind('keyup', $.event.special.textchange.handler);
			$(this).bind('cut paste input', $.event.special.textchange.delayedHandler);
		},
		teardown: function (namespaces) {
			$(this).unbind('keyup', $.event.special.textchange.keyuphandler);
			$(this).unbind('cut', $.event.special.textchange.cuthandler);
		},
		handler: function (event) {
			$.event.special.textchange.triggerIfChanged($(this));
		},
		delayedHandler: function (event) {
			var element = $(this);
			setTimeout(function () {
				$.event.special.textchange.triggerIfChanged(element);
			}, 25);
		},
		triggerIfChanged: function (element) {
			if (element.val() !== element.data('lastValue')) {
				element.trigger('textchange',  element.data('lastValue'));
				element.data('lastValue', element.val());
			}
		}
	};
	/**
	 * Effet de survol sur les boutons dans le top sidebar
	 */
		$(".topbutton:not(.ui-state-active)").hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		);
		//all hover and click logic for buttons
		$(".fg-button:not(.ui-state-disabled)").hover(
			function(){ 
				$(this).addClass("ui-state-hover"); 
			},
			function(){ 
				$(this).removeClass("ui-state-hover"); 
			}
		).mousedown(function(){
				$(this).parents('.fg-buttonset-single:first').find(".fg-button.ui-state-active").removeClass("ui-state-active");
				if( $(this).is('.ui-state-active.fg-button-toggleable, .fg-buttonset-multi .ui-state-active') ){ $(this).removeClass("ui-state-active"); }
				else { $(this).addClass("ui-state-active"); }	
		}).mouseup(function(){
			if(! $(this).is('.fg-button-toggleable, .fg-buttonset-single .fg-button,  .fg-buttonset-multi .fg-button') ){
				$(this).removeClass("ui-state-active");
			}
		});
		/**
		 * Support input button with jquery ui button
		 */
		$("input:submit").button();
		$("button.search").button({
            icons: {
                primary: 'ui-icon-search'
            },
            text: false
        });
		/**
		 * Ajout d'une classe spécifique au survol d'un thème
		 */
		$(".list-screen:not(.ui-state-active)").hover(
				function(){
					if($(this).find('ui-state-disabled')){
						$(this).removeClass("ui-state-disabled");
					}
					$(this).addClass("ui-state-hover");
				},
				function(){ 
					if(!$(this).hasClass('ui-state-active')){
						$(this).removeClass("ui-state-hover");
						$(this).addClass("ui-state-disabled");
					}
				}
		);
		/**
		 * Ajout d'une class spécifique si le thème est actif
		 */
		$(".list-screen").live("click",function (){
			$('.list-screen').removeClass("ui-state-active");
			$('.list-screen').addClass("ui-state-disabled");
			if($(this).find('ui-state-disabled')){
				$(this).removeClass("ui-state-disabled");
			}
			if($(this).find('ui-state-hover')){
				$(this).removeClass("ui-state-hover");
			}
			if($(this).not('ui-state-active')){
				$(this).addClass("ui-state-active");
			}
		});
		/**
		 * Requête ajax pour le changement de thème
		 */
		$(".list-screen a").bind("click", function(){
			var hreftitle = $(this).attr("title");
				if(hreftitle != null){
					if(ie){
					$.post('/admin/index.php?dashboard&templates&post', 
							{ theme: hreftitle}
						, function(e) {
							$(".reqdialog").html(e);
							setTimeout(function(){
								location.reload();
							},2000);
						});
					}else{
						$.ajax({
							type:'post',
							data: "theme="+hreftitle,
							url: "/admin/index.php?dashboard&templates&post",
							timeout:5000,
							error: function(request,error) {
								  if (error == "timeout") {
									  $("#error").append("The request timed out, please resubmit");
								  }
								  else {
									  $("#error").append("ERROR: " + error);
								  }
							},
							success:function(e) {
								$(".reqdialog").html(e);
								setTimeout(function(){
									location.reload();
								},2000);
							}
						});
					}
				}
		});
		/**
		 * Notification après installation pour le dossier "install"
		 */
		if ($('#notify-install').length != 0){
			$.notice({
				ntype: "dir",
				nparams: 'install'
			});
		}else if ($('#notify-folder').length != 0){
			$.notice({
				ntype: "dir",
				nparams: 'chmod'
			});
		}
		/**
		 * Initialisation du menu accordéon avec jquery cookies
		 */
		var accordion = $("#sidebar .management-menu");
		var index = $.cookie("magixadmin");
		var active;
		if (index !== null) {
			active = accordion.find("h3:eq(" + index + ")");
		} else {
			active = 0;
		}
		accordion.accordion({
			header: "h3",
			navigation: false,
			active: active,
			selectedClass: '.current',
			autoHeight: false,
			clearStyle: true,
			collapsibe: true,
			alwaysOpen: false,
			animated: 'slide',
			change: function(event, ui) {
				var index = $(this).find("h3").index ( ui.newHeader[0] );
				$.cookie("magixadmin", index, {path: "/",expires: 1});
			},
			autoHeight: false
		});
		/**
		 * Affiche ou non le module d'ajout des métas dans une div
		 */
		$("#showmetas span").addClass("ui-icon ui-icon-circle-plus");
		 $("#showmetas").click(function(){
		 	 var answer = $('#metas');
		        if (answer.is(":visible")) {
		            answer.hide();
		            $('span',this).removeClass("ui-icon ui-icon-circle-minus");
					$('span',this).addClass("ui-icon ui-icon-circle-plus");
		        } else {
		            answer.show();
		            $('span',this).removeClass("ui-icon ui-icon-circle-plus");
					$('span',this).addClass("ui-icon ui-icon-circle-minus");
		        }
		 });
		 /**
		  * Utilisation de textchange pour le compteur informatif des métas
		  */
		$('#metatitle').bind('textchange', function (event, previousText) {
			$('#charactersLeftT').html( 120 - parseInt($(this).val().length) );
		});
		$('#metadescription').bind('textchange', function (event, previousText) {
			$('#charactersLeftD').html( 180 - parseInt($(this).val().length) );
		});
		// sortable portlets ou déplacement et loking des widgets
		// les colonnes qui contiennet les widget déplaçable
		/*$(".column").sortable({
			connectWith: '.column'
		});
		$(".column").disableSelection();*/
		/*$(".dashboard-widget").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
			.find(".dashboard-widget-header")
				.addClass("ui-widget-header ui-corner-all")
				.prepend('<span class="ui-icon ui-icon-plusthick"></span>')
				.end()
			.find(".portlet-content");*/
		$(".dashboard-widget").find(".dashboard-widget-header").prepend('<span class="ui-icon ui-icon-plusthick"></span>').end().find(".portlet-content");
		$(".dashboard-widget-header .ui-icon").click(function() {
			$(this).toggleClass("ui-icon-minusthick");
			$(this).parents(".dashboard-widget:first").find(".dashboard-widget-content").toggle();
		});
		//Ajoute un ID numérique (boucle) sur la class "spin"
		$(".spin").each(function(i){
			var newid = $(this).attr("class")+"_" + i;
			this.id = newid;  
			var spinId = $(this).attr("id",newid);
			$(spinId).spinner({ min: 0, max: 200 });
		});
		/*$(".forms-cms-navigation").each(function(n){
			var newid = $(this).attr("class")+"_" + n;
			this.id = newid;  
			$(this).attr("id",newid);
		});*/
		$('#addvarprofil').bind("click", function(){
	 		$('#varprofil').show("drop", {direction:"up"}, 500);
	 		return false;
		});
		// Ajoute un look jquery UI au block
		/*$(".dashboard").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
		.find(".dashboard-header")
			.addClass("ui-widget-header ui-corner-all")
			.end()
		.find(".portlet-content");*/
	  //function replace targetblank for valid w3c
	    $('a.targetblank').click( function() {
			 window.open($(this).attr('href'));
			 return false;
		});
	    /**
	     * Initialisation de colorbox dans l'administration pour la prévisualisation
	     */
	    $(".post-preview").colorbox({width:"90%", height:"90%", iframe:true});
/*################## Langue ##############*/
	    /**
	     * Requête ajax pour la suppression des langues
	     */
	    $('.dellang').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:200,
				modal: true,
				title: 'Supprimé cette langue',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						//$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&lang&dellang="+lg,
							async: false,
							success:function(e) {
							$(".reqdialog").html(e);
								setTimeout(function(){
									location.reload();
								},3000);
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## Configuration ##############*/
	    /**
		 * Ajoute les éléments pour la réécriture des métas
		 */
		$("#add-category").bind("click",function (){
			var myContent = $("#strrewrite").val();
	        $("#strrewrite").val(myContent + "[[category]]").focus();
	        return false;
		});
		$("#add-subcategory").bind("click",function (){
			var myContent = $("#strrewrite").val();
	        $("#strrewrite").val(myContent + "[[subcategory]]").focus();
	        return false;
		});
		$("#add-product").bind("click",function (){
			var myContent = $("#strrewrite").val();
	        $("#strrewrite").val(myContent + "[[record]]").focus();
	        return false;
		});
		/*### Config Metas ###*/
		/**
	     * Requête ajax pour la suppression des réécriture de métas
	     */
		$('.d-config-rmetas').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Supprimé cette réécriture ?',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&config&metasrewrite&drmetas="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
		/**
		 * Initialisation de jQuery UI tabs pour la configuration de Magix CMS
		 */
	    $("#tabsFormsConfig").tabs();
	    /**
	     * requête ajax par sélection du bouton radio
	     */
		$("#global-config-lang :radio").click(function(){
			$("#global-config-lang").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-news :radio").click(function(){
			$("#global-config-news").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-cms :radio").click(function(){
			$("#global-config-cms").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-catalog :radio").click(function(){
			$("#global-config-catalog").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-microgalery :radio").click(function(){
			$("#global-config-microgalery").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-forms :radio").click(function(){
			$("#global-config-forms").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-rewritenews :radio").click(function(){
			$("#global-rewritenews").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post"
			});
		});
		$("#global-rewritecms :radio").click(function(){
			$("#global-rewritecms").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post"
			});
		});
		$("#global-rewritecatalog :radio").click(function(){
			$("#global-rewritecatalog").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post"
			});
		});
		$("#snumbCms").click(function(){
			$("#limited-cms-module").ajaxSubmit({
				url:"/admin/index.php?dashboard&config",
				type:"post",
				success:function(e) {$(".configupdate").html(e);}
			});
		});
		$('.spin').spinner({ min: 0, max: 200 });
/*################## CMS ##############*/
	    /**
	     * ID pour le déplacement des pages CMS
	     */
	    /*$('#sortable li').hover(
				function() { $(this).addClass('ui-state-hover'); },
				function() { $(this).removeClass('ui-state-hover'); }
		);
		$("#sortable").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortable').sortable('serialize');
				$.ajax({
					url: "/admin/index.php?dashboard&cms",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});*/
		$('#sortable li').hover(
				function() { $(this).addClass('ui-state-hover'); },
				function() { $(this).removeClass('ui-state-hover'); }
		);
		$("#sortable").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortable').sortable('serialize');
				$.ajax({
					url: "/admin/index.php?dashboard&cms&orderajax",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		$("#sortable").disableSelection();
		$(".forms-cms-navigation").each(function(el){
			var id = $(this).attr("id");
			$("#"+id+" :radio").click(function(){
				$("#"+id).ajaxSubmit({
					url:"/admin/index.php?dashboard&cms&navigation",
					type:"post"
				});
			});
		});
	    /**
		 * Soumission d'une nouvelle catégorie dans le CMS
		 */
		$("#forms-cms-category").submit(function(){
			$(this).ajaxSubmit({
				type:"post",
				success:function(e) {
					$("#resultcategory").html(e);
					setTimeout(function(){
						location.reload();
					},1000);
				}
			});
			return false; 
		});
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms-cms-page").submit(function(){
			tinyMCE.triggerSave(true,true);
			$(this).ajaxSubmit({
        		url:'/admin/index.php?dashboard&cms&add&post',
        		type:"post",
        		resetForm: true,
        		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
        			$(".mc-head-request").html(request);
        				setTimeout(function(){
        					location.reload();
        				},2800);
        		}
        	});
			return false; 
		});
		/**
		 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
		 */
		$("#forms-cms-updatepage").submit(function(){
			var pageid = $('#idpage').val();
			if(pageid != null){
				tinyMCE.triggerSave(true,true);
				$(this).ajaxSubmit({
	        		url:'/admin/index.php?dashboard&cms&editcms='+pageid+'&post',
	        		type:"post",
	        		resetForm: false,
	        		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
	        			$(".mc-head-request").html(request);
	        				setTimeout(function(){
	        					location.reload();
	        				},2800);
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
		/**
		 * Affiche la pop-up pour la modification 
		 */
		$('.ucms-category').live("click",function(){
			var idcategory = $(this).attr('title');
			var url = '/admin/index.php?dashboard&cms&ucategory='+idcategory;
			$("#update-category").load(url, function() {
				$(this).dialog({
					bgiframe: true,
					minHeight: 100,
					width:320,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: {
						'Save': function() {
							$.ajax({
								type: "post",
							    url : url,
							    data: "update_category="+$('#update_category').val(),
							    success : function(){
									$(this).dialog('close');
									location.reload()
						    	}
							})
						},
						Cancel: function() {
							$(this).dialog('close');
							success: location.reload()
						}
					}
				});
			});
		});
	    /**
	     * Requête ajax pour la suppression des pages CMS
	     */
		$('.deletecms').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Supprimé cette page',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&cms&delpage="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
		/**
		 * Requête ajax pour la mise à jour d'une catégorie CMS
		 */
		$('.dcmscat').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Supprimé cette catégorie',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&cms&dcmscat="+lg,
							async: false,
							success : function(){
								$(this).dialog('close');
								location.reload()
				    		}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## formulaire ##############*/
		/**
	     * Requête ajax pour la suppression des formulaires
	     */
	    $('.deleteinput').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Suppression de champs',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&forms&delinput="+lg,
							async: false,
							success : function(){
								$(this).dialog('close');
								location.reload()
				    		}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
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
				$(form).ajaxSubmit({url:"/admin/index.php?dashboard&user&post",
					type:"post",
					success:function(e) {
						$("div.request").html(e);
						setTimeout(function(){
							location.reload();
						},3000);
					},
					resetForm: true
				});
			}
		});
		$("#forms-users").formsusers;
		/**
		 * Mise à jour d'un utilisateur
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
			}
		});
		$("#forms-users-update").updateformsusers;
	    /**
	     * Requête ajax pour la suppression des utilisateurs
	     */
	    $('.deleteuser').click(function (){
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
							url: "/admin/index.php?dashboard&user&deluser="+lg,
							async: false,
							success : function(){
								$(this).dialog('close');
								location.reload()
					    	}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## article / news #################*/
	    /**
	     * Requête ajax pour la suppression des articles ou news
	     */
	    $('.deletenews').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Suppression d\'un article',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete News': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&news&delnews="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## Home ##############*/
	    /**
	     * Requête ajax pour la suppression des pages d'accueil
	     */
	    $('.deletehome').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Suppression d\'une page d\'accueil',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete Home Page': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&home&delhome="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## Catalog ##############*/
	    /**
		 * Soumission d'une nouvelle catégorie dans le catalogue
		 */
		$("#forms-catalog-category").submit(function(){
			/*$(this).ajaxSubmit({
				url:'/admin/index.php?dashboard&catalog&category&post',
				type:"post",
				success:function(e) {
					$("#resultcategory").html(e);
					setTimeout(function(){
						location.reload();
					},1000);
				}
			});*/
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/index.php?dashboard&catalog&category&post',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		/**
		 * Soumission d'une nouvelle sous catégorie dans le catalogue
		 */
		$("#forms-catalog-subcategory").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/index.php?dashboard&catalog&category&post',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		/**
		 * Soumission ajax d'un produit dans le catalogue
		 */
		$("#forms-catalog-product").submit(function(){
			tinyMCE.triggerSave(true,true);
			$(this).ajaxSubmit({
        		url:'/admin/index.php?dashboard&catalog&product&addproduct',
        		type:"post",
        		resetForm: true,
        		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
        			$(".mc-head-request").html(request);
        				setTimeout(function(){
        					location.reload();
        				},2800);
        		}
        	});
			return false; 
		});
		/**
		 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
		 */
		$("#forms-catalog-product-edit").submit(function(){
			var productid = $('#idcatalog').val();
			if(productid != null){
				tinyMCE.triggerSave(true,true);
				$(this).ajaxSubmit({
	        		url:'/admin/index.php?dashboard&catalog&product&editproduct='+productid+'&updateproduct',
	        		type:"post",
	        		resetForm: false,
	        		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
	        			$(".mc-head-request").html(request);
	        				setTimeout(function(){
	        					location.reload();
	        				},2800);
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
		/**
		 * Mise à jour d'une catégorie
		 */
		$('.ucategory').live("click",function(){
			var idcategory = $(this).attr('title');
			var url = '/admin/index.php?dashboard&catalog&upcat='+idcategory;
			$("#update-category").load(url, function() {
				$(this).dialog({
					bgiframe: true,
					minHeight: 100,
					width:320,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: {
						'Save': function() {
							$.ajax({
								type: "post",
							    url : url,
							    data: "update_category="+$('#update_category').val(),
							    success : function(){
									$(this).dialog('close');
									location.reload()
							    }
							})
						},
						Cancel: function() {
							$(this).dialog('close');
							success: location.reload()
						}
					}
				});
			});
		});
		/**
		 * Mise à jour d'une sous catégorie
		 */
		$('.usubcategory').live("click",function(){
			var idsubcategory = $(this).attr('title');
			var url = '/admin/index.php?dashboard&catalog&upsubcat='+idsubcategory;
			$("#update-subcategory").load(url, function() {
				$(this).dialog({
					bgiframe: true,
					minHeight: 100,
					width:320,
					modal: true,
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: {
						'Save': function() {
							$.ajax({
								type: "post",
							    url : url,
							    data: "update_subcategory="+$('#update_subcategory').val(),
							    success : function(){
									$(this).dialog('close');
									location.reload();
							    }
							});
						},
						Cancel: function() {
							$(this).dialog('close');
							success: location.reload();
						}
					}
				});
			});
		});
	    /**
	     * Ajout d'une class au survol d'une catégorie
	     */
	    $('#sortcat li,#sortsubcat li').hover(
				function() { $(this).addClass('ui-state-hover'); },
				function() { $(this).removeClass('ui-state-hover'); }
		);
	    /**
	     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
	     * Requête ajax pour l'enregistrement du déplacement
	     */
		$("#sortcat").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortcat').sortable('serialize');
				$.ajax({
					url: "/admin/index.php?dashboard&catalog&order",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		/**
	     * Initialisation du drag and drop pour les sous catégories (catalogue uniquement)
	     * Requête ajax pour l'enregistrement du déplacement
	     */
		$("#sortsubcat").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortsubcat').sortable('serialize');
				$.ajax({
					url: "/admin/index.php?dashboard&catalog&order",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		/**
	     * Requête ajax pour la suppression des produits
	     */
		$('.deleteproduct').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				minHeight:180,
				modal: true,
				title: 'Supprimé ce produit',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						//$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&catalog&product&delproduct="+lg,
							async: false,
							success:function(e) {
								$(".reqdialog").html(e);
								setTimeout(function(){
									$(this).dialog('close');
									location.reload();
								},3000);
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload();
					}
				}
			});
		 });
		/**
	     * Requête ajax pour la suppression des catégories
	     */
		$('.delc').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:220,
				modal: true,
				title: 'Supprimé cette catégorie',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				open:function(){
					$("p").append('<br />Les sous catégorie seront également supprimé');
				},
				buttons: {
					'Delete item': function() {
						//$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&catalog&category&delc="+lg,
							async: false,
							success:function(e) {
							$(".reqdialog").html(e);
								setTimeout(function(){
									//location.reload();
									window.location.href = '/admin/index.php?dashboard&catalog&category'; 
								},3000);
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success : window.location.href = '/admin/index.php?dashboard&catalog&category';//window.location.pathname;
					}
				}
			});
		 });
		/**
	     * Requête ajax pour la suppression des sous catégories dans le catalogue
	     */
		$('.dels').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé cette sous catégorie',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						//$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&catalog&category&dels="+lg,
							async: false,
							success:function(e) {
							$(".reqdialog").html(e);
							setTimeout(function(){
								window.location.href = '/admin/index.php?dashboard&catalog&category'; 
								},3000);
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success: location.reload()
					}
				}
			});
		 });
/*################## Sitemap ##############*/
		/**
	     * Requête ajax pour la création, modification de fichier sitemap xml
	     */
		$('.createxml').click(function (){
				/*$.ajax({
					type:'get',
					url: "/admin/index.php?dashboard&sitemap&createxml",
					async: false,
					success:function(e) {
						$("#reponse").html(e);
					}
				});*/
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/index.php?dashboard&sitemap&createxml',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
			//noticehead("/admin/index.php?dashboard&sitemap&createxml","get",null,4);
		 });
/*################## Google Tools ##############*/
		/**
	     * Requête ajax pour la création de la soumission vers google
	     */
		$('.pinggoogle').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/index.php?dashboard&sitemap&googleping',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		});
		/**
	     * Requête ajax pour la création du fichier xml compressé au format GZ + soumission du fichier vers google
	     */
		$('.compressping').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/index.php?dashboard&sitemap&compressionping',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		});
		/**
		 * Soumission de codes Google webmaster et/ou analytics
		 */
		$("#forms-webmaster-tools").submit(function(){
			$(this).ajaxSubmit({
				url:'/admin/index.php?dashboard&googletools&pgdata',
				type:"post",
				success:function(e) {
					$("#resultgdata").html(e);
				}
			});
			return false; 
		});
		$("#forms-analytics-tools").submit(function(){
			$(this).ajaxSubmit({
				url:'/admin/index.php?dashboard&googletools&pgdata',
				type:"post",
				success:function(e) {
					$("#resultgdata").html(e);
				}
			});
			return false; 
		});
});