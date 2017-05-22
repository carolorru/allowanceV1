'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
  .controller('LoginCtrl', function ($scope, $localStorage, AuthenticService, $http, $location) {
	
	$scope.credentials = {
		first_name: '',
		password: ''
	};

	AuthenticService.signout();
	
	$scope.submitLogin = function(){
		if(!$scope.loginForm.$valid){
			return;
		}else{
			// use then when you use Promise (look the service code)
			AuthenticService.signin($scope.credentials).then( function(){
				
				$location.path('/');
				
				/*
				$http.get('http://localhost:9001/public/users/').then(function(response) {
					console.log(response);
					//AuthService.setToken(response.data.token);
				}); 
				*/

			}).catch(function(response){
				$scope.error = response;
			});		
		}		
		
	};
  });
