var ns_jnews = {
	_addNews:function(){
		$("#forms-news").submit(function(){
	    	$.editorhtml({editor:_editorConfig});
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/news.php?add&post=1',
	    		typesend: 'post',
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
	},
	_editNews:function(){
		$("#forms-news").submit(function(){
	    	$.editorhtml({editor:_editorConfig});
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/news.php?add&post=1',
	    		typesend: 'post',
	    		resetform:true,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
	},
	_load_page_uri:function(idnews){
		$.ajax({
			url: '/admin/news.php?edit='+idnews+'&load_json_uri_news=true',
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
				$("#newsurl").css({"display":"none"}).val('');
				$('<span class="min-loader"><img src="/framework/img/small_loading.gif" /></span>').insertAfter('#newsurl');
			},
			success: function(j) {
				$('.min-loader').remove();
				var uri = j.newsuri;
				$("#newsurl").css({"display":"block"});
				$("#newsurl").val(uri);
				$(".post-preview").attr({
					href:uri
				});
			}
		});
	},
	_publishedNews:function(){
		$('.u-news-published').live("click",function (event){
			event.preventDefault();
			var uri_news_publish = $(this).attr("href");
			$("#confirm_published").dialog({
				resizable: false,
				height:140,
				width:320,
				modal: true,
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'En ligne': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: uri_news_publish+'&status_news=1',
							async: false,
							success:function(e){
								location.reload();
							}
					     });
						return false;
					},
					'Hors ligne': function() {
						$(this).dialog('close');
						$.ajax({
							type:'get',
							url: uri_news_publish+'&status_news=0',
							async: false,
							success:function(e){
								location.reload();
							}
					     });
						return false;
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	_deleteNews:function(){
		/**
	     * Requête ajax pour la suppression des articles ou news
	     */
	    $('.deletenews').click(function (e){
	    	e.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Suppression d\'un article',
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Delete News': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: "/admin/news.php",
							data: "delnews="+lg,
							async: false,
							cache:false,
							success: function(){
								//location.reload();
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
	},
	run:function(){
		this._publishedNews();
	},
	runAddNews:function(){
		this._addNews();
	},
	runEditNews:function(){
		$('#n_uri').inputLock();
		this._load_page_uri($("#idnews").val());
		this._editNews();
	}
};