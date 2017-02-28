routerApp.controller('LeftAsideCtrl', ['$scope', 'queryService', function ($scope, queryService) {
    $scope.sports = [];

    queryService.getSports().then(function (response) {
        $scope.sports = response.data
    });
}]);

routerApp.controller('SportGamesCtrl', ['$scope', 'queryService', '$stateParams', function ($scope, queryService, $stateParams) {
    $scope.sportGames = [];

    queryService.getGamesOfSportId().then(function (response) {
        $scope.sportGames = response.data;

        if ($stateParams !== "") {
            $scope.sportIdentifier = $stateParams.sportId;
        }

    });


}]);

routerApp.controller('SportBetCtrl', ['$scope', 'queryService', '$stateParams', function ($scope, queryService, $stateParams) {

    /** team name and coefficient for buttons */
    $scope.teamInGame = [];

    /** for active class in buttons */
    $scope.isActive = false;

    /** save gameId from state */
    if ($stateParams !== "") {
        $scope.gameIdentifier = $stateParams.gameId;
    }

    /** get coefficients by gameId */
    queryService.getCoefficientsForTeamsInGameId().then(function (response) {
        $scope.teamInGame = response.data;
    });

    /** get end save coefficientId from buttons */
    $scope.getCoefficient = function ($coefficientId, $teamId) {
        $scope.coefficientId = $coefficientId;
        $scope.teamId = $teamId;
    };


    /** called from "create bet" button, send POST query with params */
    $scope.createBet = function () {
        /** object for POST query "create bet" */
        var betData = {coefficient_id: $scope.coefficientId, money: $scope.money, user_id: 1};

        queryService.createBetService(betData, $scope.teamId)
            .then(function (response){
                $scope.betStatusMessage = response.data;
        });
    };
}]);



routerApp.controller('MainContentCtrl', ['$scope', 'queryService', function ($scope, queryService) {
    $scope.allGames = [];
    $scope.allBets = [];

    queryService.getAllGames().then(function (response) {
        $scope.allGames = response.data
    });

    queryService.getAllBets().then(function (response) {
        $scope.allBets = response.data
    });
}]);
