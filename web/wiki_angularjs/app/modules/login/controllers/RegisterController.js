login.controller("registerController", ['$rootScope', '$scope', '$state', '$http', '$q', 'appSettings', '$httpParamSerializerJQLike', '$localStorage',
	function($rootScope, $scope, $state, $http, $q, appSettings, $serializer, $localStorage){

	  $scope.user = {};
		$scope.register = function(user) {

			console.log(user.email);
			var idx = user.email.lastIndexOf('@');
			if (idx > -1 && user.email.slice(idx+1) === 'hitema.fr') {
			  //true if the address ends with hitema.fr
				if(user.password === user.confirmPassword){
					// console.log(user);
					let parameter = JSON.stringify({id:"", role:{name:"Abonne", users:[], id:"3"}, firstname:user.firstname, lastname: user.lastname, username:user.username, salt:"", password:user.password, email: user.email, articles:[]});
					let backend = appSettings.backend;
					let url = backend + "creation";

					console.log(parameter);
						// We POST
				    $http.post(url, parameter).
				    success(function(data, status, headers, config) {
				        $state.go('home');
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
			} else {
				alert('Votre adresse email doit terminer par hitema.fr');
			}

    };
}]);
