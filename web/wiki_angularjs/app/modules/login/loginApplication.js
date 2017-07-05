var login = angular.module('login', ['ui.router', 'ngAnimate']);

login.config(["$stateProvider", function($stateProvider){

	$stateProvider.state('login', {
        url: '/login',
        templateUrl: 'app/modules/login/views/login.html',
        controller: 'loginController',
        data: {
            pageTitle: 'Login'
        }
    });
}]);
