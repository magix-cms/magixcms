/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jdashboard
 * @update 08/10/2011 21:40
 */
var ns_jdashboard = {
	init:function(){},
	_version:function(){
		/*if($.ieTester()){
			$('#version').ajaxStart(function(){
				$(this).append('<img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" />');
			});
			 $("#version").ajaxError(function(){
			   $(this).append("<strong>Error requesting page</strong>");
			 });
			 $.get('/admin/version.php', function(e) {
				$('#version').html(e);
			});
		}else{
			$.ajax({
				type:'get',
				url: '/admin/version.php',
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
				async: false,
				beforeSend :function(){
					$('#version').html('<span class="min-loader"><img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" /></span>');
				},
				success: function(e) {
					$('.min-loader').remove();
					$('#version').html(e);
				}
			});
		}*/
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/version.php',
			typesend: 'get',
			beforeParams:function(){
				$('#version').html('<span class="min-loader"><img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" /></span>');
			},
			successParams:function(e){
				$('.min-loader').remove();
				$('#version').html(e);
				$.nicenotify.initbox(e,{
					display:false
				});
			}
		});
	},
	_deleteHome:function(){
		/**
	     * Requête ajax pour la suppression des pages d'accueil
	     */
	    $('.deletehome').live('click',function (e){
	    	e.preventDefault();
			var idhome = $(this).attr("rel");
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Delete': function() {
						$(this).dialog('close');
						/*$.ajax({
							type:'post',
							url: "/admin/home.php",
							data : 'del_home='+idhome,
							async: false,
							cache: false,
							success: function(){
								location.reload();
							}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/home.php',
							typesend: 'post',
							noticedata: 'del_home='+idhome,
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
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
	_deleteNews:function(){
		/**
	     * Requête ajax pour la suppression des articles ou news
	     */
	    $('.deletenews').click(function (e){
	    	e.preventDefault();
			var lg = $(this).attr("rel");
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				title: 'Suppression d\'un article',
				buttons: {
					'Delete News': function() {
						$(this).dialog('close');
						/*$.ajax({
							type:'post',
							url: "/admin/news.php",
							data: "delnews="+lg,
							async: false,
							cache:false,
							success: function(){
								location.reload();
							}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/news.php',
							typesend: 'post',
							noticedata: 'delnews='+lg,
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
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
						/*$.ajax({
							type:'post',
							url: uri_news_publish,
							data: 'status_news=1',
							async: false,
							success:function(e){
								location.reload();
							}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: uri_news_publish,
							typesend: 'post',
							noticedata: 'status_news=1',
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
							}
						});
						//return false;
					},
					'Hors ligne': function() {
						$(this).dialog('close');
						/*$.ajax({
							type:'post',
							url: uri_news_publish,
							data: 'status_news=0',
							async: false,
							success:function(e){
								location.reload();
							}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: uri_news_publish,
							typesend: 'post',
							noticedata: 'status_news=0',
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
							}
						});
						//return false;
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	_deletePage:function(){
		/**
	     * Requête ajax pour la suppression des pages CMS
	     */
		$('.delpage').live("click",function (e){
			e.preventDefault();
			var idpage = $(this).attr("rel");
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Delete': function() {
						$(this).dialog('close');
						/*$.ajax({
							type:'post',
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
							url: '/admin/cms.php',
							data: 'delpage='+idpage,
							async: false,
							cache:false,
							success: function(request){
								location.reload();
							}
					     });*/
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/cms.php',
							typesend: 'post',
							noticedata: 'delpage='+idpage,
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
							}
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	_deleteProduct:function(){
		/**
	     * Requête ajax pour la suppression des produits
	     */
		$('.deleteproduct').live("click",function (event){
			event.preventDefault();
			var lg = $(this).attr("title");
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				minHeight:180,
				modal: true,
				title: 'Supprimé ce produit',
				buttons: {
					'Delete item': function() {
						$(this).dialog('close');
						/*$.notice({
							ntype: "ajax",
				    		uri:  "/admin/catalog.php?product&delproduct="+lg,
				    		typesend: 'get',
				    		delay: 1800,
				    		time:1,
				    		reloadhtml:true
						});*/
						$.nicenotify({
							ntype: "ajax",
							uri: "/admin/catalog.php?product=true",
							typesend: 'post',
							noticedata: 'delproduct='+lg,
							beforeParams:function(){},
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false,
									reloadhtml:true
								});
							}
						});
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	deleteElem:function(){
		this._deleteHome();
		this._deleteNews();
		this._deletePage();
		this._deleteProduct();
	},
	run:function(){
		this._version();
		this._publishedNews();
		this.deleteElem();
	}
};