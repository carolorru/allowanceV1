'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:ConfirmRegisterCtrl
 * @description
 * # ConfirmRegisterCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('ConfirmRegisterCtrl', function ($scope, $routeParams, AuthenticService) {
		$scope.code = $routeParams.code;

		AuthenticService.signout();

		AuthenticService.confirmSignup($scope.code).then( function(response){
			
			$scope.message = response.data.message;

			AuthenticService.signin(response.data.return).then( function(){
				
				$location.path('/');

			}).catch(function(response){

				$scope.error = response;

			});		

		}).catch(function(response){
			$scope.error = response;
		});		
	});
