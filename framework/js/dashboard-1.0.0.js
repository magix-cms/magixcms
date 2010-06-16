/**
 * @category   javascript
 * @package    dashboard
 * @copyright  Copyright (c) 2010 - 2011 (http://www.logiciel-referencement-professionnel.com)
 * @license    Proprietary software
 * @version    1.3 
 * @Date       2010-01-04
 * @update     2010-06-16
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Requête pour charger la version du CMS courant comparativement à la dernière version
 */
$(function(){
	var ie = ($.browser.msie);
	if(ie){
	$('#version').ajaxStart(function(){
		$(this).append('<img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" />');
	});
	 $("#version").ajaxError(function(){
	   $(this).append("<strong>Error requesting page</strong>");
	 });
	 $.get('/admin/version.php', function(e) {
		$('#version').html(e);
	});
	}else{
		$.ajax({
			type:'get',
			url: '/admin/version.php',
			async: false,
			beforeSend :function(){
				$('#version').html('<img src="/framework/img/small_loading.gif" width="20" height="20" alt="...loading" />');
			},
			success: function(e) {
				$('#version').html(e);
			}
		});
	}
});