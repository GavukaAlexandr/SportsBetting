var routerApp = angular.module('routerApp', ['ui.router']).config(function($interpolateProvider) {
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
                    controller: 'LeftAside'
                },
                'content': {
                    templateUrl: 'asset/app/partials/content/content.html'
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

        // ABOUT PAGE AND MULTIPLE NAMED VIEWS =================================
        // .state('about', {
        //     url: '/about',
        //     views: {
        //         '': { templateUrl: 'partial-about.html' },
        //         'columnOne@about': { template: 'Look I am a column!' },
        //         'columnTwo@about': {
        //             templateUrl: 'table-data.html',
        //             controller: 'scotchController'
        //         }
        //     }
        // });
});

routerApp.controller('LeftAside', ['$scope', '$http', function ($scope, $http) {

    $scope.sports = [];
    $http.get('/api/sports').then(function(res) {
        $scope.sports = res.data;
    });

    // $scope.sportGames = [];
    // $http.get('/api/sports/:sportId/games').then(function(res) {
    //     $scope.sportGames = res.data
    // });
}]);

routerApp.controller('SportGamesCtrl', ['$scope', '$http', '$stateParams', function ($scope, $http, $stateParams) {

    $scope.sportGames = [];
    $http.get('/api/sports/' +$stateParams.sportId+ '/games').then(function(res) {
        $scope.sportGames = res.data
    });
}]);









// var myApp = angular.module("myApp", []).config(function($interpolateProvider){
//     $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
// });
//
// myApp.controller('MainCtrl', ['$scope', '$http', function ($scope, $http) {
//
//     $scope.sports = [];
//     $http.get('/api/sports').then(function(res) {
//         $scope.sports = res.data;
//     });
//
//     $scope.sportGames = [];
//     $http.get('/api/sports/game/game').then(function(res) {
//         $scope.sportGames = res.data
//     });
// }]);
