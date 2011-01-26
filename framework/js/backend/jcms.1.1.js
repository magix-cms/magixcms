$(function(){
	/*################## CMS ##############*/
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
    /**
     * ID pour le déplacement des pages CMS
     */
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
		/*tinyMCE.triggerSave(true,true);*/
		$.editorhtml({editor:_editorConfig});
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
			/*/*tinyMCE.triggerSave(true,true);*/
			$.editorhtml({editor:_editorConfig});
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
	$('.ucms-category').live("click",function(e){
		e.preventDefault();
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
	$('.deletecms').click(function (e){
		e.preventDefault();
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
						cache:false,
						success: function(){
							location.reload();
						}
				     });
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
	/**
	 * Requête ajax pour la mise à jour d'une catégorie CMS
	 */
	$('.dcmscat').click(function (e){
		e.preventDefault();
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
	$('.cms-page-uri').live("click",function(e){
		e.preventDefault();
		var currenturi = $(this).attr('title');
			$('#window-box').dialog({
				open:function() {
					$(this).append(currenturi);
				},
				bgiframe: false,
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
});