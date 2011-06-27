var ns_jsettingimage = {
	_loadingConfig:function(){
		$('.spincount').spinner({ min: 50 });
	}
	,
	_updateSizeImg:function(formsId){
		$(formsId).submit(function(){
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
		this._updateSizeImg('#cat_category_image_size');
		this._updateSizeImg('#cat_subcategory_image_size');
		this._updateSizeImg('#mini_product_image_size');
		this._updateSizeImg('#medium_product_image_size');
		this._updateSizeImg('#large_product_image_size');
	},
	exeUpdate:function(){
		this._configUpdateId();
	}
};