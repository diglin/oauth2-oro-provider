<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2OroBundle
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2OroBundle\Api;

use Diglin\OAuth2OroBundle\Api\Provider\PostAuthOptionProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessTokenInterface;

final class ClientOAuth implements ClientOAuthInterface
{
    const ACCESS_TOKEN_ENDPOINT = '/oauth2-token';

    /**
     * @var ClientOAuthSettings
     */
    protected $config;

    /**
     * @var AccessTokenInterface
     */
    protected $accessToken;

    /**
     * @var GenericProvider
     */
    protected $provider;

    public function __construct(?ClientOAuthSettings $config = null)
    {
        if ($config) {
            $this->init($config);
        }
    }

    public function init(ClientOAuthSettings $config): void
    {
        $this->config = $config;
    }

    public function request(string $method = self::REQUEST_GET, string $url = '', array $options = [])
    {
        if (strpos($url, '/') !== false) {
            $url = $this->config->getUrl() . $url;
        }

        try {
            $request = $this->getOAuthProvider()->getAuthenticatedRequest($method, $url, $this->getToken(), $options);

            return $this->getOAuthProvider()->getParsedResponse($request);
        } catch (IdentityProviderException $e) {
            // TODO handle errors
            throw $e;
        }
    }

    private function getOAuthProvider(): OroClientProvider
    {
        if (is_null($this->provider)) {
            $this->provider = new OroClientProvider(
                [
                    'clientId'                => $this->config->getClientId(),
                    'clientSecret'            => $this->config->getClientSecret(),
                    'urlAccessToken'          => $this->config->getUrl() . self::ACCESS_TOKEN_ENDPOINT,
                    'redirectUri'             => null,
                    'urlAuthorize'            => null,
                    'urlResourceOwnerDetails' => null,
                    'timeout'                 => 15
                ],
                ['optionProvider' => new PostAuthOptionProvider()]
            );
        }

        return $this->provider;
    }

    /**
     * @TODO Manage storage of the token and refresh it when needed
     *
     * @throws IdentityProviderException
     */
    private function getToken(): AccessTokenInterface
    {
        if (!$this->accessToken || $this->accessToken->hasExpired()) {
            switch ($this->config->getGrantType()) {
                case 'client_credentials':
                    $this->accessToken = $this->getOAuthProvider()->getAccessToken($this->config->getGrantType());
                    break;
                case 'password':
                    if (!is_null($this->accessToken) && $this->accessToken->hasExpired()) {
                        $this->accessToken = $this->getOAuthProvider()->getAccessToken('refresh_token', [
                            'refresh_token' => $this->accessToken->getRefreshToken(),
                        ]);
                    } else {
                        $this->accessToken = $this->getOAuthProvider()->getAccessToken($this->config->getGrantType(), [
                            'username' => $this->config->getUsername(),
                            'password' => $this->config->getPassword(),
                        ]);
                    }

                    break;
            }
        }

        return $this->accessToken;
    }
}
