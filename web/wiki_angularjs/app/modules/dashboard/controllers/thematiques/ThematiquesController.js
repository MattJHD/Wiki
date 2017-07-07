dashboard.controller("ThematiquesController", ['$scope', '$http', 'appSettings', '$mdDialog', '$localStorage',
	function($scope, $http, appSettings, $mdDialog, $localStorage){

		var backend = appSettings.backend;

		var currentUsername = $localStorage.currentUser.data.username;

		//getThemes
		$http.get(backend + "themes").then(function(response){
			$scope.themes = response.data;
			console.log($scope.themes);
		});


		$scope.status = '  ';
  		$scope.customFullscreen = true;

		//détails article
		$scope.showTheme = function($event, id){
			
			$mdDialog.show({
	          	locals: {id: id},
	            controller: modalController,
	            templateUrl: 'app/modules/dashboard/views/thematiques/thematiqueDetails.html',
	            parent: angular.element(document.body),
	            targetEvent: $event,
	            clickOutsideToClose:true,
	            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
	          })
	          .then(function(answer) {
	            $scope.status = 'ok';
	          });

          	function modalController($scope, $mdDialog, $http, id) {
				$http.get(backend + "themes/" + id).then(function(response){
					$scope.thisTheme = response.data;
					console.log($scope.thisTheme );
				});

				$scope.hide = function() {
				  $mdDialog.hide();
				};

				$scope.cancel = function() {
				  $mdDialog.cancel();
				};
			}

        };

        $http.get(backend + "users/username=" + currentUsername).then(function(response){
		var currentUserData = response.data;


					//add theme
					$scope.addTheme = function($event){
						
						$mdDialog.show({
				            controller: modalAddController,
				            templateUrl: 'app/modules/dashboard/views/thematiques/thematiqueAdd.html',
				            parent: angular.element(document.body),
				            targetEvent: $event,
				            clickOutsideToClose:true,
				            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
				          })
				          .then(function(answer) {
				            $scope.status = 'ok';
				          });

				      	function modalAddController($scope, $mdDialog, $http) {

							$scope.hide = function() {
							  $mdDialog.hide();
							};

							$scope.cancel = function() {
							  $mdDialog.cancel();
							};

							$scope.goAdd = function(thisTheme){
								console.log(thisTheme);

								var dataTheme = new Object();
									dataTheme.id = "";
									dataTheme.name = thisTheme.name;
									dataTheme.user = currentUserData;

								var jsonTheme = JSON.stringify(dataTheme);
								console.log(jsonTheme);

								$http({
									url: backend + "themes", 
									method: 'POST',
									data: jsonTheme, 
									headers: { 'content-type': 'application/json' }
								}).success(function(data, status, headers, config, answer){
									$scope.PostDataResponse = data;
									console.log($scope.PostDataResponse);
									location.reload();
								}).error(function (data, status, header, config) {
					                $scope.ResponseDetails = "Data: " + data +
					                    "<hr />status: " + status +
					                    "<hr />headers: " + header +
					                    "<hr />config: " + config;
					            });



							}
						}

				    };

				    //edit theme
					$scope.editTheme = function($event, id){
						
						$mdDialog.show({
				          	locals: {id: id},
				            controller: modalEditController,
				            templateUrl: 'app/modules/dashboard/views/thematiques/thematiqueEdit.html',
				            parent: angular.element(document.body),
				            targetEvent: $event,
				            clickOutsideToClose:true,
				            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
				          })
				          .then(function(answer) {
				            $scope.status = 'ok';
				          });

				      	function modalEditController($scope, $mdDialog, $http, id) {
							$http.get(backend + "themes/" + id).then(function(response){
								$scope.thisTheme = response.data;
								console.log($scope.thisTheme);
							});

							$scope.hide = function() {
							  $mdDialog.hide();
							};

							$scope.cancel = function() {
							  $mdDialog.cancel();
							};

							$scope.goEdit = function(thisTheme){
								console.log(thisTheme);

								var dataTheme = new Object();
									dataTheme.id = id;
									dataTheme.name = thisTheme.name;
									dataTheme.user = currentUserData;

								var jsonTheme = JSON.stringify(dataTheme);
								console.log(jsonTheme);

								$http({
									url: backend + "themes/" + id, 
									method: 'PUT',
									data: jsonTheme, 
									headers: { 'content-type': 'application/json' }
								}).success(function(data, status, headers, config, answer){
									$scope.PostDataResponse = data;
									console.log($scope.PostDataResponse);

									location.reload();
								}).error(function (data, status, header, config) {
					                $scope.ResponseDetails = "Data: " + data +
					                    "<hr />status: " + status +
					                    "<hr />headers: " + header +
					                    "<hr />config: " + config;
					            });



							}
						}

				    };


		});

	    
        /*suppression theme*/
		$scope.deleteTheme = function(id){

			var confirmDelete = confirm('Voulez-vous vraiment supprimer cette ressource?');

			if(confirmDelete){
				$http.post(backend + "themes/delete/" + id).success(function(data, status, headers, config){

					location.reload();

				}).error(function (data, status, header, config) {
	                $scope.ResponseDetails = "Data: " + data +
	                    "<hr />status: " + status +
	                    "<hr />headers: " + header +
	                    "<hr />config: " + config;
	            });

			};
			
		};





}]);