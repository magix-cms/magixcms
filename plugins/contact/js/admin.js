/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
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
	var formsAddContact = $("#forms-plugins-contact").validate({
		onsubmit: true,
		event: 'submit',
		rules: {
			idadmin: {
				required: true
			}
		},
		submitHandler: function(form) {
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/plugins.php?name=contact&add',
				typesend: 'post',
				idforms: $(form),
				beforeParams:function(){},
				successParams:function(e){
					$.nicenotify.initbox(e,{
						//display:false,
						reloadhtml:true
					});
				}
			});
			return false; 
		}
	});
	$("#forms-plugins-contact").formsAddContact;
	 /**
     * Requête ajax pour la suppression des contacts
     */
	 $(document).on('click','.d-plugins-contact',function (event){
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