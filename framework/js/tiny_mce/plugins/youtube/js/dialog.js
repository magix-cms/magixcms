tinyMCEPopup.requireLangPack();

var YouTubeDialog = {
	init : function() {
	},

	insert : function() {
		// Insert the contents from the input into the document
		//SELECT Include related videos
        var insertedRel = '';
		var relvideo = document.getElementById("youtubeREL");
		switch (relvideo.value)        {
	        case '0': 
	            insertedRel = '';
	        break;
	        case '1':
	        	insertedRel = '&amp;rel=0';
                break;
		}
		//SELECT Watch in HD
		var insertedHD = '';
		var HD = document.getElementById("youtubeHD");
		switch (HD.value)        {
	        case '0':
	        	insertedHD = '';
	        break;
	        case '1':
	        	insertedHD = '&amp;hd=1';
            break;
		}
		// Insert the contents from the input into the document
		var objectCode = '<div class="youtube" style="width:'+document.forms[0].youtubeWidth.value+';height:'+document.forms[0].youtubeHeight.value+';">';
		objectCode +='<object type="application/x-shockwave-flash" width="'+document.forms[0].youtubeWidth.value+'" height="'+document.forms[0].youtubeHeight.value+'" data="http://www.youtube.com/v/'+document.forms[0].youtubeID.value+insertedRel+insertedHD+'">';
		objectCode += '<param name="movie" value="http://www.youtube.com/v/'+document.forms[0].youtubeID.value+insertedRel+insertedHD+'" />';
		objectCode += '<param name="wmode" value="transparent" />';
		objectCode += '</object>';
		objectCode += '</div>';
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, objectCode);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(YouTubeDialog.init, YouTubeDialog);
