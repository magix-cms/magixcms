function result_search_page(j){
	$('#result-search-page').empty();
	var tablecat = '<table id="table_search_product" class="table-widget-product">'
		+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th>'
		+'<th><span class="lfloat magix-icon magix-icon-h1"></span>Titre</th>'
		+'<th><span class="lfloat ui-icon ui-icon-folder-collapsed"></span></th>'
		+'<th><span class="lfloat magix-icon magix-icon-igoogle-t"></span></th>'
		+'<th><span class="lfloat magix-icon magix-icon-igoogle-d"></span></th>'
		+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
		+'<th><span class="lfloat ui-icon ui-icon-person"></span></th>'
		+'<th><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></th>'
		+'<th><span class="lfloat ui-icon ui-icon-pencil"></span></th>'
		+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
		+'</tr></thead>'
		+'<tbody>';
	tablecat += '</tbody></table>';
	$(tablecat).appendTo('#result-search-page');
	if(j === undefined){
		console.log(j);
	}
	if(j !== null){
		$.each(j, function(i,item) {
			if(item.idcategory != 0){
				category = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}else{
				category = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-home"></span></div>';
			}
			if(item.metatitle != null & item.metatitle != ""){
				metaTitle = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}else{
				metaTitle = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
			}
			if(item.metadescription != null & item.metadescription != ""){
				metaDesc = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}else{
				metaDesc = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
			}
			if(item.codelang != null){
				flaglang = '<div class="ui-state-error" style="border:none;">'+item.codelang+'</div>';
			}else{
				flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
			}
			return $('<tr><td>'+item.idpage+'</td>'
			+'<td class="medium-cell"><a href="/admin/cms.php?editcms='+item.idpage+'" class="linkurl">'+item.subjectpage+'</a></td>'
			+'<td class="small-icon">'+category+'</td>'
			+'<td class="small-icon">'+metaTitle+'</td>'
			+'<td class="small-icon">'+metaDesc+'</td>'
			+'<td class="small-icon">'+flaglang+'</td>'
			+'<td class="small-icon">'+item.pseudo+'</td>'
			+'<td class="small-icon"><a href="/admin/cms.php?movepage='+item.idpage+'" class="linkurl"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a></td>'
			+'<td class="small-icon"><a href="/admin/cms.php?editcms='+item.idpage+'" class="linkurl"><span class="lfloat ui-icon ui-icon-pencil"></span></a></td>'
			+'<td class="small-icon"><a href="#" class="deletecms" title="'+item.idpage+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
			'</tr>').appendTo('#table_search_product tbody');
		});
	}else{
		return $('<tr><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td></tr>').appendTo('#table_search_product tbody');
	}
}
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
	$('.deletecms').live("click",function (e){
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
    		url:'/admin/cms.php?get_search_page=true',
    		type:"post",
    		dataType:"json",
    		resetForm: true,
    		beforeSubmit:function(){
    			$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
    		},
    		success:function(request) {
    			result_search_page(request);
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