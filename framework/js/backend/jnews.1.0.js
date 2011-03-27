/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jnews.1.2.js
 *
 */
function create_dynamic_news_uri(){
	var newsid = $("#idnews").val();
	$.ajax({
		url: '/admin/news.php?edit='+newsid+'&load_json_uri_news=true',
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
}
$(function(){
	/*################## article / news #################*/
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
    /**
	 * Soumission ajax d'une mise à jour d'une news ou article
	 */
	$("#forms-news-update").submit(function(){
		var newsid = $('#idnews').val();
		if(newsid != null){
			/*tinyMCE.triggerSave(true,true);*/
			$.editorhtml({editor:_editorConfig});
			$(this).ajaxSubmit({
        		url:'/admin/news.php?edit='+newsid+'&post',
        		type:"post",
        		resetForm: false,
        		success:function(request) {
					$.notice({
						ntype: "simple",
						time:2
					});
        			$(".mc-head-request").html(request);
        			create_dynamic_news_uri();
        		}
        	});
			return false; 
		}else{
			console.log("%s: %o","newsid is null",newsid);
		}
	});
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
						type:'get',
						url: "/admin/news.php?delnews="+lg,
						async: false,
						cache:false,
						success: function(){
							location.reload();
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
});