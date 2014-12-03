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
			var nameQuiz = $(".content_"+id).html();
			
			if(confirm("Are you sure you want to delete \""+nameQuiz+"\"?"))
			{			
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
			}
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
			  if(data == "1" || data == "2")
			  {
				  location.reload();
			  }                          
			},
		});
		
	});
	
	$("#closeQuiz").click(function(){
		var cid = $("#hiddenCid").val();
		
		window.location.href = "c_quiz.php?quiz_title_chosen="+cid+"&create_quiz=Choose+Quiz+Title";
	});
	
	$("#howmanyoption").change(function(){
		var one = $("#oneDiv").html();
		var two = $("#twoDiv").html();
		var three = $("#threeDiv #threeT").html();
		var four = $("#fourDiv #fourT").html();
		var five = $("#fiveDiv #fiveT").html();
		
		if(three === undefined)
			three = "Sample Option";
		if(four === undefined)
			four = "Sample Option";
		if(five === undefined)
			five = "Sample Option";
		
		var value = $(this).val();
		
		if(value == 3)
		{
			$("#threeDiv").html("<input type=\"radio\" name=\"answer\" value=\"three\" $checked> <textarea id=\"threeT\">"+three+"</textarea></div>");
			$("#fourDiv").html("");
			$("#fiveDiv").html("");
		}
		if(value == 4)
		{			
			$("#threeDiv").html("<input type=\"radio\" name=\"answer\" value=\"three\" $checked> <textarea id=\"threeT\">"+three+"</textarea></div>");
			$("#fourDiv").html("<input type=\"radio\" name=\"answer\" value=\"four\" $checked> <textarea id=\"fourT\">"+four+"</textarea></div>");
			$("#fiveDiv").html("");
		}
		if(value == 5)
		{			
			$("#threeDiv").html("<input type=\"radio\" name=\"answer\" value=\"three\" $checked> <textarea id=\"threeT\">"+three+"</textarea></div>");
			$("#fourDiv").html("<input type=\"radio\" name=\"answer\" value=\"four\" $checked> <textarea id=\"fourT\">"+four+"</textarea></div>");
			$("#fiveDiv").html("<input type=\"radio\" name=\"answer\" value=\"five\" $checked> <textarea id=\"fiveT\">"+five+"</textarea></div>");
		}
	});
	
	$("#saveQuiz_2").click(function(){
		var val = $("#howmanyoption").val();
		var qid = $("#hiddenQid").val();
		var cid = $("#hiddenCid").val();
		
		var correct = $('input[name="answer"]:checked', '#MCEdit').val();
		var question = encodeURIComponent($("#questionText").val());
		var answer = "";
					
		sendurl = "ajax.php?action=savetf&id="+qid+"&correct="+correct+"&question="+question;
				
		$.ajax({
			type:"GET",
			url:sendurl,
			dataType:"html",
			success: function(data){
			  if(data == "inserted")
			  {
				  window.location.href = "c_quiz.php?quiz_title_chosen="+cid+"&create_quiz=Choose+Quiz+Title";
			  }                          
			},
		});
		
	});
	
	$("#saveQuiz_1").click(function(){
		var val = $("#howmanyoption").val();
		var qid = $("#hiddenQid").val();
		var cid = $("#hiddenCid").val();
		
		var correct = $('input[name="answer"]:checked', '#MCEdit').val();
		
		var question = encodeURIComponent($("#questionText").val());
		var one = encodeURIComponent($("#oneT").val());
		var two = encodeURIComponent($("#twoT").val());
		var three = encodeURIComponent($("#threeT").val());
		if(val == "4")
			var four = encodeURIComponent($("#fourT").val());
		if(val == "5")
			var four = encodeURIComponent($("#fourT").val());
			var five = encodeURIComponent($("#fiveT").val());
		
		var sendurl = "";
		
		if(val == 5)
		{
			sendurl += "ajax.php?action=savemc&id="+qid+"&correct="+correct+"&question="+question+"&one="+one+"&two="+two+"&three="+three+"&four="+four+"&five="+five;
		}
		if(val == 4)
		{
			sendurl += "ajax.php?action=savemc&id="+qid+"&correct="+correct+"&question="+question+"&one="+one+"&two="+two+"&three="+three+"&four="+four;
		}
		if(val == 3)
		{
			sendurl += "ajax.php?action=savemc&id="+qid+"&correct="+correct+"&question="+question+"&one="+one+"&two="+two+"&three="+three;
		}
		
		//alert($("#threeT").val());
										
		$.ajax({
			type:"GET",
			url:sendurl,
			dataType:"html",
			success: function(data){
			  if(data == "inserted")
			  {
				  window.location.href = "c_quiz.php?quiz_title_chosen="+cid+"&create_quiz=Choose+Quiz+Title";
			  }                          
			},
		});
		
	});
	
	$(".deleteQuiz").click(function(){
		var id = $(this).attr("id");
		
		if(confirm("Are you sure you want to delete?"))
		{			
			$.ajax({
				type:"GET",
				url:"ajax.php?action=deletequiz&id="+id,
				dataType:"html",
				success: function(data){
				  if(data == "deleted")
				  {
					  $("."+id).hide("slow",function(){
						
					  });
				  }
				  else
				  {
					  alert("Error Occured!");
				  }
				},
			});
		}
	});
	
		
});