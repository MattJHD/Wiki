var dashboard = angular.module('dashboard', ['ui.router.router', 'ui.router.stateHelper', 'ngAnimate','ngMaterial', 'angular-loading-bar','angularMoment']);

dashboard.config(["stateHelperProvider", "cfpLoadingBarProvider", function(stateHelperProvider, cfpLoadingBarProvider){

	cfpLoadingBarProvider.parentSelector = '.loader';

	stateHelperProvider.state({
		name: 'app.articles', 
		url: '/articles',
		templateUrl: 'app/modules/dashboard/views/articles/articles.html',
		controller: 'ArticlesController',
		data: {
			pageTitle: 'Articles'
		}
	});

	stateHelperProvider.state({
		name: 'app.medias', 
		url: '/medias',
		templateUrl: 'app/modules/dashboard/views/medias/medias.html',
		controller: 'MediasController',
		data: {
			pageTitle: 'Medias'
		}
	});

	stateHelperProvider.state({
		name: 'app.thematiques', 
		url: '/thematiques',
		templateUrl: 'app/modules/dashboard/views/thematiques/thematiques.html',
		controller: 'ThematiquesController',
		data: {
			pageTitle: 'Thematiques'
		}
	});

	stateHelperProvider.state({
		name: 'app.utilisateurs', 
		url: '/utilisateurs',
		templateUrl: 'app/modules/dashboard/views/utilisateurs/utilisateurs.html',
		controller: 'UtilisateursController',
		data: {
			pageTitle: 'Utilisateurs'
		}
	});

	stateHelperProvider.state({
		name: 'app.administration', 
		url: '/administration',
		templateUrl: 'app/modules/dashboard/views/administration/administration.html',
		controller: 'AdministrationController',
		data: {
			pageTitle: 'Administration'
		}
	});



}]);