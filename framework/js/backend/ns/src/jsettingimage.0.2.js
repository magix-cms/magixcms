/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jsettingimage
 * @update 27/10/2011 15:16
 */
var ns_jsettingimage = {
	_loadingConfig:function(){
		$('.spincount').spinner({ min: 50 });
	},
	_updateSizeImg:function(formsId){
		$('#'+formsId).submit(function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/imagesize.php',
				typesend: 'post',
				idforms: $(this)
			});
			return false; 
		});
	},
	_configUpdateId:function(){
		$(".forms-config").each(function(){
			var formsId = $(this).attr('id');
			ns_jsettingimage._updateSizeImg(formsId);
		});
		this._loadingConfig();
	}
};