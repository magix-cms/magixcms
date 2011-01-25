$(function(){
	var ie6 = ($.browser.msie && $.browser.version < 7);
	var ie7 = ($.browser.msie && $.browser.version > 6);
	var ie = ($.browser.msie);
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
	$(".list-screen a").bind("click", function(e){
		e.preventDefault();
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
	 * Requête ajax pour le changement de thème
	 */
	$(".list-editor a").bind("click", function(e){
		e.preventDefault();
		var hreftitle = $(this).attr("title");
			if(hreftitle != null){
				if(ie){
					$.post('/admin/config.php?htmleditor=true', 
						{ editor: hreftitle}
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
						data: "editor="+hreftitle,
						url: "/admin/config.php?htmleditor=true",
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
})