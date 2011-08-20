tinyMCEPopup.requireLangPack();

var YouTubeDialog = {
	init : function() {
	},
	videovalue:function(youtubeID){
		// Return video value for replace
		// get the current URL
		 var url = youtubeID;//window.location.toString();
		 if(url == '') {
			 tinyMCEPopup.close();
			 return false;
		 }else{
			 //get the parameters
			 url.match(/\?(.+)$/);
			 var params = RegExp.$1;
			 // split up the query string and store in an
			 // associative array
			 var params = params.split("&");
			 var queryStringList = {};
			 
			 for(var i=0;i<params.length;i++)
			 {
			 	var tmp = params[i].split("=");
			 	queryStringList[tmp[0]] = unescape(tmp[1]);
			 }
			 
			 // print all querystring in key value pairs
			 for(var i in queryStringList){
			 	return(queryStringList[i]);
			 }
		 }
	},
	insert : function() {
		// Insert the contents from the input into the document
		var f = document.forms[0], objectCode, videoSize = '', domSize = '', options = '';
		//If no code just return.
		if(f.youtubeID.value == '') {
		  tinyMCEPopup.close();
		  return false;
		}
		//SELECT AUTOPLY
		switch (f.youtubeAutoplay.value){
	        case '0':
	        	options += '';
	        break;
	        case '1':
	        	options += '&amp;autoplay=1';
            break;
		}
		//SELECT Include related videos
		//var relvideo = document.getElementById("youtubeREL");
		switch (f.youtubeREL.value)        {
	        case '0': 
	        	options += '';
	            break;
	        case '1':
	        	options += '&amp;rel=0';
                break;
		}
		//SELECT Watch in HD
		//var HD = document.getElementById("youtubeHD");
		switch (f.youtubeHD.value){
	        case '0':
	        	options += '';
	        break;
	        case '1':
	        	options += '&amp;hd=1';
            break;
		}
		//Config Size Video
		if(f.youtubeWidth.value != ''){
			domSize += 'width: ' + f.youtubeWidth.value + ';';
			videoSize += 'width="' + f.youtubeWidth.value + '"';
		}
		if(f.youtubeWidth.value != ''){
			domSize += 'height: ' + f.youtubeHeight.value + ';';
			videoSize += 'height="' + f.youtubeHeight.value + '"';
		}
		//Replace http://youtu.be/xxxxxxxx for http://www.youtube.com/v/xxxxxxxxxx
		if(f.youtubeID.value.match(new RegExp("http://www.youtube.com/","g"))){
			//Replace url
			var youtubeuri = f.youtubeID.value.replace(f.youtubeID.value,"http://www.youtube.com/v/"+YouTubeDialog.videovalue(f.youtubeID.value));
			//Construct URL
			var constructUri = youtubeuri+options;
		}else if(f.youtubeID.value.match(new RegExp("http://youtu.be/","g"))){
			//Replace url
			var youtubeuri = f.youtubeID.value.replace('http://youtu.be/',"http://www.youtube.com/v/");
			//Construct URL
			var constructUri = youtubeuri+options;
		}
		//width="'+document.forms[0].youtubeWidth.value+'" height="'+document.forms[0].youtubeHeight.value+'"
		// Insert the contents from the input into the document
		var objectCode = '<div class="youtube" style="'+domSize+'">';
		objectCode +='<object type="application/x-shockwave-flash" '+videoSize+' data="'+constructUri+'">';
		objectCode += '<param name="movie" value="'+constructUri+'" />';
		objectCode += '<param name="wmode" value="transparent" />';
		objectCode += '</object>';
		objectCode += '</div>';
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, objectCode);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(YouTubeDialog.init, YouTubeDialog);
