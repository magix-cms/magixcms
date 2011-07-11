var ns_jlanguage = {
	_listLang:function(){
		$.ajax({
			url: '/admin/lang.php?json_list_lang=true',
			dataType: 'json',
			type: "get",
			statusCode: {
				0: function() {
					console.error("jQuery Error");
				},
				401: function() {
					console.warn("access denied");
				},
				404: function() {
					console.warn("object not found");
				},
				403: function() {
					console.warn("request forbidden");
				},
				408: function() {
					console.warn("server timed out waiting for request");
				},
				500: function() {
					console.error("Internal Server Error");
				}
			},
			async: true,
			cache:false,
			beforeSend: function(){
				$('#list_lang').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#list_lang').empty();
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var tablecat = '<table id="table-language" class="table-widget-product">'
						+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header">'
						+'<th>ID</th>'
						+'<th><span class="lfloat magix-icon magix-icon-locale"></span></th>'
						+'<th>Langue</th>'
						+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
						+'<th>Defaut</th>'
						+'<th>Active</th>'
						+'<th><span class="lfloat ui-icon ui-icon-pencil"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
						+'</tr></thead>'
						+'<tbody>';
					tablecat += '</tbody></table>';
					$(tablecat).appendTo('#list_lang');
					$.each(j, function(i,item) {
						if(item.active_lang != 0){
							active = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							active = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
						}
						if(item.default_lang != 0){
							defaultlang = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							defaultlang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
						}
						return $('<tr>'
						+'<td>'+item.idlang+'</td>'
						+'<td>'+item.iso+'</td>'
						+'<td>'+item.language+'</td>'
						+'<td class="small-icon"></td>'
						+'<td class="small-icon">'+defaultlang+'</td>'
						+'<td class="small-icon">'+active+'</td>'
						+'<td class="small-icon"><a href="#" class="drelangpage" rel="'+item.idrel_lang+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'
						+'<td class="small-icon"><a href="#" class="drelangpage" rel="'+item.idrel_lang+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
						'</tr>').appendTo('#table-language tbody');
					});
				}else{
					return $('<tr>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'</tr>').appendTo('#table-language tbody');
				}
			}
		});		
	}	
};