'use strict';

describe('Controller: ConfirmregisterCtrl', function () {

  // load the controller's module
  beforeEach(module('allowanceApp'));

  var ConfirmregisterCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ConfirmregisterCtrl = $controller('ConfirmregisterCtrl', {
      $scope: scope
      // place here mocked dependencies
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(ConfirmregisterCtrl.awesomeThings.length).toBe(3);
  });
});
