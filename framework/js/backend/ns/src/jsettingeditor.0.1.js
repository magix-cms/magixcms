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
var ns_jsettingeditor = {
	_loadingConfig:function(){
		/**
		 * Ajout d'une classe spécifique au survol d'un éditeur
		 */
		$(".list-editor:not(.ui-state-highlight)").hover(
			function(){
				if($(this).find('ui-state-disabled')){
					$(this).removeClass("ui-state-disabled");
				}
				$(this).addClass("ui-state-hover");
			},
			function(){ 
				if(!$(this).hasClass('ui-state-highlight')){
					$(this).removeClass("ui-state-hover");
					$(this).addClass("ui-state-disabled");
				}
			}
		);
		/**
		 * Ajout d'une class spécifique si le thème est actif
		 */
		$(".list-editor").live("click",function (){
			$('.list-editor').removeClass("ui-state-highlight");
			$('.list-editor').addClass("ui-state-disabled");
			if($(this).find('ui-state-disabled')){
				$(this).removeClass("ui-state-disabled");
			}
			if($(this).find('ui-state-hover')){
				$(this).removeClass("ui-state-hover");
			}
			if($(this).not('ui-state-highlight')){
				$(this).addClass("ui-state-highlight");
			}
		});
	},
	_updateEditor:function(){
		/*################## Configuration ##############*/
		var ie6 = ($.browser.msie && $.browser.version < 7);
		var ie7 = ($.browser.msie && $.browser.version > 6);
		var ie = ($.browser.msie);
		/**
		 * Requête ajax pour le changement d'éditeur
		 */
		$(".list-editor a").bind("click", function(e){
			e.preventDefault();
			var hreftitle = $(this).attr("title");
				if(hreftitle != null){
					if(ie){
						$.post('/admin/editor.php?htmleditor=true', 
							{ editor: hreftitle}
						, function(request) {
							$.notice({
								ntype: "simple",
								time:2
							});
		        			$(".mc-head-request").html(request);
	        				setTimeout(function(){
	        					location.reload();
	        				},2800);
						});
					}else{
						$.ajax({
							type:'post',
							data: "editor="+hreftitle,
							url: "/admin/editor.php?htmleditor=true",
							timeout:5000,
							error: function(request,error) {
								  if (error == "timeout") {
									  $("#error").append("The request timed out, please resubmit");
								  }
								  else {
									  $("#error").append("ERROR: " + error);
								  }
							},
							success:function(request) {
								$.notice({
									ntype: "simple",
									time:2
								});
			        			$(".mc-head-request").html(request);
		        				setTimeout(function(){
		        					location.reload();
		        				},2800);
							}
						});
					}
				}
		});
	},
	_updateSubConfig:function(){
		$("#manager-editor-settings :radio").click(function(){
			$.notice({
				ntype: "ajaxsubmit",
	    		delay: 2800,
	    		dom: '#manager-editor-settings',
	    		uri: '/admin/editor.php?manager_editor_setting=true',
	    		typesend: 'post',
	    		time:2,
	    		reloadhtml:false	
			});
			return false; 
		});
	}
};