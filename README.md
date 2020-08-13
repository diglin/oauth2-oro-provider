# OAuth2 Client for OroPlatform based applications

## Introduction

This Symfony 4.x Bundle allows you to authenticate and connect to OroPlatform based applications API via the OAUth2 protocol.
This bundle extends the `league/oauth2-client` dependency and will be automatically installed. Fur further informations about the dependency, visit the url [https://github.com/thephpleague/oauth2-client](https://github.com/thephpleague/oauth2-client) 

## Compatibility

- OroCRM 4.x with OAuth Server active on OroCRM side - See [API Feature activation](https://doc.oroinc.com/api/enabling-api-feature/) and [OAuth Authentification on OroPlatform](https://doc.oroinc.com/api/authentication/oauth/)
- Symfony 4.x (maybe Symfony 5 as well but not yet tested) 

## Installation

Via composer:

`composer require diglin/oauth2-oro-provider:^1.0`

### Configuration

Configure the bundle by adding the following lines and correct values onto `config/packages/_sylius.yml`.

In case you use the `client_credentials` grant_type:
```yaml
parameters:
    ... 
    diglin_oro_client.api.url: "<YOUR_URL>"
    diglin_oro_client.api.client_id: "<ORO_CLIENT_ID>"
    diglin_oro_client.api.client_secret: "<ORO_CLIENT_SECRET>"
    diglin_oro_client.api.grant_type: "client_credentials" # possible values: client_credentials or password
```

Or in case you use the `password` grant_type:
```yaml
parameters:
    ... 
    diglin_oro_client.api.url: "<YOUR_URL>"
    diglin_oro_client.api.client_id: "<ORO_CLIENT_ID>"
    diglin_oro_client.api.client_secret: "<ORO_CLIENT_SECRET>"
    diglin_oro_client.api.username: "<YOUR_ORO_USERNAME>"
    diglin_oro_client.api.password: "<YOUR_ORO_PASSWORD>"
    diglin_oro_client.api.grant_type: "password" # possible values: client_credentials or password
```

- `url`: should looks like `http://my-domain.com/oauth2-token`
- `client_id` and `client_secret`: you can get the value from OroCRM - see [https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications](https://doc.oroinc.com/user/back-office/system/user-management/oauth-app/#oauth-applications)
- `grant_type`: can be `password` or `client_credentials`

As stated in Oro Documentation:

The Client Credentials type is used for machine-to-machine authentication (e.g., in a cron job that performs maintenance tasks over an API) and Password is used by trusted first-party clients to exchange the credentials (username and password) for an access token.

## Usage

Create an Endpoint implementing the `\Diglin\OAuth2Oro\Client\Api\Endpoints\EndpointInterface` interface. Your class can looks like this:

```php
<?php
namespace Acme\Oro;

class MyEndpoint implements EndpointInterface
{
    const ENPOINT_CUSTOMER = '/api/users';
    const TYPE = 'users';

    /**
     * @var ClientOAuthFactoryInterface
     */
    private $factory;

    public function __construct(ClientOAuthFactoryInterface $factory)
    {
        $this->factory = $factory;
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

        $client = $this->factory->create();
        return $client->request(\Diglin\OAuth2Oro\Client\Api\ClientOAuthInterface::REQUEST_GET, $this->getEndpoint(), ['body' => $myJsonData]);
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
$factory = new \Diglin\OAuth2Oro\Client\Api\ClientOAuthFactory(\Diglin\OAuth2Oro\Client\Api\ClientOAuth::class, $settings);
$endpoint = new \Acme\Oro\MyEndpoint($factory);

$users = $endpoint->get();
```

## Tips

To get the list of available endpoints on your Oro Application, you can request the url `http://myoroapp.com/api/doc` (if you use OroCommerce, there is a difference between frontend and backend, in this case the admin url for backend API may looks like this `http://myoroapp.com/admin/api/doc`)

## License

See [LICENSE.txt](./LICENSE.txt)

## Author

* Diglin GmbH
* https://www.diglin.com/
* [@diglin_](https://twitter.com/diglin_)
* [Follow us on github!](https://github.com/diglin)
