'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:RegisterCtrl
 * @description
 * # RegisterCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
  .controller('RegisterCtrl', function ($scope, AuthenticService) {
    $scope.registration = {
		first_name: '',
		last_name: '',
		email: '',
		password: ''
	};
	
	AuthenticService.signout();

	$scope.$back = function() { 
		window.history.back();
	};

	$scope.submitRegister = function(){
		if(!$scope.registerForm.$valid){
			return;
		}else{
			//console.log($scope.registerForm);
			
			// use then when you use Promise (look the service code)
			AuthenticService.signup($scope.registration).then( function(response){
				console.log(response);

				//$location.path('/');m
				
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
