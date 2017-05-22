'use strict';

describe('Controller: ConfirmRegisterCtrl', function () {

  // load the controller's module
  beforeEach(module('allowanceApp'));

  var ConfirmRegisterCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ConfirmRegisterCtrl = $controller('ConfirmRegisterCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(ConfirmRegisterCtrl.awesomeThings.length).toBe(3);
  });
});
