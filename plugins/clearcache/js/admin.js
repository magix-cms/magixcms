/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.2
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
	$('#clear-minify-cache').on('click','a',function(event){
		event.preventDefault();
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers de minify',
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.nicenotify({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache",
						typesend: 'post',
						noticedata:"clear=caches",
						beforeParams:function(){
							$('#clear-minify-cache a').hide();
							$('#clear-minify-cache').prepend('<span class="min-loader"><img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" /></span>');
						},
						successParams:function(e){
							$('#clear-minify-cache a').show();
							$('.min-loader').remove();
							$.nicenotify.initbox(e);
						}
					});
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
	$('#clear-tpl-cache').on('click','a',function (event){
		event.preventDefault();
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers temporaire',
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.nicenotify({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache",
						typesend: 'post',
						noticedata:"clear=tpl",
						beforeParams:function(){
							$('#clear-tpl-cache a').hide();
							$('#clear-tpl-cache').prepend('<span class="min-loader"><img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" /></span>');
						},
						successParams:function(e){
							$('#clear-tpl-cache a').show();
							$('.min-loader').remove();
							$.nicenotify.initbox(e);
						}
					});
				},
				Cancel: function() {
					$(this).dialog('close');
				}
			}
		});
	 });
	$('#clear-admin-cache').on('click','a',function (event){
		event.preventDefault();
		$("#clearcache-dialog").dialog({
			bgiframe: true,
			resizable: false,
			minHeight:200,
			modal: true,
			title: 'Suppression des fichiers temporaire',
			buttons: {
				'Vider le cache': function() {
					$(this).dialog('close');
					$.nicenotify({
						ntype: "ajax",
						uri: "/admin/plugins.php?name=clearcache",
						typesend: 'post',
						noticedata:"clear=admin",
						beforeParams:function(){
							$('#clear-admin-cache a').hide();
							$('#clear-admin-cache').prepend('<span class="min-loader"><img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" /></span>');
						},
						successParams:function(e){
							$('#clear-admin-cache a').show();
							$('.min-loader').remove();
							$.nicenotify.initbox(e);
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