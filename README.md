# OAuth2 Client for OroPlatform based applications

## Introduction

This Symfony 4.x|5.x Bundle allows you to authenticate and connect to OroPlatform based applications API via the OAUth2 protocol.
This bundle extends the `league/oauth2-client` dependency and will be automatically installed. Fur further informations about the dependency, visit the url [https://github.com/thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client) 

## Compatibility

- OroPlatform 4.x with OAuth Server active on OroPlatform side - See [API Feature activation](https://doc.oroinc.com/api/enabling-api-feature/) and [OAuth Authentification on OroPlatform](https://doc.oroinc.com/api/authentication/oauth/)
- Symfony 4.x (maybe Symfony 5 as well but not yet tested) 

## Installation

Via composer:

`composer require diglin/oauth2-oro-provider:^1.0`

### Configuration

Configure the bundle by adding the following lines and correct values onto a config YAML file like `config/packages/_sylius.yml` on Sylius.

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

Create an other file at the path `config/packages/diglin_oauth2_oro.yaml` (you can set also this file at environment level, like inot the prod or dev folder.) with the following content:

```yaml
diglin_oauth2_oro:
    api:
        url: "http://my.orocrm.domain"
        client_id: '<CLIENT_ID_HERE>'
        client_secret: '<CLIENT_SECRET_HERE>'
        username: ~ # value only if grant_type = password
        password: ~ # value only if grant_type = password
        grant_type: "client_credentials" # client_credentials or password 
```

- `url`: should looks like `http://my-domain.com`
- `client_id` and `client_secret`: you can get the value from OroPlatform - see [https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications](https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications)
- `grant_type`: can be `password` or `client_credentials`

As stated in Oro Documentation:

The Client Credentials type is used for machine-to-machine authentication (e.g., in a cron job that performs maintenance tasks over an API) and Password is used by trusted first-party clients to exchange the credentials (username and password) for an access token.

## Usage

Create an Endpoint implementing the `\Diglin\OAuth2OroBundle\Api\Endpoints\EndpointInterface` interface. Your class can looks like this:

```php
<?php

namespace Acme\Oro;

use Diglin\OAuth2OroBundle\Api\ClientOAuthInterface;

class MyEndpoint implements \Diglin\OAuth2OroBundle\Api\Endpoints\EndpointInterface
{
    const ENPOINT_CUSTOMER = '/api/users';
    const TYPE = 'users';

    /**
     * @var ClientOAuthInterface
     */
    private $client;

    public function __construct(ClientOAuthInterface $client)
    {
        $this->client = $client;
    }

    public function get()
    {
        $myJsonData = \json_encode([
          'data' => [
              'type'       => self::TYPE,
              'attributes' => [
                  'my_attribute' => 'my value'
              ],
          ],
        ]);

        return $this->client->request(ClientOAuthInterface::REQUEST_GET, $this->getEndpoint(), ['body' => $myJsonData]);
    }

    public function getEndpoint(): string
    {
        return self::ENPOINT_CUSTOMER;
    }
}

```

Then in your code you can do the following (be aware, the code below should be adapted of course)

```php
$settings = $container->get('diglin_oro.api.client_settings');
$factory = new \Diglin\OAuth2OroBundle\Api\ClientOAuthFactory(\Diglin\OAuth2OroBundle\Api\ClientOAuth::class, $settings);
$client = $factory->create();
$endpoint = new \Acme\Oro\MyEndpoint($client);

$users = $endpoint->get();
```

## Tips

To get the list of available endpoints on your Oro Application, you can request the url `http://myoroapp.com/api/doc` (if you use OroCommerce, there is a difference between frontend and backend, in this case the admin url for backend API may looks like this `http://myoroapp.com/admin/api/doc`)

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
