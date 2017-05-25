'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:ConfirmRegisterCtrl
 * @description
 * # ConfirmRegisterCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('ConfirmRegisterCtrl', function ($scope, $routeParams, AuthenticService, $location) {
		$scope.code = $routeParams.code;

		AuthenticService.signout();

		AuthenticService.confirmSignup($scope.code).then( function(response){
			
			$scope.message = response.data.message;

			$scope.status = response.data.status === 401;

			if (!$scope.status) {
				$scope.credentials = {
					email: response.data.return.email,
					password: response.data.return.pass_tmp
				};

				AuthenticService.signin($scope.credentials).then( function(){
					
					$location.path('/');

				}).catch(function(response){

					$scope.error = response;

				});	
			}	

		}).catch(function(response){
			$scope.error = response;
		});		
	});
