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
                }
                // 'footer': {
                //     templateUrl: 'asset/app/partials/footer/footer.html'
                // }
            }
        })
        .state('home.sportgames', {
            url: 'sport/{sportId}/games',
            views: {
                'content@': {
                    templateUrl: 'asset/app/partials/content/games/games.html',
                    controller: 'SportGamesCtrl'
                }
            }
        })
        .state('home.sportgames.bet', {
            url: '/{gameId}/bet',
            views: {
                'content@': {
                    templateUrl: 'asset/app/partials/content/games/bet/game-bet.html',
                    controller: 'SportBetCtrl'
                }
            }
        })
});
