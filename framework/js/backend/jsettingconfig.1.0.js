/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jsettingconfig.1.0.js
 *
 */
function load_list_metas(){
	$.ajax({
		url: '/admin/config.php?metasrewrite=true&load_metas=true',
		dataType: 'json',
		type: "get",
		async: true,
		cache:false,
		beforeSend: function(){
			$('#load_list_metas').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
		},
		success: function(j) {
			$('#load_list_metas').empty();
			var tablecat = '<table id="table_load_metas" class="table-widget-product">'
				+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header">'
				+'<th>ID</th>'
				+'<th class="medium-cell">Métas</th>'
				+'<th class="medium-cell">Module</th>'
				+'<th class="medium-cell">Phrase</th>'
				+'<th class="small-icon">Level</th>'
				+'<th class="small-icon"><span style="float:left;" class="ui-icon ui-icon-flag"></span></th>'
				+'<th class="small-icon"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></th>'
				+'<th class="small-icon"><span class="lfloat ui-icon ui-icon-close"></span></th>'
				+'</tr></thead>'
				+'<tbody>';
			tablecat += '</tbody></table>';
			$(tablecat).appendTo('#load_list_metas');
			if(j === undefined){
				console.log(j);
			}
			if(j !== null){
				$.each(j, function(i,item) {
					if(item.codelang != null){
						flaglang = '<div class="ui-state-error" style="border:none;">'+item.codelang+'</div>';
					}else{
						flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
					}
					switch(item.idmetas){
						case "1":
							var type = 'TITLE';
						break;
						case "2":
							var type = 'DESCRIPTION';
						break;
					}
					return $('<tr>'
					+'<td>'+item.idrewrite+'</td>'
					+'<td class="medium-cell">'+type+'</td>'
					+'<td class="medium-cell">'+item.named+'</td>'
					+'<td class="medium-cell">'+item.strrewrite+'</td>'
					+'<td class="small-icon">'+item.level+'</td>'
					+'<td class="small-icon">'+flaglang+'</td>'
					+'<td class="small-icon"><a href="/admin/config.php?metasrewrite&edit='+item.idrewrite+'" class="linkurl"><span class="lfloat ui-icon ui-icon-pencil"></span></a></td>'
					+'<td class="small-icon"><a href="#" class="d-config-rmetas" title="'+item.idrewrite+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
					'</tr>').appendTo('#load_list_metas tbody');
				});
			}else{
				return $('<tr><td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
						+'</tr>').appendTo('#load_list_metas tbody');
			}
		}
	});
}
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
		$(this).ajaxSubmit({
    		url:'/admin/config.php?metasrewrite&add',
    		type:"post",
    		resetForm: true,
    		beforeSubmit:function(){
    			$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
    		},
    		success:function(request) {
    			$.notice({
					ntype: "simple",
					time:2
				});
    			$(".mc-head-request").html(request);
    			load_list_metas(request);
    		}
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
        		beforeSubmit:function(){
        			$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
        		},
        		success:function(request) {
        			$.notice({
    					ntype: "simple",
    					time:2
    				});
        			$(".mc-head-request").html(request);
        			load_list_metas(request);
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