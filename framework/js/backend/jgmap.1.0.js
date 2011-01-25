$(function(){
	/*################## Sitemap ##############*/
	/**
     * Requête ajax pour la création, modification de fichier sitemap xml
     */
	$('.create-xml-index').click(function (event){
		event.preventDefault();
		$.notice({
			ntype: "ajax",
    		uri: '/admin/sitemap.php?create_xml_index=true',
    		typesend: 'get',
    		noticedata: null,
    		time:2
		});
	 });
	$('.create-xml-url').click(function (event){
		event.preventDefault();
		$.notice({
			ntype: "ajax",
    		uri: '/admin/sitemap.php?create_xml_url=true',
    		typesend: 'get',
    		noticedata: null,
    		time:2
		});
	 });
	$('.create-xml-images').click(function (event){
		event.preventDefault();
		$.notice({
			ntype: "ajax",
    		uri: '/admin/sitemap.php?create_xml_images=true',
    		typesend: 'get',
    		noticedata: null,
    		time:2
		});
	 });
});