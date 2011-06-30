var ns_jrewritemetas = {
	_loadingConfig:function(){
		/**
		 * Ajoute les éléments pour la réécriture des métas
		 */
		$.getScript('/framework/js/tools/jquery.a-tools-1.5.2.min.js', function(){
			$("#add-category").bind("click",function (){
				var myContent = $("#strrewrite").val();
				$("#strrewrite").insertAtCaretPos("[[category]]");
		        return false;
			});
			$("#add-subcategory").bind("click",function (){
				var myContent = $("#strrewrite").val();
				$("#strrewrite").insertAtCaretPos("[[subcategory]]");
		        return false;
			});
			$("#add-product").bind("click",function (){
				var myContent = $("#strrewrite").val();
				$("#strrewrite").insertAtCaretPos("[[record]]");
		        return false;
			});
		});
	},
	_listingRecords:function(){
		$.ajax({
			url: '/admin/rewritemetas.php?load_metas=true',
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
						if(item.iso != null){
							flaglang = item.iso;
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
						+'<td class="medium-cell">'+item.attribute+'</td>'
						+'<td class="medium-cell">'+item.strrewrite+'</td>'
						+'<td class="small-icon">'+item.level+'</td>'
						+'<td class="small-icon">'+flaglang+'</td>'
						+'<td class="small-icon"><a href="/admin/rewritemetas.php?edit='+item.idrewrite+'" class="linkurl"><span class="lfloat ui-icon ui-icon-pencil"></span></a></td>'
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
	},
	_addNewMetas:function(){
		$("#forms-config-rewrite").submit(function(){
			$(this).ajaxSubmit({
	    		url:'/admin/rewritemetas.php?add=1',
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
	    			ns_jrewritemetas._listingRecords();
	    		}
	    	});
			return false; 
		});
	},
	_updateMetas:function(){
		/**
		 * Soumission ajax d'une mise à jour d'une réécriture de métas dans la configuration
		 */
		$("#forms-config-rewrite-update").submit(function(){
			var rewriteid = $('#idrewrite').val();
			if(rewriteid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/rewritemetas.php?edit='+rewriteid+'&post',
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
	        			ns_jrewritemetas._listingRecords();
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","rewriteid is null",rewriteid);
			}
		});
	},
	_deleteMetas:function(){
		/**
	     * Requête ajax pour la suppression des réécriture de métas
	     */
		$('.d-config-rmetas').live('click',function(e){
			e.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Supprimé cette réécriture ?',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: "/admin/rewritemetas.php",
							data: "drmetas="+lg,
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
							async: false,
							success: function(){
								ns_jrewritemetas._listingRecords();
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	}
};