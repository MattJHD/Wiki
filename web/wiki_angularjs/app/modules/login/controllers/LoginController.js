login.controller("loginController", ['$rootScope', '$scope', '$state', '$http', '$q', 'appSettings', '$httpParamSerializerJQLike', '$localStorage',
	function($rootScope, $scope, $state, $http, $q, appSettings, $serializer, $localStorage){

		var backend = appSettings.backend;
		console.log(backend);


$scope.loginWiki = function(credentials){
            var defer = $q.defer();

            $http({
                url: backend + 'login_check',
                method: 'POST',
                data: $serializer(credentials),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).success(function(success, status, headers, config, statusText) {
                console.log(success);
                console.log(status);
                console.log(headers);
                console.log(config);
                console.log(statusText);
                console.log(success.token);
                //console.log(defer.resolve(success));

                defer.resolve(success);

                if(status == 200){
                    if(success.token){
                        $http.get(backend + 'users/username=' + credentials.username).success(function(response){
                            var user = response;
                            if (user) {
                                $localStorage.currentUser = {username: credentials._username, token: success.token, data: user} ;
                                $http.defaults.headers.common.Authorization = 'Bearer ' + success.token;
                                $state.go('app', {name : credentials.username});

                                console.log($localStorage);
                            }
                        });
                    }

                    console.log("OK!!!!!")
                }

                /*if(status.code == 400) {
                    Flash.create('danger', 'Mot de passe invalide ', 'large-text')
                } else if(status.code == 401) {
                    Flash.create('danger', 'Login invalide', 'large-text')
                }*/

            }).error(function(error, status, headers, config, statusText){
                console.log(error);
                console.log(status);
                console.log(headers);
                console.log(config);
                console.log(statusText);

                defer.reject(error);
                console.log('error');

            });

            return defer.promise
        };
}]);