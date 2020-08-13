<?php
/**
 * Diglin GmbH - Switzerland.
 *
 * @author      Sylvain Rayé <support at diglin.com>
 * @category    OAuth2Oro
 * @copyright   2020 - Diglin (https://www.diglin.com)
 */
declare(strict_types=1);

namespace Diglin\OAuth2Oro\Client\Api;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ClientOAuthSettings implements ClientOAuthSettingsInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function getUrl(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.url');
    }

    public function getGrantType(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.grant_type');
    }

    public function getClientId(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.client_id');
    }

    public function getClientSecret(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.client_secret');
    }

    public function getUsername(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.username');
    }

    public function getPassword(): string
    {
        return $this->container->getParameter('diglin_oro_client.api.password');
    }
}
