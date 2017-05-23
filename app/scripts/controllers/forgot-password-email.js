'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:ForgotPasswordEmailCtrl
 * @description
 * # ForgotPasswordEmailCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('ForgotPasswordEmailCtrl', function ($scope, AuthenticService, Users) {
		
		$scope.credentials = {
			email: ''
		};

		AuthenticService.signout();

		$scope.$back = function() { 
			window.history.back();
		};

		$scope.submitForgotPass = function() {
			if(!$scope.emailForgotPassForm.$valid){
				return;
			}else{
				Users.forgotPassSendEmail($scope.credentials).then( function(response){
					
					$scope.message = response.data.message;

					$scope.status = response.data.status === 401;

				}).catch(function(response){
					$scope.error = response;
				});		
			}
		};
	});
