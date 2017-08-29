
var myApp = angular.module('mainApp', []).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

myApp.controller('baseController', ['$scope', '$http', function($scope, $http){
    console.log("baseController");
    $http.get("/api/users", {}).then(function(response){
        console.log(response.data);
        $scope.data = response.data;
    });
}]);