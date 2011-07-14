var ns_jsettingimage = {
	_loadingConfig:function(){
		$('.spincount').spinner({ min: 50 });
	},
	_updateSizeImg:function(formsId){
		$('#'+formsId).submit(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: this,
	    		uri: '/admin/imagesize.php',
	    		typesend: 'post',
	    		time:2,
	    		reloadhtml:false	
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