'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:ForgotPasswordCtrl
 * @description
 * # ForgotPasswordCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('ForgotPasswordCtrl', function ($scope) {

		$scope.$back = function() { 
			window.history.back();
		};

	});
