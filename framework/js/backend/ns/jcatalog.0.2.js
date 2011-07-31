var ns_jcatalog_subcategory = {
	_load_json_subcat:function(upcat){
		$.ajax({
			url: '/admin/catalog.php?upcat='+upcat+'&json_sub_cat=true',
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
				$('#list-sub-category').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#list-sub-category').empty();
				var sortcat = '<ul id="sortsubcat">';
				sortcat += '</ul>';
				$(sortcat).appendTo('#list-sub-category');
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						if($.ieTester()){
							return $('<li class="ui-state-default" id="sorder_'+item.idcls+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.slibelle
							+'<div style="float:right;margin-top:-15px;top:0;margin-right:10px;">'
							+'<a href="/admin/catalog.php?upsubcat='+item.idcls+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a href="#" style="cursor:pointer;" class="aspanfloat dels" title="'+item.idcls+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></div>'+
							'<div style="clear:both;"></div></li>').appendTo('#sortsubcat');
						}else{
							return $('<li class="ui-state-default" id="sorder_'+item.idcls+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.slibelle
							+'<div style="float:right">'
							+'<a href="/admin/catalog.php?upsubcat='+item.idcls+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a href="#" class="aspanfloat dels" title="'+item.idcls+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a>'+
							'</li>').appendTo('#sortsubcat');
						}
					});
				}
				/**
			     * Initialisation du drag and drop pour les sous catégories (catalogue uniquement)
			     * Requête ajax pour l'enregistrement du déplacement
			     */
				$('#sortsubcat li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				$('#sortsubcat').sortable({
					placeholder: 'ui-state-highlight',
					cursor: "move",
					axis: "y",
					update : function () {
						serial = $('#sortsubcat').sortable('serialize');
						$.ajax({
							url: "/admin/catalog.php?order",
							type: "post",
							cache:false,
							data: serial,
							error: function(){
								alert("theres an error with AJAX");
							}
						});
					}
				});
				$("#sortsubcat").disableSelection();
			}
		});
	},
	_loadImgSubCat:function(usubcategory){
		$.ajax({
			url: '/admin/catalog.php?upsubcat='+usubcategory+'&imgsubcat=1',
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
				$('#contener_image').html('<img src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#contener_image').empty();
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						return $('<img src="/upload/catalogimg/subcategory/'+item.img_s+'" />').appendTo('#contener_image');
					});
				}else{
					return $('<img src="/framework/img/no-picture.png" />').appendTo('#contener_image');
				}
			}
		});
	},
	_addNewSubCat:function(upcat){
		/**
		 * Soumission d'une nouvelle sous catégorie dans le catalogue
		 */
		$("#forms-catalog-subcategory").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/catalog.php?category&post=1',
	    		type:"post",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#list-sub-category').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
	    		},
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			ns_jcatalog_subcategory._load_json_subcat(upcat);
	    		}
	    	});
			return false;
		});
	},
	_editSubCat:function(idsubcategory){
		/**
		 * Mise à jour d'une sous catégorie
		 */
		$("#forms-catalog-editsubcategory").submit(function(){
			var urleditsubcat = '/admin/catalog.php?upsubcat='+idsubcategory;
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri:  urleditsubcat+"&post=1",
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:false,
	    		resetform:false
			});
			return false;
		});
	},
	_editSubCatImg:function(idsubcategory){
		/**
		 * Edition d'une image de sous catégorie
		 */
		$("#forms-catalog-editsubcategory-img").submit(function(){
			var urleditsubcat = '/admin/catalog.php?upsubcat='+idsubcategory;
			$(this).ajaxSubmit({
	    		url: urleditsubcat+"&postimg=1",
	    		type:"post",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			//$('#contener_image').html('<img src="/framework/img/square-circle.gif" />');
	    		},
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			ns_jcatalog_subcategory._loadImgSubCat(idsubcategory);
	    		}
	    	});
			return false; 
		});
	},
	_deleteSubCat:function(){
		/**
	     * Requête ajax pour la suppression des sous catégories dans le catalogue
	     */
		$('.dels').live("click",function(event){
			event.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				minHeight:180,
				modal: true,
				title: 'Supprimé une sous catégorie ?',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?category&dels="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	runEdit:function(){
		this._loadImgSubCat($("#usubcategory").val());
		this._editSubCat($('#usubcategory').val());
		this._editSubCatImg($('#usubcategory').val());
	}
};
var ns_jcatalog_category = {
	_init:function(edit){
		if(edit != false){
			/**
		     * Ajout d'une class au survol d'une catégorie
		     */
		    $('#sortproduct li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
			);
		    /**
		     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
		     * Requête ajax pour l'enregistrement du déplacement
		     */
			$("#sortproduct").sortable({
				placeholder: 'ui-state-highlight',
				dropOnEmpty: false,
				axis: "y",
				cursor: "move",
				update : function () {
					serial = $('#sortproduct').sortable('serialize');
					$.ajax({
						url: "/admin/catalog.php?catalog&order",
						type: "post",
						data: serial,
						error: function(){
							alert("theres an error with AJAX");
						}
					});
				}
			});
		}else{
			/**
		     * Ajout d'une class au survol d'une catégorie
		     */
		    $('#sortcat li,#sortsubcat li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
			);
		}
	},
	_load_json_cat:function(idlang){
		$.ajax({
			url: '/admin/catalog.php?getlang='+idlang+'&category=true&json_cat=true',
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
				$('#list-category').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#list-category').empty();
				var sortcat = '<ul id="sortcat">';
				sortcat += '</ul>';
				$(sortcat).appendTo('#list-category');
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						if(item.iso != null){
							langspan = '<span class="lfloat">'+item.iso+'</span>';
						}else{
							langspan = '<span class="lfloat ui-icon ui-icon-flag"></span>';
						}
						if($.ieTester()){
							return $('<li class="ui-state-default" id="corder_'+item.idclc+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.clibelle
							+'<div style="float:right;margin-top:-15px;top:0;margin-right:10px;">'+langspan
							+'<a href="/admin/catalog.php?upcat='+item.idclc+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a href="#" class="aspanfloat delc" title="'+item.idclc+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></div>'+
							'<div style="clear:both;"></div></li>').appendTo('#sortcat');
						}else{
							return $('<li class="ui-state-default" id="corder_'+item.idclc+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.clibelle
							+'<div style="float:right;">'+langspan
							+'<a href="/admin/catalog.php?upcat='+item.idclc+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a href="#" class="aspanfloat delc" title="'+item.idclc+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></div>'+
							'</li>').appendTo('#sortcat');
						}
					});
				}
				/**
			     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
			     * Requête ajax pour l'enregistrement du déplacement
			     */
				$('#sortcat li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				$('#sortcat').sortable({
					placeholder: 'ui-state-highlight',
					cursor: "move",
					axis: "y",
					update : function () {
						serial = $('#sortcat').sortable('serialize');
						$.ajax({
							url: "/admin/catalog.php?order",
							type: "post",
							cache:false,
							data: serial,
							error: function(){
								alert("theres an error with AJAX");
							}
						});
					}
				});
				$("#sortcat").disableSelection();
			}
		});
	},
	_addNewCat:function(getlang,idlang){
		/**
		 * Soumission d'une nouvelle catégorie dans le catalogue
		 */
		$("#forms-catalog-category").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/catalog.php?category&post=1',
	    		type:"post",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#list-category').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
	    		},
	    		success:function(request) {
	    			$('#img_c:file').val('');
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			if(getlang==true){
	    				ns_jcatalog_category._load_json_cat(idlang);
	    			}else{
	    				ns_jcatalog_product._google_chart_language();
	    			}
	    		}
	    	});
			return false;
		});
	},
	_loadImgCat:function(edit){
		$.ajax({
			url: '/admin/catalog.php?upcat='+edit+'&imgcat=1',
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
				$('#contener_image').html('<img src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#contener_image').empty();
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						return $('<img src="/upload/catalogimg/category/'+item.img_c+'" />').appendTo('#contener_image');
					});
				}else{
					return $('<img src="/framework/img/no-picture.png" />').appendTo('#contener_image');
				}
			}
		});
	},
	_editCat:function(idcategory){
		/**
		 * Mise à jour d'une catégorie
		 */
		$("#forms-catalog-editcategory").submit(function(){
			var url = '/admin/catalog.php?upcat='+idcategory;
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri:  url+"&post=1",
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:false,
	    		resetform:false
			});
			return false; 
		});
	},
	_editCatImg:function(idcategory){
		$("#forms-catalog-editcategory-img").submit(function(){
			var urleditcat = '/admin/catalog.php?upcat='+idcategory;
			$(this).ajaxSubmit({
	    		url: urleditcat+"&postimg=1",
	    		type:"post",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#contener_image').html('<img src="/framework/img/square-circle.gif" />');
	    		},
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			ns_jcatalog_category._loadImgCat(idcategory);
	    		}
	    	});
			return false; 
		});
	},
	_deleteCat:function(){
		/**
	     * Requête ajax pour la suppression des catégories
	     */
		$('.delc').live("click",function(event){
			event.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:220,
				modal: true,
				title: 'Supprimé cette catégorie',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				open:function(){
					$("p").append('<br />Les sous catégorie seront également supprimé');
				},
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri: "/admin/catalog.php?category&delc="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
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
		this._addNewCat(false,false);
		ns_jcatalog_product._google_chart_language();
	},
	runLang:function(){
		this._init(false);
		this._load_json_cat($("#idlang").val());
		this._addNewCat(true,$("#idlang").val());
		this._deleteCat();
	},
	runEdit:function(){
		this._init(true);
		this._loadImgCat($("#ucategory").val());
		ns_jcatalog_subcategory._load_json_subcat($("#ucategory").val());
		ns_jcatalog_subcategory._addNewSubCat($("#ucategory").val());
		this._editCat($('#ucategory').val());
		this._editCatImg($('#ucategory').val());
		ns_jcatalog_subcategory._deleteSubCat();
	}
};
var ns_jcatalog_product = {
	_load_json_cat_product:function(idcatalog){
		$.ajax({
			url: '/admin/catalog.php?product&editproduct='+idcatalog+'&json_cat_product=true',
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
				$('#load_cat_product').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#load_cat_product').empty();
				var tablecat = '<table id="table_cat_product" class="table-widget-product">'
					+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th>'
					+'<th><span class="lfloat ui-icon ui-icon-folder-open"></span>catégorie</th>'
					+'<th><span class="lfloat ui-icon ui-icon-folder-collapsed"></span> sous catégorie</th>'
					+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
					+'</tr></thead>'
					+'<tbody>';
				tablecat += '</tbody></table>';
				$(tablecat).appendTo('#load_cat_product');
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						if(item.slibelle != null){
							subcat = item.slibelle;
						}else{
							subcat = '<span class="lfloat ui-icon ui-icon-minus"></span>';
						}
						return $('<tr><td>'+item.idproduct+'</td>'
						+'<td class="medium-cell">'+item.clibelle+'</td>'
						+'<td>'+subcat+'</td>'
						+'<td class="small-icon"><a href="#" class="d-in-product" title="'+item.idproduct+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></td>'+
						'</tr>').appendTo('#table_cat_product tbody');
					});
				}else{
					return $('<tr>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'</tr>').appendTo('#table_cat_product tbody');
				}
			}
		});
	},
	_deleteCatProduct:function(idcatalog){
		/**
		 * Supprime une création de produit dans une catégorie/ou sous catégorie
		 */
		$('.d-in-product').live("click",function (event){
			event.preventDefault();
			var inproduct = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé ce produit ?',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							url: "/admin/catalog.php?product&editproduct="+idcatalog+"&d_in_product="+inproduct,
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
							beforeSend: function(){},
							success: function(request) {
								$.notice({
									ntype: "simple",
						    		time:2
								});
								$(".mc-head-request").html(request);
								ns_jcatalog_product._load_json_cat_product(idcatalog);
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
	_load_rel_product:function(idcatalog){
		$.ajax({
			url: '/admin/catalog.php?product&editproduct='+idcatalog+'&json_rel_product=true',
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
				$('#load_rel_product').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#load_rel_product').empty();
				var tablecat = '<table id="table_rel_product" class="table-widget-product">'
					+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th>'
					+'<th><span class="lfloat ui-icon ui-icon-folder-open"></span>catégorie</th>'
					+'<th><span class="lfloat ui-icon ui-icon-folder-collapsed"></span> sous catégorie</th>'
					+'<th><span class="lfloat magix-icon magix-icon-h1"></span> Titre</th>'
					+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
					+'</tr></thead>'
					+'<tbody>';
				tablecat += '</tbody></table>';
				$(tablecat).appendTo('#load_rel_product');
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) {
						if(item.slibelle != null){
							subcat = item.slibelle;
						}else{
							subcat = '<span class="lfloat ui-icon ui-icon-minus"></span>';
						}
						return $('<tr><td>'+item.idrelproduct+'</td>'
						+'<td class="medium-cell">'+item.clibelle+'</td>'
						+'<td class="medium-cell">'+subcat+'</td>'
						+'<td class="medium-cell">'+item.titlecatalog+'</td>'
						+'<td class="small-icon"><a href="#" class="d-rel-product" title="'+item.idrelproduct+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></td>'+
						'</tr>').appendTo('#table_rel_product tbody');
					});
				}else{
					return $('<tr>'
							+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
							+'<td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
							+'<td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
							+'<td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
							+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
							+'</tr>').appendTo('#table_rel_product tbody');
				}
			}
		});
	},
	_deleteRelProduct:function(productid){
		/**
		 * Supprime une liaison de produit avec une fiche catalogue
		 */
		$('.d-rel-product').live("click",function (event){
			event.preventDefault();
			var relproduct = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé une liaison avec ce produit ?',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							url: "/admin/catalog.php?product&editproduct="+productid+"&d_rel_product="+relproduct,
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
							beforeSend: function(){},
							success: function(request) {
								$.notice({
									ntype: "simple",
						    		time:2
								});
								$(".mc-head-request").html(request);
								ns_jcatalog_product._load_rel_product(productid);
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
	_loadImgProduct:function(idproduct){
		$.ajax({
			url: '/admin/catalog.php?product&getimg='+idproduct+'&jsonimgproduct=1',
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
				$('#contener_image_product,#contener_image_medium,#contener_image_mini').html('<img src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#contener_image_product,#contener_image_medium,#contener_image_mini,#gwidth,#gheight,#pwidth,#pheight,#swidth,#sheight').empty();
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					$.each(j, function(i,item) { 
						var img = $('<img src="/upload/catalogimg/product/'+item.imgcatalog+'" width="'+item.gwidth+'" height="'+item.gheight+'" />').appendTo('#contener_image_product');
						img += $('<img src="/upload/catalogimg/medium/'+item.imgcatalog+'" width="'+item.pwidth+'" height="'+item.pheight+'" />').appendTo('#contener_image_medium');
						img += $('<img src="/upload/catalogimg/mini/'+item.imgcatalog+'" width="'+item.swidth+'" height="'+item.sheight+'" />').appendTo('#contener_image_mini');
						img += $('<strong>'+item.gwidth+'</strong>').appendTo('#gwidth');
						img += $('<strong>'+item.gheight+'</strong>').appendTo('#gheight');
						img += $('<strong>'+item.pwidth+'</strong>').appendTo('#pwidth');
						img += $('<strong>'+item.pheight+'</strong>').appendTo('#pheight');
						img += $('<strong>'+item.swidth+'</strong>').appendTo('#swidth');
						img += $('<strong>'+item.sheight+'</strong>').appendTo('#sheight');
						return img;
					});
				}else{ 
					var img = $('<img src="/framework/img/no-picture.png" width="120" height="120" />').appendTo('#contener_image_product');
					img += $('<img src="/framework/img/no-picture.png" width="120" height="120" />').appendTo('#contener_image_medium');
					img += $('<img src="/framework/img/no-picture.png" width="120" height="120" />').appendTo('#contener_image_mini');
					img += $('<strong>0</strong>').appendTo('#gwidth');
					img += $('<strong>0</strong>').appendTo('#gheight');
					img += $('<strong>0</strong>').appendTo('#pwidth');
					img += $('<strong>0</strong>').appendTo('#pheight');
					img += $('<strong>0</strong>').appendTo('#swidth');
					img += $('<strong>0</strong>').appendTo('#sheight');
					return img;
				}
			}
		});
	},
	_loadImgMicroGalery:function(idproduct){
		$.ajax({
			url: '/admin/catalog.php?product&getimg='+idproduct+'&json_micro_galery=1',
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
				$('#contener_micro_galery').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#contener_micro_galery').empty();
				var contener_images = '<div id="list-image-galery">';
				contener_images += '</div>';
				$(contener_images).appendTo('#contener_micro_galery');
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var listimg = '';
					$.each(j, function(i,item) {
						listimg += $('<div class="list-img ui-widget-content">'
						+'<div class="title-galery-image ui-widget-content">'
						+'<a href="#" class="delmicro" title="'+item.idmicro+'"><span style="float:right;" class="ui-icon ui-icon-trash"></span></a>'
						+'</div>'
						+'<div class="img-galery"><img src="/upload/catalogimg/galery/mini/'+item.imgcatalog+'" /></div>'
						+'</div>').appendTo('#list-image-galery');
					});
					listimg +=$('<div style="clear:left;"></div>').appendTo('#list-image-galery');
					$('.title-galery-image .delmicro').hover(
						function() { 
							$(this).parent().addClass('ui-state-active'); 
						},
						function() { 
							$(this).parent().removeClass('ui-state-active'); 
						}
					);
					return listimg;
				}
			}
		});
	},
	_editImgProduct:function(idproduct){
		var valphoto = $("#forms-catalog-image").validate({
		 	rules: {
			imgcatalog: {
		 			required: true,
		 			minlength: 1,
		 			accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
		 		}
		 	},
		 	submitHandler: function(form) {
			 	$(form).ajaxSubmit({
				 	url:'/admin/catalog.php?product&getimg='+idproduct+'&postimgproduct=1',
				 	type:"post",
				 	resetForm: true,
				 	beforeSubmit:function(){
				 		$('#contener_image_product,#contener_image_medium,#contener_image_mini').html('<img src="/framework/img/square-circle.gif" />');
				 	},
				 	success:function(request){
				 		$('#imgcatalog:file').val('');
				 		ns_jcatalog_product._loadImgProduct(idproduct);
				 	}
				});
			 	return false;
		 	}
		 });
		$("#forms-catalog-image").valphoto;
	},
	_addImgMicroGalery:function(idproduct){
		var valgalery = $("#forms-catalog-galery").validate({
		 	rules: {
		 		imggalery: {
		 			required: true,
		 			minlength: 1,
		 			accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
		 		}
		 	},
		 	submitHandler: function(form) {
			 	$(form).ajaxSubmit({
				 	url:'/admin/catalog.php?product&getimg='+idproduct+'&postimggalery=1',
				 	type:"post",
				 	beforeSubmit:function(){
				 		$('#contener_micro_galery').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
				 	},
				 	success:function(e){
				 		$('#imggalery:file').val('');
				 		ns_jcatalog_product._loadImgMicroGalery(idproduct);
				 	}
				});
		 	}
		 });
		$("#forms-catalog-galery").valgalery;
	},
	_deleteMicroGalery:function(idproduct){
		$('.delmicro').live("click",function(event){
			event.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:180,
				modal: true,
				title: 'Supprimé cette image de la galerie',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
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
							url: '/admin/catalog.php?product&getimg='+idproduct+'&delmicro='+lg,
							async: false,
							success:function(request) {
								$.notice({
									ntype: "simple",
									time:2
								});
		        				$(".mc-head-request").html(request);
		        				ns_jcatalog_product._loadImgMicroGalery(idproduct);
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
	_deleteProduct:function(){
		/**
	     * Requête ajax pour la suppression des produits
	     */
		$('.deleteproduct').live("click",function (event){
			event.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				minHeight:180,
				modal: true,
				title: 'Supprimé ce produit',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri:  "/admin/catalog.php?product&delproduct="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	_addCatalogCardProduct:function(){
		/**
		 * Soumission ajax d'un produit dans le catalogue
		 */
		$("#forms-catalog-card-product").submit(function(){
			$(this).ajaxSubmit({
	    		url:'/admin/catalog.php?product=true&add_card_product=1',
	    		type:"post",
	    		resetForm: true,
	    		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    		}
	    	});
			return false; 
		});
	},
	_editCatalogCardProduct:function(productid){
		/**
		 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
		 */
		$("#forms-catalog-card-product-edit").submit(function(){
			if(productid != null){
				$.notice({
					ntype: "ajaxsubmit",
		    		delay: 1800,
		    		dom: this,
		    		uri: '/admin/catalog.php?product&editproduct='+productid+'&updateproduct=1',
		    		typesend: 'post',
		    		noticedata: null,
		    		resetform:false,
		    		time:2,
		    		reloadhtml:false	
				});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
	},
	_addProduct:function(productid){
		/**
		 * Soumission ajax d'un produit dans le catalogue
		 */
		$("#forms-catalog-product").submit(function(){
			if(productid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/catalog.php?product=true&editproduct='+productid+'&add_product=1',
	        		type:"post",
	        		resetForm: false,
	        		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
	        			$(".mc-head-request").html(request);
	        			ns_jcatalog_product._load_json_cat_product(productid);
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
	},
	_addRelProduct:function(productid){
		$("#forms-catalog-rel-product").submit(function(){
			if(productid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/catalog.php?product=true&editproduct='+productid+'&post_rel_product=1',
	        		type:"post",
	        		resetForm: false,
	        		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
	        			$(".mc-head-request").html(request);
	        			ns_jcatalog_product._load_rel_product(productid);
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","productid is null",productid);
			}
		});
	},
	_search_product:function(){
		/**
		 * Recherche simple dans les titres des catalogues
		 */
		$("#forms-search-catalog").submit(function(){
			$(this).ajaxSubmit({
	    		url:'/admin/catalog.php?get_search_page=true',
	    		type:"post",
	    		dataType:"json",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
	    		},
	    		success:function(j) {
					$('#result-search-page').empty();
					var tablecat = '<table id="table_search_product" class="table-widget-product">'
						+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th>'
						+'<th><span class="lfloat magix-icon magix-icon-h1"></span>Titre</th>'
						+'<th><span class="lfloat ui-icon ui-icon-image"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-person"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-copy"></span></th>'
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
							if(item.imgcatalog != null){
								imgcatalog = '<div class="ui-state-highlight" style="border:none;"><a href="/admin/catalog.php?product&getimg='+item.idcatalog+'"><span style="float:left" class="ui-icon ui-icon-check"></span></a></div>';
							}else{
								imgcatalog = '<div class="ui-state-error" style="border:none;"><a href="/admin/catalog.php?product&getimg='+item.idcatalog+'"><span style="float:left" class="ui-icon ui-icon-cancel"></span></a></div>';
							}
							if(item.iso != null){
								flaglang =item.iso;
							}
							return $('<tr><td>'+item.idcatalog+'</td>'
							+'<td class="medium-cell"><a href="/admin/catalog.php?product&editproduct='+item.idcatalog+'" class="linkurl">'+item.titlecatalog+'</a></td>'
							+'<td class="small-icon">'+imgcatalog+'</td>'
							+'<td class="small-icon">'+flaglang+'</td>'
							+'<td class="small-icon">'+item.pseudo+'</td>'
							+'<td class="small-icon"><a href="/admin/catalog.php?product&moveproduct='+item.idcatalog+'" class="linkurl"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a></td>'
							+'<td class="small-icon"><a href="/admin/catalog.php?product&copyproduct='+item.idcatalog+'" class="linkurl"><span class="lfloat ui-icon ui-icon-copy"></span></a></td>'
							+'<td class="small-icon"><a href="/admin/catalog.php?product&editproduct='+item.idcatalog+'" class="linkurl"><span class="lfloat ui-icon ui-icon-pencil"></span></a></td>'
							+'<td class="small-icon"><a href="#" class="deleteproduct" title="'+item.idcatalog+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
							'</tr>').appendTo('#table_search_product tbody');
						});
					}else{
						return $('<tr>'
								+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'<td class="small-icon"><span class="lfloat ui-icon ui-icon-minus"></span></td>'
								+'</tr>').appendTo('#table_search_product tbody');
					}
	    		}
	    	});
			return false; 
		});
	},
	_copyProduct:function(idproduct){
		/**
		 * Formulaire de copie d'un produit du catalogue
		 */
		var formsproduct = $("#copy-catalog-product").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				titlecatalog: {
					required: true,
					minlength: 2
				},
				desccatalog: {
					required: true
				}
			},
			messages: {
				titlecatalog: {
					required: "Enter a title"
				},
				desccatalog: {
					required: "Enter a content"
				}
			},
			submitHandler: function(form) {
				$.notice({
					ntype: "ajaxsubmit",
		    		dom: form,
		    		uri: '/admin/catalog.php?product&copyproduct='+idproduct+'&postcopyproduct',
		    		typesend: 'post',
		    		delay: 1800,
		    		time:1,
		    		reloadhtml:false	
				});
			}
		});
		$("#copy-catalog-product").formsproduct;
	},
	_moveProduct:function(idproduct){
		/**
		 * Déplacement d'un produit dans une autre langue
		 */
		var formsproduct = $("#move-catalog-product").validate({
			onsubmit: true,
			event: 'submit',
			rules: {
				idclc: {
					required: true
				}
			},
			messages: {
				idclc: {
					required: "select category"
				}
			},
			submitHandler: function(form) {
				$.notice({
					ntype: "ajaxsubmit",
		    		dom: form,
		    		uri: '/admin/catalog.php?product&moveproduct='+idproduct+'&postmoveproduct',
		    		typesend: 'post',
		    		delay: 1800,
		    		time:1,
		    		reloadhtml:false	
				});
			}
		});
		$("#move-catalog-product").formsproduct;
	},
	_google_chart_language:function(){
		$.ajax({
			url: '/admin/catalog.php?json_google_chart_catalog=true',
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
				$('#chart-google-catalog').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				 $('#chart-google-catalog').empty();
				 var optionsObj = {
					title: 'Catalog Statistics',
					series: [{label:'Produits'},{label:'Catégories'},{label:'Sous catégories'}],
					legend: {
						show: true,
						location: 'ne',
						placement: 'outsideGrid'
					},
					seriesColors: [ "#4bb2c5", "#EAA228", "#c5b47f", "#579575", "#839557", "#958c12",
					                "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],
					seriesDefaults:{
						min: 1,
						shadow: true,
						renderer:$.jqplot.BarRenderer,
						rendererOptions:{
			 	           barPadding: 8,
				           barMargin: 10,
				           fillToZero: true,
				           barWidth: 25
				       }
					},
					axesDefaults: {
				        tickOptions: {
				          fontFamily: 'Georgia',
				          fontSize: '10pt'
				        }
				    },
					axes: {
			            // Use a category axis on the x axis and use our custom ticks.
			            xaxis: {
			                renderer: $.jqplot.CategoryAxisRenderer,
			                ticks: j.lang
			            },
			            // Pad the y axis just a little so bars can get close to, but
			            // not touch, the grid boundaries.  1.2 is the default padding.
			            yaxis: {
			                //pad: 1.2
			            }
					}
				};
				 $.jqplot('chart-google-catalog', [j.catalog_count,j.catalog_category_count,j.catalog_subcategory_count], optionsObj);
			}
		});		
	},
	run:function(){
		this._deleteProduct();
		this._search_product();
		this._google_chart_language();
	},
	runAdd:function(){
		this._addCatalogCardProduct();
	},
	runEdit:function(){
		this._load_json_cat_product($("#idcatalog").val());
		this._deleteCatProduct($("#idcatalog").val());
		this._load_rel_product($("#idcatalog").val());
		this._deleteRelProduct($("#idcatalog").val());
		this._editCatalogCardProduct($("#idcatalog").val());
		this._addProduct($("#idcatalog").val());
		this._addRelProduct($("#idcatalog").val());
	},
	runImgEdit:function(){
		this._loadImgProduct($("#idproduct").val());
		this._loadImgMicroGalery($("#idproduct").val());
		this._editImgProduct($("#idproduct").val());
		this._addImgMicroGalery($("#idproduct").val());
		this._deleteMicroGalery($("#idproduct").val());
	},
	runCopy:function(){
		this._copyProduct($("#idproduct").val());
	},
	runMove:function(){
		this._moveProduct($("#idproduct").val());
	}
};