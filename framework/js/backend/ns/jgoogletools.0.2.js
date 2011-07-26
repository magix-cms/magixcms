var ns_jgoogletools = {
	/**
	 * Soumission de codes Google webmaster et/ou analytics
	 */
	_editWebmasterTools:function(){
		$("#forms-webmaster-tools").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true,
	    		resetform:false
			});
			return false; 
		});
	},
	_editAnalytics:function(){
		$("#forms-analytics-tools").submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		dom: this,
	    		uri: '/admin/googletools.php?pgdata',
	    		typesend: 'post',
	    		delay: 2800,
	    		time:2,
	    		reloadhtml:true	
			});
			return false; 
		});
	},
	run:function(){
		this._editWebmasterTools();
		this._editAnalytics();
	}
};