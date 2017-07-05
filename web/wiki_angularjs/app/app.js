var app = angular.module('app', ['ui.router', 'ui.bootstrap', 'angularjs-datetime-picker', 'ngSanitize', 'home', 'dashboard', 'login', 'ngStorage']);

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
        var publicPages = ['/login'];
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



// chargement des configs
app.constant('appSettings', appConfig);
