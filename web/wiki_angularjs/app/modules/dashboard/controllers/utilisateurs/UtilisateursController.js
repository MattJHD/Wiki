dashboard.controller("UtilisateursController", ['$scope', '$http', 'appSettings',
	function($scope, $http, appSettings){

		var backend = appSettings.backend;
		console.log(backend);

		//getUsers
		$http.get(backend + "users").then(function(response){
			$scope.users = response.data;
			console.log($scope.users);
		});



}]);