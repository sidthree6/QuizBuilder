$(document).ready(function() {
	$(".edit").click(function(){
		var editID = $(this).attr("id");
		var value = $("#"+editID).html();	
                                
		$("#buttons_"+editID).html("<img src=\"images/save.png\" class=\"saveEdit\" id=\""+editID+"\"> <img src=\"images/close.png\" class=\"closeEdit\" id=\""+editID+"\">");
		
		$("#"+editID).html("<label>Catagory Name: </label><input type=\"text\" name=\"c_name\" id=\"c_name\">");
		
                $(".saveEdit").click(function(){
                    //var value = $("#c_name").val();
                    alert($("#c_name").val());
                    /*$.ajax({
                        type:"GET",
                        url:"ajax.php?action=edit&id="+id,
                        dataType:"html",
                        success: function(data){
                          if(data == "1")
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
                    });*/
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
                  if(data == "1")
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
});