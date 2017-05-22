'use strict';

describe('Service: AuthenticService', function () {

  // load the service's module
  beforeEach(module('allowanceApp'));

  // instantiate service
  var AuthenticService;
  beforeEach(inject(function (_AuthenticService_) {
    AuthenticService = _AuthenticService_;
  }));

  it('should do something', function () {
    expect(!!AuthenticService).toBe(true);
  });

});
