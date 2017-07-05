var login = angular.module('login', ['ui.router', 'ngAnimate', 'ngStorage']);

login.config(["$stateProvider", function($stateProvider){

	$stateProvider.state('login', {
        url: '/login',
        templateUrl: 'app/modules/login/views/login.html',
        controller: 'loginController'
    });

    $stateProvider.state('register', {
        url: '/register',
        templateUrl: 'app/modules/login/views/register.html',
        controller: 'registerController'
    });
}]);
