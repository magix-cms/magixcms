/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.1
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name adminjs
 * @package plugins
 * @addon clearcache
 *
 */
$(function(){
	$(".clear-cache").button({
        icons: {
            primary: 'ui-icon-trash'
        },
        text: true
    });
	$('#clear-minify-cache').click(function (){
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers de minify',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache&clear=caches",
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
	$('#clear-tpl-cache').click(function (){
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers temporaire',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache&clear=tpl",
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
	$('#clear-admin-cache').click(function (){
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers temporaire',
			overlay: {
				backgroundColor: '#000',
				opacity: 0.5
			},
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.notice({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache&clear=admin",
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