tinyMCEPopup.requireLangPack();
function insert_cms_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a title="'+name+'" href="'+href+'">'+name+'</a>');
}
var CMSPageDialog = {
	init : function() {
		var t = this;
		t._search();
	},
	_search: function(){
		var t = this;
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
		$('#table_search_cmspage tbody').empty();
		if(j === undefined){
			console.log(j);
		}
		if(j !== null){
			$.each(j, function(i,item) {
				if(item.iso != null){
					flaglang = item.iso;
				}else{
					flaglang = '-';
				}
				if(item.uri_category != null){
					cat = item.uri_category;
				}else{
					cat = '-';
				}
				var titlepage = t._addslashes(item.title_page);
				//var insertLink = insert_cms_link(item.uricms,item.title_page);
				return $('<tr><td>'+item.idpage+'</td>'
				+'<td>'+flaglang+'</td>'
				+'<td>'+cat+'</td>'
				+'<td>'+item.title_page+'</td>'
				+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="insert_cms_link(\''+item.uricms+'\',\''+titlepage+'\');" class="link-cms-page">Insert</a></td>'
				//+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="'+insertLink+'" class="link-cms-page">Insert</a></td>'
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
	},
	insert : function() {
		return null;
	}
};

tinyMCEPopup.onInit.add(CMSPageDialog.init, CMSPageDialog);