'use strict';

/**
 * @ngdoc overview
 * @name allowanceApp
 * @description
 * # allowanceApp
 *
 * Main module of the application.
 */
angular
	.module('allowanceApp', [
		'ngAnimate',
		'ngAria',
		'ngCookies',
		'ngMessages',
		'ngResource',
		'ngRoute',
		'ngSanitize',
		'ngTouch',
		'ngStorage',
		'base64'
	])
	.config(function ($routeProvider, $locationProvider, $httpProvider) {
		$routeProvider
			.when('/', {
				templateUrl: 'views/main.html',
				controller: 'MainCtrl',
				controllerAs: 'main',
				authorize: true
			})
			.when('/about', {
				templateUrl: 'views/about.html',
				controller: 'AboutCtrl',
				controllerAs: 'about',
				authorize: true
			})
			.when('/login', {
				templateUrl: 'views/login.html',
				controller: 'LoginCtrl',
				controllerAs: 'login',
				authorize: false
			})
			.when('/register', {
				templateUrl: 'views/register.html',
				controller: 'RegisterCtrl',
				controllerAs: 'register',
				authorize: false
			})
			.when('/users', {
				templateUrl: 'views/users.html',
				controller: 'UsersCtrl',
				controllerAs: 'users',
				authorize: true
			})
			.when('/confirm-register/:code', {
				templateUrl: 'views/confirm-register.html',
				controller: 'ConfirmRegisterCtrl',
				controllerAs: 'confirmRegister',
				authorize: false
			})
			.when('/forgot-password/:email/:code', {
				templateUrl: 'views/forgot-password.html',
				controller: 'ForgotPasswordCtrl',
				controllerAs: 'forgotPassword',
				authorize: false
			})
			.when('/forgot-password-email', {
				templateUrl: 'views/forgot-password-email.html',
				controller: 'ForgotPasswordEmailCtrl',
				controllerAs: 'forgotPasswordEmail',
				authorize: false
			})
			.otherwise({
				redirectTo: '/'
			});      
		
		// use the HTML5 History API
        //$locationProvider.html5Mode(true).hashPrefix('');

		// Add the interceptor to the $httpProvider.
		$httpProvider.interceptors.push('AuthInterceptor');

	})
	.run(function ($rootScope, $location, AuthService) {		
		$rootScope.$on('$routeChangeStart', function (event, next, current) {			
			
			$rootScope.isPublicEnvironment = !next.authorize;
			
			if (next.authorize) {
				
				if (!AuthService.getToken()) {
					// Set to user NOT connected
					$rootScope.isLogin = false;

					$rootScope.$evalAsync(function () {
						$location.path('/login');
					});
				}else{
					// Set to user connected
					$rootScope.isLogin = true;
				}
			}

		});
	});


