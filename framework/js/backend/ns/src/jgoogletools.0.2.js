/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jgoogletools
 * @update 03/01/2012 22:45
 */
var ns_jgoogletools = {
	/**
	 * Soumission de codes Google webmaster et/ou analytics
	 */
	_editWebmasterTools:function(){
		$("#forms-webmaster-tools").submit(function(){
			/*$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true,
	    		resetform:false
			});*/
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/googletools.php?pgdata',
				typesend: 'post',
				idforms: $(this),
				successParams:function(e){
					$.nicenotify.initbox(e,{
						display : true,
						time: 4,
						reloadhtml:true,
						delay: 3000
					});
				}
			});
			return false; 
		});
	},
	_editAnalytics:function(){
		$("#forms-analytics-tools").submit(function(){
			/*$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
			});*/
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/googletools.php?pgdata',
				typesend: 'post',
				idforms: $(this),
				successParams:function(e){
					$.nicenotify.initbox(e,{
						display : true,
						time: 4,
						reloadhtml:true,
						delay: 3000
					});
				}
			});
			return false;  
		});
	},
	run:function(){
		this._editWebmasterTools();
		this._editAnalytics();
	}
};