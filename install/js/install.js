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
	//function replace targetblank for valid w3c
    $('a.targetblank').click( function() {
		 window.open($(this).attr('href'));
		 return false;
	});
	/**
	 * Effet de survol sur les boutons
	 */
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
		$('#install-check').live('click',function(){
			window.location = "/install/check.php";
		});
		/**
		 * Système d'analyse des fonctions disponible sur l'hébergement
		 * Requête ajax tous les 200 micros S 
		 */
		$("#checking").live("click",function(){
			$('#forms-install-check').ajaxSubmit({
				type:'post',
				url: "/install/check.php?version",
				beforeSubmit:function() {
					$("#phpversion").append('<img src="/framework/img/small_loading.gif" />');
				},
				success:function(e) {
					$("#phpversion").html(e);
				}
		    });
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?mbstr",
					beforeSubmit:function() {
						$("#mbstr").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#mbstr").html(e);
					}
			    });
			},200);
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?iconv",
					beforeSubmit:function() {
						$("#iconv").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#iconv").html(e);
					}
			    });
			},400);
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?obst",
					beforeSubmit:function() {
						$("#obst").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#obst").html(e);
					}
			    });
			},600);
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?simple",
					beforeSubmit:function() {
						$("#simple").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#simple").html(e);
					}
			    });
			},800);
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?dom",
					beforeSubmit:function() {
						$("#dom").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dom").html(e);
					}
			    });
			},1000);
			setTimeout(function(){
				$('#forms-install-check').ajaxSubmit({
					type:'post',
					url: "/install/check.php?spl",
					beforeSubmit:function() {
						$("#spl").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#spl").html(e);
					}
			    });
			},1200);
			//Active le bouton "continuer" une fois les requêtes terminé
			setTimeout(function(){
				$('#install-config').removeClass("ui-state-disabled");
				$('#install-config').addClass("ui-state-active");
				$('#install-config').live('click',function(){
					window.location = "/install/install.php";
				});
			},1400);
		});
		/**
		 * Validation du formulaire de création du fichier de configuration (avec requête ajax)
		 */
		var formsCreateFile = $("#forms-install-config").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				M_DBHOST: {
					required: true,
					minlength: 2
				},
				M_DBUSER:{
					required: true,
					minlength: 2
				},
				M_DBPASSWORD:{
					required: true,
					minlength: 2
				},
				M_DBNAME:{
					required: true,
					minlength: 2
				},
				M_TMP_DIR:{
					required: true,
					minlength: 2
				}
			},
			messages: {
				M_DBHOST: {
					required: "Enter a host"
				},
				M_DBUSER:{
					required: "Enter a user db"
				},
				M_DBPASSWORD:{
					required: "Enter a password db"
				},
				M_DBNAME:{
					required: "Enter a name db"
				},
				M_TMP_DIR:{
					required: "Enter a path file log"
				}
			},
			submitHandler: function(form) {
				$(form).ajaxSubmit({
					type:'post',
					url: "/install/install.php?cfile",
					beforeSubmit:function() {
						$("#reqconfig").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$('#install-database').removeClass("ui-state-disabled");
						$('#install-database').addClass("ui-state-active");
						$('#install-database').live('click',function(){
							window.location = "/install/database.php";
						});
						$("#reqconfig").html(e);
					}
			    });
			}
		});
		$("#forms-install-config").formsCreateFile;
		/*$('#i-config').live('click',function(){
			$('#install-database').removeClass("ui-state-disabled");
			$('#install-database').addClass("ui-state-active");
			$('#install-database').live('click',function(){
				window.location = "/install/install.php";
			});
		});*/
		/**
		 * Installe les tables SQL de magix cms
		 * Requête ajax tous les 200 micros S 
		 */
		$("#i-database").live("click",function(){
			$('#forms-install-database').ajaxSubmit({
				type:'post',
				url: "/install/database.php?cusers",
				beforeSubmit:function() {
					$("#dbuser").append('<img src="/framework/img/small_loading.gif" />');
				},
				success:function(e) {
					$("#dbuser").html(e);
				}
		    });
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cperms",
					beforeSubmit:function() {
						$("#dbperms").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbperms").html(e);
					}
			    });
			},300);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?csessions",
					beforeSubmit:function() {
						$("#dbsessions").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbsessions").html(e);
					}
			    });
			},600);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccatalogproduct",
					beforeSubmit:function() {
						$("#dbcatalogprod").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcatalogprod").html(e);
					}
			    });
			},900);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccatalogcat",
					beforeSubmit:function() {
						$("#dbcatalogcat").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcatalogcat").html(e);
					}
			    });
			},1200);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccatalogsubcat",
					beforeSubmit:function() {
						$("#dbcatalogsubcat").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcatalogsubcat").html(e);
					}
			    });
			},1500);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccatalogimg",
					beforeSubmit:function() {
						$("#dbcatalogimg").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcatalogimg").html(e);
					}
			    });
			},1800);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccataloggalery",
					beforeSubmit:function() {
						$("#dbcataloggalery").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcataloggalery").html(e);
					}
			    });
			},2100);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccmscategory",
					beforeSubmit:function() {
						$("#dbcmscategory").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcmscategory").html(e);
					}
			    });
			},2400);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?ccmspage",
					beforeSubmit:function() {
						$("#dbcmspage").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbcmspage").html(e);
					}
			    });
			},2700);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?clang",
					beforeSubmit:function() {
						$("#dblang").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dblang").html(e);
					}
			    });
			},3000);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?chome",
					beforeSubmit:function() {
						$("#dbhome").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbhome").html(e);
					}
			    });
			},3300);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cnews",
					beforeSubmit:function() {
						$("#dbnews").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbnews").html(e);
					}
			    });
			},3600);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cnewspublication",
					beforeSubmit:function() {
						$("#dbnewspub").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbnewspub").html(e);
					}
			    });
			},3900);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?crewrite",
					beforeSubmit:function() {
						$("#dbrewrite").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbrewrite").html(e);
					}
			    });
			},4200);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cglobalconf",
					beforeSubmit:function() {
						$("#dbglobalconf").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbglobalconf").html(e);
					}
			    });
			},4500);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cforms",
					beforeSubmit:function() {
						$("#dbforms").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbforms").html(e);
					}
			    });
			},4800);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cformsinput",
					beforeSubmit:function() {
						$("#dbformsinput").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbformsinput").html(e);
					}
			    });
			},5100);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cconfiglimited",
					beforeSubmit:function() {
						$("#dbconfiglimited").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbconfiglimited").html(e);
					}
			    });
			},5400);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?cplugins",
					beforeSubmit:function() {
						$("#dbplugins").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbplugins").html(e);
					}
			    });
			},5700);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?csettingconf",
					beforeSubmit:function() {
						$("#dbsettingconf").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbsettingconf").html(e);
					}
			    });
			},6000);
			setTimeout(function(){
				$('#forms-install-database').ajaxSubmit({
					type:'post',
					url: "/install/database.php?csitemap",
					beforeSubmit:function() {
						$("#dbsitemap").append('<img src="/framework/img/small_loading.gif" />');
					},
					success:function(e) {
						$("#dbsitemap").html(e);
						$('#install-user').removeClass("ui-state-disabled");
						$('#install-user').addClass("ui-state-active");
						$('#install-user').live('click',function(){
							window.location = "/install/adminuser.php";
						});
					}
			    });
			},6300);
		});
		/**
		 * Validation de l'utilisateur principal
		 */
		var formsusers = $("#forms-install-users").validate({
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
		$("#forms-install-users").formsusers;
});