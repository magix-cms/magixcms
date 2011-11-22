/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jrewritemetas
 * @update 20/10/2011 12:20
 */
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
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/rewritemetas.php?load_metas=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$('#load_list_metas').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			successParams:function(j){
				$('#load_list_metas').empty();
				$.nicenotify.initbox(j,{
					display:false
				});
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
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/rewritemetas.php?add=1',
				typesend: 'post',
				idforms: $(this),
				resetForm: true,
				beforeParams:function(){
					$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
				},
				successParams:function(e){
					$.nicenotify.initbox(e);
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
				$.nicenotify({
					ntype: "submit",
					uri: '/admin/rewritemetas.php?edit='+rewriteid+'&post',
					typesend: 'post',
					idforms: $(this),
					beforeParams:function(){
						$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
					},
					successParams:function(e){
						$.nicenotify.initbox(e);
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
						$.nicenotify({
							ntype: "ajax",
							uri: "/admin/rewritemetas.php",
							typesend: 'post',
							noticedata : "drmetas="+lg,
							successParams:function(request){
								$.nicenotify.initbox(request,{
									display:false
								});
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
	},
	run:function(){
		this._loadingConfig();
		this._listingRecords();
		this._addNewMetas();
		this._deleteMetas();
	},
	runEdit:function(){
		this._loadingConfig();
		this._listingRecords();
		this._updateMetas();
		this._deleteMetas();
	}
};