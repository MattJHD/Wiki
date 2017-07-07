dashboard.controller("UtilisateursController", ['$scope', '$http', 'appSettings', '$mdDialog',
	function($scope, $http, appSettings, $mdDialog){

		var backend = appSettings.backend;
		console.log(backend);

		//getUsers
		$http.get(backend + "users").then(function(response){
			$scope.users = response.data;
			console.log($scope.users);
		});

		$scope.status = '  ';
  		$scope.customFullscreen = true;

		//détails users
		$scope.showUser = function($event, id){
			
			$mdDialog.show({
	          	locals: {id: id},
	            controller: modalController,
	            templateUrl: 'app/modules/dashboard/views/utilisateurs/utilisateurDetails.html',
	            parent: angular.element(document.body),
	            targetEvent: $event,
	            clickOutsideToClose:true,
	            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
	          })
	          .then(function(answer) {
	            $scope.status = 'ok';
	          });

          	function modalController($scope, $mdDialog, $http, id) {
				$http.get(backend + "users/" + id).then(function(response){
					$scope.thisUser = response.data;
					console.log($scope.thisUser);
				});

				$scope.hide = function() {
				  $mdDialog.hide();
				};

				$scope.cancel = function() {
				  $mdDialog.cancel();
				};
			}

        };

    //add user
	$scope.addUser = function($event){
		
		$mdDialog.show({
            controller: modalAddController,
            templateUrl: 'app/modules/dashboard/views/utilisateurs/utilisateurAdd.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true,
            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
          })
          .then(function(answer) {
            $scope.status = 'ok';
          });

      	function modalAddController($scope, $mdDialog, $http) {

			$http.get(backend + "roles").then(function(response){
				$scope.roles = response.data;
				console.log($scope.roles);
			});

			$scope.hide = function() {
			  $mdDialog.hide();
			};

			$scope.cancel = function() {
			  $mdDialog.cancel();
			};

			$scope.goAdd = function(thisUser){
				console.log(thisUser);

				var role = JSON.parse(thisUser.role);

				var dataUser = new Object();
					dataUser.id = "";
					dataUser.firstname = thisUser.firstname;
					dataUser.lastname = thisUser.lastname;
					dataUser.username = thisUser.username;
					dataUser.salt = "";
					dataUser.password = "";
					dataUser.email = thisUser.email;
					dataUser.role = role;

				var jsonUser = JSON.stringify(dataUser);
				console.log(jsonUser);

				$http({
					url: backend + "users", 
					method: 'POST',
					data: jsonUser, 
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

    //edit user
	$scope.editUser = function($event, id){
		
		$mdDialog.show({
          	locals: {id: id},
            controller: modalEditController,
            templateUrl: 'app/modules/dashboard/views/utilisateurs/utilisateurEdit.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true,
            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
          })
          .then(function(answer) {
            $scope.status = 'ok';
          });

      	function modalEditController($scope, $mdDialog, $http, id) {
			$http.get(backend + "users/" + id).then(function(response){
				$scope.thisUser = response.data;
				console.log($scope.thisUser);
			});

			$http.get(backend + "roles").then(function(response){
				$scope.roles = response.data;
				console.log($scope.roles);
			});

			$scope.hide = function() {
			  $mdDialog.hide();
			};

			$scope.cancel = function() {
			  $mdDialog.cancel();
			};

			$scope.goEdit = function(thisUser){
				console.log(thisUser);

				var role = JSON.parse(thisUser.role);

				var dataUser = new Object();
					dataUser.id = "";
					dataUser.firstname = thisUser.firstname;
					dataUser.lastname = thisUser.lastname;
					dataUser.username = thisUser.username;
					dataUser.salt = "";
					dataUser.password = "";
					dataUser.email = thisUser.email;
					dataUser.role = role;

				var jsonUser = JSON.stringify(dataUser);
				console.log(jsonUser);

				$http({
					url: backend + "users/" + id, 
					method: 'PUT',
					data: jsonUser, 
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

    /*suppression utilisateur*/
		$scope.deleteUtilisateur = function(id){

			var confirmDelete = confirm('Voulez-vous vraiment supprimer cette ressource?');

			if(confirmDelete){
				$http.post(backend + "users/delete/" + id).success(function(data, status, headers, config){

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