# OAuth2 Client for OroPlatform based applications

## Introduction

This Symfony 4.x & 5.x Bundle allows you to authenticate and connect to OroPlatform based applications API via the OAUth2 protocol.

This bundle extends the `league/oauth2-client` dependency and will be automatically installed. Fur further information about the dependency, visit the url [https://github.com/thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client) 

## Compatibility

- OroPlatform 4.x & 5.x with OAuth Server active on OroPlatform side 
  - See [API Feature activation](https://doc.oroinc.com/api/enabling-api-feature/) and [OAuth Authentification on OroPlatform](https://doc.oroinc.com/api/authentication/oauth/)
- Symfony 4.x | 5.x 

## Installation

Via composer:

`composer require diglin/oauth2-oro-provider:^1.0`

### Configuration

The default configuration of DiglinOAuth2OroBundle is illustrated below:

```
# Default configuration for extension with alias: "diglin_oauth2_oro"
diglin_oauth2_oro:
    api:

        # Url of the Oro Application, without trailing slash
        url:                  ~ # Required

        # Client ID: see documentation to get the value
        client_id:            ~ # Required

        # Client secret: see documentation to get the value
        client_secret:        ~ # Required

        # Username: required if grant_type = password
        username:             null

        # Password: required if grant_type = password
        password:             null

        # grant_type possible values: client_credentials or password
        grant_type:           client_credentials # Required
```

Create a file at the path `config/packages/diglin_oauth2_oro.yaml` (you can set also this file at environment level, like into the prod or dev folder.) with the following content example:

```yaml
parameters:
 'env(OROCRM_URL)': ''
 'env(OROCRM_CLIENT_ID)': ''
 'env(OROCRM_CLIENT_SECRET)': ''

diglin_oauth2_oro:
 api:
  url: "%env(OROCRM_URL)%"
  client_id: '%env(OROCRM_CLIENT_ID)%'
  client_secret: '%env(OROCRM_CLIENT_SECRET)%'
  username: ~ # value only if grant_type = password
  password: ~ # value only if grant_type = password
  grant_type: "client_credentials" # client_credentials or password 

```

- `url`: should looks like `https://my-domain.com`
- `client_id` and `client_secret`: you can get the value from OroPlatform - see [https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications](https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications)
- `grant_type`: can be `password` or `client_credentials`. `client_credentials` is recommended 

As stated in Oro Documentation:

The Client Credentials type is used for machine-to-machine authentication (e.g. in a cron job that performs maintenance tasks over an API) and Password is used by trusted first-party clients to exchange the credentials (username and password) for an access token. OAuth advises to use `client_credentials`

## Usage

Create an Endpoint implementing the `\Diglin\OAuth2OroBundle\Api\Endpoints\EndpointInterface` interface. Your class can looks like this:

```php
<?php

namespace Acme\Oro;

use Diglin\OAuth2OroBundle\Api\ClientOAuthInterface;

class MyEndpoint implements \Diglin\OAuth2OroBundle\Api\Endpoints\EndpointInterface
{
    const ENDPOINT_CUSTOMER = '/api/users';
    const TYPE = 'users';

    public function __construct(private ClientOAuthInterface $client)
    {
    }

    public function get()
    {
        return $this->client->request(ClientOAuthInterface::REQUEST_GET, $this->getEndpoint());
    }
    
    // When creating a new entity entry
    public function put(array $data = ['my_attribute' => 'my value'])
    {
        $myJsonData = \json_encode([
          'data' => [
              'type'       => self::TYPE,
              'attributes' => $data
          ],
        ]);

        return $this->client->request(ClientOAuthInterface::REQUEST_PUT, $this->getEndpoint(), ['body' => $myJsonData]);
    }
    
    // When updating existing entity entry
    public function post(array $data = ['my_attribute' => 'my value'])
    {
        $myJsonData = \json_encode([
          'data' => [
              'type'       => self::TYPE,
              'attributes' => $data
          ],
        ]);

        return $this->client->request(ClientOAuthInterface::REQUEST_POST, $this->getEndpoint(), ['body' => $myJsonData]);
    }

    public function getEndpoint(): string
    {
        return self::ENDPOINT_CUSTOMER;
    }
}

```

Then in your code you can do the following (be aware, the code below should be adapted of course)

```php
<?php

// require autoloader + Symfony bootstrap in this example 

$parameters = $container->get('diglin_oauth2_oro.api');

$settings = new Diglin\OAuth2OroBundle\Api\ClientOAuthSettings($parameters['url'], $parameters['client_id'], $parameters['client_secret'], $parameters['client_credentials'], $parameters['username'], $parameters['password']);

$factory = new \Diglin\OAuth2OroBundle\Api\ClientOAuthFactory(\Diglin\OAuth2OroBundle\Api\ClientOAuth::class, $settings);

$endpoint = new \Acme\Oro\MyEndpoint($factory->create());
$users = $endpoint->get();
```

## Tips

To get the list of available endpoints on your Oro Application, you can request the url `https://myoroapp.com/api/doc` (if you use OroCommerce, there is a difference between frontend and backend, in this case the admin url for backend API may looks like this `https://myoroapp.com/admin/api/doc`)

## PHP Test compatibility

Run ` ./vendor/bin/phpcs -p src --standard=PHPCompatibility --runtime-set testVersion 8.1`

## TODO

- Storage of the API token and take in account the use of the refresh token

## License

See [LICENSE.txt](./LICENSE.txt)

## Author

* Diglin GmbH
* https://www.diglin.com/
* [@diglin_](https://twitter.com/diglin_)
* [Follow us on github!](https://github.com/diglin)
