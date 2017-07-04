dashboard.controller("MediasController", ['$scope', '$http', 'appSettings',
	function($scope, $http, appSettings){

		var backend = appSettings.backend;
		console.log(backend);

		//getMedias
		$http.get(backend + "medias").then(function(response){
			$scope.medias = response.data;
			console.log($scope.medias);
		});



}]);