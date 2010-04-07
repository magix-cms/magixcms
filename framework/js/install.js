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
			setTimeout(function(){
				$('#install-config').removeClass("ui-state-disabled");
				$('#install-config').addClass("ui-state-active");
				$('#install-config').live('click',function(){
					window.location = "/install/install.php";
				});
			},1400);
		});
});