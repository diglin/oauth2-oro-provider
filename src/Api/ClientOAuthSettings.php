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

final class ClientOAuthSettings implements ClientOAuthSettingsInterface
{
    private $url;
    private $clientId;
    private $clientSecret;
    private $grantType;
    private $username;
    private $password;

    public function __construct(
        string $url,
        string $clientId,
        string $clientSecret,
        string $grantType = 'client_credentials',
        ?string $username = null,
        ?string $password = null
    ) {
        $this->url = $url;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->grantType = $grantType;
        $this->username = $username;
        $this->password = $password;
    }

    public function getUrl(): string
    {
        return trim($this->url, '/');
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getGrantType(): string
    {
        return $this->grantType;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
