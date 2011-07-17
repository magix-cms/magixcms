tinyMCEPopup.requireLangPack();
function insert_product_catalog_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a title="'+name+'" href="'+href+'">'+name+'</a>');
}
var ProductSearchDialog = {
	init : function() {
		var t = this;
		t._search();
	},
	_search : function(){
		var t = this;
		$("#forms-search-product").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/catalog.php?get_search_product=true',
	    		type:"post",
	    		dataType:"json",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#table_search_product tbody').empty();
	    			$('#table_search_product tbody').html('<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><img src="/framework/img/small_loading.gif" /></td><td>&nbsp;</td><td>&nbsp;</td></tr>');
	    		},
	    		success:function(request) {
	    			t._result(request);
	    		}
	    	});
			return false; 
		});
	},
	_addslashes: function(ch) {
		ch = ch.replace(/\\/g,"\\\\");
		ch = ch.replace(/\'/g,"\\'");
		ch = ch.replace(/\"/g,"\\\"");
		return ch;
	},
	_result :function(j){
		var t = this;
		$('#table_search_product tbody').empty();
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
				if(item.codelang != null){
					flaglang = item.codelang;
				}else{
					flaglang = '-';
				}
				if(item.subcategory != null){
					scategory = item.subcategory;
				}else{
					scategory = '-';
				}
				var titleproduct = t._addslashes(item.titlecatalog);
				//tinyMCEPopup.editor
				//tinyMCEPopup.restoreSelection();
				$('<tr>'
				+'<td>'+item.idproduct+'</td>'
				+'<td>'+flaglang+'</td>'
				+'<td>'+item.titlecatalog+'</td>'
				+'<td>'+item.category+'</td>'
				+'<td>'+scategory+'</td>'
				+'<td><a href="javascript:;" onclick="tinyMCEPopup.close();" onmousedown="insert_product_catalog_link(\''+item.uriproduct+'\',\''+titleproduct+'\');">Insert</a></td>'
				+'</tr>').appendTo('#table_search_product tbody');
			});
		}else{
			$('<tr>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'</tr>').appendTo('#table_search_product tbody');
		}
	},
	insert: function () {
		return null;
	}
};

tinyMCEPopup.onInit.add(ProductSearchDialog.init, ProductSearchDialog);
