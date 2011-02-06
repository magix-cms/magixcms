/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name dashboard.1.0.0.js
 *
 */
/**
 * Requête pour charger la version du CMS courant comparativement à la dernière version
 */
$(function(){
	var ie = ($.browser.msie);
	if(ie){
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
			async: false,
			beforeSend :function(){
				$('#version').html('<img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" />');
			},
			success: function(e) {
				$('#version').html(e);
			}
		});
	}
	/**
     * Requête ajax pour la suppression des pages d'accueil
     */
    $('.deletehome').click(function (e){
    	e.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			title: 'Suppression d\'une page d\'accueil',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete Home Page': function() {
					$(this).dialog('close');
					$.ajax({
						type:'get',
						url: "/admin/home.php?delhome="+lg,
						async: false,
						cache: false,
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
	/**
     * Requête ajax pour la suppression des pages CMS
     */
	$('.deletecms').live("click",function (e){
		e.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			title: 'Supprimé cette page',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.ajax({
						type:'get',
						url: "/admin/cms.php?delpage="+lg,
						async: false,
						cache:false,
						success: function(){
							location.reload();
						}
				     });
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
	/**
     * Requête ajax pour la suppression des produits
     */
	$('.deleteproduct').live("click",function (event){
		event.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:180,
			modal: true,
			title: 'Supprimé ce produit',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
			    		uri:  "/admin/catalog.php?product&delproduct="+lg,
			    		typesend: 'get',
			    		delay: 1800,
			    		time:1,
			    		reloadhtml:true
					});
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
});