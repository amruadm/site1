myApp.controller('postController', ['$scope', '$http', function($scope, $http){

    $scope.comment_add = '';

    $http.get("/api/post", {}).then(function(response){
        $scope.posts = response.data;
        $scope.currentPost = response.data[0];
        if(response.data.length > 0)
            $scope.getPost($scope.currentPost.id);
    });

    $scope.getPost = function(id){
        console.log("getPost");
        $("#news_list li").removeClass("active");
        for(var i = 0; i < $scope.posts.length; i++){
            if($scope.posts[i].id === id){
                $scope.currentPost = $scope.posts[i];
                $("#post_"+$scope.currentPost.id).addClass("active");
                break;
            }
        }
        //$('.comment').remove();
        $scope.postComments = null;
        $http.get("/api/comments/"+$scope.currentPost.id, {}).then(function(response){
            $scope.postComments = response.data;
        }, function(response){

        });
    };

    $scope.addComment = function(){
        var comm_text = $("#comm_add_text").val();
        $http.post("/api/comment",
            {
                'post_id': $scope.currentPost.id,
                'comm_text': comm_text
            },
        {}).then(function(response){ // succefull
                $scope.getPost($scope.currentPost.id);
            },
            function (response) { // error
                alert(response.headers);
            });
    };

    $scope.removeComment = function(id){
        $http.delete("api/comment/"+id,{}).then(function(response){
            $scope.getPost($scope.currentPost.id);
        }, function(response){
            alert("Bad response");
        });
    };

    $scope.replyComment = function(login){
        $scope.comment_add += login + ', ';
    };

}]);