'use strict';

describe('Controller: ForgotPasswordEmailCtrl', function () {

  // load the controller's module
  beforeEach(module('allowanceApp'));

  var ForgotPasswordEmailCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ForgotPasswordEmailCtrl = $controller('ForgotPasswordEmailCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(ForgotPasswordEmailCtrl.awesomeThings.length).toBe(3);
  });
});
