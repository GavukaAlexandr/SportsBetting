var routerApp = angular.module('routerApp', ['ui.router', 'ui.bootstrap']).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
});

routerApp.config(function($stateProvider, $urlRouterProvider) {
    $urlRouterProvider.otherwise('/'); //for invalid routes
    $stateProvider
        .state('home', {
            url: '/',
            views: {
                'header': {
                    templateUrl: 'asset/app/partials/header/header.html'
                },
                'left_aside': {
                    templateUrl: 'asset/app/partials/left_aside/left_aside.html',
                    controller: 'LeftAsideCtrl'
                },
                'content': {
                    templateUrl: 'asset/app/partials/content/content.html',
                    controller: 'MainContentCtrl'
                },
                'footer': {
                    templateUrl: 'asset/app/partials/footer/footer.html'
                }
            }
        })
        .state('home.sportgames', {
            url: 'sport/{sportId}/games',
            views: {
                'content@': {
                    templateUrl: 'asset/app/games/games.html',
                    controller: 'SportGamesCtrl'
                }
            }
        });
});

routerApp.controller('LeftAsideCtrl', ['$scope', '$http', '$uibModal', function ($scope, $http, $uibModal) {
    $scope.sports = [];
    $http.get('/api/sports').then(function(res) {
        $scope.sports = res.data;
    });
}]);

routerApp.controller('SportGamesCtrl', ['$scope', '$http', '$stateParams', function ($scope, $http, $stateParams) {
    $scope.sportGames = [];
    $http.get('/api/sports/' +$stateParams.sportId+ '/games').then(function(res) {
        $scope.sportGames = res.data
    });
}]);

routerApp.controller('MainContentCtrl', ['$scope', '$http', function ($scope, $http) {
    $scope.allGames = [];
    $http.get('/api/sports/games').then(function(res) {
        $scope.allGames = res.data
    });

    $scope.allBets =[];
    $http.get('/api/sports/bets').then(function(res) {
        $scope.allBets = res.data
    });
}]);

////////////////   MODAL_REGISTER   //////////////////

// routerApp.controller('openFormUser', ['$scope', '$http', '$uibModal', function ($scope, $http, $uibModal) {
//
//     $ctrl.animationsEnabled = true;
//
//     var modalInstance = $uibModal.open({
//         animation: false,
//         ariaLabelledBy: 'modal-title',
//         ariaDescribedBy: 'modal-body',
//         template: '<div>TEMPLATE</div>',
//         // templateUrl: 'myModalContent.html',
//         // controller: 'ModalInstanceCtrl',
//         // controllerAs: '$ctrl',
//         size: 'lg',
//         // appendTo: parentElem,
//         // resolve: {
//         //     items: function () {
//         //         return $ctrl.items;
//         //     }
//         // }
//     });
//
// }]);
