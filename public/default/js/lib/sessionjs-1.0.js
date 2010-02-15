function updateProgress() {
	  var progress;
	  progress = $("#progressbar")
	    .progressbar("option","value");
	  if (progress <= 100) {
	      $("#progressbar")
	        .progressbar("option", "value", progress + 1);
	      $("#progressText").text(progress+"%");
	      setTimeout(updateProgress, 100);
	  }
	  if(progress>=100){
		  location.reload();
	  }
	  return false;
	}
function randomPassword() {
	var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$_+";
	var size = 10;
	var i = 1;
	var ret = '';
	while ( i <= size ) {
		$max = chars.length-1;
		$num = Math.floor(Math.random()*$max);
		$temp = chars.substr($num, 1);
		ret += $temp;
		i++;
	}
	return ret;
}
(function($){
	$(document).ready(function(){
		$.jGrowl.defaults.closer = function() {
			console.log("Closing everything!", this);
			$('#userpanel').bind('click',function(){
				$.jGrowl($("#userbox").html(), { header: 'User Box', sticky: true, closer: false});
				$.jGrowl($("#userboxExtend").html(), { header: 'Extend Box', sticky: true, closer: false});
				$.jGrowl($(".user_msg").html(), { sticky: true, closer: false});
			});
		};
		$.jGrowl.defaults.open = function() {
			$('#userpanel').unbind('click');
		};
		$.jGrowl.defaults.closeTemplate = '';
		if ( !$.browser.safari ) {
			$.jGrowl.defaults.animateOpen = {
				width: 'show'
			};
			$.jGrowl.defaults.animateClose = {
				width: 'hide'
			};
		}
		//$.jGrowl($(".user_welcome").html(),{ life: 5000});
		$.jGrowl($("#userbox").html(), { header: 'User Box', sticky: true, closer: false});
		$.jGrowl($("#userboxExtend").html(), { header: 'Extend Box', sticky: true, closer: false});
		$.jGrowl($(".user_msg").html(), { sticky: true, closer: false});
		$("#tabsFormsSession").tabs();
		$('<div class="filesystem"></div>').insertAfter('span.photo');
		$('.filesystem').empty();
		$(':checkbox#addimg').click(function(){
	 		if(this.checked){
	 			jQuery('<input type="file" id="photo" name="photo" value="" />').appendTo(".filesystem");
	 		}else{
	 			jQuery('.filesystem').empty();
	 		}
	 	});
		$('#etatcivil').uniform();
		$("#idgenre").uniform();
	});
})(jQuery);