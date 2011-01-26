function load_cat_product(){
	var idcatalog = $("#idcatalog").val();
	$.ajax({
		url: '/admin/catalog.php?product&editproduct='+idcatalog+'&json_cat_product=true',
		dataType: 'json',
		type: "get",
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
				return $('<tr><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td><td><span class="lfloat ui-icon ui-icon-minus"></span></td></tr>').appendTo('#table_cat_product tbody');
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
$(function(){
	/*################## Catalog ##############*/
    /**
	 * Soumission d'une nouvelle catégorie dans le catalogue
	 */
	$("#forms-catalog-category").submit(function(){
		$.notice({
			ntype: "ajaxsubmit",
    		delay: 2800,
    		dom: this,
    		uri: '/admin/catalog.php?category&post',
    		typesend: 'post',
    		noticedata: null,
    		resetform:true,
    		time:2,
    		reloadhtml:true	
		});
		return false; 
	});
	/**
	 * Soumission d'une nouvelle sous catégorie dans le catalogue
	 */
	$("#forms-catalog-subcategory").submit(function(){
		$.notice({
			ntype: "ajaxsubmit",
    		delay: 2800,
    		dom: this,
    		uri: '/admin/catalog.php?category&post',
    		typesend: 'post',
    		noticedata: null,
    		resetform:true,
    		time:2,
    		reloadhtml:true	
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
    		url:'/admin/catalog.php?product&add_card_product',
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
	    		uri: '/admin/catalog.php?product&editproduct='+productid+'&updateproduct',
	    		typesend: 'post',
	    		noticedata: null,
	    		resetform:false,
	    		time:1,
	    		reloadhtml:true	
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
        		url:'/admin/catalog.php?product&editproduct='+productid+'&add_product',
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
        		url:'/admin/catalog.php?product&editproduct='+productid+'&post_rel_product',
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
		var url = '/admin/catalog.php?catalog&upcat='+idcategory;
		$.notice({
			ntype: "ajaxsubmit",
    		dom: this,
    		uri:  url+"&postimg",
    		typesend: 'post',
    		delay: 2800,
    		time:2,
    		reloadhtml:true,
    		resetform:true
		});
		return false; 
	});
	/**
	 * Mise à jour d'une sous catégorie
	 */
	$("#forms-catalog-editsubcategory").submit(function(){
		var idsubcategory = $('#usubcategory').val();
		var url = '/admin/catalog.php?upsubcat='+idsubcategory;
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
	/**
	 * Edition d'une image de sous catégorie
	 */
	$("#forms-catalog-editsubcategory-img").submit(function(){
		var idsubcategory = $('#usubcategory').val();
		var url = '/admin/catalog.php?upsubcat='+idsubcategory;
		$.notice({
			ntype: "ajaxsubmit",
    		dom: this,
    		uri:  url+"&postimg",
    		typesend: 'post',
    		delay: 2800,
    		time:2,
    		reloadhtml:false,
    		resetform:false
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
     * Initialisation du drag and drop pour les catégories (catalogue ou cms)
     * Requête ajax pour l'enregistrement du déplacement
     */
	$("#sortcat").sortable({
		placeholder: 'ui-state-highlight',
		dropOnEmpty: false,
		axis: "y",
		cursor: "move",
		update : function () {
			serial = $('#sortcat').sortable('serialize');
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
     * Initialisation du drag and drop pour les sous catégories (catalogue uniquement)
     * Requête ajax pour l'enregistrement du déplacement
     */
	$("#sortsubcat").sortable({
		placeholder: 'ui-state-highlight',
		dropOnEmpty: false,
		axis: "y",
		cursor: "move",
		update : function () {
			serial = $('#sortsubcat').sortable('serialize');
			$.ajax({
				url: "/admin/catalog.php?order",
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
	$('.deleteproduct').click(function (e){
		e.preventDefault();
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
	$('.delc').click(function(e){
		e.preventDefault();
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
	$('.dels').click(function (e){
		e.preventDefault();
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
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
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
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
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
    		resetForm: true,
    		success:function(request) {
    			$("#result-search-page").html(request);
    		}
    	});
		return false; 
	});
});