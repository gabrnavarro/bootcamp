$(function(){

	function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

	var first = getUrlVars()["projects_id"];
	var $currmems = $('#memheader');
	var $name = $('#name');
	var memberjson;

	$.ajax({
	  url: "/projects/member_info",
	  type: "get", //send it through get method
	  data:{projects_id:first},
	  success: function(response) {
	  	memberjson = JSON.parse(response);
	    $.each(JSON.parse(response), function(i, member){
	    	$currmems.append(' <li id= '+member.person_id+'> '+ member.Firstname +' '+member.Lastname+' <a href="javascript:;" id ='+member.person_id+' > Remove</a> </li> ');
	    	});

	  }
	});

	$('#addmember').on('click', function(){

		var member = {
			name: $name.val(),
			projects_id: first,
		};

		$('#name option:selected').remove();

		$.ajax({
			url: "/projects/assign",
			type: "post",
			data: member,
			success: function(newMember){
				memberjson=JSON.parse(newMember);
				 $.each(JSON.parse(newMember), function(i, newMember){
		    	$currmems.append(' <li id= '+newMember.person_id+'> '+ newMember.Firstname +' '+newMember.Lastname+' <a href="javascript:;" id ='+newMember.person_id+' > Remove</a> </li> ');

		    	});


			},

		});

	});

	$(document).on('click',"a", function(){
		var member = {
			name: $(this).attr("id"),
		};
		
		$.ajax({
			url:"/projects/unassign",
			type: "post",
			data: member,
			success: function(lostMember){
				console.log('success');
				$.each(JSON.parse(lostMember), function(i, lostMember){
				$name.append(' <option value= '+lostMember.person_id+'> '+lostMember.Firstname+' '+lostMember.Lastname+' </option>');
				$('#' + lostMember.person_id).remove();

				});

			},



		});



	});


});