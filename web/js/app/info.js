myApp.controller('infoController', ['$scope', '$http', '$sanitize', function($scope, $http, $sanitize){
    $scope.updateInfoPage = function (action) {
        $http.get('/pages/'+action+'.html', {
            cache: false
        }).then(function (response) {
            $('#info_body').html(response.data);
            if($('#editor') !== undefined){
                $('#editor').html($('#info_body').html());
            }
        }, function (response) {
            $('#info_body').html("Информация не найдена");
        });
    };

}]);