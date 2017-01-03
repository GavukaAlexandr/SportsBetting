var myApp = angular.module("myApp", []).config(function($interpolateProvider){
    $interpolateProvider.startSymbol("{[{").endSymbol("}]}");
});

myApp.controller('MainCtrl', ['$scope', '$http', function ($scope, $http) {

    $scope.sports = [];
    $http.get('/api/sports').then(function(res) {
        $scope.sports = res.data;
    });
}]);
