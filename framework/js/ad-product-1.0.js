$(function() {
	/*$.getJSON("/admin/dashboard/catalog/json/getidclc="+ $('select#idclc').val(),function(j){
	    var options = '<option value="0">Aucune sous-catégorie</option>';
	    for (var i = 0; i < j.length; i++) {
	      options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
	    }
	    $("select#idcls").html(options);
	  });
	$("select#idclc").change(function(){
	   $.getJSON("/admin/dashboard/catalog/json/getidclc="+ $(this).val(),
		function(j){
		if(j == undefined){
			console.log(j);
		}
		var subcat = $('select#idcls');
		subcat.empty();
		if(j !== null){
		    var options = '<option value="0">Aucune sous-catégorie</option>';
		    for (var i = 0; i < j.length; i++) {
		      options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
		    }
		    subcat.html(options);
		}else{
			subcat.empty();
		}
	  });*/
	$("select#idclc").change(function(){
		$.getJSON("/admin/catalog.php?json&getidclc="+ $('#idclc').val(),function(j){
			if(j == undefined){
				console.log(j);
			}else{
				var subcat = $('#idcls');
				subcat.empty();
				if(j !== null){
					$('<option value="0">Aucune sous-catégorie</option>').appendTo("#idcls");
					$.each(j, function(i,item) {
						$('<option value="' +item.optionValue + '">' + item.optionDisplay + '</option>').appendTo("#idcls");
						//$("<option>élément[" + i + "] = " + item.optionValue + ", " + item.optionDisplay + "</option>").appendTo("#idcls");
					});
				}
			}
		});
	});
		/*$.ajax({
			dataType: 'json',
			url: '/admin/dashboard/catalog/json/getidclc='+ $(this).val(),
			async: false,
			success: function(j) {
				var options = '<option value="0">Aucune sous-catégorie</option>';
			    for (var i = 0; i < j.length; i++) {
			      options += '<option value="' + j[i].optionValue + '">' + j[i].optionDisplay + '</option>';
			    }
			    $("select#idcls").html(options);
			}
		});*/
	//});
});