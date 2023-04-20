# Magento 2 Mock API

This module will add a frontend controller into the current Magento store that will simulate an API.

This is useful to test new features that requires external API connections.

The module adds two public controllers:

* POST {domain}/mockapi/
* GET {domain}/mockapi/

The controller response should return JSON data that will be configurable.

The controller request should receive a Bearer token to validate the request. The token is configurable.

The module allow to define a set of fields that the body must have in order to validate request and simulate Bad Request responses.

Allow to log into custom file received request.

## Settings

Module configuration is available at:

Stores > Configuration > Advanced > Developer > Mock API

### Options

* Enabled
* Enable Log
* Validate Token
* Token
* GET display request on response
* POST display request on response
* Validate Request Fields
* Fields to Validate

## Example usage:

### GET request

```
curl --location --request GET 'https://local.magento2.com/mockapi/?XDEBUG_SESSION_START=PHPSTORM' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer tokenFalso1234' \
--header 'Cookie: PHPSESSID=c357851ccf74ce451fbd5457b81eb636; XDEBUG_SESSION=PHPSTORM; mage-messages=%5B%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%5D; private_content_version=5918e325802932538802aac4b4c892eb' \
--data '{
    "id": "000000001",
    "currency": "USD",
    "discount": "0.0000",
    "total": "36.3900",
    "shipping": {
        "name": "Veronica Costello",
        "address": "6146 Honey Bluff Parkway",
        "city": "Calder",
        "state": "Michigan",
        "postcode": "49628-7978",
        "country": "US",
        "amount": "5.0000",
        "method": "Flat Rate - Fixed",
    }
}'
```

### POST request

```
curl --location 'https://local.magento2.com/mock_erp_api?XDEBUG_SESSION_START=PHPSTORM' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer tokenFalso1234' \
--header 'Cookie: PHPSESSID=c357851ccf74ce451fbd5457b81eb636; XDEBUG_SESSION=PHPSTORM; mage-messages=%5B%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%2C%7B%22type%22%3A%22error%22%2C%22text%22%3A%22Invalid%20Form%20Key.%20Please%20refresh%20the%20page.%22%7D%5D; private_content_version=cea3ca278c04ca29a7d9ab339a2b572c' \
--data '{
    "id": "000000001",
    "currency": "USD",
    "discount": "0.0000",
    "total": "36.3900",
    "shipping": {
        "name": "Veronica Costello",
        "address": "6146 Honey Bluff Parkway",
        "city": "Calder",
        "state": "Michigan",
        "postcode": "49628-7978",
        "country": "US",
        "amount": "5.0000",
        "method": "Flat Rate - Fixed",
    }
}'
```

## Logger

Received request are logged into: var/log/mock_api.log

## TODO

* Allow to configure body response on GET request
* Allow to configure body response on POST request
* Allow to configure unauthorized error message
