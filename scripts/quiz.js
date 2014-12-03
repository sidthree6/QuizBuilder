// JavaScript Document

$(document).ready(function() {
	var id = $("#hiddenID").val();
	
	var output = "";
	
	$.ajax({
	  type:"GET",
	  url:"genXML.php?id="+id,
	  dataTyle:"json",
	  success:function(xml){
		var count = 1;
		output += "<form action=\"checkresult.php\" method=\"get\">";
		$.each(xml, function(index,xml) {        
       		output += "<div id=\"qBlock\"><div id=\"question\">"+count+") "+xml.question+"</div>";
			output += "<div id=\"answers\">";
			if(xml.answerOne != "")
			{
				output += "<div id=\"answerBox\"><input type=\"radio\" name=\""+xml.qid+"\" value=\"one\" checked=checked> <label>"+xml.answerOne+"</label></div>";
			}
			if(xml.answerTwo != "")
			{
				output += "<div id=\"answerBox\"><input type=\"radio\" name=\""+xml.qid+"\" value=\"two\"> <label>"+xml.answerTwo+"</label></div>";
			}
			if(xml.answerThree != "")
			{
				output += "<div id=\"answerBox\"><input type=\"radio\" name=\""+xml.qid+"\" value=\"three\"> <label>"+xml.answerThree+"</label></div>";
			}
			if(xml.answerFour != "")
			{
				output += "<div id=\"answerBox\"><input type=\"radio\" name=\""+xml.qid+"\" value=\"four\"> <label>"+xml.answerFour+"</label></div>";
			}
			if(xml.answerFive != "")
			{
				output += "<div id=\"answerBox\"><input type=\"radio\" name=\""+xml.qid+"\" value=\"five\"> <label>"+xml.answerFive+"</label></div>";
			}
			output += "</select>";
			output += "</div></div>";
			
			count++;
        });
		output += "<input type=\"hidden\" name=\"id\" value=\""+xml[0].cid+"\" >";
		output += "<input type=\"submit\" value=\"Submit Quiz\" name=\"submitQUiz\" >";
		output += "</form>";
		
		$("#mainquiz").append(output);
	  }
	});
	
});