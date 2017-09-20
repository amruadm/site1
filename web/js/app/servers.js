myApp.controller('serversController', ['$scope', '$http', function($scope, $http){
    $scope.description = "";
    $scope.updateServers = function(){
        $http.get("/api/minecraft/servers", {}).then(function(response){
            console.log(response.data.description);
            $scope.description = response.data.description;
            $scope.players = response.data.players;
            $scope.maxPlayers = response.data.max_players;
        });
    };
    $scope.updateServers();
}]);