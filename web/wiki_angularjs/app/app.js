var app = angular.module('app', ['ui.router', 'ui.bootstrap', 'angularjs-datetime-picker', 'ngSanitize', 'dashboard']);

app.config(['$stateProvider', '$locationProvider', '$urlRouterProvider', function ( $stateProvider, $locationProvider, $urlRouterProvider) {

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

    $urlRouterProvider.otherwise('app');

}
])
;

// chargement des configs
app.constant('appSettings', appConfig);
