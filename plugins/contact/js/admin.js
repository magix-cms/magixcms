/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
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
		$.notice({
			ntype: "ajaxsubmit",
    		delay: 2800,
    		dom: this,
    		uri: '/admin/plugins.php?name=contact&add',
    		typesend: 'post',
    		resetform:false,
    		time:2,
    		reloadhtml:true
		});
		return false; 
	});
	 /**
     * Requête ajax pour la suppression des contacts
     */
	$('.d-plugins-contact').click(function (){
		var lg = $(this).attr("title");
		$("#dialog").dialog({
			bgiframe: true,
			resizable: false,
			height:140,
			modal: true,
			title: 'Supprimé ce contact',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Delete item': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
			    		uri:  "/admin/plugins.php?name=contact&dcontact="+lg,
			    		typesend: 'get',
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