/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jnews.1.0.js
 *
 */
$(function(){
	/*################## article / news #################*/
    $("#forms-news").submit(function(){
		/*tinyMCE.triggerSave(true,true);*/
    	$.editorhtml({editor:_editorConfig});
		$(this).ajaxSubmit({
    		url:'/admin/news.php?add&post',
    		type:"post",
    		resetForm: true,
    		success:function(request) {
				$.notice({
					ntype: "simple",
					time:2
				});
    			$(".mc-head-request").html(request);
    				setTimeout(function(){
    					location.reload();
    				},2800);
    		}
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
        				setTimeout(function(){
        					location.reload();
        				},2800);
        		}
        	});
			return false; 
		}else{
			console.log("%s: %o","newsid is null",newsid);
		}
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