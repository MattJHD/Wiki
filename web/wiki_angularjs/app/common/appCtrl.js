app.controller("appCtrl", ['$rootScope', '$scope', '$stateParams', '$location', 'appSettings',
function ($rootScope, $scope, $stateParams, $location, appSettings, $timeout) {

    $rootScope.theme = appSettings.theme;

    $scope.logo = appSettings.logo;
    $scope.version = appSettings.version;

    $scope.today = new Date();

    // $scope.userName = $stateParams.name;
    // $scope.userRole = $stateParams.role;

    console.log($scope.theme);


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
        },
        {
            title: "Administration",
            icon: "database",
            state: "administration"
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


}]);
