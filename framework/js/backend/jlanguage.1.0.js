/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jlanguage.1.0.js
 *
 */
$(function(){
	/*################## Langues ##############*/
	/**
	 * Ajoute une nouvelle langue
	 */
    $("#forms-lang").submit(function(){
		$.notice({
			ntype: "ajaxsubmit",
    		delay: 2800,
    		dom: this,
    		uri: '/admin/lang.php?add',
    		typesend: 'post',
    		resetform:true,
    		time:2,
    		reloadhtml:true	
		});
		return false; 
	});
    /**
     * Edition des langues dans une modalbox
     */
    $('.edit-lang').live("click",function(e){
    	e.preventDefault();
		var idlang = $(this).attr('title');
		var url = '/admin/lang.php?ulang='+idlang;
		$("#update-lang").load(url, function() {
			$(this).dialog({
				bgiframe: true,
				minHeight: 100,
				width:320,
				modal: true,
				overlay: {
					backgroundColor: '#000',
					opacity: 0.5
				},
				buttons: {
					'Save': function() {
						$(this).dialog('close');
						$.notice({
							ntype: "ajax",
				    		uri:  url+"&post",
				    		typesend: 'post',
				    		noticedata: "ucodelang="+$('#ucodelang').val()+"&udesclang="+$('#udesclang').val(),
				    		time:2,
				    		reloadhtml:true
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
    /**
     * Requête ajax pour la suppression des langues
     */
    $('.dellang').click(function(e){
    	e.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:200,
			modal: true,
			title: 'Supprimé cette langue',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
			    		uri:  "/admin/lang.php?dellang="+lg,
			    		typesend: 'post',
			    		time:2,
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