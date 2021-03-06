var dashboard = angular.module('dashboard', ['ui.router.stateHelper', 'ngAnimate','ngMaterial', 'angular-loading-bar','angularMoment']);

dashboard.config(["stateHelperProvider", "cfpLoadingBarProvider", function(stateHelperProvider, cfpLoadingBarProvider){

	cfpLoadingBarProvider.parentSelector = '.loader';

	stateHelperProvider.state({
		name: 'app.articles',
		url: '/articles',
		templateUrl: 'app/modules/dashboard/views/articles/articles.html',
		controller: 'ArticlesController'
	});

	stateHelperProvider.state({
		name: 'app.medias',
		url: '/medias',
		templateUrl: 'app/modules/dashboard/views/medias/medias.html',
		controller: 'MediasController'
	});

	stateHelperProvider.state({
		name: 'app.thematiques',
		url: '/thematiques',
		templateUrl: 'app/modules/dashboard/views/thematiques/thematiques.html',
		controller: 'ThematiquesController'
	});

	stateHelperProvider.state({
		name: 'app.utilisateurs',
		url: '/utilisateurs',
		templateUrl: 'app/modules/dashboard/views/utilisateurs/utilisateurs.html',
		controller: 'UtilisateursController'
	});

	stateHelperProvider.state({
		name: 'app.contact',
		url: '/contact',
		templateUrl: 'app/modules/dashboard/views/contact/contact.html',
		controller: 'ContactController'
	});



}]);

dashboard.filter('startFrom', function(){
	return function(input, start) {
	 	if (!input || !input.length) { return; }
        start = +start; //parse to int
        return input.slice(start);
    }
});

dashboard.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);
