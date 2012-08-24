/**
 * MAGIX CMS
 * @copyright  MAGIX CMS Copyright (c) 2011 - 2012 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    0.3
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * @name ns_jcms
 * @update 24/08/2012 15:15
 */
var ns_jcms = {
	_initTextChange:function(){
		$.getScript('/framework/js/tools/jquery.jqEasyCharCounter.min.js', function() {
			$('#seo_title_page').jqEasyCounter({
				'maxChars': 120,
				'maxCharsWarning': 110,
				'msgTextAlign': 'left',
				'msgFontSize': '12px',
				'msgFontColor': '#FFF',
				'msgAppendMethod': 'insertAfter'
			});
			$('#seo_desc_page').jqEasyCounter({
				'maxChars': 180,
				'maxCharsWarning': 170,
				'msgTextAlign': 'left',
				'msgFontSize': '12px',
				'msgFontColor': '#FFF',
				'msgAppendMethod': 'insertAfter'
			});
		});
	},
	_addParentPage:function(getlang,idlang){
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms_cms_add_parent").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?add_parent_p=true',
				typesend: 'post',
				idforms: $(this),
				resetform: true,
				successParams:function(e){
					$.nicenotify.initbox(e);
					if(getlang==true){
	    				ns_jcms._loadParentPage(idlang);
	    			}else{
	    				ns_jcms._google_chart_language();
	    			}
				}
			});
			return false;
		});
	},
	_load_page_uri:function(idpage){
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/cms.php?edit='+idpage+'&load_json_uri_cms=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$("#cmslink").css({"display":"none"}).val('');
				$('<span class="min-loader"><img src="/framework/img/small_loading.gif" /></span>').insertAfter('#cmslink');
			},
			successParams:function(j){
				$.nicenotify.initbox(j,{
					display:false
				});
				$('.min-loader').remove();
				var uri = j.cmsuri;
				$("#cmslink").css({"display":"block"});
				$("#cmslink").val(uri);
				$(".post-preview").attr({
					href:uri
				});
			}
		});
	},
	_loadParentPage:function(idlang){
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/cms.php?getlang='+idlang+'&json_page_p=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$('#list_page_p').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			successParams:function(j){
				$('#list_page_p').empty();
				$.nicenotify.initbox(j,{
					display:false
				});
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var sort_page_p = '<ul id="sort_page_p">';
					sort_page_p += '</ul>';
					$(sort_page_p).appendTo('#list_page_p');
					$.each(j, function(i,item) {
						if(item.sidebar_page != '0'){
							sidebar_states = '<span class="lfloat magix-icon magix-icon-network-status-busy"></span>';
						}else{
							sidebar_states = '<span class="lfloat magix-icon magix-icon-network-status"></span>';
						}
						if($.ieTester()){
							return $('<li class="ui-state-default" id="pageorderp_'+item.idpage+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.title_page
							+'<div style="float:right;margin-top:-15px;top:0;margin-right:10px;">'
							+'<a title="Publication" class="u_sidebar_pages" href="#" rel="'+item.idpage+'">'+sidebar_states+'</a>'
							+'<a title="Déplacement" href="/admin/cms.php?movepage='+item.idpage+'"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a>'
							+'<a title="Gestion de la page parente" href="/admin/cms.php?getlang='+idlang+'&get_page_p='+item.idpage+'"><span class="lfloat ui-icon ui-icon-gear"></span></a>'
							+'<a title="Edition" href="/admin/cms.php?edit='+item.idpage+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a title="Suppression" href="#" class="delpage" rel="'+item.idpage+'"><span class="lfloat ui-icon ui-icon-close"></span></a></div>'+
							'<div style="clear:both;"></div></li>').appendTo('#sort_page_p');
						}else{
							return $('<li class="ui-state-default" id="pageorderp_'+item.idpage+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.title_page
							+'<div style="float:right;">'
							+'<a title="Publication" class="u_sidebar_pages" href="#" rel="'+item.idpage+'">'+sidebar_states+'</a>'
							+'<a title="Déplacement" href="/admin/cms.php?movepage='+item.idpage+'"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a>'
							+'<a title="Gestion de la page parente" href="/admin/cms.php?getlang='+idlang+'&get_page_p='+item.idpage+'"><span class="lfloat ui-icon ui-icon-gear"></span></a>'
							+'<a title="Edition" href="/admin/cms.php?edit='+item.idpage+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a title="Suppression" href="#" class="delpage" rel="'+item.idpage+'"><span class="lfloat ui-icon ui-icon-close"></span></a></div>'+
							'</li>').appendTo('#sort_page_p');
						}
					});
				}
				/**
			     * Initialisation du drag and drop
			     * Requête ajax pour l'enregistrement du déplacement
			     */
				$('#sort_page_p li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				$('#sort_page_p').sortable({
					placeholder: 'ui-state-highlight',
					cursor: "move",
					axis: "y",
					update : function () {
						serial = $('#sort_page_p').sortable('serialize');
						$.nicenotify({
							ntype: "ajax",
							uri: "/admin/cms.php?order_page=true",
							typesend: 'post',
							noticedata : serial,
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
							}
						});
					}
				});
				$("#sort_page_p").disableSelection();
			}
		});
	},
	_loadChildPage:function(idlang,idcat_p){
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/cms.php?getlang='+idlang+'&get_page_p='+idcat_p+'&json_child_p=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$('#list_child_page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			successParams:function(j){
				$('#list_child_page').empty();
				$.nicenotify.initbox(j,{
					display:false
				});
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var sort_page_p = '<ul id="sort_child_page">';
					sort_page_p += '</ul>';
					$(sort_page_p).appendTo('#list_child_page');
					$.each(j, function(i,item) {
						if(item.sidebar_page != '0'){
							sidebar_states = '<span class="lfloat magix-icon magix-icon-network-status-busy"></span>';
						}else{
							sidebar_states = '<span class="lfloat magix-icon magix-icon-network-status"></span>';
						}
						if($.ieTester()){
							return $('<li class="ui-state-default" id="pageorderp_'+item.idpage+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.title_page
							+'<div style="float:right;margin-top:-15px;top:0;margin-right:10px;">'
							+'<a title="Publication" class="u_sidebar_pages" href="#" rel="'+item.idpage+'">'+sidebar_states+'</a>'
							+'<a title="Déplacement" href="/admin/cms.php?movepage='+item.idpage+'"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a>'
							+'<a title="Edition" href="/admin/cms.php?edit='+item.idpage+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a title="Suppression" href="#" class="delpage" rel="'+item.idpage+'"><span class="lfloat ui-icon ui-icon-close"></span></a></div>'+
							'<div style="clear:both;"></div></li>').appendTo('#sort_child_page');
						}else{
							return $('<li class="ui-state-default" id="pageorderp_'+item.idpage+'">'
							+'<span class="arrowthick ui-icon ui-icon-arrowthick-2-n-s"></span>'+item.title_page
							+'<div style="float:right;">'
							+'<a title="Publication" class="u_sidebar_pages" href="#" rel="'+item.idpage+'">'+sidebar_states+'</a>'
							+'<a title="Déplacement" href="/admin/cms.php?movepage='+item.idpage+'"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a>'
							+'<a title="Edition" href="/admin/cms.php?edit='+item.idpage+'"><span class="lfloat ui-icon ui-icon-pencil"></span></a>'
							+'<a title="Suppression" href="#" class="delpage" rel="'+item.idpage+'"><span class="lfloat ui-icon ui-icon-close"></span></a></div>'+
							'</li>').appendTo('#sort_child_page');
						}
					});
				}
				/**
			     * Initialisation du drag and drop
			     * Requête ajax pour l'enregistrement du déplacement
			     */
				$('#sort_child_page li').hover(
					function() { $(this).addClass('ui-state-hover'); },
					function() { $(this).removeClass('ui-state-hover'); }
				);
				$('#sort_child_page').sortable({
					placeholder: 'ui-state-highlight',
					cursor: "move",
					axis: "y",
					update : function () {
						serial = $('#sort_child_page').sortable('serialize');
						$.nicenotify({
							ntype: "ajax",
							uri: "/admin/cms.php?order_page=true",
							typesend: 'post',
							noticedata : serial,
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
							}
						});
					}
				});
				$("#sort_child_page").disableSelection();
			}
		});	
	},
	_addChildPage:function(idlang,idcat_p){
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms_cms_add_child").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?getlang='+idlang+'&get_page_p='+idcat_p,
				typesend: 'post',
				idforms: $(this),
				resetform: true,
				successParams:function(e){
					$.nicenotify.initbox(e);
					ns_jcms._loadChildPage(idlang,idcat_p);
				}
			});
			return false;
		});
	},
	_editPage:function(edit){
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms_cms_edit_page").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?edit='+edit,
				typesend: 'post',
				idforms: $(this),
				resetform: false,
				successParams:function(e){
					$.nicenotify.initbox(e);
					ns_jcms._load_page_uri(edit);
				}
			});
			return false;
		});
	},
	_addRelLangPage:function(edit){
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms-add-relatedlang-pages").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?edit='+edit,
				typesend: 'post',
				idforms: $(this),
				resetform: false,
				successParams:function(e){
					$.nicenotify.initbox(e);
					ns_jcms._child_lang_page(edit);
				}
			});
			return false;
		});
	},
	_child_lang_page:function(edit){
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/cms.php?edit='+edit+'&json_child_lang_page=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$('#child-lang-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			successParams:function(j){
				$('#child-lang-page').empty();
				$.nicenotify.initbox(j,{
					display:false
				});
				if(j === undefined){
					console.log(j);
				}
				if(j !== null){
					var tablecat = '<table id="table-child-lang-page" class="table-widget-product">'
						+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th><th>Idpage</th>'
						+'<th><span class="lfloat magix-icon magix-icon-h1"></span>Titre</th>'
						+'<th><span class="lfloat ui-icon ui-icon-folder-collapsed"></span></th>'
						+'<th><span class="lfloat magix-icon magix-icon-igoogle-t"></span></th>'
						+'<th><span class="lfloat magix-icon magix-icon-igoogle-d"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-person"></span></th>'
						+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
						+'</tr></thead>'
						+'<tbody>';
					tablecat += '</tbody></table>';
					$(tablecat).appendTo('#child-lang-page');
					$.each(j, function(i,item) {
						if(item.uri_category != null){
							category = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							category = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-home"></span></div>';
						}
						if(item.seo_title_page != 0){
							metaTitle = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							metaTitle = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
						}
						if(item.seo_desc_page != 0){
							metaDesc = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
						}else{
							metaDesc = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
						}
						if(item.iso != null){
							flaglang = item.iso;
						}else{
							flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
						}
						return $('<tr>'
						+'<td>'+item.idrel_lang+'</td>'
						+'<td>'+item.idpage+'</td>'
						+'<td class="medium-cell"><a href="/admin/cms.php?edit='+item.idpage+'" class="linkurl">'+item.title_page+'</a></td>'
						+'<td class="small-icon">'+category+'</td>'
						+'<td class="small-icon">'+metaTitle+'</td>'
						+'<td class="small-icon">'+metaDesc+'</td>'
						+'<td class="small-icon">'+flaglang+'</td>'
						+'<td class="small-icon">'+item.pseudo+'</td>'
						+'<td class="small-icon"><a href="#" class="drelangpage" rel="'+item.idrel_lang+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
						'</tr>').appendTo('#table-child-lang-page tbody');
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
					+'</tr>').appendTo('#table-child-lang-page tbody');
				}
			}
		});
	},
	_resultSearch:function(j){
		$('#result-search-page').empty();
		var tablecat = '<table id="table_search_product" class="table-widget-product">'
			+'<thead><tr style="padding:3px;" class="ui-widget ui-widget-header"><th>ID</th>'
			+'<th><span class="lfloat magix-icon magix-icon-h1"></span>Titre</th>'
			+'<th><span class="lfloat ui-icon ui-icon-folder-collapsed"></span></th>'
			+'<th><span class="lfloat magix-icon magix-icon-igoogle-t"></span></th>'
			+'<th><span class="lfloat magix-icon magix-icon-igoogle-d"></span></th>'
			+'<th><span class="lfloat ui-icon ui-icon-flag"></span></th>'
			+'<th><span class="lfloat ui-icon ui-icon-person"></span></th>'
			+'<th><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></th>'
			+'<th><span class="lfloat ui-icon ui-icon-pencil"></span></th>'
			+'<th><span class="lfloat ui-icon ui-icon-close"></span></th>'
			+'</tr></thead>'
			+'<tbody>';
		tablecat += '</tbody></table>';
		$(tablecat).appendTo('#result-search-page');
		if(j === undefined){
			console.log(j);
		}
		if(j !== null){
			$.each(j, function(i,item) {
				if(item.uri_category != null){
					category = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
					movepage = '<td class="small-icon"><a href="/admin/cms.php?movepage='+item.idpage+'" class="linkurl"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a></td>';
				}else{
					category = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-home"></span></div>';
					movepage = '<td class="small-icon"><a href="/admin/cms.php?movepage='+item.idpage+'" class="linkurl"><span class="lfloat ui-icon ui-icon-transfer-e-w"></span></a></td>';
				}
				if(item.seo_title_page != 0){
					metaTitle = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
				}else{
					metaTitle = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
				}
				if(item.seo_desc_page != 0){
					metaDesc = '<div class="ui-state-highlight" style="border:none;"><span style="float:left" class="ui-icon ui-icon-check"></span></div>';
				}else{
					metaDesc = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-alert"></span></div>';
				}
				if(item.iso != null){
					flaglang = item.iso;
				}else{
					flaglang = '<div class="ui-state-error" style="border:none;"><span style="float:left;" class="ui-icon ui-icon-cancel"></span></div>';
				}
				return $('<tr>'
				+'<td>'+item.idpage+'</td>'
				+'<td class="medium-cell"><a href="/admin/cms.php?edit='+item.idpage+'" class="linkurl">'+item.title_page+'</a></td>'
				+'<td class="small-icon">'+category+'</td>'
				+'<td class="small-icon">'+metaTitle+'</td>'
				+'<td class="small-icon">'+metaDesc+'</td>'
				+'<td class="small-icon">'+flaglang+'</td>'
				+'<td class="small-icon">'+item.pseudo+'</td>'
				+movepage
				+'<td class="small-icon"><a title="Edition" href="/admin/cms.php?edit='+item.idpage+'" class="linkurl"><span class="lfloat ui-icon ui-icon-pencil"></span></a></td>'
				+'<td class="small-icon"><a title="Suppression" href="#" class="delpage" rel="'+item.idpage+'"><span style="float:left;" class="ui-icon ui-icon-close"></span></a></td>'+
				'</tr>').appendTo('#table_search_product tbody');
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
					+'</tr>').appendTo('#table_search_product tbody');
		}
		//ns_jcms._deletePage(false);
	},
	_initSearchPage:function(){
		/**
		 * Recherche simple dans les titres des pages CMS
		 */
		$("#forms-search-page").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?get_search_page=true',
				typesend: 'post',
				datatype: 'json',
				idforms: $(this),
				resetform: true,
				beforeParams:function(){
					$('#result-search-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
				},
				successParams:function(j){
					$.nicenotify.initbox(j,{
						display:false
					});
					ns_jcms._resultSearch(j);
				}
			});
			return false; 
		});
	},
	_google_chart_language:function(){
		$.nicenotify({
			ntype: "ajax",
			uri: '/admin/cms.php?json_google_chart_pages=true',
			typesend: 'get',
			datatype: 'json',
			beforeParams:function(){
				$('#chart-google-page').html('<img class="loader-block" src="/framework/img/square-circle.gif" />');
			},
			successParams:function(j){
				$('#chart-google-page').empty();
				$.nicenotify.initbox(j,{
					display:false
				});
				 var optionsObj = {
					title: 'CMS Statistics',
					series: [{label:'Pages parente'},{label:'Pages enfants'},{label:'Langues relative'}],
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
			                //pad: 1.2
			            }
					}
				};
				 $.jqplot('chart-google-page', [j.parent_p_count,j.child_p_count,j.rel_lang_child], optionsObj);
			}
		});
	},
	_autoComplete_cat_p_lang:function(){
		$("#title_p_lang").autocomplete({
		    minLength: 2,
		    scrollHeight: 220, 
	        source: function(req, add){
	        	$.nicenotify({
					ntype: "ajax",
					uri: '/admin/cms.php?callback=?',
					typesend: 'get',
					datatype: 'json',
					noticedata: 'getlang='+$('#idlang option:selected').val()+'&title_p_lang='+req.term,
					beforeParams:function(){},
					successParams:function(data){
						$.nicenotify.initbox(data,{
							display:false
						});
						var suggestions = [];  
	                    //process response  
	                    $.each(data, function(i, val){  
	                    	suggestions.push({"id": val.id, "value": val.value});  
	                	});  
	                	//pass array to callback  
	                	add(suggestions); 
					}
				});
	    	},
            select: function(event, ui) {
                $('#idlang_p').val(ui.item.id);
            }
		});
	},
	_deletePage:function(config){
		/**
	     * Requête ajax pour la suppression des pages CMS
	     */
		$(document).on("click",'.delpage',function (e){
			e.preventDefault();
			var idpage = $(this).prop('rel');
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Delete': function() {
						$(this).dialog('close');
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/cms.php',
							typesend: 'post',
							noticedata : 'delpage='+idpage,
							successParams:function(request){
								switch(config){
									case "page_p":
										$.nicenotify.initbox(request,{
											display:false
										});
										ns_jcms._loadParentPage($("#idlang").val());
									break;
									case "page_child":
										$.nicenotify.initbox(request,{
											display:false
										});
						    			ns_jcms._loadChildPage($("#idlang").val(),$('#idcat_p').val());
									break;
									case "search":
										$.nicenotify.initbox(request,{
											display:false
										});
										$('#result-search-page').empty();
									break;
								}
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
	_deleteRelLangPage:function(edit){
		/**
	     * Requête ajax pour la suppression des pages CMS
	     */
		$(document).on("click",'.drelangpage',function (e){
			e.preventDefault();
            var idrel_lang = $(this).prop('rel');
			$("#dialog_delete").dialog({
				bgiframe: true,
				resizable: false,
				height:140,
				modal: true,
				buttons: {
					'Delete': function() {
						$(this).dialog('close');
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/cms.php?edit='+edit,
							typesend: 'post',
							noticedata : 'del_relang_p='+idrel_lang,
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
								ns_jcms._child_lang_page(edit);
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
	_sidebarPage:function(child){
        $(document).on("click",'.u_sidebar_pages',function (event){
            event.preventDefault();
            var idpage = $(this).prop('rel');
			$("#confirm_published").dialog({
				resizable: false,
				height:140,
				width:320,
				modal: true,
				buttons: {
					'Afficher': function() {
						$(this).dialog('close');
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/cms.php',
							typesend: 'post',
							noticedata : 'idpage='+idpage+'&sidebar_page=1',
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
								if(child == true){
									ns_jcms._loadChildPage($("#idlang").val(),$('#idcat_p').val());
								}else{
									ns_jcms._loadParentPage($("#idlang").val());
								}
							}
						});
						return false;
					},
					'Cacher': function() {
						$(this).dialog('close');
						$.nicenotify({
							ntype: "ajax",
							uri: '/admin/cms.php',
							typesend: 'post',
							noticedata : 'idpage='+idpage+'&sidebar_page=0',
							successParams:function(e){
								$.nicenotify.initbox(e,{
									display:false
								});
								if(child == true){
									ns_jcms._loadChildPage($("#idlang").val(),$('#idcat_p').val());
								}else{
									ns_jcms._loadParentPage($("#idlang").val());
								}
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
	_autoComplete_parent_cat_p:function(){
		$("#title_p_move").autocomplete({
		    minLength: 2,
		    scrollHeight: 220, 
	        source: function(req, add){
	        	$.nicenotify({
					ntype: "ajax",
					uri: '/admin/cms.php?callback=?',
					typesend: 'get',
					datatype: 'json',
					noticedata: 'getlang='+$('#idlang option:selected').val()+'&title_p_move='+req.term,
					beforeParams:function(){},
					successParams:function(data){
						$.nicenotify.initbox(data,{
							display:false
						});
						var suggestions = [];  
	                    //process response  
	                    $.each(data, function(i, val){  
	                    	suggestions.push({"id": val.id, "value": val.value});  
	                	});  
	                	//pass array to callback  
	                	add(suggestions); 
					}
				});
	    	},
            select: function(event, ui) {
                $('#idcat_p').val(ui.item.id);
            }
		});
	},
	_updateMovePage:function(movepage){
		/**
		 * Soumission d'une nouvelle page CMS
		 */
		$("#forms_cms_move_page").on('submit',function(){
			$.nicenotify({
				ntype: "submit",
				uri: '/admin/cms.php?movepage='+movepage,
				typesend: 'post',
				idforms: $(this),
				beforeParams:function(){},
				successParams:function(request){
					$('#idcat_p,#title_p_move').val('');
					$.nicenotify.initbox(request);
					ns_jcms._load_page_uri(movepage);
				}
			});
			return false;
		});
	},
	run:function(){
		this._initTextChange();
		this._addParentPage(false,false);
		this._google_chart_language();
		this._initSearchPage();
		this._deletePage("search");
	},
	runParentPage:function(){
		this._initTextChange();
		this._addParentPage(true,$("#idlang").val());
		this._loadParentPage($("#idlang").val());
		this._sidebarPage(false);
		this._deletePage("page_p");
	},
	runChildPage:function(){
		this._initTextChange();
		this._addChildPage($("#idlang").val(),$('#idcat_p').val());
		this._loadChildPage($("#idlang").val(),$('#idcat_p').val());
		this._sidebarPage(true);
		this._deletePage("page_child");
	},
	runMovePage:function(){
		this._load_page_uri($("#idpage").val());
		this._autoComplete_parent_cat_p();
		this._initSearchPage();
		this._updateMovePage($("#idpage").val());
	},
	runEditPage:function(){
		this._initTextChange();
		$('#uri_page').inputLock();
		this._load_page_uri($("#idpage").val());
		this._editPage($("#idpage").val());
		this._initSearchPage();
		this._autoComplete_cat_p_lang();
		this._addRelLangPage($("#idpage").val());
		this._child_lang_page($("#idpage").val());
		this._deleteRelLangPage($("#idpage").val());
	}
};