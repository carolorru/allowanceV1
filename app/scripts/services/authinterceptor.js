'use strict';

/**
 * @ngdoc service
 * @name allowanceApp.AuthInterceptor
 * @description
 * # AuthInterceptor
 * Factory in the allowanceApp.
 */
angular.module('allowanceApp')
	.factory('AuthInterceptor', function ($location, AuthService, $q) {
		return {
			request: function(config) {
				config.headers = config.headers || {};

				if (AuthService.getToken()) {
					config.headers['Authorization'] = 'Bearer ' + AuthService.getToken();
				}

				return config;
			},

			requestError: function (rejection) {
				// console.log(rejection); // Contains the data about the error on the request.

				// Return the promise rejection.
				return $q.reject(rejection);
			},

			response: function (response) {
				// console.log(response); // Contains the data from the response.

				// Return the response or promise.
				return response || $q.when(response);
			},

			responseError: function(response) {
				if (response.status === 401 || response.status === 403) {
					$location.path('/login');
				}

				return $q.reject(response);
			}
		};
	});