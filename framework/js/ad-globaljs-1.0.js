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
		$(".button-link").button();
		/**
		 * Bouton pour les modifications dans les templates
		 */
		$(".template-edit").button({
            icons: {
                primary: 'ui-icon-pencil'
            },
            text: false
        });
		$(".template-delete").button({
            icons: {
                primary: 'ui-icon-close'
            },
            text: false
        });
		/**
		 * Ajout d'une classe spécifique au survol d'un thème
		 */
		$(".list-screen:not(.ui-state-highlight)").hover(
				function(){
					if($(this).find('ui-state-disabled')){
						$(this).removeClass("ui-state-disabled");
					}
					$(this).addClass("ui-state-hover");
				},
				function(){ 
					if(!$(this).hasClass('ui-state-highlight')){
						$(this).removeClass("ui-state-hover");
						$(this).addClass("ui-state-disabled");
					}
				}
		);
		/**
		 * Ajout d'une class spécifique si le thème est actif
		 */
		$(".list-screen").live("click",function (){
			$('.list-screen').removeClass("ui-state-highlight");
			$('.list-screen').addClass("ui-state-disabled");
			if($(this).find('ui-state-disabled')){
				$(this).removeClass("ui-state-disabled");
			}
			if($(this).find('ui-state-hover')){
				$(this).removeClass("ui-state-hover");
			}
			if($(this).not('ui-state-highlight')){
				$(this).addClass("ui-state-highlight");
			}
		});
		/**
		 * Requête ajax pour le changement de thème
		 */
		$(".list-screen a").bind("click", function(){
			var hreftitle = $(this).attr("title");
				if(hreftitle != null){
					if(ie){
						$.post('/admin/templates.php?post', 
							{ theme: hreftitle}
						, function(request) {
							$.notice({
								ntype: "simple",
								time:2
							});
		        			$(".mc-head-request").html(request);
	        				setTimeout(function(){
	        					location.reload();
	        				},2800);
						});
					}else{
						$.ajax({
							type:'post',
							data: "theme="+hreftitle,
							url: "/admin/templates.php?post",
							timeout:5000,
							error: function(request,error) {
								  if (error == "timeout") {
									  $("#error").append("The request timed out, please resubmit");
								  }
								  else {
									  $("#error").append("ERROR: " + error);
								  }
							},
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
		}else if ($('#notify-header-plus').length != 0){
			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
				$('#notify-header').destroyMeerkat();
				$('#notify-header-plus').meerkat({
					background:"#efefef",
					width: '100%',
					position: 'top',
					close: '.close-notify',
					animationIn: 'fade',
					animationOut: 'slide',
					animationSpeed: '750',
					height: '80px',
					opacity: '0.90',
					timer: 2,
					onMeerkatShow: function() { 
						$(this).animate({opacity: 'show'}, 1000); 
					}
				}).addClass('pos-top');
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
	    $("#forms-lang").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/lang.php?add',
	    		typesend: 'post',
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
	    $('.edit-lang').live("click",function(){
			var idlang = $(this).attr('title');
			var url = '/admin/lang.php?ulang='+idlang;
			$("#update-lang").load(url, function() {
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
							$(this).dialog('close');
							$.notice({
								ntype: "ajax",
					    		uri:  url+"&post",
					    		typesend: 'post',
					    		noticedata: "ucodelang="+$('#ucodelang').val()+"&udesclang="+$('#udesclang').val(),
					    		time:2,
					    		reloadhtml:true
							});
						},
						Cancel: function() {
							$(this).dialog('close');
							//success: location.reload()
						}
					}
				});
			});
		});
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
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri:  "/admin/lang.php?dellang="+lg,
				    		typesend: 'post',
				    		time:2,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
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
		$("#forms-config-rewrite").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/config.php?metasrewrite&add',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		/**
		 * Soumission ajax d'une mise à jour d'une réécriture de métas dans la configuration
		 */
		$("#forms-config-rewrite-update").submit(function(){
			var rewriteid = $('#idrewrite').val();
			if(rewriteid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/config.php?metasrewrite&edit='+rewriteid+'&post',
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
				console.log("%s: %o","rewriteid is null",rewriteid);
			}
		});
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
							url: "/admin/config.php?metasrewrite&drmetas="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
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
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-news :radio").click(function(){
			$("#global-config-news").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-cms :radio").click(function(){
			$("#global-config-cms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-catalog :radio").click(function(){
			$("#global-config-catalog").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-microgalery :radio").click(function(){
			$("#global-config-microgalery").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-forms :radio").click(function(){
			$("#global-config-forms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-rewritenews :radio").click(function(){
			$("#global-rewritenews").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
		$("#global-rewritecms :radio").click(function(){
			$("#global-rewritecms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
		$("#global-rewritecatalog :radio").click(function(){
			$("#global-rewritecatalog").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
		$("#snumbCms").click(function(){
			$("#limited-cms-module").ajaxSubmit({
				url:"/admin/config.php",
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
			placeholder: 'ui-state-highlight',
			dropOnEmpty: false,
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortable').sortable('serialize');
				$.ajax({
					url: "/admin/cms.php?orderajax",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		$("#sortable").disableSelection();
		/**
		 * Requête ajax pour activre/desactiver une page du menu sidebar
		 */
		$(".forms-cms-navigation").each(function(el){
			var id = $(this).attr("id");
			$("#"+id+" :radio").click(function(){
				$("#"+id).ajaxSubmit({
					url:"/admin/cms.php?navigation",
					type:"post"
				});
			});
		});
	    /**
		 * Soumission d'une nouvelle catégorie dans le CMS
		 */
		$("#forms-cms-category").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/cms.php?category&post',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		$("#move-cms-page").submit(function(){
			var getpage = $("#idpage").val();
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/cms.php?movepage='+getpage+'&postmovepage',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms-cms-page").submit(function(){
			tinyMCE.triggerSave(true,true);
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/cms.php?add&post',
	    		typesend: 'post',
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
		/**
		 * Soumission ajax d'une mise à jour d'un produit dans le cms
		 */
		$("#forms-cms-updatepage").submit(function(){
			var pageid = $('#idpage').val();
			if(pageid != null){
				tinyMCE.triggerSave(true,true);
				$.notice({
					ntype: "ajaxsubmit",
		    		delay: 2800,
		    		dom: this,
		    		uri: '/admin/cms.php?editcms='+pageid+'&post',
		    		typesend: 'post',
		    		resetform:false,
		    		time:2,
		    		reloadhtml:true	
				});
				return false; 
			}else{
				console.log("%s: %o","pageid is null",pageid);
			}
		});
		/**
		 * Affiche la pop-up pour la modification 
		 */
		$('.ucms-category').live("click",function(){
			var idcategory = $(this).attr('title');
			var url = '/admin/cms.php?ucategory='+idcategory;
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
							$(this).dialog('close');
							$.notice({
								ntype: "ajax",
					    		uri:  url+"&post",
					    		typesend: 'post',
					    		noticedata: "update_category="+$('#update_category').val(),
					    		time:2,
					    		reloadhtml:true
							});
						},
						Cancel: function() {
							$(this).dialog('close');
							//success: location.reload()
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
							url: "/admin/cms.php?delpage="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
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
							url: "/admin/cms.php?dcmscat="+lg,
							async: false,
							success : function(){
								$(this).dialog('close');
								location.reload()
				    		}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
		/**
		 * Recherche simple dans les titres des pages CMS
		 */
		$("#forms-search-page").submit(function(){
			$(this).ajaxSubmit({
        		url:'/admin/cms.php?get_search_page',
        		type:"post",
        		resetForm: true,
        		success:function(request) {
        			$("#result-search-page").html(request);
        		}
        	});
			return false; 
		});
		/**
		 * Affiche la popup des liens des pages CMS
		 */
		$('.cms-page-uri').live("click",function(){
			var currenturi = $(this).attr('title');
				$('#window-box').dialog({
					open:function() {
						$(this).append(currenturi);
					},
					bgiframe: true,
					minHeight: 120,
					minWidth: 400,
					modal: true,
					title: 'Copier un lien',
					closeOnEscape: true,
					//position: "center",
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: { 
						"Close": function() { 
						$(this).dialog("close"); 
						} 
					},
					close: function() {
						$(this).empty();
					}
				});
				return false;
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
						//success: location.reload()
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
						//success: location.reload()
					}
				}
			});
		 });
/*################## article / news #################*/
	    $("#forms-news").submit(function(){
			tinyMCE.triggerSave(true,true);
			$(this).ajaxSubmit({
        		url:'/admin/news.php?add&post',
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
		 * Soumission ajax d'une mise à jour d'une news ou article
		 */
		$("#forms-news-update").submit(function(){
			var newsid = $('#idnews').val();
			if(newsid != null){
				tinyMCE.triggerSave(true,true);
				$(this).ajaxSubmit({
	        		url:'/admin/news.php?edit='+newsid+'&post',
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
				console.log("%s: %o","newsid is null",newsid);
			}
		});
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
						//success: location.reload()
					}
				}
			});
		 });
/*################## Home ##############*/
	    $("#forms-home").submit(function(){
			tinyMCE.triggerSave(true,true);
			$(this).ajaxSubmit({
        		url:'/admin/home.php?add',
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
	    $("#forms-home-update").submit(function(){
			var homeid = $('#idhome').val();
			if(homeid != null){
				tinyMCE.triggerSave(true,true);
				$(this).ajaxSubmit({
	        		url:'/admin/home.php?edit='+homeid+'&post',
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
				console.log("%s: %o","homeid is null",homeid);
			}
		});
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
							url: "/admin/home.php?delhome="+lg,
							async: false,
							success: location.reload()
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
/*################## Catalog ##############*/
	    /**
		 * Soumission d'une nouvelle catégorie dans le catalogue
		 */
		$("#forms-catalog-category").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/catalog.php?category&post',
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
	    		uri: '/admin/catalog.php?category&post',
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
		$("#forms-catalog-card-product").submit(function(){
			tinyMCE.triggerSave(true,true);
			$(this).ajaxSubmit({
        		url:'/admin/catalog.php?product&add_card_product',
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
		$("#forms-catalog-card-product-edit").submit(function(){
			var productid = $('#idcatalog').val();
			if(productid != null){
				tinyMCE.triggerSave(true,true);
				/*$(this).ajaxSubmit({
	        		url:'/admin/catalog.php?product&editproduct='+productid+'&updateproduct',
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
	        	});*/
				$.notice({
					ntype: "ajaxsubmit",
		    		delay: 1800,
		    		dom: this,
		    		uri: '/admin/catalog.php?product&editproduct='+productid+'&updateproduct',
		    		typesend: 'post',
		    		noticedata: null,
		    		resetform:false,
		    		time:1,
		    		reloadhtml:true	
				});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
		/**
		 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
		 */
		$("#forms-catalog-product").submit(function(){
			var productid = $('#idcatalog').val();
			if(productid != null){
				/*$(this).ajaxSubmit({
	        		url:'/admin/catalog.php?product&editproduct='+productid+'&add_product',
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
	        	});*/
				$.notice({
					ntype: "ajaxsubmit",
		    		delay: 1800,
		    		dom: this,
		    		uri: '/admin/catalog.php?product&editproduct='+productid+'&add_product',
		    		typesend: 'post',
		    		noticedata: null,
		    		resetform:false,
		    		time:1,
		    		reloadhtml:true	
				});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
		$("#forms-catalog-rel-product").submit(function(){
			var productid = $('#idcatalog').val();
			if(productid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/catalog.php?product&editproduct='+productid+'&post_rel_product',
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
		$("#forms-catalog-editcategory").submit(function(){
			var idcategory = $('#ucategory').val();
			var url = '/admin/catalog.php?catalog&upcat='+idcategory;
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri:  url+"&post",
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true,
	    		resetform:false
			});
			return false; 
		});
		/**
		 * Mise à jour d'une sous catégorie
		 */
		$("#forms-catalog-editsubcategory").submit(function(){
			var idsubcategory = $('#usubcategory').val();
			var url = '/admin/catalog.php?upsubcat='+idsubcategory;
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri:  url+"&post",
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true,
	    		resetform:false
			});
			return false; 
		});
		/**
		 * Affiche la popup des liens du produit
		 */
		$('.cat-uri-product').live("click",function(){
			var idproducturi = $(this).attr('title');
			var url = '/admin/catalog.php?geturicat='+idproducturi;
			$("#window-box").load(url, function() {
				$(this).dialog({
					bgiframe: true,
					minHeight: 150,
					minWidth: 400,
					modal: true,
					title: 'Copier un lien',
					closeOnEscape: true,
					position: "center",
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: { "Close": function() { $(this).dialog("close"); } }
				});
			});
		});
		/**
		 * Affiche la popup des produits de liaison
		 */
		$('.rel-uri-product').live("click",function(){
			var idproducturi = $(this).attr('title');
			var url = '/admin/catalog.php?getreluri='+idproducturi;
			$("#window-box").load(url, function() {
				$(this).dialog({
					bgiframe: true,
					minHeight: 150,
					minWidth: 400,
					modal: true,
					title: 'Copier un lien de produit de liaison',
					closeOnEscape: true,
					position: "center",
					overlay: {
						backgroundColor: '#000',
						opacity: 0.5
					},
					buttons: { "Close": function() { $(this).dialog("close"); } }
				});
			});
		});
	    /**
	     * Ajout d'une class au survol d'une catégorie
	     */
	    $('#sortproduct li,#sortcat li,#sortsubcat li').hover(
				function() { $(this).addClass('ui-state-hover'); },
				function() { $(this).removeClass('ui-state-hover'); }
		);
	    /**
	     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
	     * Requête ajax pour l'enregistrement du déplacement
	     */
		$("#sortproduct").sortable({
			placeholder: 'ui-state-highlight',
			dropOnEmpty: false,
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortproduct').sortable('serialize');
				$.ajax({
					url: "/admin/catalog.php?catalog&order",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
	    /**
	     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
	     * Requête ajax pour l'enregistrement du déplacement
	     */
		$("#sortcat").sortable({
			placeholder: 'ui-state-highlight',
			dropOnEmpty: false,
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortcat').sortable('serialize');
				$.ajax({
					url: "/admin/catalog.php?catalog&order",
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
			placeholder: 'ui-state-highlight',
			dropOnEmpty: false,
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortsubcat').sortable('serialize');
				$.ajax({
					url: "/admin/catalog.php?order",
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
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri:  "/admin/catalog.php?product&delproduct="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload();
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
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?category&delc="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success : window.location.href = '/admin/catalog.php?category';//window.location.pathname;
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
				minHeight:180,
				modal: true,
				title: 'Supprimé une sous catégorie ?',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?category&dels="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
		/**
		 * Supprime une création de produit dans une catégorie/ou sous catégorie
		 */
		$('.d-in-product').click(function (){
			var inproduct = $(this).attr("title");
			var productid = $('#idcatalog').val();
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé ce produit ?',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?product&editproduct="+productid+"&d_in_product="+inproduct,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
		/**
		 * Supprime une liaison de produit avec une fiche catalogue
		 */
		$('.d-rel-product').click(function (){
			var relproduct = $(this).attr("title");
			var productid = $('#idcatalog').val();
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé une liaison avec ce produit ?',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?product&editproduct="+productid+"&d_rel_product="+relproduct,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
		/**
		 * Formulaire de copie d'un produit du catalogue
		 */
		var formsproduct = $("#copy-catalog-product").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				titlecatalog: {
					required: true,
					minlength: 2
				},
				desccatalog: {
					required: true
				}
			},
			messages: {
				titlecatalog: {
					required: "Enter a title"
				},
				desccatalog: {
					required: "Enter a content"
				}
			},
			submitHandler: function(form) {
				var getcatalog = $("#idproduct").val();
				$.notice({
					ntype: "ajaxsubmit",
		    		dom: form,
		    		uri: '/admin/catalog.php?product&copyproduct='+getcatalog+'&postcopyproduct',
		    		typesend: 'post',
		    		delay: 2800,
		    		time:2,
		    		reloadhtml:true	
				});
			}
		});
		$("#copy-catalog-product").formsproduct;
		/**
		 * Déplacement d'un produit dans une autre langue
		 */
		var formsproduct = $("#move-catalog-product").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				idclc: {
					required: true
				}
			},
			messages: {
				idclc: {
					required: "select category"
				}
			},
			submitHandler: function(form) {
				var getcatalog = $("#idproduct").val();
				$.notice({
					ntype: "ajaxsubmit",
		    		dom: form,
		    		uri: '/admin/catalog.php?product&moveproduct='+getcatalog+'&postmoveproduct',
		    		typesend: 'post',
		    		delay: 2800,
		    		time:2,
		    		reloadhtml:true	
				});
			}
		});
		$("#move-catalog-product").formsproduct;
		/**
		 * Recherche simple dans les titres des catalogues
		 */
		$("#forms-search-catalog").submit(function(){
			$(this).ajaxSubmit({
        		url:'/admin/catalog.php?get_search_page=true',
        		type:"post",
        		resetForm: true,
        		success:function(request) {
        			$("#result-search-page").html(request);
        		}
        	});
			return false; 
		});
/*################## Sitemap ##############*/
		/**
	     * Requête ajax pour la création, modification de fichier sitemap xml
	     */
		$('.create-xml-index').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php?create_xml_index=true',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		 });
		$('.create-xml-url').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php?create_xml_url=true',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		 });
		$('.create-xml-images').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php?create_xml_images=true',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		 });
/*################## Google Tools ##############*/
		/**
	     * Requête ajax pour la création de la soumission vers google
	     */
		$('.pinggoogle').click(function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php?sitemap&googleping',
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
	    		uri: '/admin/sitemap.php?compressionping',
	    		typesend: 'get',
	    		noticedata: null,
	    		time:2
			});
		});
		/**
		 * Soumission de codes Google webmaster et/ou analytics
		 */
		$("#forms-webmaster-tools").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true,
	    		resetform:false
			});
			return false; 
		});
		$("#forms-analytics-tools").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
});