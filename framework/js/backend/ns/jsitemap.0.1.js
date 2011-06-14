var ns_jsitemap = {
	_reqCreateXml:function(domclass,data){
		$(domclass).live('click',function (event){
			event.preventDefault();
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php',
	    		typesend: 'post',
	    		noticedata: data+'='+data,
	    		time:2
			});
		});
	},
	_createXML:function(){
		this._reqCreateXml('.create-xml-index','create_xml_index');
		this._reqCreateXml('.create-xml-url','create_xml_url');
		this._reqCreateXml('.create-xml-images','create_xml_url');
	},
	_reqPing:function(domclass,data){
		$(domclass).live('click',function (){
			$.notice({
				ntype: "ajax",
	    		uri: '/admin/sitemap.php',
	    		typesend: 'post',
	    		noticedata: data+'='+data,
	    		time:2
			});
		});
	},
	_execPing:function(){
		this._reqPing('.pinggoogle','googleping');
		this._reqPing('.compressping','compressionping');
	}
};