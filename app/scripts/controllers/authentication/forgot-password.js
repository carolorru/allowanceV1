'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:ForgotPasswordCtrl
 * @description
 * # ForgotPasswordCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('ForgotPasswordCtrl', function ($scope, $routeParams, AuthenticService, $location, Users) {

		$scope.code = $routeParams.code;

		$scope.credentials ={
			email: $routeParams.email,
			password: ''
		};

		AuthenticService.signout();

		$scope.submitChangePass = function () {
			if(!$scope.forgotPasswordForm.$valid){
				return;
			}else{
				Users.forgotPassChangePass($scope.credentials, $scope.code).then( function(response){
				
					$scope.message = response.data.message;

					$scope.status = response.data.status === 401;

					if (!$scope.status) {
						AuthenticService.signin($scope.credentials).then( function(){
							
							$location.path('/');

						}).catch(function(response){

							$scope.error = response;

						});	
					}	

				}).catch(function(response){
					$scope.error = response;
				});		
			}
		};

	});
