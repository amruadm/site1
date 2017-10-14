myApp.controller('postController', ['$scope', '$http', function($scope, $http){

    $scope.comment_add = '';

    $http.get("/api/post/0", {}).then(function(response){
        $scope.posts = response.data;
    });

    $scope.viewPost = function($id){
        window.location = '/post/'+$id;
    };

    $scope.getComments = function (id) {
        $http.get('/api/comments/'+id, {}).then(function(response) {
            $scope.postComments = response.data;
            $scope.commentsNum = response.data.length;
        });
    }

    $scope.addComment = function(post_id){
        var comm_text = $("#comm_add_text").val();
        $('#comment_block button').hide();
        $('#comment_block i').show();
        $http.post("/api/comment/"+post_id,
            {
                'comm_text': comm_text
            },
            {}).then(function(response){ // succefull
                $scope.getComments(post_id);
                $("#comm_add_text").val('');
                $('#comment_block button').show();
                $('#comment_block i').hide();
            },
            function (response) { // error
                $('#comment_block button').show();
                $('#comment_block i').hide();
                alert(response.data);
            });
    };

    $scope.removeComment = function(post_id, id){
        $('#comm_delete_'+id).hide();
        $('#comm_del_wait_'+id).show();
        $http.delete("/api/comment/"+id,{}).then(function(response){
            $scope.getComments(post_id);
            $('#comm_del_wait_'+id).hide();
            $('#comm_delete_'+id).show();
        }, function(response){
            $('#comm_del_wait_'+id).hide();
            $('#comm_delete_'+id).show();
            alert(response.data);
        });
    };

    $scope.replyComment = function(login){
        $scope.comment_add += login + ', ';
    };

}]);