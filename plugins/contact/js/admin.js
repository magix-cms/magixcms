/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name adminjs
 * @package plugins
 * @addon contact
 *
 */
$(function() {
	 /**
     * Requête ajax pour l'ajout des contacts
     */
	 $("#forms-plugins-contact").submit(function(){
		$.nicenotify({
			ntype: "submit",
			uri: '/admin/plugins.php?name=contact&add',
			typesend: 'post',
			idforms: $(this),
			beforeParams:function(){},
			successParams:function(e){
				$.nicenotify.initbox(e,{
					//display:false,
					reloadhtml:true
				});
			}
		});
		return false; 
	});
	 /**
     * Requête ajax pour la suppression des contacts
     */
	$('.d-plugins-contact').click(function (event){
		event.preventDefault();
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			title: 'Supprimé ce contact',
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.nicenotify({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=contact&dcontact="+lg,
						typesend: 'get',
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
});