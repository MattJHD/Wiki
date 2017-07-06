var app = angular.module('app', ['ui.router', 'ui.bootstrap', 'angularjs-datetime-picker', 'ngSanitize', 'home', 'dashboard', 'login', 'ngStorage', 'ngMaterial']);

app.config(['$stateProvider', '$locationProvider', '$urlRouterProvider', function ( $stateProvider, $locationProvider, $urlRouterProvider) {

    $stateProvider.state('app',
		{
			url: '/app',
			templateUrl: 'app/common/app.html',
			controller: 'appCtrl'
		});

    $urlRouterProvider.otherwise('home');

}
])
.run(['$rootScope', '$http', '$location', '$localStorage', function($rootScope, $http, $location, $localStorage){
  if ($localStorage.currentUser) {
      $http.defaults.headers.common.Authorization = 'Bearer ' + $localStorage.currentUser.token;
      console.log($localStorage.currentUser);
  }

  $rootScope.$on('$locationChangeStart', function (event, next, current) {
        var publicPages = ['/login', '/register'];
        var restrictedPage = publicPages.indexOf($location.path()) === -1;
        if (restrictedPage && !$localStorage.currentUser) {
            $location.path('/home');
        }
    });


}])
;

app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});


app.filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace !== -1) {
                  //Also remove . and , so its gives a cleaner result.
                  if (value.charAt(lastspace-1) === '.' || value.charAt(lastspace-1) === ',') {
                    lastspace = lastspace - 1;
                  }
                  value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
    });
// chargement des configs
app.constant('appSettings', appConfig);
