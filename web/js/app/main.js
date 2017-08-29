
var myApp = angular.module('mainApp', []).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

myApp.controller('baseController', ['$scope', function($scope){
    $scope.testValue = 1;
    $scope.changeValue = function(){
        $scope.testValue += 1;
    };
}]);