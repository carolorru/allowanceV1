'use strict';

/**
 * @ngdoc service
 * @name allowanceApp.users
 * @description
 * # users
 * Factory in the allowanceApp.
 */
angular.module('allowanceApp')
	.factory('Users', function ($http, $q) {
		return {
			
			forgotPassSendEmail: function (data) {
				var deferred = $q.defer();

				$http.post('http://localhost:9001/public/users/forgotPassword', data)
				.then(function onSuccess(response) {
					
					deferred.resolve(response);

				}).catch(function onError(response) {
					
					deferred.reject(response.data.message);

				}); 

				return deferred.promise;
			},

			forgotPassChangePass: function (data, code) {
				var deferred = $q.defer();

				$http.patch('http://localhost:9001/public/users/changePassword?code='+code, data)
				.then(function onSuccess(response) {
					
					deferred.resolve(response);

				}).catch(function onError(response) {
					
					deferred.reject(response.data.message);

				}); 

				return deferred.promise;

			}
		};
	});
