/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jcms.1.1.js
 *
 */
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
			if(item.metatitle != 0){
				metaTitle = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}else{
				metaTitle = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
			}
			if(item.metadescription != 0){
				metaDesc = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
			}else{
				metaDesc = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
			}
			if(item.codelang != null){
				flaglang = item.codelang;
			}else{
				flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
			}
			return $('<tr>'
			+'<td>'+item.idpage+'</td>'
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
function create_dynamic_cms_uri(){
	var idpage = $("#idpage").val();
	$.ajax({
		url: '/admin/cms.php?editcms='+idpage+'&load_json_uri_cms=true',
		dataType: 'json',
		type: "get",
		statusCode: {
			0: function() {
				console.error("jQuery Error");
			},
			401: function() {
				console.warn("access denied");
			},
			404: function() {
				console.warn("object not found");
			},
			403: function() {
				console.warn("request forbidden");
			},
			408: function() {
				console.warn("server timed out waiting for request");
			},
			500: function() {
				console.error("Internal Server Error");
			}
		},
		async: true,
		cache:false,
		beforeSend: function(){
			$("#cmslink").css({"display":"none"}).val('');
			if($("#category").length != 0){
				$("#category").css({"display":"none"}).val('');
				$('<span class="min-loader"><img src="/framework/img/small_loading.gif" /></span>').insertAfter('#category');
			}
			$('<span class="min-loader"><img src="/framework/img/small_loading.gif" /></span>').insertAfter('#cmslink');
		},
		success: function(j) {
			$('.min-loader').remove();
			var uri = j.cmsuri;
			$("#cmslink").css({"display":"block"});
			$("#cmslink").val(uri);
			$(".post-preview").attr({
				href:uri
			});
			if($("#category").length != 0){
				$("#category").css({"display":"block"});
				var cmscategory = j.category;
				if(cmscategory != null){
					$("#category").val(cmscategory);
				}
			}
		}
	});
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
			$.editorhtml({editor:_editorConfig});
			$(this).ajaxSubmit({
	    		url:'/admin/cms.php?editcms='+pageid+'&post',
	    		type:"post",
	    		resetForm: false,
	    		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			create_dynamic_cms_uri();
	    		}
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