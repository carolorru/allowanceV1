'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:NavbarCtrl
 * @description
 * # NavbarCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
	.controller('NavbarCtrl', function ($scope, $location) {
		

		$scope.items = [
			{path: '', title: 'Home'},
			{path: 'about', title: 'Users'},
			{path: 'login', title: 'Logout'},
		];		

		$scope.isActive = function(item) {
			if (item.path === $location.path()) {
				return true;
			}
			return false;			
		};
	});
