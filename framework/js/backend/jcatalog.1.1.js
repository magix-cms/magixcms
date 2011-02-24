/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jcatalog.1.1.js
 *
 */
function load_category(){
	$.ajax({
		url: '/admin/catalog.php?category=true&json_cat=true',
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
					if(item.codelang != null){
						langspan = '<span class="lfloat">'+item.codelang+'</span>';
					}else{
						langspan = '<span class="lfloat ui-icon ui-icon-flag"></span>';
					}
					return $('<li class="ui-state-default" id="corder_'+item.idclc+'">'
					+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.clibelle
					+'<div style="float:right">'+langspan
					+'<a href="/admin/catalog.php?upcat='+item.idclc+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
					+'<a href="#" class="aspanfloat delc" title="'+item.idclc+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a>'+
					'</li>').appendTo('#sortcat');
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
}
function load_subcategory(){
	var upcat = $("#ucategory").val();
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
					return $('<li class="ui-state-default" id="sorder_'+item.idcls+'">'
					+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.slibelle
					+'<div style="float:right">'
					+'<a href="/admin/catalog.php?upsubcat='+item.idcls+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
					+'<a href="#" class="aspanfloat dels" title="'+item.idcls+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a>'+
					'</li>').appendTo('#sortsubcat');
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
}
function load_cat_product(){
	var idcatalog = $("#idcatalog").val();
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
}
function load_rel_product(){
	var idcatalog = $("#idcatalog").val();
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
				return $('<tr><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td><td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td><td class="medium-cell"><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td></tr>').appendTo('#table_rel_product tbody');
			}
		}
	});
}
function result_search_product(j){
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
			if(item.codelang != null){
				flaglang = '<div class="ui-state-error" style="border:none;">'+item.codelang+'</div>';
			}else{
				flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
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
function load_img_category_catalog(){
	var ucategory = $("#ucategory").val();
	$.ajax({
		url: '/admin/catalog.php?upcat='+ucategory+'&imgcat=1',
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
}
function load_img_subcategory_catalog(){
	var usubcategory = $("#usubcategory").val();
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
}
function load_img_product_catalog(){
	var idproduct = $("#idproduct").text();
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
}
function load_micro_galery_catalog(){
	var idproduct = $("#idproduct").text();
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
			var listimg = '<div id="list-image-galery">';
			listimg += '</div>';
			$(listimg).appendTo('#contener_micro_galery');
			if(j === undefined){
				console.log(j);
			}
			if(j !== null){
				$.each(j, function(i,item) {
					return $('<div class="list-img ui-widget-content">'
					+'<div class="title-galery-image ui-state-default">'
					+'<a href="#" class="delmicro" title="'+item.idmicro+'"><span style="float:right;" class="ui-icon ui-icon-trash"></span></a>'
					+'</div>'
					+'<div class="img-galery"><img src="/upload/catalogimg/galery/mini/'+item.imgcatalog+'" /></div></div>'
					).appendTo('#list-image-galery');
				});
			}
			$('.delmicro').hover(
				function() { 
					$(this).parent().addClass('ui-state-hover'); 
				},
				function() { 
					$(this).parent().removeClass('ui-state-hover'); 
				}
			);
		}
	});
}
$(function(){
	/*################## Catalog ##############*/
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
    			$.notice({
					ntype: "simple",
					time:2
				});
    			$(".mc-head-request").html(request);
    			load_category();
    		}
    	});
		return false;
	});
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
    			load_subcategory();
    		}
    	});
		return false;
	});
	/**
	 * Soumission ajax d'un produit dans le catalogue
	 */
	$("#forms-catalog-card-product").submit(function(){
		/*tinyMCE.triggerSave(true,true);*/
		$.editorhtml({editor:_editorConfig});
		$(this).ajaxSubmit({
    		url:'/admin/catalog.php?product&add_card_product=1',
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
	/**
	 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
	 */
	$("#forms-catalog-card-product-edit").submit(function(){
		var productid = $('#idcatalog').val();
		if(productid != null){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 1800,
	    		dom: this,
	    		uri: '/admin/catalog.php?product&editproduct='+productid+'&updateproduct=1',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:false,
	    		time:1,
	    		reloadhtml:false	
			});
			return false; 
		}else{
			console.log("%s: %o","productid is null",productid);
		}
	});
	/**
	 * Soumission ajax d'une mise à jour d'un produit dans le catalogue
	 */
	$("#forms-catalog-product").submit(function(){
		var productid = $('#idcatalog').val();
		if(productid != null){
			$(this).ajaxSubmit({
        		url:'/admin/catalog.php?product&editproduct='+productid+'&add_product=1',
        		type:"post",
        		resetForm: false,
        		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
        			$(".mc-head-request").html(request);
        			load_cat_product();
        		}
        	});
			return false; 
		}else{
			console.log("%s: %o","productid is null",productid);
		}
	});
	$("#forms-catalog-rel-product").submit(function(){
		var productid = $('#idcatalog').val();
		if(productid != null){
			$(this).ajaxSubmit({
        		url:'/admin/catalog.php?product&editproduct='+productid+'&post_rel_product=1',
        		type:"post",
        		resetForm: false,
        		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
        			$(".mc-head-request").html(request);
        			load_rel_product();
        		}
        	});
			return false; 
		}else{
			console.log("%s: %o","productid is null",productid);
		}
	});
	/**
	 * Mise à jour d'une catégorie
	 */
	$("#forms-catalog-editcategory").submit(function(){
		var idcategory = $('#ucategory').val();
		var url = '/admin/catalog.php?catalog&upcat='+idcategory;
		$.notice({
			ntype: "ajaxsubmit",
    		dom: this,
    		uri:  url+"&post",
    		typesend: 'post',
    		delay: 2800,
    		time:2,
    		reloadhtml:false,
    		resetform:false
		});
		return false; 
	});
	$("#forms-catalog-editcategory-img").submit(function(){
		var idcategory = $('#ucategory').val();
		var urleditcat = '/admin/catalog.php?upcat='+idcategory;
		$(this).ajaxSubmit({
    		url: urleditcat+"&postimg",
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
    			load_img_category_catalog();
    		}
    	});
		return false; 
	});
	/**
	 * Mise à jour d'une sous catégorie
	 */
	$("#forms-catalog-editsubcategory").submit(function(){
		var idsubcategory = $('#usubcategory').val();
		var urleditsubcat = '/admin/catalog.php?upsubcat='+idsubcategory;
		$.notice({
			ntype: "ajaxsubmit",
    		dom: this,
    		uri:  urleditsubcat+"&post",
    		typesend: 'post',
    		delay: 2800,
    		time:2,
    		reloadhtml:false,
    		resetform:false
		});
		return false;
	});
	/**
	 * Edition d'une image de sous catégorie
	 */
	$("#forms-catalog-editsubcategory-img").submit(function(){
		var idsubcategory = $('#usubcategory').val();
		var urleditsubcat = '/admin/catalog.php?upsubcat='+idsubcategory;
		$(this).ajaxSubmit({
    		url: urleditsubcat+"&postimg",
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
    			load_img_subcategory_catalog();
    		}
    	});
		return false; 
	});
	/**
	 * Affiche la popup des liens du produit
	 */
	$('.cat-uri-product').live("click",function(event){
		event.preventDefault();
		var idproducturi = $(this).attr('title');
		var url = '/admin/catalog.php?geturicat='+idproducturi;
		$("#window-box").load(url, function() {
			$(this).dialog({
				bgiframe: false,
				minHeight: 150,
				minWidth: 400,
				modal: true,
				title: 'Copier un lien',
				closeOnEscape: true,
				position:"center",
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
		});
	});
	/**
	 * Affiche la popup des produits de liaison
	 */
	$('.rel-uri-product').live("click",function(event){
		event.preventDefault();
		var idproducturi = $(this).attr('title');
		var url = '/admin/catalog.php?getreluri='+idproducturi;
		$("#window-box").load(url, function() {
			$(this).dialog({
				bgiframe: false,
				minHeight: 150,
				minWidth: 400,
				modal: true,
				title: 'Copier un lien de produit de liaison',
				closeOnEscape: true,
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
		});
	});
    /**
     * Ajout d'une class au survol d'une catégorie
     */
    $('#sortproduct li,#sortcat li,#sortsubcat li').hover(
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
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
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
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
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
	/**
	 * Supprime une création de produit dans une catégorie/ou sous catégorie
	 */
	$('.d-in-product').live("click",function (event){
		event.preventDefault();
		var inproduct = $(this).attr("title");
		var productid = $('#idcatalog').val();
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:180,
			modal: true,
			title: 'Supprimé ce produit ?',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.ajax({
						url: "/admin/catalog.php?product&editproduct="+productid+"&d_in_product="+inproduct,
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
							load_cat_product();
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
	 * Supprime une liaison de produit avec une fiche catalogue
	 */
	$('.d-rel-product').live("click",function (event){
		event.preventDefault();
		var relproduct = $(this).attr("title");
		var productid = $('#idcatalog').val();
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:180,
			modal: true,
			title: 'Supprimé une liaison avec ce produit ?',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
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
							load_rel_product();
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
			var getcatalog = $("#idproduct").val();
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: form,
	    		uri: '/admin/catalog.php?product&copyproduct='+getcatalog+'&postcopyproduct',
	    		typesend: 'post',
	    		delay: 1800,
	    		time:1,
	    		reloadhtml:false	
			});
		}
	});
	$("#copy-catalog-product").formsproduct;
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
			var getcatalog = $("#idproduct").val();
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: form,
	    		uri: '/admin/catalog.php?product&moveproduct='+getcatalog+'&postmoveproduct',
	    		typesend: 'post',
	    		delay: 1800,
	    		time:1,
	    		reloadhtml:false	
			});
		}
	});
	$("#move-catalog-product").formsproduct;
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
    		success:function(request) {
    			result_search_product(request);
    		}
    	});
		return false; 
	});
	var valphoto = $("#forms-catalog-image").validate({
	 	rules: {
		imgcatalog: {
	 			required: true,
	 			minlength: 1,
	 			accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
	 		}
	 	},
	 	submitHandler: function(form) {
	 		var idcatalog = $("#idproduct").text();
		 	$(form).ajaxSubmit({
			 	url:'/admin/catalog.php?product&getimg='+idcatalog+'&postimgproduct=1',
			 	type:"post",
			 	resetForm: true,
			 	beforeSubmit:function(){
			 		$('#contener_image_product,#contener_image_medium,#contener_image_mini').html('<img src="/framework/img/square-circle.gif" />');
			 	},
			 	success:function(request){
			 		/*$.notice({
						ntype: "simple",
			    		time:2
					});
					$(".mc-head-request").html(request);*/
			 		load_img_product_catalog();
			 	}
			});
		 	return false;
	 	}
	 });
	var valgalery = $("#forms-catalog-galery").validate({
	 	rules: {
	 		imggalery: {
	 			required: true,
	 			minlength: 1,
	 			accept: "(jpe?g|gif|png|JPE?G|GIF|PNG)"
	 		}
	 	},
	 	submitHandler: function(form) {
	 		var idcatalog = $("#idproduct").text();
		 	$(form).ajaxSubmit({
			 	url:'/admin/catalog.php?product&getimg='+idcatalog+'&postimggalery=1',
			 	type:"post",
			 	beforeSubmit:function(){
			 		$('#contener_micro_galery').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			 	},
			 	success:function(e){
			 		load_micro_galery_catalog();
			 	}
			});
	 	}
	 });
	$('.delmicro').live("click",function(event){
		event.preventDefault();
		var idcatalog = $("#idproduct").text();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:180,
			modal: true,
			title: 'Supprimé cette image de la galerie',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
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
						url: '/admin/catalog.php?product&getimg='+idcatalog+'&delmicro='+lg,
						async: false,
						success:function(request) {
							$.notice({
								ntype: "simple",
								time:2
							});
	        				$(".mc-head-request").html(request);
	        				load_micro_galery_catalog();
						}
				     });
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
	$("#forms-catalog-image").valphoto;
	$("#forms-catalog-galery").valgalery;
});