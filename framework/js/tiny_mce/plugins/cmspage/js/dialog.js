tinyMCEPopup.requireLangPack();
function insert_cms_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a href="'+href+'">'+name+'</a>');
}
function result_search_page(j){
	$('#result-search-page').empty();
	var tablecat = '<table id="table_search_product" class="clean-table">'
		+'<thead><tr>'
		+'<th style="width:1%;">ID</th>'
		+'<th style="width:16px;">Lang</th>'
		+'<th>Category</th>'
		+'<th>Subject</th>'
		+'<th style="width:1%;">Link</th>'
		+'</tr></thead>'
		+'<tbody>';
	tablecat += '</tbody></table>';
	$(tablecat).appendTo('#result-search-page');
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
			if(item.category != null){
				cat = item.category;
			}else{
				cat = '-';
			}
			return $('<tr><td>'+item.idpage+'</td>'
			+'<td>'+flaglang+'</td>'
			+'<td>'+cat+'</td>'
			+'<td>'+item.subjectpage+'</td>'
			+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="insert_cms_link(\''+item.uricms+'\',\''+item.subjectpage+'\');" class="link-cms-page">Insert</a></td>'
			+'</tr>').appendTo('#table_search_product tbody');
		});
	}else{
		return $('<tr>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'<td>-</td>'
				+'</tr>').appendTo('#table_search_product tbody');
	}
}
var CMSPageDialog = {
	init : function() {
		$("#forms-search-page").submit(function(){
			$(this).ajaxSubmit({
	    		url:'/admin/cms.php?get_search_page=true',
	    		type:"post",
	    		dataType:"json",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#result-search-page').html('<img src="/framework/img/small_loading.gif" />');
	    		},
	    		success:function(request) {
	    			result_search_page(request);
	    		}
	    	});
			return false; 
		});
	},

	insert : function() {
		
	}
};

tinyMCEPopup.onInit.add(CMSPageDialog.init, CMSPageDialog);
