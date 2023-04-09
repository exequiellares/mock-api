# Magento 2 Mock API

This module will add a frontend controller into the current Magento store that will simulate an API.

This is useful to test new features that requires external API connections.

The module adds two public controllers:

* mock-api/test-post
* mock-api/test-get

The controller response should return JSON data that will be configurable.

The controller request should receive a Bearer token to validate the request. This token could be any string or could be configurable.


## TODO

* Add configuration to enable module
* Create route and controller files
  * Create POST controller
  * Create GET controller
* Add configuration to set plain text to be returned into GET controller response
* Add configuration to set plain text to be returned into POST controller response
* Add configuration to allow POST controller to return the data received via POST
* Add configuration to set fake bearer token.
* Add configuration to allow fake bearer token to be any string or not
* Validate fake Bearer token to allow controller to be processed
* Respond unauthorized if bearer token is not present or doesn't match
