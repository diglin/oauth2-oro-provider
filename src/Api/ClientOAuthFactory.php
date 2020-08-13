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

class ClientOAuthFactory implements ClientOAuthFactoryInterface
{
    /** @var string */
    private $clientClassName;

    /** @var ClientOAuthSettings */
    private $configuration;

    public function __construct(string $fqcn, ?ClientOAuthSettings $configuration = null)
    {
        $this->clientClassName = $fqcn;
        $this->configuration = $configuration;
    }

    public function create(): ClientOAuthInterface
    {
        $instance = new $this->clientClassName();
        if (!$instance instanceof ClientOAuthInterface) {
            throw \Exception(printf('Classname %s does not implements the interface ClientOAuthInterface', $this->clientClassName));
        }

        if ($this->configuration) {
            $instance->init($this->configuration);
        }

        return $instance;
    }
}
