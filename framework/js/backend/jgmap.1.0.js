/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jgmap.1.0.js
 *
 */
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