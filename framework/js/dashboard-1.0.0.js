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