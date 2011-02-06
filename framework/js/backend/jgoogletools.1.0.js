/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name jgoogletools.1.0.js
 *
 */
$(function(){
	/*################## Google Tools ##############*/
	/**
     * Requête ajax pour la création de la soumission vers google
     */
	$('.pinggoogle').click(function (){
		$.notice({
			ntype: "ajax",
    		uri: '/admin/sitemap.php?sitemap&googleping',
    		typesend: 'get',
    		noticedata: null,
    		time:2
		});
	});
	/**
     * Requête ajax pour la création du fichier xml compressé au format GZ + soumission du fichier vers google
     */
	$('.compressping').click(function (){
		$.notice({
			ntype: "ajax",
    		uri: '/admin/sitemap.php?compressionping',
    		typesend: 'get',
    		noticedata: null,
    		time:2
		});
	});
	/**
	 * Soumission de codes Google webmaster et/ou analytics
	 */
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
});