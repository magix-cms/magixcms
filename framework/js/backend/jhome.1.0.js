$(function(){
	/*################## Home ##############*/
	$("#meta").click(function(){
		var visible = $("#forms-metas").toggle().is(":visible");
		 $(this).html(visible ? "-" : "+");
	});
	$.getScript('/framework/js/tools/jquery.textchange.min.js', function() {
		/**
		  * Utilisation de textchange pour le compteur informatif des métas
		  */
		$('#metatitle').bind('textchange', function (event, previousText) {
			$('#charactersLeftT').html( 120 - parseInt($(this).val().length) );
		});
		$('#metadescription').bind('textchange', function (event, previousText) {
			$('#charactersLeftD').html( 180 - parseInt($(this).val().length) );
		});
	});
    $("#forms-home").submit(function(){
		/*tinyMCE.triggerSave(true,true);*/
    	$.editorhtml({editor:_editorConfig});
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
			/*tinyMCE.triggerSave(true,true);*/
			$.editorhtml({editor:_editorConfig});
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
    $('.deletehome').click(function (e){
    	e.preventDefault();
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
						cache: false,
						success: function(){
							location.reload();
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
});