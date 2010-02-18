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
		/*$(".list-screen a").bind({
			click: function() {
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
			}
		});*/
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
		//menu accordeon
		$("#sidebar .management,#sidebar .articles,#sidebar .catalog,#sidebar .cms,#sidebar .extensions").accordion({
			header: "h3",
			icons: {
				header: false,
				headerSelected: false
			},
			navigation: true,
			active: '.selected',
			autoHeight: false,
			clearStyle: true,
			collapsibe: true,
			alwaysOpen: false,
			animated: 'slide',
			//change state for menu accordion
			change: function(event,ui) {
				var hid = ui.newHeader.children('a').attr('id');
				if (hid === undefined) {
					$.cookie('menustate', null);
				} else {
					$.cookie('menustate', hid, { expires: 2 });
					//$.cookie('menustate', hid, { path: '/', expires: 2 });
				}
			}
		});
		// check cookie for accordion state
		if($.cookie('menustate')) {
		   $('#sidebar .management,#sidebar .articles,#sidebar .catalog,#sidebar .cms,#sidebar .extensions').accordion('option', 'animated', false);
		   $('#sidebar .management,#sidebar .articles,#sidebar .catalog,#sidebar .cms,#sidebar .extensions').accordion('activate', $('#' + $.cookie('menustate')).parent('h3'));
		   $('#sidebar .management,#sidebar .articles,#sidebar .catalog,#sidebar .cms,#sidebar .extensions').accordion('option', 'animated', 'slide');
		  /* $("#bdashboard").click(function(){
			   $.cookie('menustate', null, { path: '/', expires: 2 });
		   });*/
		}
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
	    $(".post-preview").colorbox({width:"90%", height:"90%", iframe:true});
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
	    $('#sortcat li,#sortsubcat li').hover(
				function() { $(this).addClass('ui-state-hover'); },
				function() { $(this).removeClass('ui-state-hover'); }
		);
		$("#sortcat").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortcat').sortable('serialize');
				$.ajax({
					url: "/admin/dashboard/catalog/order/",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		$("#sortsubcat").sortable({
			axis: "y",
			cursor: "move",
			update : function () {
				serial = $('#sortsubcat').sortable('serialize');
				$.ajax({
					url: "/admin/dashboard/catalog/order/",
					type: "post",
					data: serial,
					error: function(){
						alert("theres an error with AJAX");
					}
				});
			}
		});
		$('.deleteproduct').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
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
									window.location.href = '/admin/dashboard/catalog/category/'; 
								},3000);
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						success : window.location.href = '/admin/dashboard/catalog/category/';//window.location.pathname;
					}
				}
			});
		 });
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
								//location.reload();
								window.location.href = '/admin/dashboard/catalog/category/'; 
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
		$('.d-news-rmetas').click(function (){
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Supprimé cette phrase ?',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: "/admin/index.php?dashboard&news&rewrite&drmetas="+lg,
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
		$('.createxml').click(function (){
				$.ajax({
					type:'get',
					url: "/admin/index.php?dashboard&sitemap&createxml",
					async: false,
					success:function(e) {
					$("#reponse").html(e);
				}
			});
		 });
		$('.pinggoogle').click(function (){
			$.ajax({
				type:'get',
				url: "/admin/index.php?dashboard&sitemap&googleping",
				async: false,
				success:function(e) {
				$("#reponse").html(e);
			}
		});
	 });
	});