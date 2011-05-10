/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name install.js
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
	//function replace targetblank for valid w3c
    $('a.targetblank').click( function() {
		 window.open($(this).attr('href'));
		 return false;
	});
		/**
		 * Support input button with jquery ui button
		 */
		$("input:submit").button();
		$(".inst-button").button();
		/**
		 * Notification après installation pour le dossier "install"
		 */
		if ($('#notify-folder').length != 0){
			$('#notify-folder').destroyMeerkat();
			$('#notify-folder').meerkat({
				background:"#efefef",
				width: '100%',
				position: 'top',
				close: '.close-notify',
				dontShowAgain: '.dont-notify',
				animationIn: 'fade',
				animationOut: 'slide',
				animationSpeed: '750',
				//removeCookie: '.reset',
				height: '80px',
				opacity: '0.90',
				onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
			}).addClass('pos-top');
		}
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
				$('#install-config').live('click',function(e){
					e.preventDefault();
					$(this).removeClass("ui-state-disabled");
					$(this).addClass("ui-state-active");
					$(this).attr("href","/install/config.php");
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
				$.notice({
					ntype: "ajaxsubmit",
		    		dom: form,
		    		uri: '/install/config.php?cfile',
		    		typesend: 'post',
		    		noticedata: null,
		    		resetform:true,
		    		time:null,
		    		reloadhtml:false
				});
				$(':submit',form).attr("disabled","disabled");
				$('#install-database').live('click',function(){
					$(this).attr("href","/install/database.php");
				});
				return false; 
			}
		});
		$("#forms-install-config").formsCreateFile;
		/**
		 * Installe les tables SQL de magix cms
		 * Requête ajax tous les 200 micros S 
		 */
		$("#forms-install-database").submit(function(){
			/*$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/install/database.php?process=true',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:true,
	    		time:null,
	    		reloadhtml:false
	    	});*/
			$(this).ajaxSubmit({
				url:"/install/database.php?process=true",
				type:"post",
				beforeSubmit:function(){
					$("#dbinstall").prepend('<img style="margin-left:50px;" src="/install/img/loading.gif" />');
				},
				success:function(e){
					$.notice({
						ntype: "simple",
			    		time:null
			    	});
					$("#dbinstall").empty();
					$(".mc-head-request").html(e);
					$(':submit',this).attr("disabled","disabled");
					$('#install-user').removeClass("ui-state-disabled");
					$('#install-user').addClass("ui-state-active");
					$('#install-user').live('click',function(){
						window.location = "/install/adminuser.php";
					});
				}
			});
			return false; 
		});
		/**
		 * Validation de l'utilisateur principal avec requête ajax pour l'ajout de l'utilisateur principal
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
/**
 * Initialisation de nivoslider pour le défilement d'images
 */
$(window).load(function() {
	$('#slider').nivoSlider({
		effect:'random',
		pauseTime:5000, 
		pauseOnHover:true,
		captionOpacity:0.8 //Universal caption opacity
	});
});