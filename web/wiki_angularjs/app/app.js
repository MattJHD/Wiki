var app = angular.module('app', ['ui.router', 'ui.bootstrap', 'angularjs-datetime-picker', 'ngSanitize', 'home', 'dashboard']);

app.config(['$stateProvider', '$locationProvider', '$urlRouterProvider', function ( $stateProvider, $locationProvider, $urlRouterProvider) {

    $stateProvider.state('login',
    {
      url: '/login',
      templateUrl: 'app/modules/login/views/login.html',
      controller: 'loginController',
      data: {
          pageTitle: 'Login'
      }
    });

    $stateProvider.state('app',
		{
			url: '/app',
			templateUrl: 'app/common/app.html',
			controller: 'appCtrl',
			params: {
				'name': '',
				'role': ''
			}
		});

    $urlRouterProvider.otherwise('home');

}
])
;

app.filter('capitalize', function() {
    return function(input) {
      return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
    }
});

// chargement des configs
app.constant('appSettings', appConfig);
