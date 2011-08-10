/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_
 *
 */
var ns_jsettingparams = {
	_loadingConfig:function(){
		//Ajoute un ID numérique (boucle) sur la class "spin"
		$(".spin").each(function(i){
			var newid = $(this).attr("class")+"_" + i;
			this.id = newid;  
			var spinId = $(this).attr("id",newid);
			$(spinId).spinner({ min: 0, max: 200 });
		});
		$('.spin').spinner({ min: 0, max: 200 });
	},
	_radioConfig:function(){
		/**
	     * requête ajax par sélection du bouton radio
	     */
		$("#global-config-lang :radio").click(function(){
			$("#global-config-lang").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-news :radio").click(function(){
			$("#global-config-news").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-cms :radio").click(function(){
			$("#global-config-cms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-catalog :radio").click(function(){
			$("#global-config-catalog").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-microgalery :radio").click(function(){
			$("#global-config-microgalery").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-config-forms :radio").click(function(){
			$("#global-config-forms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:location.reload()
			});
		});
		$("#global-rewritenews :radio").click(function(){
			$("#global-rewritenews").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
		$("#global-rewritecms :radio").click(function(){
			$("#global-rewritecms").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
		$("#global-rewritecatalog :radio").click(function(){
			$("#global-rewritecatalog").ajaxSubmit({
				url:"/admin/config.php",
				type:"post"
			});
		});
	},
	_maxNumber:function(){
		$("#snumbCms").live('click',function(){
			$("#limited-cms-module").ajaxSubmit({
				url:"/admin/config.php",
				type:"post",
				success:function(e) {
					$(".configupdate").html(e);
				}
			});
		});
	}
};