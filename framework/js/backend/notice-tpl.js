(function($) { 
    $.notice = function(settings) { 
    	var options =  { 
    		ntype: "simple",
    		nparams: false,
    		delay: 3000,
    		dom: null,
    		uri: null,
    		typesend: 'post',
    		noticedata: null,
    		resetform:false,
    		time:4,
    		reloadhtml:false
    	};
        $.extend(options, settings);
        function getSimpleNotify(time){
        	$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
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
        function submit_noticehead(dom,uri,typesend,noticedata,resetform,time,reloadhtml){
        	$(dom).ajaxSubmit({
        		url:uri,
        		type:typesend,
        		data:noticedata,
        		resetForm: resetform,
        		success:function(request) {
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-header').destroyMeerkat();
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
        			$(".mc-head-request").html(request);
        			if(reloadhtml == true){
        				setTimeout(function(){
        					location.reload();
        				},options.delay);
        			}
        		}
        	});
        }
        function noticehead(uri,typesend,noticedata,time){
        	$.ajax({
        		url:uri,
        		type:typesend,
        		async: false,
        		data: noticedata,
        		success:function(request) {
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
        				$('#notify-header').destroyMeerkat();
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
        			$(".mc-head-request").html(request);
        		}
        	});
        }
        function getDirNotify(nparams){
        	switch(nparams){
        		case "install":
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
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
        					height: '80px',
        					opacity: '0.90',
        					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
        				}).addClass('pos-top');
        			});
        		break;
        		case "chmod":
        			$.getScript('/framework/js/jquery.meerkat.1.3.min.js', function() {
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
        					height: '80px',
        					opacity: '0.90',
        					onMeerkatShow: function() { $(this).animate({opacity: 'show'}, 1000); }
        				}).addClass('pos-top');
        			});
        		break;
        	}
        }
        switch(options.ntype){
        	case "simple":
        		getSimpleNotify(options.time);
        	case "ajaxsubmit":
        		submit_noticehead(options.dom,options.uri,options.typesend,options.noticedata,options.resetform,options.time,options.reloadhtml);
        	break;
        	case "ajax":
        		noticehead(options.uri,options.typesend,options.noticedata,options.time);
        	break;
        	case "dir":
        		getDirNotify(options.nparams);
        	break;
        }
        if(options.ntype == ""){
        	console.log("%s: %o","ntype is null");
        	return false;
        }else if(options.ntype == undefined){
        	console.log("%s: %o","ntype is undefined");
        	return false;
        }
    }; 
})(jQuery); 