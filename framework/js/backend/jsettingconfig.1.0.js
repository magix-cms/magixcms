$(function(){
	/*################## Configuration ##############*/
	//Ajoute un ID numérique (boucle) sur la class "spin"
	$(".spin").each(function(i){
		var newid = $(this).attr("class")+"_" + i;
		this.id = newid;  
		var spinId = $(this).attr("id",newid);
		$(spinId).spinner({ min: 0, max: 200 });
	});
	/**
	 * Ajoute les éléments pour la réécriture des métas
	 */
	$.getScript('/framework/js/tools/jquery.a-tools-1.5.2.min.js', function() {
		$("#add-category").bind("click",function (){
			var myContent = $("#strrewrite").val();
			//$("#strrewrite").val(myContent + "[[category]]").focus();
			$("#strrewrite").insertAtCaretPos("[[category]]");
	        return false;
		});
		$("#add-subcategory").bind("click",function (){
			var myContent = $("#strrewrite").val();
	        //$("#strrewrite").val(myContent + "[[subcategory]]").focus();
			$("#strrewrite").insertAtCaretPos("[[subcategory]]");
	        return false;
		});
		$("#add-product").bind("click",function (){
			var myContent = $("#strrewrite").val();
	        //$("#strrewrite").val(myContent + "[[record]]").focus();
			$("#strrewrite").insertAtCaretPos("[[record]]");
	        return false;
		});
	});
	/**
	 * Initialisation de jQuery UI tabs pour la configuration de Magix CMS
	 */
    $("#tabsFormsConfig").tabs({
		cookie: {
			expires: 1,
			name:"FormsConfig"
		}
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
	$('.d-config-rmetas').click(function(e){
		e.preventDefault();
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
	$("#manager-editor-settings :radio").click(function(){
		$.notice({
			ntype: "ajaxsubmit",
    		delay: 2800,
    		dom: '#manager-editor-settings',
    		uri: '/admin/config.php?manager_editor_setting=true',
    		typesend: 'post',
    		time:2,
    		reloadhtml:false	
		});
		return false; 
	});
	$('.spin').spinner({ min: 0, max: 200 });
});