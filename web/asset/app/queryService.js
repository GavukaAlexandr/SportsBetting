routerApp.service('queryService', ['$http', '$stateParams', function ($http, $stateParams) {
        return {
            /** get all sports */
            getSports: function () {
                return $http.get('/api/sports')
            },
            /** get games by sportId */
            getGamesOfSportId: function () {
                return $http.get('/api/sports/' + $stateParams.sportId + '/games')
            },
            /** get all games */
            getAllGames: function () {
                return $http.get('/api/sports/games')
            },
            /** get all bets */
            getAllBets: function () {
                return $http.get('/api/sports/bets')
            },
            /** create bet */
            createBetService: function (betData, $teamId) {
                return $http.post(
                    '/api/sports/' + $stateParams.sportId + '/game/' + $stateParams.gameId + '/team/' + $teamId + '/bet',
                    betData
                )
            }, //todo перевірити пост ссилку і знайти чому не відправляються пост параметри

            /** get coefficients for teams by gameId */
            getCoefficientsForTeamsInGameId: function () {
                return $http.get('/api/sports/' + $stateParams.sportId + '/game/' + $stateParams.gameId + '/teams/coefficient')
            }
        }
    }]
);
