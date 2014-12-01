// JavaScript Document

$(document).ready(function() {
	$(".edit").click(function(){
		var editID = $(this).attr("id");
		var value = $("#"+editID).html();	
		
		$("#buttons").html("<img src=\"images/save.png\"> <img src=\"images/close.png\" class=\"closeEdit\" id=\""+editID+"\">");
		
		$("#"+editID).html("<label>Catagory Name: </label><input type=\"text\" name=\"c_name\" id=\"c_name\">");
		
		$(".closeEdit").click(function(){
			
			$("#buttons").html("<img src=\"images/edit.png\" class=\"edit\" id=\""+editID+"\" /> <img src=\"images/delete.png\"/>");
			
			var editID_C = $(this).attr("id");
			$("td#"+editID).html(value);
		});
		
	});	
});