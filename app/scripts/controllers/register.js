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
		activ: '',
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
			// use then when you use Promise (look the service code)
			AuthenticService.signup($scope.registration).then( function(response){
				$scope.message = response.data.message;

			}).catch(function(response){
				$scope.error = response;
			});		
			
		}
		
	};
  });
