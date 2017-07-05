app.controller("appCtrl", ['$rootScope', '$scope', '$location', 'appSettings', '$localStorage', '$http', '$state',
function ($rootScope, $scope, $location, appSettings, $localStorage, $http, $state) {

    $rootScope.theme = appSettings.theme;

    $scope.logo = appSettings.logo;
    $scope.version = appSettings.version;

    $scope.today = new Date();

    $scope.userName =  $localStorage.currentUser.data.username;


    $scope.appTitle = [
        {
            name: "Wiki",
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
        {
            title: "Médias",
            icon: "television",
            state: "medias"
        },
        {
            title: "Thématiques",
            icon: "edit",
            state: "thematiques"
        },
        {
            title: "Utilisateurs",
            icon: "users",
            state: "utilisateurs"
        }
    ];

    console.log($scope.menuItems);

    // for(var i=0 ; i<vm.menuItems.length ; i++){
    //     if($scope.userRoles != vm.menuItems[i].permission){
    //         $scope.item = true;
    //     }
    //     else{
    //         $scope.item = null;
    //     }
    //    console.log($scope.item);
    // }

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


}]);
