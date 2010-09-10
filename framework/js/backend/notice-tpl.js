function noticehead(uri,typesend,noticedata,time){
	$.ajax({
		url:uri,
		type:typesend,
		data: noticedata,
		success:function(request) {
			$.getScript('/framework/js/jquery.meerkat.1.3.js', function() {
				$('#notify-header').meerkat({
					background:"#efefef",
					width: '100%',
					position: 'top',
					close: '.close-notify',
					animationIn: 'fade',
					animationOut: 'slide',
					animationSpeed: '750',
					height: '80px',
					opacity: '0.90',
					timer: time,
					onMeerkatShow: function() { 
						$(this).animate({opacity: 'show'}, 1000); 
					}
				}).addClass('pos-top');
			});
			$("div.dc-head-request").html(request);
		}
	});
}
function getDirNotify(nparams){
	switch(nparams){
		case "install":
			$.getScript('/framework/js/jquery.meerkat.1.3.js', function() {
				$('#notify-install').destroyMeerkat();
				$('#notify-install').meerkat({
					background:"#fdd",
					width: '100%',
					position: 'top',
					close: '.close-notify',
					dontShowAgain: '.dont-notify',
					animationIn: 'fade',
					animationOut: 'slide',
					animationSpeed: '750',
					//removeCookie: '.reset',
					height: '80px',
					opacity: '0.90',
					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
				}).addClass('pos-top');
			});
		break;
		case "folder":
			$.getScript('/framework/js/jquery.meerkat.1.3.js', function() {
				$('#notify-folder').destroyMeerkat();
				$('#notify-folder').meerkat({
					background:"#efefef",
					width: '100%',
					position: 'top',
					close: '.close-notify',
					dontShowAgain: '.dont-notify',
					animationIn: 'fade',
					animationOut: 'slide',
					animationSpeed: '750',
					//removeCookie: '.reset',
					height: '80px',
					opacity: '0.90',
					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
				}).addClass('pos-top');
			});
		break;
	}
}
function getSimpleNotify(time){
	$.getScript('/framework/js/jquery.meerkat.1.3.js', function() {
		$('#notify-header').meerkat({
			background:"#efefef",
			width: '100%',
			position: 'top',
			close: '.close-notify',
			animationIn: 'fade',
			animationOut: 'slide',
			animationSpeed: '750',
			height: '80px',
			opacity: '0.90',
			timer: time,
			onMeerkatShow: function() { 
				$(this).animate({opacity: 'show'}, 1000); 
			}
		}).addClass('pos-top');
	});
}