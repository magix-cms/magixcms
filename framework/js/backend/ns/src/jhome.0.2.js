/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.2
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_
 *
 */
var ns_jhome = {
	_initTextChange:function(){
		$.getScript('/framework/js/tools/jquery.jqEasyCharCounter.min.js', function() {
			$('#metatitle').jqEasyCounter({
				'maxChars': 120,
				'maxCharsWarning': 110,
				'msgTextAlign': 'left',
				'msgFontSize': '12px',
				'msgFontColor': '#FFF',
				'msgAppendMethod': 'insertAfter'
			});
			$('#metadescription').jqEasyCounter({
				'maxChars': 180,
				'maxCharsWarning': 170,
				'msgTextAlign': 'left',
				'msgFontSize': '12px',
				'msgFontColor': '#FFF',
				'msgAppendMethod': 'insertAfter'
			});
		});
	},
	_homePageList:function(){
		$.ajax({
			url: '/admin/home.php?json_list_home_page=true',
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
				$('#list_home_page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				$('#list_home_page').empty();
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var tablecat = '<table id="table-list-home-page" class="table-widget-product">'
						+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header">'
						+'<th>ID</th>'
						+'<th><span class="lfloat magix-icon magix-icon-h1"></span>Titre</th>'
						+'<th><span class="lfloat magix-icon magix-icon-igoogle-t"></span></th>'
						+'<th><span class="lfloat magix-icon magix-icon-igoogle-d"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-person"></span></th>'
						+'<th><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-pencil"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
						+'</tr></thead>'
						+'<tbody>';
					tablecat += '</tbody></table>';
					$(tablecat).appendTo('#list_home_page');
					$.each(j, function(i,item) {
						if(item.metatitle != 0){
							metaTitle = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							metaTitle = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
						}
						if(item.metadescription != 0){
							metaDesc = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							metaDesc = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
						}
						return $('<tr>'
						+'<td class="small-icon">'+item.idhome+'</td>'
						+'<td class="medium-cell"><a href="/admin/home.php?edit='+item.idhome+'" class="linkurl">'+item.subject+'</a></td>'
						+'<td class="small-icon">'+metaTitle+'</td>'
						+'<td class="small-icon">'+metaDesc+'</td>'
						+'<td class="small-icon">'+item.iso+'</td>'
						+'<td class="small-icon">'+item.pseudo+'</td>'
						+'<td class="small-icon"><a class="post-preview" href="'+item.uri_home+'"><span style="float:left;" class="ui-icon ui-icon-zoomin"></span></a></td>'
						+'<td class="small-icon"><a href="/admin/home.php?edit='+item.idhome+'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>'
						+'<td class="small-icon"><a href="#" class="deletehome" rel="'+item.idhome+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
						'</tr>').appendTo('#table-list-home-page tbody');
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
					+'<td><span class="lfloat ui-icon ui-icon-minus"></span></td>'
					+'</tr>').appendTo('#table-list-home-page tbody');
				}
				$(".post-preview").colorbox({width:"95%", height:"95%", iframe:true});
			}
		});		
	},
	_addNewHome:function(){
		 $("#forms-add-home").submit(function(){
				$(this).ajaxSubmit({
		    		url:'/admin/home.php',
		    		type:"post",
		    		resetForm: true,
		    		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
		    			$(".mc-head-request").html(request);
		    			ns_jhome._homePageList();
		    		}
		    	});
				return false; 
			});
	},
	_editHome:function(){
		$("#forms-home-update").submit(function(){
			var homeid = $('#idhome').val();
			if(homeid != null){
				$(this).ajaxSubmit({
	        		url:'/admin/home.php?edit='+homeid,
	        		type:"post",
	        		resetForm: false,
	        		success:function(request) {
						$.notice({
							ntype: "simple",
							time:2
						});
	        			$(".mc-head-request").html(request);
	        			ns_jhome._homePageList();
	        		}
	        	});
				return false; 
			}else{
				console.log("%s: %o","homeid is null",homeid);
			}
		});
	},
	_deleteHome:function(){
		/**
	     * Requête ajax pour la suppression des pages d'accueil
	     */
	    $('.deletehome').live('click',function (e){
	    	e.preventDefault();
			var idhome = $(this).attr("rel");
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Delete': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: "/admin/home.php",
							data : 'del_home='+idhome,
							async: false,
							cache: false,
							success: function(){
								ns_jhome._homePageList();
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
						//success: location.reload()
					}
				}
			});
		 });
	},
	run:function(){
		this._initTextChange();
		this._homePageList();
		this._addNewHome();
		this._deleteHome();
	},
	runEdit:function(){
		this._initTextChange();
		this._editHome();
		this._deleteHome();
	}
};