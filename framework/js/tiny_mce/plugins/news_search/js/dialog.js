tinyMCEPopup.requireLangPack();
function insert_news_link(href,name){
	tinyMCE.execCommand('mceInsertContent',false,'<a title="'+name+'" href="'+href+'">'+name+'</a>');
}
var newsDialog = {
	init : function() {
		var t = this;
		t._search();
	},
	_search: function(){
		var t = this;
		$("#forms-search-news").submit(function(){
			$(this).ajaxSubmit({
	    		url:'/admin/news.php?get_search_news=true',
	    		type:"post",
	    		dataType:"json",
	    		resetForm: true,
	    		beforeSubmit:function(){
	    			$('#table_search_news tbody').empty();
	    			$('#table_search_news tbody').html('<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><img src="/framework/img/small_loading.gif" /></td><td>&nbsp;</td></tr>');
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
		$('#table_search_news tbody').empty();
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
				var titlepage = t._addslashes(item.n_title);
				return $('<tr><td>'+item.idnews+'</td>'
				+'<td>'+flaglang+'</td>'
				+'<td>'+item.date_register+'</td>'
				+'<td>'+item.n_title+'</td>'
				+'<td><a href="#" onclick="tinyMCEPopup.close();" onmousedown="insert_news_link(\''+item.urinews+'\',\''+titlepage+'\');" class="link-news">Insert</a></td>'
				+'</tr>').appendTo('#table_search_news tbody');
			});
		}else{
			return $('<tr>'
					+'<td>-</td>'
					+'<td>-</td>'
					+'<td>-</td>'
					+'<td>-</td>'
					+'<td>-</td>'
					+'</tr>').appendTo('#table_search_news tbody');
		}
	},
	insert : function() {
		return null;
	}
};

tinyMCEPopup.onInit.add(newsDialog.init, newsDialog);
