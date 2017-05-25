'use strict';

/**
 * @ngdoc service
 * @name allowanceApp.AuthService
 * @description
 * # AuthService
 * Factory in the allowanceApp.
 */
angular.module('allowanceApp')
	.factory('AuthService', function ($localStorage) {
		return {
			getToken : function () {
			  	return $localStorage.token;
			},
			setToken: function (token) {
			  	$localStorage.token = token;
			},
			getUser : function () {
			  	return $localStorage.user;
			},
			setUser: function (user) {
			  	$localStorage.user = user;
			}				
		};
	});

