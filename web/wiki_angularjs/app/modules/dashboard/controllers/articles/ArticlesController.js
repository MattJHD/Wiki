dashboard.controller("ArticlesController", ['$scope', '$http', 'appSettings', '$mdDialog',
	function($scope, $http, appSettings, $mdDialog){
		var backend = appSettings.backend;
		console.log(backend);

		//getArticles
		$http.get(backend + "articles").then(function(response){
			 $scope.articles = response.data;
			 console.log($scope.articles);
		});

		$scope.status = '  ';
		$scope.customFullscreen = false;

		$scope.showAdvanced = function(ev, id) {
	    $mdDialog.show({
	      controller: ModalController,
	      templateUrl: 'app/modules/dashboard/views/articles/articleDetail.html',
	      parent: angular.element(document.body),
	      targetEvent: ev,
	      clickOutsideToClose:true,
	      fullscreen: $scope.customFullscreen, // Only for -xs, -sm breakpoints.
				data: {
					id:id
				}
			})
	    .then(function(answer) {
	      $scope.status = 'You said the information was "' + answer + '".';
	    }, function() {
	      $scope.status = 'You cancelled the dialog.';
	    });
	  };

		function ModalController($scope, $mdDialog, id) {

			console.log('id = '+id);
	    $scope.hide = function() {
	      $mdDialog.hide();
	    };

	    $scope.cancel = function() {
	      $mdDialog.cancel();
	    };

	    $scope.answer = function(answer) {
	      $mdDialog.hide(answer);
	    };
	  }

}]);
