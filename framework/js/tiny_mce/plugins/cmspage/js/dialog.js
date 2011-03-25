tinyMCEPopup.requireLangPack();
function insert_cms_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a title="'+name+'" href="'+href+'">'+name+'</a>');
}
function result_search_page(j){
	$('#table_search_cmspage tbody').empty();
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
			var insertLink = insert_cms_link(item.uricms,item.subjectpage);
			return $('<tr><td>'+item.idpage+'</td>'
			+'<td>'+flaglang+'</td>'
			+'<td>'+cat+'</td>'
			+'<td>'+item.subjectpage+'</td>'
			//+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="insert_cms_link(\''+item.uricms+'\',\''+item.subjectpage+'\');" class="link-cms-page">Insert</a></td>'
			+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="'+insertLink+'" class="link-cms-page">Insert</a></td>'
			+'</tr>').appendTo('#table_search_cmspage tbody');
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
	    			$('#table_search_cmspage tbody').empty();
	    			$('#table_search_cmspage tbody').html('<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><img src="/framework/img/small_loading.gif" /></td><td>&nbsp;</td></tr>');
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
