/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jsitemap
 * @update 20/10/2011 13:21
 */
var ns_jsitemap = {
	_reqCreateXml:function(domclass,data){
		$(domclass).live('click',function (event){
			event.preventDefault();
			$.nicenotify({
				ntype: "ajax",
				uri: '/admin/sitemap.php',
				typesend: 'post',
				noticedata: data+'='+data
			});
		});
	},
	_createXML:function(){
		this._reqCreateXml('.create-xml-index','create_xml_index');
		this._reqCreateXml('.create-xml-url','create_xml_url');
		this._reqCreateXml('.create-xml-images','create_xml_images');
	},
	_reqPing:function(domclass,data){
		$(domclass).live('click',function (){
			$.nicenotify({
				ntype: "ajax",
				uri: '/admin/sitemap.php',
				typesend: 'post',
				noticedata: data+'='+data
			});
		});
	},
	_execPing:function(){
		this._reqPing('.pinggoogle','googleping');
		this._reqPing('.compressping','compressionping');
	}
};