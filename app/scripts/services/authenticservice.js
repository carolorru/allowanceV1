'use strict';

/**
 * @ngdoc service
 * @name allowanceApp.AuthenticService
 * @description
 * # AuthenticService
 * Factory in the allowanceApp.
 */
angular.module('allowanceApp')
	.factory('AuthenticService', function ($localStorage, AuthService, $http, $q, $base64) {		

		return {
			signin : function (data) {
				
				var deferred = $q.defer();

				$http.post('http://localhost:9001/public/token', data ,{
					headers: {'authorization': 'Basic ' + $base64.encode(data.email+':'+data.password)}
				}).then(function onSuccess(response) {
					
					// Store token
					AuthService.setToken(response.data.token);
					// Store user
					AuthService.setUser(response.data.user);

					deferred.resolve(response);

				}).catch(function onError(response) {
					
					deferred.reject(response.data.message);

				}); 

				return deferred.promise;
			},

			signup : function (data) {
				
				var deferred = $q.defer();

				$http.post('http://localhost:9001/public/users/add', data)
				.then(function onSuccess(response) {					
					
					deferred.resolve(response);

				}).catch(function onError(response) {
					
					deferred.reject(response.data.message);

				}); 

				return deferred.promise;
			},

			confirmSignup : function (data) {

				var deferred = $q.defer();

				$http.patch('http://localhost:9001/public/users/confirm?code=' + data)
				.then(function onSuccess(response) {					

					deferred.resolve(response);

				}).catch(function onError(response) {
					
					deferred.reject(response.data.message);

				}); 

				return deferred.promise;
			},

			signout : function () {
				delete $localStorage.token;
				$q.when();
			}
		};
	});
