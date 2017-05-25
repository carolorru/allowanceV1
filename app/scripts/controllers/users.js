'use strict';

/**
 * @ngdoc function
 * @name allowanceApp.controller:UsersCtrl
 * @description
 * # UsersCtrl
 * Controller of the allowanceApp
 */
angular.module('allowanceApp')
  .controller('UsersCtrl', function ($scope, $localStorage) {
    
    $scope.user = $localStorage.user;
    
  });
