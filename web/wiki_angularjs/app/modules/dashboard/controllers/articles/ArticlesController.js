dashboard.controller("ArticlesController", ['$scope', '$http', 'appSettings', '$mdDialog', '$localStorage',
	function($scope, $http, appSettings, $mdDialog, $localStorage){

		var backend = appSettings.backend;
		//console.log($localStorage);
		var currentUsername = $localStorage.currentUser.data.username;

		//getArticles
		$http.get(backend + "articles").then(function(response){
			 $scope.articles = response.data;
			 console.log($scope.articles);
		});

		
		

		//datetime
		function zero(num, size) {
		    var s = num;
		    if (parseInt(s) < parseInt(size)) s = "0" + s;	
		    return s;
		}
		var currentdate = new Date(); 
		var datetimeNow =  currentdate.getFullYear() + "-"
						+ zero((currentdate.getMonth()+1),10)  + "-" 
						+ zero(currentdate.getDate(), 10);
        console.log(datetimeNow);


		
        //CRUD
		$scope.status = '  ';
  		$scope.customFullscreen = true;

		//détails article
		$scope.showArticle = function($event, id){

			$mdDialog.show({
	          	locals: {id: id},
	            controller: modalController,
	            templateUrl: 'app/modules/dashboard/views/articles/articleDetails.html',
	            parent: angular.element(document.body),
	            targetEvent: $event,
	            clickOutsideToClose:true//,
	            //fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
	          })
	          .then(function(answer) {
	            $scope.status = 'ok';
	          });

          	function modalController($scope, $mdDialog, $http, id) {
				$http.get(backend + "articles/" + id).then(function(response){
					$scope.thisArticle = response.data;
					console.log($scope.thisArticle);
				});

				$scope.hide = function() {
				  $mdDialog.hide();
				};

				$scope.cancel = function() {
				  $mdDialog.cancel();
				};
			}

        };

<<<<<<< HEAD
    //add article
	$scope.addArticle = function($event){

		$mdDialog.show({
            controller: modalAddController,
            templateUrl: 'app/modules/dashboard/views/articles/articleAdd.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true,
            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
          })
          .then(function(answer) {
            $scope.status = 'ok';
          });

      	function modalAddController($scope, $mdDialog, $http) {

			$http.get(backend + "themes").then(function(response){
				$scope.themes = response.data;
				console.log($scope.themes);
			});

			$scope.hide = function() {
			  $mdDialog.hide();
			};

			$scope.cancel = function() {
			  $mdDialog.cancel();
			};

			$scope.goAdd = function(thisArticle){
				console.log(thisArticle);
				var themes = [];
				for(var i = 0; i<thisArticle.themes.length; i++){
					var dataTheme = JSON.parse(thisArticle.themes[i]);
					themes.push(dataTheme);
				}

				var dataArticle = new Object();
					dataArticle.id = "";
					dataArticle.name = thisArticle.name;
					dataArticle.description = thisArticle.description;
					dataArticle.date_creation = thisArticle.date_creation;
					dataArticle.pathname = "";
					dataArticle.user = {};
					dataArticle.themes = themes;

				var jsonArticle = JSON.stringify(dataArticle);
				console.log(jsonArticle);

				$http({
					url: backend + "articles",
					method: 'POST',
					data: jsonArticle,
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

    //edit article
	$scope.editArticle = function($event, id){

		$mdDialog.show({
          	locals: {id: id},
            controller: modalEditController,
            templateUrl: 'app/modules/dashboard/views/articles/articleEdit.html',
            parent: angular.element(document.body),
            targetEvent: $event,
            clickOutsideToClose:true,
            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
          })
          .then(function(answer) {
            $scope.status = 'ok';
          });

      	function modalEditController($scope, $mdDialog, $http, id) {
			$http.get(backend + "articles/" + id).then(function(response){
				$scope.thisArticle = response.data;
				console.log($scope.thisArticle);
			});

			$http.get(backend + "themes").then(function(response){
				$scope.themes = response.data;
				console.log($scope.themes);
			});

			$scope.hide = function() {
			  $mdDialog.hide();
			};

			$scope.cancel = function() {
			  $mdDialog.cancel();
			};

			$scope.goEdit = function(thisArticle){
				console.log(thisArticle);
				var themes = [];
				for(var i = 0; i<thisArticle.themes.length; i++){
					var dataTheme = JSON.parse(thisArticle.themes[i]);
					themes.push(dataTheme);
				}

				var dataArticle = new Object();
					dataArticle.id = id;
					dataArticle.name = thisArticle.name;
					dataArticle.description = thisArticle.description;
					dataArticle.date_creation = thisArticle.date_creation;
					dataArticle.pathname = "";
					dataArticle.user = {};
					dataArticle.themes = themes;

				var jsonArticle = JSON.stringify(dataArticle);
				console.log(jsonArticle);

				$http({
					url: backend + "articles/" + id,
					method: 'PUT',
					data: jsonArticle,
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
=======
        $http.get(backend + "users/username=" + currentUsername).then(function(response){
		var currentUserData = response.data;

			//add article
			$scope.addArticle = function($event){
				
				$mdDialog.show({
		            controller: modalAddController,
		            templateUrl: 'app/modules/dashboard/views/articles/articleAdd.html',
		            parent: angular.element(document.body),
		            targetEvent: $event,
		            clickOutsideToClose:true,
		            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
		          })
		          .then(function(answer) {
		            $scope.status = 'ok';
		          });

		      	function modalAddController($scope, $mdDialog, $http) {

					$http.get(backend + "themes").then(function(response){
						$scope.themes = response.data;
						console.log($scope.themes);
					});

					$scope.hide = function() {
					  $mdDialog.hide();
					};

					$scope.cancel = function() {
					  $mdDialog.cancel();
					};

					$scope.goAdd = function(thisArticle){
						console.log(thisArticle);
						var themes = [];
						for(var i = 0; i<thisArticle.themes.length; i++){
							var dataTheme = JSON.parse(thisArticle.themes[i]); 
							themes.push(dataTheme);
						}

						var dataArticle = new Object();
							dataArticle.id = "";
							dataArticle.name = thisArticle.name;
							dataArticle.description = thisArticle.description;
							dataArticle.date_creation = datetimeNow;
							dataArticle.pathname = "";
							dataArticle.user = currentUserData;
							dataArticle.themes = themes;

						var jsonArticle = JSON.stringify(dataArticle);
						console.log(jsonArticle);

						$http({
							url: backend + "articles", 
							method: 'POST',
							data: jsonArticle, 
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

		    //edit article
			$scope.editArticle = function($event, id){
				
				$mdDialog.show({
		          	locals: {id: id},
		            controller: modalEditController,
		            templateUrl: 'app/modules/dashboard/views/articles/articleEdit.html',
		            parent: angular.element(document.body),
		            targetEvent: $event,
		            clickOutsideToClose:true,
		            fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
		          })
		          .then(function(answer) {
		            $scope.status = 'ok';
		          });

		      	function modalEditController($scope, $mdDialog, $http, id) {
					$http.get(backend + "articles/" + id).then(function(response){
						$scope.thisArticle = response.data;
						console.log($scope.thisArticle);
					});

					$http.get(backend + "themes").then(function(response){
						$scope.themes = response.data;
						console.log($scope.themes);
					});

					$scope.hide = function() {
					  $mdDialog.hide();
					};

					$scope.cancel = function() {
					  $mdDialog.cancel();
					};

					$scope.goEdit = function(thisArticle){
						console.log(thisArticle);
						var themes = [];
						for(var i = 0; i<thisArticle.themes.length; i++){
							var dataTheme = JSON.parse(thisArticle.themes[i]); 
							themes.push(dataTheme);
						}

						var dataArticle = new Object();
							dataArticle.id = id;
							dataArticle.name = thisArticle.name;
							dataArticle.description = thisArticle.description;
							dataArticle.date_creation = thisArticle.date_creation;
							dataArticle.pathname = "";
							dataArticle.user = currentUserData;
							dataArticle.themes = themes;

						var jsonArticle = JSON.stringify(dataArticle);
						console.log(jsonArticle);

						$http({
							url: backend + "articles/" + id, 
							method: 'PUT',
							data: jsonArticle, 
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

>>>>>>> 69dda6dbe11a82bcfdcf08290e3b0727e5b3da4b

		    };



		})

    

}]);
