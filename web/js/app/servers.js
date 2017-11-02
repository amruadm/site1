myApp.controller('serversController', ['$scope', '$http', '$timeout', function($scope, $http, $timeout){
    $scope.description = "";
    $scope.updateServers = function(){
        $http.get("/api/minecraft/servers", {}).then(function(response){
            $scope.servers = response.data;
        });
        $timeout($scope.updateServers, 60000);
    };
    $scope.updateServers();
}]);