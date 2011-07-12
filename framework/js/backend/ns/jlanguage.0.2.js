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
							active = '<a href="#" class="u_active_lang" rel="'+item.idlang+'"><span class="lfloat magix-icon magix-icon-network-status-busy"></span></a>';
						}else{
							active = '<a href="#" class="u_active_lang" rel="'+item.idlang+'"><span class="lfloat magix-icon magix-icon-network-status"></span></a>';
						}
						if(item.default_lang != 0){
							defaultlang = '<span class="lfloat magix-icon magix-icon-check"></span>';
						}else{
							defaultlang = '<span class="lfloat magix-icon magix-icon-cross"></span>';
						}
						return $('<tr>'
						+'<td>'+item.idlang+'</td>'
						+'<td>'+item.iso+'</td>'
						+'<td>'+item.language+'</td>'
						+'<td class="small-icon"><img src="/upload/iso_lang/'+item.iso+'.png" width="16" height="11" alt="'+item.iso+'" /></td>'
						+'<td class="small-icon">'+defaultlang+'</td>'
						+'<td class="small-icon">'+active+'</td>'
						+'<td class="small-icon"><a href="/admin/lang.php?edit='+item.idlang+'"><span style="float:left;" class="ui-icon ui-icon-pencil"></span></a></td>'
						+'<td class="small-icon"><a href="#" class="del-lang" rel="'+item.idlang+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
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
					+'</tr>').appendTo('#table-language tbody');
				}
			}
		});		
	},
	_addNewLanguage:function(){
		$("#forms-add-lang").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/lang.php',
	    		type:"post",
	    		resetForm: true,
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			ns_jlanguage._listLang();
	    		}
	    	});
			return false;
		});
	},
	_editNewLanguage:function(edit){
		$("#forms-update-lang").submit(function(){
			$(this).ajaxSubmit({
	    		url: '/admin/lang.php?edit='+edit,
	    		type:"post",
	    		resetForm: true,
	    		success:function(request) {
	    			$.notice({
						ntype: "simple",
						time:2
					});
	    			$(".mc-head-request").html(request);
	    			ns_jlanguage._listLang();
	    		}
	    	});
			return false;
		});
	},
	_deleteLang:function(){
		/**
	     * Requête ajax pour la suppression des pages CMS
	     */
		$('.del-lang').live("click",function (e){
			e.preventDefault();
			var idlang = $(this).attr("rel");
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
							url: '/admin/lang.php',
							data: 'dellang='+idlang,
							async: false,
							cache:false,
							success: function(request){
								$.notice({
									ntype: "simple",
									time:2
								});
				    			$(".mc-head-request").html(request);
				    			ns_jlanguage._listLang();
							}
					     });
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	_google_chart_language:function(){
		$.ajax({
			url: '/admin/lang.php?json_google_chart_lang=true',
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
				$('#chart-google-language').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			success: function(j) {
				 $('#chart-google-language').empty();
				 var optionsObj = {
					title: 'Language statistics',
					series: [{label:'CMS'},{label:'NEWS'},{label:'PRODUCT'}],
					legend: {
						show: true,
						location: 'ne',
						placement: 'outsideGrid'
					},
					seriesColors: [ "#4bb2c5", "#EAA228", "#c5b47f", "#579575", "#839557", "#958c12",
					                "#953579", "#4b5de4", "#d8b83f", "#ff5800", "#0085cc"],
					seriesDefaults:{
						min: 1,
						shadow: true,
						renderer:$.jqplot.BarRenderer,
						rendererOptions:{
						   barDirection: 'vertical',
			 	           barPadding: 8,
				           barMargin: 10,
				           fillToZero: true,
				           barWidth: 25
				       }
					},
					axesDefaults: {
				        tickOptions: {
				          fontFamily: 'Georgia',
				          fontSize: '10pt'
				        }
				    },
					axes: {
			            // Use a category axis on the x axis and use our custom ticks.
			            xaxis: {
			                renderer: $.jqplot.CategoryAxisRenderer,
			                ticks: j.lang
			            },
			            // Pad the y axis just a little so bars can get close to, but
			            // not touch, the grid boundaries.  1.2 is the default padding.
			            yaxis: {
			            	pad: 1.2
			            }
					}
				};
				 $.jqplot('chart-google-language', [j.cms_pages_count,j.news_count,j.product_count], optionsObj);
			}
		});		
	},
	_activeLang:function(){
		$('.u_active_lang').live("click",function (event){
			event.preventDefault();
			var idlang = $(this).attr("rel");
			$("#confirm_published").dialog({
				resizable: false,
				height:140,
				width:320,
				modal: true,
				buttons: {
					'Activer': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: '/admin/lang.php',
							data: 'idlang='+idlang+'&active_lang=1',
							async: false,
							success:function(e){
								ns_jlanguage._listLang();
							}
					     });
						return false;
					},
					'Désactiver': function() {
						$(this).dialog('close');
						$.ajax({
							type:'post',
							url: '/admin/lang.php',
							data: 'idlang='+idlang+'&active_lang=0',
							async: false,
							success:function(e){
								ns_jlanguage._listLang();
							}
					     });
						return false;
					},
					Cancel: function() {
						$(this).dialog('close');
					}
				}
			});
		 });
	},
	run:function(){
		this._listLang();
		this._google_chart_language();
		this._addNewLanguage();
		this._deleteLang();
		this._activeLang();
	},
	runEdit:function(){
		this._listLang();
		this._google_chart_language();
		this._editNewLanguage($('#idlang').val());
		this._activeLang();
	}
};