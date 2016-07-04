	var App = angular.module('App', []);
	
	App.config(function($locationProvider) {
    $locationProvider.html5Mode({
      enabled: true,
      requireBase: false
    });
	});

	App.controller('Controller', function($scope, $http, $location){
		$scope.formData={};
		$scope.members={};
		$scope.nonmembers={};

		var queryparams = $location.search().projects_id;

		console.log({projects_id:queryparams});

			$scope.GetMemInfo = function(){$http({
				method : 'GET',
				url: "/projects/nonmember_info",
				params: {projects_id: queryparams}
			})
			.then(function(data){
				console.log(data);
				$scope.nonmembers=data.data;
				},
				function(data){
				console.log(data);}

				);

			$http({
				method: 'GET',
				url: "/projects/member_info",
				params: {projects_id:queryparams}
			})
			.then(function(data){
				console.log(data);
				$scope.members=data.data;
				},
				function(data){
				console.log(data);	

				});
		};
		$scope.GetMemInfo();
		$scope.AddMember = function(){
			console.log("haha");
			$http.post("/projects/assign",{"projects_id" : queryparams, "name" :$scope.formData} )
			.then(function(data){
				console.log(data);
				$scope.GetMemInfo();
			});
		}; 

		$scope.RemoveMember = function(item){
			console.log("haha");
			var id = item.currentTarget.getAttribute("id");
			$http.post("/projects/unassign",{"projects_id" : queryparams, "name" : id} )
			.then(function(data){
				console.log(data);
				$scope.GetMemInfo();
				
			});
		};

	});



















































// $(function(){

// 	function getUrlVars()
// {
//     var vars = [], hash;
//     var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
//     for(var i = 0; i < hashes.length; i++)
//     {
//         hash = hashes[i].split('=');
//         vars.push(hash[0]);
//         vars[hash[0]] = hash[1];
//     }
//     return vars;
// }

// 	var first = getUrlVars()["projects_id"];
// 	var $currmems = $('#memheader');
// 	var $name = $('#name');
// 	var $header = $('#header');
// 	var memberjson;


// 	$.ajax({
// 	  url: "/session",
// 	  type: "get", //send it through get method
// 	  success: function(response){
// 	  	memberjson = JSON.parse(response);
// 	  	$header.append('Welcome, ' +memberjson.username+ '!');
// 	  }

// 	  });
// 	$.ajax({
// 	  url: "/projects/member_info",
// 	  type: "get", //send it through get method
// 	  data:{projects_id:first},
// 	  success: function(response) {
// 	  	memberjson = JSON.parse(response);
// 	    $.each(JSON.parse(response), function(i, member){
// 	    	$currmems.append(' <li id= '+member.person_id+'> '+ member.Firstname +' '+member.Lastname+' <a class= "remove" href="javascript:;" id ='+member.person_id+' > Remove</a> </li> ');
// 	    	});

// 	  }
// 	});

// 	$.ajax({
// 	  url: "/projects/nonmember_info",
// 	  type: "get", //send it through get method
// 	  data:{projects_id:first},
// 	  success: function(response) {
// 	  	memberjson = JSON.parse(response);
// 	    $.each(JSON.parse(response), function(i, Anothermember){
// 	    	$name.append(' <option value= '+Anothermember.person_id+'> '+Anothermember.Firstname+' '+Anothermember.Lastname+' </option>');
// 	    	});

// 	  }
// 	});



// 	$('#addmember').on('click', function(){

// 		var member = {
// 			name: $name.val(),
// 			projects_id: first,
// 		};

// 		$('#name option:selected').remove();

// 		$.ajax({
// 			url: "/projects/assign",
// 			type: "post",
// 			data: member,
// 			success: function(newMember){
// 				memberjson=JSON.parse(newMember);
// 				 $.each(JSON.parse(newMember), function(i, newMember){
// 		    	$currmems.append('<li id= '+newMember.person_id+'> '+ newMember.Firstname +' '+newMember.Lastname+' <a class= "remove" href="javascript:;" id ='+newMember.person_id+' > Remove</a> </li> ');

// 		    	});


// 			},

// 		});

// 	});

// 	$(document).on('click',"a.remove", function(){
// 		var member = {
// 			name: $(this).attr("id"),
// 		};
		
// 		$.ajax({
// 			url:"/projects/unassign",
// 			type: "post",
// 			data: member,
// 			success: function(lostMember){
// 				console.log('success');
// 				$.each(JSON.parse(lostMember), function(i, lostMember){
// 				$name.append(' <option value= '+lostMember.person_id+'> '+lostMember.Firstname+' '+lostMember.Lastname+' </option>');
// 				$('#' + lostMember.person_id).remove();

// 				});

// 			},



// 		});



// 	});


// });