var home = angular.module('home', ['ui.router', 'ngAnimate']);

home.config(["$stateProvider", function($stateProvider){

	$stateProvider.state('home', {
        url: '/home',
        templateUrl: 'app/modules/home/views/home.html',
        controller: 'homeController',
        data: {
            pageTitle: 'Home'
        },
				params: {
					'name': '',
					'role': ''
				}
    });
}]);
