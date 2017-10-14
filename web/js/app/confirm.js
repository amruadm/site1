myApp.controller('confirmController', ['$scope', '$http', function($scope, $http){

    $scope.retryMail = function(login){
        $('#retry_block button').hide();
        $('#retry_block i').show();
        $('#retry_block #span_msg').html('');
        $http.post('/api/tryconfirm/'+login, {}).then(function(response){
            $('#retry_block button').show();
            $('#retry_block i').hide();
            $('#retry_block #span_msg').html('Сообщение отправлено').css('color', '#00b300');
        }, function(response){
            $('#retry_block button').show();
            $('#retry_block i').hide();
            $('#retry_block #span_msg').html('Ошибка').css('color', 'red');
        });
    };

}]);