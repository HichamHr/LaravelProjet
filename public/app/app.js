//noinspection JSUnresolvedFunction
/**
 * Created by Charif on 30/03/2016.
 */
var app = angular.module('OpenTestFrameWork', ['ngRoute','ngStorage']);
var BASE_URL = "http://localhost:9988/MrCharif/LaravelProjet/public/";

app.config(['$routeProvider', function($routeProvider){
    $routeProvider.when('/login',{templateUrl: './Auth/loginForm',controller:'LoginForm'});
    $routeProvider.when('/register',{templateUrl: './Auth/registerForm',controller:'RegisterForm'});
    $routeProvider.otherwise({redirectTo: '/login'});
}]);

app.controller('LoginForm', function($scope,AuthFactory) {
    // create a message to display in our view
    $scope.message = 'This Is Login Page';
    $scope.cridentiel = {
        email:null,
        password : null
    };

    $scope.Login = function() {
         console.log($scope.cridentiel.email);
         console.log($scope.cridentiel.password);
         var data = $.param({
                 email: $scope.cridentiel.email,
                 password: $scope.cridentiel.password
         });
         AuthFactory.LOGIN(BASE_URL+'api/login',data);
    }
});

app.controller('RegisterForm', function($scope) {
    // create a message to display in our view
    $scope.message = 'This Is Register Page';

    $scope.toggle = function(v){
        alert("Hello");
        v.removeClass('active');
    }
});