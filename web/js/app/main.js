
var myApp = angular.module('mainApp', ['ngAnimate', 'ngSanitize']).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
});

