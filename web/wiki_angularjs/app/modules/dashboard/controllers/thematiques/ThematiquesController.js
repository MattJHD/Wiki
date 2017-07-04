dashboard.controller("ThematiquesController", ['$scope', '$http', 'appSettings',
	function($scope, $http, appSettings){

		var backend = appSettings.backend;
		console.log(backend);

		//getThemes
		$http.get(backend + "themes").then(function(response){
			$scope.themes = response.data;
			console.log($scope.themes);
		});


}]);