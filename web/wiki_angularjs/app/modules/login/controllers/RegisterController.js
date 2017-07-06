login.controller("registerController", ['$rootScope', '$scope', '$state', '$http', '$q', 'appSettings', '$httpParamSerializerJQLike', '$localStorage',
	function($rootScope, $scope, $state, $http, $q, appSettings, $serializer, $localStorage){

	  $scope.user = {};
		$scope.register = function(user) {
			if(user.password === user.confirmPassword){
				// console.log(user);


				let parameter = JSON.stringify({id:"", role:{name:"Abonne", users:[], id:"3"}, firstname:user.firstname, lastname: user.lastname, username:user.username, salt:"", password:user.password, email: user.email, articles:[]});
				let backend = appSettings.backend;
				let url = backend + "users";

				console.log(parameter);
					// We POST
			    $http.post(url, parameter).
			    success(function(data, status, headers, config) {
			        // this callback will be called asynchronously
			        // when the response is available
			        console.log(data);
			      }).
			      error(function(data, status, headers, config) {
			        // called asynchronously if an error occurs
			        // or server returns response with an error status.
							console.log('erreur');
							console.log(data);
							console.log(status);
							console.log(header);
			      });
					//console.log(parameter);
			} else {
				alert('Les mots de passe doivent être identiques');
			}
    };
}]);


// Posting data to php file
// $http({
//   method  : 'POST',
//   url     : backend + "users",
//   data    : $scope.user, //forms user object
//   headers : {'Content-Type': 'application/x-www-form-urlencoded'}
//  })
//   .success(function(data) {
//     if (data.errors) {
//       // Showing errors.
//       $scope.errorName = data.errors.name;
//       $scope.errorUserName = data.errors.username;
//       $scope.errorEmail = data.errors.email;
//     } else {
//       $scope.message = data.message;
//     }
//   });
// console.log($scope.user);
