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
        $http.post("/api/comment",
            {
                'post_id': post_id,
                'comm_text': comm_text
            },
            {}).then(function(response){ // succefull
                $scope.getComments(post_id);
                $("#comm_add_text").val('');
            },
            function (response) { // error
                alert(response.headers);
            });
    };

    $scope.removeComment = function(post_id, id){
        $http.delete("/api/comment/"+id,{}).then(function(response){
            $scope.getComments(post_id);
        }, function(response){
            alert("Bad response");
        });
    };

    $scope.replyComment = function(login){
        $scope.comment_add += login + ', ';
    };

}]);