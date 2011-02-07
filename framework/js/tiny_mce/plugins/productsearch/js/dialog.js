tinyMCEPopup.requireLangPack();
function insert_product_catalog_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a href="'+href+'">'+name+'</a>');
}
function result_search_product(j){
	$('#result-search-product').empty();
	var tablecat = '<table id="table_search_product" class="clean-table">'
		+'<thead><tr>'
		+'<th></th>'
		+'<th style="width:1%;">ID</th>'
		+'<th>Lang</th>'
		+'<th>Title Catalog</th>'
		+'<th style="width:1%;">Link</th>'
		+'</tr></thead>'
		+'<tbody>';
	tablecat += '</tbody></table>';
	$(tablecat).appendTo('#result-search-product');
	if(j === undefined){
		console.log(j);
	}
	if(j !== null){
		$.each(j, function(i,item) {
			if(item.codelang != null){
				flaglang = item.codelang;
			}else{
				flaglang = '-';
			}
			return $('<tr>'
			+'<td><a href="#" class="open-td" title="'+item.idcatalog+'">Ouvrir</a></td>'
			+'<td>'+item.idcatalog+'</td>'
			+'<td>'+flaglang+'</td>'
			//+'<td>'+cat+'</td>'
			+'<td>'+item.titlecatalog+'</td>'
			//+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="insert_product_catalog_link(\''+item.uricms+'\',\''+item.subjectpage+'\');">Insert</a></td>'
			+'</tr><tr class="hidden-uri-tr"><td colspan=4></td></tr>').appendTo('#table_search_product tbody');
		});
	}else{
		return $('<tr>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'</tr>').appendTo('#table_search_product tbody');
	}
}
function load_ajax_injectlist(idcatalog){
	$.ajax({
		url: '/admin/catalog.php?product_ref_catalog='+idcatalog,
		dataType: 'json',
		type: "get",
		async: true,
		cache:false,
		beforeSend: function(){},
		success: function(j) {
			if(j === undefined){
				console.log(j);
			}
			if(j !== null){
				$.each(j, function(i,item) {
					return $('<span>'+item.uriproduct+'</span>').appendTo("#contains");
				});
			}
		}
	});
}
var ProductSearchDialog = {
	init : function() {
		$('a.open-td').live("click",function(){
			var idcatalog = $(this).attr("title");
			var answer = $(this).parent().parent().next();
	        if (answer.is(":visible")) {
	        load_ajax_injectlist(idcatalog);
	           answer.slideUp();
	        } else {
	           answer.slideDown();
	        }
		});
		$("#forms-search-product").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/catalog.php?get_search_product=true',
	    		type:"post",
	    		dataType:"json",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#result-search-product').html('<img src="/framework/img/small_loading.gif" />');
	    		},
	    		success:function(request) {
	    			result_search_product(request);
	    		}
	    	});
			return false; 
		});
	},

	insert : function() {
		
	}
};

tinyMCEPopup.onInit.add(ProductSearchDialog.init, ProductSearchDialog);
