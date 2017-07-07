app.controller("appCtrl", ['$rootScope', '$scope', '$location', 'appSettings', '$localStorage', '$http', '$state', '$filter',
function ($rootScope, $scope, $location, appSettings, $localStorage, $http, $state, $filter) {

    $rootScope.theme = appSettings.theme;

    $scope.logo = appSettings.logo;
    $scope.version = appSettings.version;

    $scope.today = new Date();

    $scope.userName =  $localStorage.currentUser.data.username;
    console.log($localStorage.currentUser);

    var backend = appSettings.backend;
    $http.get(backend + "articles").then(function(response){
        $scope.articles = response.data;

        /*pagination*/
        $scope.currentPageArticles= 0;
        $scope.pageSizePageArticles = 3;
        
        $scope.getPageArticles = function () {
          return $filter('filter')($scope.articles);
        };
         
        $scope.nbPagesArticles = function(){
            return Math.ceil($scope.articles.length/$scope.pageSizePageArticles);                
        };      
    });



    $scope.appTitle = [
        {
            name: "Wiki'tema",
            shortname: "WK",
            state: "app"
        }
    ]

    $scope.menuItems = [
        {
            title: "Articles",
            icon: "archive",
            state: "articles"
        },
        // {
        //     title: "Médias",
        //     icon: "television",
        //     state: "medias"
        // },
        {
            title: "Thématiques",
            icon: "edit",
            state: "thematiques"
        },
        {
            title: "Utilisateurs",
            icon: "users",
            state: "utilisateurs"
        },
        {
            title: "Contact",
            icon: "envelope",
            state: "contact"
        }
    ];

    console.log($scope.menuItems);

    $scope.sideBar = function (value ) {
        if($(window).width()<=767){
        if ($("body").hasClass('sidebar-open'))
            $("body").removeClass('sidebar-open');
        else
            $("body").addClass('sidebar-open');
        }
        else {
            if(value==1){
            if ($("body").hasClass('sidebar-collapse'))
                $("body").removeClass('sidebar-collapse');
            else
                $("body").addClass('sidebar-collapse');
            }
        }


    };

    $scope.logout = function(){
        delete $localStorage.currentUser;
        $http.defaults.headers.common.Authorization = '';
        $state.go('home');
    };

    function checkRole(arr, val) {
        return arr.some(function(arrVal) {
            return val === arrVal.name;
        });
    };

    var arrayRole = [];
    arrayRole.push($localStorage.currentUser.data.role);

    $scope.Administrateur = checkRole(arrayRole, 'Administrateur');
    $scope.Auteur = checkRole(arrayRole, 'Auteur');
    $scope.Abonne = checkRole(arrayRole, 'Abonne');

    if($scope.Auteur){
        $scope.articlesAuteur = [];
        for(var i=0;i<$localStorage.currentUser.data.articles.length;i++){
                $scope.articlesAuteur.push($localStorage.currentUser.data.articles[i].id);
        }
    }
    
    

}]);
