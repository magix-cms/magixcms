var ns_jnews = {
	_addNews:function(){
		$("#forms-news-add").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/news.php?add=true',
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
	_editNews:function(idnews){
		$("#forms-news-update").submit(function(){
			//$.editorhtml({editor:_editorConfig});
			$(this).ajaxSubmit({
	    		url: '/admin/news.php?edit='+idnews,
	    		type:"post",
	    		resetForm: true,
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			ns_jnews._load_page_uri(idnews);
	    			$(".mc-head-request").html(request);
	    		}
	    	});
			return false;
		});
	},
	_editImage:function(idnews){
		$("#forms-news-image-update").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/news.php?edit='+idnews+'&post=1',
	    		type:"post",
	    		resetForm: true,
	    		success:function(request) {
	    			$('#n_image:file').val('');
	    			/*$.notice({
						ntype: "simple",
						time:2
					});*/
	    			ns_jnews._LoadImageNews(idnews);
	    			//$(".mc-head-request").html(request);
	    		}
	    	});
			return false;
		});
	},
	_LoadImageNews:function(idnews){
		/**
		 * Requete get pour charger l'image du profil
		 */
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
			url: '/admin/news.php?edit='+idnews+'&imgnews=true',
			async: true,
			cache:false,
			beforeSend: function(){
				$('#load_news_img').html('<img style="margin-top:40%;" class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(e){
				$('#load_news_img').html(e);
			}
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
				buttons: {
					'En ligne': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: uri_news_publish,
							data: 'status_news=1',
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
							type:'post',
							url: uri_news_publish,
							data: 'status_news=0',
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
	runEditNews:function(idnews){
		$('#n_uri').inputLock();
		this._load_page_uri(idnews);
		this._editNews(idnews);
		this._editImage(idnews);
		this._LoadImageNews(idnews);
	}
};