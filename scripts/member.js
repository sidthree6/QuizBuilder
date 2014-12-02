$(document).ready(function() {
	$(".edit").click(function(){
		var editID = $(this).attr("id");
		var value = $("#"+editID).html();	
                                
		$("#buttons_"+editID).html("<img src=\"images/save.png\" class=\"saveEdit\" id=\""+editID+"\"> <img src=\"images/close.png\" class=\"closeEdit\" id=\""+editID+"\">");
		
		$("#"+editID).html("<label>Catagory Title: </label><input type=\"text\" name=\"c_name\" value=\""+value+"\" id=\"c_edit_name\">");
		
                $(".saveEdit").click(function(){
                    var editVal = $("#c_edit_name").val();                   
                    var id = $(this).attr("id");
					
					$.ajax({
                        type:"GET",
                        url:"ajax.php?action=edit&id="+id+"&value="+editVal,
                        dataType:"html",
                        success: function(data){
                          if(data == "edited")
                          {							  	
                                window.location.href = "c_catagory.php";                              
                          }
						  else if(data == "wrongsize")				
						  {
							  alert("Title must not be more than 100 characters long.");
						  }
                          else
                          {
                              alert("Error Occured!");
                          }
                        },
                    });
					
                });
                
		$(".closeEdit").click(function(){
			
			$("#buttons_"+editID).html("<img src=\"images/edit.png\" class=\"edit\" id=\""+editID+"\" /> <img src=\"images/delete.png\" class=\"delete\" id=\""+editID+"\" />");
			
			var editID_C = $(this).attr("id");
			$("td#"+editID).html(value);
            window.location.href = "c_catagory.php";
		});		
	});	
        
        $(".delete").click(function(){
            var id = $(this).attr("id");
            $.ajax({
                type:"GET",
                url:"ajax.php?action=delete&id="+id,
                dataType:"html",
                success: function(data){
                  if(data == "deleted")
                  {
                      $("."+id).hide("slow",function(){
                        window.location.href = "c_catagory.php";
                      });
                  }
                  else
                  {
                      alert("Error Occured!");
                  }
                },
            });
        });
		
	$(".add_quiz_mc, .add_quiz_tf").click(function(){
		var id = $(this).attr("id");
		var tclass = $(this).attr("class");
		
		var sendurl="";
		
		if(tclass == "add_quiz_mc")
			sendurl = "ajax.php?action=addquiz&value=mc&id="+id;
		else
			sendurl = "ajax.php?action=addquiz&value=tf&id="+id;
			
		$.ajax({
			type:"GET",
			url:sendurl,
			dataType:"html",
			success: function(data){
			  if(data == "1")
			  {
				  alert("Multiple Choice Added!");
			  }
			},
		});
		
	});	
	
});