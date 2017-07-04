dashboard.controller("ArticlesController", ['$scope', '$http', 'appSettings',
	function($scope, $http, appSettings){

		var backend = appSettings.backend;
		console.log(backend);

		//getArticles
		$http.get(backend + "articles").then(function(response){
			$scope.articles = response.data;
			console.log($scope.articles);
		});



}]);