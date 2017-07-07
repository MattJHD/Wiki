dashboard.controller("ContactController", ['$scope', '$http', 'appSettings', '$mdDialog', '$localStorage', 'textAngularManager', '$filter',
	function($scope, $http, appSettings, $mdDialog, $localStorage, textAngularManager, $filter){

		var backend = appSettings.backend;
		//console.log($localStorage);
		var currentUsername = $localStorage.currentUser.data.username;

		$scope.test = "toto";

		$scope.submitForm = function(data){

						var dataMail = new Object();
							dataMail.firstname = data.firstname;
							dataMail.lastname = data.lastname;
							dataMail.email = data.email;
							dataMail.message = data.message;
							;

						var jsonMail = JSON.stringify(dataMail);
						console.log(jsonMail);

						$http({
							url: backend + "contact", 
							method: 'POST',
							data: jsonMail, 
							headers: { 'content-type': 'application/json' }
						}).success(function(data, status, headers, config, answer){
							$scope.PostDataResponse = data;
							console.log($scope.PostDataResponse);
							//location.reload();
						}).error(function (data, status, header, config) {
			                $scope.ResponseDetails = "Data: " + data +
			                    "<hr />status: " + status +
			                    "<hr />headers: " + header +
			                    "<hr />config: " + config;
			            });



					}

    

}]);
